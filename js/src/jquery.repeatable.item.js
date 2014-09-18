/*!
 * Repeatable list item 1.5.0 (http://n-molham.github.io/jquery.repeatable.item/)
 * Copyright 2014 Nabeel Molham.
 * Licensed under MIT License (http://opensource.org/licenses/MIT)
 */
( function ( window ) {
	jQuery( function( $ ) {
		$.fn.repeatable_item = function( events ) {
			// check if doT.js template engine is available
			if ( typeof doT !== 'object' ) {
				throw 'doT.js Template engine not found, click here https://github.com/olado/doT';
			}

			// default events handler
			events = $.extend( {
				init: function() {},
				completed: function() {},
				new_item: function() {},
				removed: function() {},
			}, events );

			// plugins methods
			var methods = {
					add_item: function( $list, index, data ) {
						// check empty item
						if ( $list.settings.is_empty ) {
							$list.settings.is_empty = false;
							$list.find( '.repeatable-empty' ).remove();
						}
						// create clone
						var $new_item = $list.item_template.clone();

						// add new index
						var item_content = $new_item.html().replace( new RegExp( '{'+ $list.settings.indexKeyName +'}', 'g' ), index );

						// check data
						switch( typeof data ) {
							case 'undefined':
								break;

							case 'object':
								console.log( $list.item_template_dot );
								// refill fields data
								item_content = $list.item_template_dot( data );
								break;

							default:
								item_content = item_content.replace( new RegExp( '{'+ $list.settings.valueKeyName +'}', 'g' ), data );
								break;
						}

						// clear placeholder left overs
						item_content = item_content.replace( /{[a-zA-Z0-9_\-]+}/g, '' );

						// replace HTML and append to list
						$new_item.html( item_content ).appendTo( $list );

						// index increment
						$list.settings.startIndex = parseInt( index ) + 1;

						// trigger event: add new
						$list.trigger( 'repeatable-new-item', [ $list, $new_item, index, data ] );
						events.new_item( $list, $new_item, index, data );
					},
					array_keys: function ( input, search_value, argStrict ) {
						//  discuss at: http://phpjs.org/functions/array_keys/
						var search = typeof search_value !== 'undefined',
						tmp_arr = [],
						strict = !! argStrict,
						include = true,
						key = '';
						if ( input && typeof input === 'object' && input.change_key_case ) {
							// Duck-type check for our own array()-created PHPJS_Array
							return input.keys(search_value, argStrict);
						}
						for ( key in input ) {
							if (input.hasOwnProperty(key)) {
								include = true;
								if ( search ) {
									if ( strict && input[key] !== search_value ) {
										include = false;
									} else if ( input[key] != search_value ) {
										include = false;
									}
								}
								
								if ( include ) {
									tmp_arr[tmp_arr.length] = key;
								}
							}
						}
						return tmp_arr;
					},
					array_max: function () {
						//  discuss at: http://phpjs.org/functions/max/
						var ar, retVal, i = 0,
						n = 0,
						argv = arguments,
						argc = argv.length,
						_obj2Array = function (obj) {
							if (Object.prototype.toString.call(obj) === '[object Array]') {
								return obj;
							} else {
								var ar = [];
								for (var i in obj) {
									if (obj.hasOwnProperty(i)) {
										ar.push(obj[i]);
									}
								}
								return ar;
							}
						}; //function _obj2Array
						var _compare = function (current, next) {
							var i = 0,
							n = 0,
							tmp = 0,
							nl = 0,
							cl = 0;
							
							if (current === next) {
								return 0;
							} else if (typeof current === 'object') {
								if (typeof next === 'object') {
									current = _obj2Array(current);
									next = _obj2Array(next);
									cl = current.length;
									nl = next.length;
									if (nl > cl) {
										return 1;
									} else if (nl < cl) {
										return -1;
									}
									for (i = 0, n = cl; i < n; ++i) {
										tmp = _compare(current[i], next[i]);
										if (tmp == 1) {
											return 1;
										} else if (tmp == -1) {
											return -1;
										}
									}
									return 0;
								}
								return -1;
							} else if (typeof next === 'object') {
								return 1;
							} else if (isNaN(next) && !isNaN(current)) {
								if (current === 0) {
									return 0;
								}
								return (current < 0 ? 1 : -1);
							} else if (isNaN(current) && !isNaN(next)) {
								if (next === 0) {
									return 0;
								}
								return (next > 0 ? 1 : -1);
							}
							
							if (next == current) {
								return 0;
							}
							return (next > current ? 1 : -1);
						}; //function _compare
						if (argc === 0) {
							throw new Error('At least one value should be passed to max()');
						} else if (argc === 1) {
							if (typeof argv[0] === 'object') {
								ar = _obj2Array(argv[0]);
							} else {
								throw new Error('Wrong parameter count for max()');
							}
							if (ar.length === 0) {
								throw new Error('Array must contain at least one element for max()');
							}
						} else {
							ar = argv;
						}
						
						retVal = ar[0];
						for (i = 1, n = ar.length; i < n; ++i) {
							if (_compare(retVal, ar[i]) == 1) {
								retVal = ar[i];
							}
						}
						
						return retVal;
					}
			};

			// element loop
			this.each( function( index, element ) {
				var $list = $( element );
				
				// trigger event: initialize
				$list.trigger( 'repeatable-init' );
				events.init( $list );

				// settings
				$list.settings = $.extend( {
					startIndex: 0,
					indexKeyName: 'index',
					valueKeyName: 'value',
					addButtonLabel: 'Add New',
					addButtonClass: 'btn btn-primary',
					wrapperClass: 'repeatable-wrapper',
					confirmRemoveMessage: 'Are Your Sure ?',
					confirmRemove: 'no',
					emptyListMessage: 'No Items Found',
					values: [],
					is_empty: true
				}, $list.data() );

				// wrap list
				$list.wrap( '<div class="'+ $list.settings.wrapperClass +'" />' );

				// index parsing
				$list.settings.startIndex = parseInt( $list.settings.startIndex );
				
				// repeatable item template
				$list.item_template = $list.find( '> [data-template=yes]' ).removeAttr( 'data-template' ).remove();
				if ( $list.item_template.length !== 1 ) {
					// throw exception cause the template item not set
					throw 'Repeatable Exception: Template item not found.';
				}

				// compiled template function
				$list.item_template_dot = doT.template( $list.item_template.outerHTML() );

				// remove selector
				$list.item_template.remove_selector = $list.item_template.prop( 'tagName' ).toLowerCase();
				$list.item_template.remove_selector += '[class*="'+ $list.item_template.prop( 'className' ) +'"]';

				// create add button and wrap if in p tag
				$( '<p class="add-wrapper"><a href="#" class="'+ $list.settings.addButtonClass +'">'+ $list.settings.addButtonLabel +'</a></p>' )
				// insert after the list
				.insertAfter( $list )
				// click event
				.on( 'click', function( e ) {
					e.preventDefault();

					// add new item
					methods.add_item( $list, $list.settings.startIndex );
				} );

				// add values if any
				if ( typeof $list.settings.values === 'object' ) {
					// loop items for appending indexes
					var data_indexes = [];
					$.each( $list.settings.values, function( item_index, item_data ) {
						if ( typeof item_data.order_index !== 'undefined' ) {
							// use index from item data if exists
							item_index = parseInt( item_data.order_index );
						}
						data_indexes.push( item_index );

						// add new item
						methods.add_item( $list, item_index, item_data );
						$list.settings.is_empty = false;
					} );

					if ( data_indexes.length ) {
						// calculate next index
						$list.settings.startIndex = Math.max.apply( Math, data_indexes ) + 1;
					}
				}

				// empty list label if is set
				if ( $list.settings.is_empty && $list.settings.emptyListMessage != 'no' ) {
					$list.append( '<li class="repeatable-empty">'+ $list.settings.emptyListMessage +'</li>' );
				}

				// remove button
				$list.on( 'click', '[data-remove=yes]', function( e ) {
					e.preventDefault();

					// confirm first
					if ( $list.settings.confirmRemove == 'yes' ) {
						if ( !confirm( $list.settings.confirmRemoveMessage ) ) {
							return false;
						}
					}

					// query the item to remove > remove it
					var $remove_item = $( e.currentTarget ).closest( $list.item_template.remove_selector ).remove();

					// trigger event: item removed
					$list.trigger( 'repeatable-removed', [ $list, $remove_item ] );
					events.removed( $list, $remove_item );
				} );

				// trigger event: initializing completed
				$list.trigger( 'repeatable-completed', [ $list ] );
				events.completed( $list );
			} );

			// chaining
			return this;
		};

		if ( !$.fn.outerHTML ) {
			// get element whole HTML layout
			$.fn.outerHTML = function() {
				return $( '<div />' ).append( this.eq(0).clone() ).html();
			};
		}
	} );
} )( window );