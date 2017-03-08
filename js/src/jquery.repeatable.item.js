/*!
 * Repeatable list item 1.6.6 (http://n-molham.github.io/jquery.repeatable.item/)
 * Copyright 2014 Nabeel Molham (http://nabeel.molham.me).
 * Licensed under MIT License (http://opensource.org/licenses/MIT)
 */
(function ( win ) {
	"use strict";

	jQuery( function ( $ ) {
		$.fn.repeatable_item = function ( events ) {
			// check if doT.js template engine is available
			if ( typeof doT !== 'object' ) {
				throw 'Repeatable Exception: doT.js Template engine not found, click here https://github.com/olado/doT';
			}

			// default events handler
			events = $.extend( {
				init     : function () {
				},
				completed: function () {
				},
				new_item : function () {
				},
				removed  : function () {
				}
			}, events );

			// plugins methods
			var methods = {
				/**
				 * Clean final item layout from placeholders
				 *
				 * @param {string} layout
				 * @return {string}
				 */
				clean_template_holders: function ( layout ) {
					// index/value cleanup
					var output = layout.replace( /\{[a-zA-Z0-9_\-]+\}/g, '' );

					// clean template placeholders
					output = output.replace( doT.templateSettings.evaluate, '' );
					output = output.replace( doT.templateSettings.interpolate, '' );
					output = output.replace( doT.templateSettings.encode, '' );
					output = output.replace( doT.templateSettings.use, '' );
					output = output.replace( doT.templateSettings.define, '' );
					output = output.replace( doT.templateSettings.conditional, '' );
					output = output.replace( doT.templateSettings.iterate, '' );

					return output;
				},
				/**
				 * Add new list item
				 *
				 * @param {Object} $list
				 * @param {Number} index
				 * @param {any} data
				 * @return void
				 */
				add_item              : function ( $list, index, data ) {
					data = data || false;

					// check empty item
					if ( $list.settings.is_empty ) {
						$list.settings.is_empty = false;
						$list.find( '.repeatable-empty' ).remove();
					}

					// add new index
					var item_content;

					// check data
					switch ( typeof data ) {
						case 'boolean':
							item_content = $list.item_template_dot( $list.settings.defaultItem );
							break;

						case 'object':
							// refill fields data template
							item_content = $list.item_template_dot( data );
							break;

						default:
							// fill in with value
							item_content = $list.item_template.outerHTML().replace( new RegExp( '{' + $list.settings.valueKeyName + '}', 'g' ), data );
							break;
					}

					// add new index
					item_content = item_content.replace( new RegExp( '{' + $list.settings.indexKeyName + '}', 'g' ), index );

					// clear placeholder left overs
					item_content = methods.clean_template_holders( item_content );

					// replace HTML and append to list
					var $new_item = $( item_content ).appendTo( $list );

					// index increment
					$list.settings.startIndex = parseInt( index ) + 1;

					// trigger event: add new
					$list.trigger( 'repeatable-new-item', [ $list, $new_item, index, data ] );
					events.new_item( $list, $new_item, index, data );
				}
			};

			// element loop
			this.each( function ( index, element ) {
				var $list = $( element );

				// trigger event: initialize
				$list.trigger( 'repeatable-init' );
				events.init( $list );

				// settings
				$list.settings = $.extend( {
					startIndex          : 0,
					templateSelector    : '',
					indexKeyName        : 'index',
					valueKeyName        : 'value',
					addButtonLabel      : 'Add New',
					addButtonClass      : 'btn btn-primary',
					wrapperClass        : 'repeatable-wrapper',
					confirmRemoveMessage: 'Are Your Sure ?',
					confirmRemove       : 'no',
					emptyListMessage    : '<li>No Items Found</li>',
					defaultItem         : {},
					values              : [],
					is_empty            : true
				}, $list.data() );

				// wrap list
				$list.wrap( '<div class="' + $list.settings.wrapperClass + '" />' );

				// index parsing
				var start_index = parseInt( $list.settings.startIndex );

				// repeatable item template
				if ( $list.settings.templateSelector == '' ) {
					// use internal template
					$list.item_template = $list.find( '> [data-template=yes]' ).removeAttr( 'data-template' ).remove();
				} else {
					// use external template from query selector
					try {
						$list.item_template = $( $( $list.settings.templateSelector ).html() );
					} catch ( ex ) {
						throw 'Repeatable Exception: Invalid item template selector <' + $list.settings.templateSelector + '>';
					}
				}

				if ( $list.item_template.size() !== 1 ) {
					// throw exception cause the template item not set
					throw 'Repeatable Exception: Template item not found.';
				}

				// compiled template function
				$list.item_template_dot = doT.template( $list.item_template.outerHTML() );

				// remove selector
				$list.item_template.remove_selector = $list.item_template.prop( 'tagName' ).toLowerCase();
				if ( $list.item_template.is( '[class]' ) ) {
					// specified more by class
					$list.item_template.remove_selector += '[class*="' + $list.item_template.prop( 'className' ) + '"]';
				}

				// create add button and wrap if in p tag
				$list.add_new_btn = $( '<p class="add-wrapper"><a href="#" class="' + $list.settings.addButtonClass + '">' + $list.settings.addButtonLabel + '</a></p>' )
				// insert after the list
				.insertAfter( $list )
				// click event
				.on( 'click repeatable-add-click', 'a', function ( e ) {
					e.preventDefault();

					// add new item
					methods.add_item( $list, $list.settings.startIndex );
				} );

				// add values if any
				if ( typeof $list.settings.values === 'object' ) {
					// loop items for appending indexes
					var data_indexes = [];
					$.each( $list.settings.values, function ( item_index, item_data ) {
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
						var max_index = Math.max.apply( Math, data_indexes );

						$list.settings.startIndex = ( max_index > start_index ? max_index : start_index ) + 1;
					}
				}

				if ( $list.settings.is_empty && $list.settings.emptyListMessage.length ) {
					if ( $list.settings.emptyListMessage == 'item' ) {
						// empty list label if is set
						$list.add_new_btn.trigger( 'repeatable-add-click' );
					} else {
						// empty list label if is set
						$list.append( $( $list.settings.emptyListMessage ).addClass( 'repeatable-empty' ) );
					}
				}

				// remove button
				$list.on( 'click', '[data-remove=yes]', function ( e ) {
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
			/**
			 * Get element whole HTML layout
			 *
			 * @returns {*|jQuery}
			 */
			$.fn.outerHTML = function () {
				return $( '<div />' ).append( this.eq( 0 ).clone() ).html();
			};
		}
	} );
})( window );