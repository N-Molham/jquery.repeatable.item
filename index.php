<?php 
$output = filter_input( INPUT_GET, 'output' );
if ( $output )
	ob_start();
?><!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/prettify.min.css">
		<link rel="stylesheet" href="css/showcase.min.css">
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<title>jQuery Repeatable List Item by N-Molham</title>
	</head>

	<body>
		<div id="main-container" class="container">
			<?php
			$options = array (
					'data-start-index' => array ( 
							'value' => '<strong>Integer</strong>, default <code>0</code>',
							'description' => 'The index to start counting from to put in the repeated template.',
					),
					'data-index-key-name' => array ( 
							'value' => '<strong>String</strong>, default <code>index</code>',
							'description' => 'The <code>{index key name}</code> placeholder used in the template replaced with index number.',
					),
					'data-value-key-name' => array ( 
							'value' => '<strong>String</strong>, default <code>value</code>',
							'description' => 'The <code>{value key name}</code> placeholder used in the template replaced with value.',
					),
					'data-template-selector' => array (
							'value' => '<strong>String</strong>, default <code>empty string</code>',
							'description' => 'The query selector for the script template container <code>script[type="text/template"]</code>.',
					),
					'data-add-button-label' => array (
							'value' => '<strong>String</strong>, default <code>Add New</code>',
							'description' => 'Add new item button label.',
					),
					'data-add-button-class' => array ( 
							'value' => '<strong>String</strong>, default <code>btn btn-primary</code>',
							'description' => 'Add button <code>class</code> attribute value.',
					),
					'data-wrapper-class' => array ( 
							'value' => '<strong>String</strong>, default <code>repeatable-wrapper</code>',
							'description' => 'Class name of the list wrapper <code>div</code>.',
					),
					'data-confirm-remove' => array ( 
							'value' => '<code>yes</code> or <code>no</code>, default <code>no</code>',
							'description' => 'Wither to confirm before removing item or not.',
					),
					'data-confirm-remove-message' => array ( 
							'value' => '<strong>String</strong>, default <code>Are Your Sure ?</code>',
							'description' => 'The message user sees to confirm.',
					),
					'data-empty-list-message' => array ( 
							'value' => '<strong>String</strong>, default <code>'. htmlentities( '<li>No Items Found</li>' ) .'</code><br/>'.
										'set to <code>item</code> if you want a pre added empty item by default or empty string for no message',
							'description' => 'The message users sees if there are no items added yet in the list.',
					),
					'data-default-item' => array ( 
							'value' => '<strong>Object</strong>, default <code>{}</code>',
							'description' => 'The default list item values used in adding new item, <strong>Required</strong> when using <code>doT.js</code> template engine',
					),
					'data-values' => array ( 
							'value' => '<strong>JSON</strong>, default <code>[]</code>',
							'description' => 'Default values to fill the list with on start, <strong>JSON</strong> array object.',
					),
			);

			$events = array (
					'repeatable-init' => array (
							'parameters' => array ( 
									'None',
							),
							'description' => 'Triggers when the list is initializing.',
					),
					'repeatable-completed' => array (
							'parameters' => array ( 
									'The list jQuery element',
							),
							'description' => 'Triggers when the list is initialized and ready.',
					),
					'repeatable-new-item' => array (
							'parameters' => array ( 
									'The list jQuery element',
									'The new item jQuery element added to the list',
									'The index replaced the <code>{index}</code> placeholder',
									'The data object that parsed to replace the corresponding placeholders',
							),
							'description' => 'Triggers when the a new item added to the list.',
					),
					'repeatable-removed' => array (
							'parameters' => array ( 
									'The list jQuery element',
									'The remove item jQuery element',
							),
							'description' => 'Triggers when an item removed from the list.',
					),
			);
			?>

			<h1 class="page-header">jQuery Repeatable List Item</h1>
			<p class="lead">Repeatable item with doT.js template engine</p>

			<section class="downloads">
				<a href="https://raw.githubusercontent.com/N-Molham/jquery.repeatable.item/master/js/dist/jquery.repeatable.item.min.js" class="btn btn-primary btn-lg">
					<i class="fa fa-file-code-o fa-lg"></i> JS ( Minified )
				</a>
				&nbsp;
				<a href="https://github.com/N-Molham/jquery.repeatable.item/zipball/master" class="btn btn-success btn-lg">
					<i class="fa fa-file-archive-o fa-lg"></i> Download .zip
				</a>
				&nbsp;
				<a href="https://github.com/N-Molham/jquery.repeatable.item" class="btn btn-default btn-lg">
					<i class="fa fa-github fa-lg"></i> View on GitHub
				</a>
			</section>

			<section>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Full Options List ( Data Attributes )</h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<colgroup>
									<col class="col-xs-3">
									<col class="col-xs-4">
									<col class="col-xs-5">
								</colgroup>
								<thead>
									<tr>
										<th>Option</th>
										<th>Value</th>
										<th>Description</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach ( $options as $option_name => $option_info )
									{
										echo '<tr><td><code>', $option_name ,'</code></td>';
										echo '<td>', $option_info['value'] ,'</td>';
										echo '<td>', $option_info['description'] ,'</td></tr>';
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>

			<section>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Events</h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<colgroup>
									<col class="col-xs-3">
									<col class="col-xs-4">
									<col class="col-xs-5">
								</colgroup>
								<thead>
									<tr>
										<th>Event</th>
										<th>Parameters</th>
										<th>Description</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach ( $events as $event_name => $event_info )
									{
										echo '<tr><td><code>', $event_name ,'</code></td>';
										echo '<td><ul>';
										foreach ( $event_info['parameters'] as $parameter )
										{
											echo '<li><p>', $parameter ,'</p></li>';
										}
										echo '</ul></td>';
										echo '<td>', $event_info['description'] ,'</td></tr>';
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>

			<section>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Simple List</h3>
					</div>
					<div class="panel-body">
						<ul class="list-unstyled repeatable" data-empty-list-message="<?php echo htmlentities( '<li><p class="alert alert-info">No Items Yet</p></li>' ); ?>">
							<li data-template="yes" class="list-item">
								<div class="row">
									<p class="col-md-10"><input type="text" name="input[{index}]" placeholder="Input Label" class="form-control" /></p>
									<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
								</div>
							</li>
						</ul>
			
						<p class="page-header">Code :</p>
						<pre class="prettyprint"><?php echo htmlentities( '
<!-- If you want HTML content as the empty message, just escape HTML entities, ex: in PHP -->
<?php 
$empty_msg = htmlentities( \'<li><p class="alert alert-info">No Items Yet</p></li>\' );
?>

<!-- List -->
<ul class="repeatable" data-empty-list-message="<?php echo $empty_msg; ?>">
	<li data-template="yes" class="list-item">
		<div class="row">
			<p class="col-md-10"><input type="text" name="input[{index}]" class="form-control" /></p>
			<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
		</div>
	</li>
</ul>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.repeatable.item.js"></script>
<script>
( function ( window ) {
	jQuery( function( $ ) {
		$( \'.repeatable\' ).repeatable_item();
	});
} )( window );
</script>
' ); ?>
						</pre>
					</div>
				</div>
			</section>

			<section>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">List With Item Added By Default</h3>
					</div>
					<div class="panel-body">
						<ul class="list-unstyled repeatable" data-empty-list-message="item">
							<li data-template="yes" class="list-item">
								<div class="row">
									<p class="col-md-10"><input type="text" name="input[{index}]" placeholder="Input Label" class="form-control" /></p>
									<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
								</div>
							</li>
						</ul>

						<p class="page-header">Code :</p>
						<pre class="prettyprint"><?php echo htmlentities( '
<!-- If you want an empty item added by default to the list -->
<!-- List -->
<ul class="repeatable" data-empty-list-message="item">
	<li data-template="yes" class="list-item">
		<div class="row">
			<p class="col-md-10"><input type="text" name="input[{index}]" class="form-control" /></p>
			<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
		</div>
	</li>
</ul>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.repeatable.item.js"></script>
<script>
( function ( window ) {
	jQuery( function( $ ) {
		$( \'.repeatable\' ).repeatable_item();
	});
} )( window );
</script>
' ); ?>
						</pre>
					</div>
				</div>
			</section>

			<section>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">List With Data Array</h3>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" role="form">
							<ul class="list-unstyled repeatable" data-confirm-remove="yes" data-values="{&quot;1&quot;:&quot;jon.deo@mail.com&quot;,&quot;3&quot;:&quot;will.smith@mail.com&quot;,&quot;5&quot;:&quot;sean.connery@mail.com&quot;}">
								<li data-template="yes" class="list-item">
									<div class="row">
										<p class="col-md-10"><input type="email" name="input[{index}]" placeholder="Email" class="form-control" value="{value}" /></p>
										<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
									</div>
								</li>
							</ul>
						</form>
			
						<p class="page-header">Code :</p>
						<pre class="prettyprint"><?php echo htmlentities( '
<!-- Data JSON -->
<?php
$data = array (
	1 => "jon.deo@mail.com",
	3 => "will.smith@mail.com",
	5 => "sean.connery@mail.com",
);

$data_json = htmlentities( json_encode( $data ) );
?>

<!-- List -->
<ul class="repeatable" data-confirm-remove="yes" data-values="<?php echo $data_json; ?>">
	<li data-template="yes" class="list-item">
		<div class="row">
			<p class="col-md-10"><input type="text" name="input[{index}]" placeholder="Input Label" class="form-control" value="{value}" /></p>
			<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
		</div>
	</li>
</ul>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.repeatable.item.js"></script>
<script>
( function ( window ) {
	jQuery( function( $ ) {
		$( \'.repeatable\' ).repeatable_item();
	});
} )( window );
</script>
' ); ?>
						</pre>
					</div>
				</div>
			</section>
			
			<section>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Array of Objects with <code>doT.js</code> Template</h3>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" role="form">
							<?php
							$data_json = htmlentities( json_encode( array ( 
									array ( 
										'name' => 'Will Smith',
										'email' => 'will.smith@mail.com',
										'gender' => 'male',
									),
									array ( 
										'name' => 'Emma Watson',
										'email' => 'emma.watson@mail.com',
										'gender' => 'female',
									),
									array ( 
										'name' => 'Sean Connery',
										'email' => 'sean.connery@mail.com',
										'gender' => 'male',
									),
							) ) );

							// default item required
							$default_item_json = htmlentities( json_encode( array ( 
									'name' => '',
									'email' => '',
									'gender' => '',
							) ) );
							?>
							<ul class="list-unstyled repeatable" data-confirm-remove="yes" data-default-item="<?php echo $default_item_json; ?>" data-values="<?php echo $data_json; ?>">
								<li data-template="yes" class="list-item">
									<div class="form-group">
										<label for="user[{index}][name]" class="col-md-2 control-label">Name</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="user[{index}][name]" id="user[{index}][name]" placeholder="Name" value="{{=it.name}}" />
										</div>
									</div>
									<div class="form-group">
										<label for="user[{index}][email]" class="col-md-2 control-label">Email</label>
										<div class="col-md-8">
											<input type="email" class="form-control"name="user[{index}][email]"  id="user[{index}][email]" placeholder="Email" value="{{=it.email}}" />
										</div>
									</div>
									<div class="form-group">
										<label for="user[{index}][gender]" class="col-md-2 control-label">Gender</label>
										<div class="col-md-8">
											<div class="radio-inline">
												<label>
													{{ if( it.gender === 'male' ) { }}
													<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="male" checked="checked" />
													{{ } else { }}
													<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="male" />
													{{ } }}
													Male
												</label>
											</div>
											<div class="radio-inline">
												<label>
													{{ if( it.gender === 'female' ) { }}
													<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="female" checked="checked" />
													{{ } else { }}
													<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="female" />
													{{ } }}
													Female
												</label>
											</div>
										</div>
										<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
									</div>
									<hr class="divider" />
								</li>
							</ul>
						</form>
			
						<p class="page-header">Code :</p>
						<pre class="prettyprint"><?php echo htmlentities( '
<!-- Data JSON -->
<?php
$data_json = htmlentities( json_encode( array (
		array (
			"name" => "Will Smith",
			"email" => "will.smith@mail.com",
			"gender" => "male",
		),
		array (
			"name" => "Emma Watson",
			"email" => "emma.watson@mail.com",
			"gender" => "female",
		),
		array (
			"name" => "Sean Connery",
			"email" => "sean.connery@mail.com",
			"gender" => "male",
		),
) ) );

// default item required
$default_item_json = htmlentities( json_encode( array (
		"name" => "",
		"email" => "",
		"gender" => "",
) ) );
?>

<!-- List -->
<ul class="repeatable" data-confirm-remove="yes" data-default-item="<?php echo $default_item_json; ?>" data-values="<?php echo $data_json; ?>">
	<li data-template="yes" class="list-item">
		<div class="form-group">
			<label for="user[{index}][name]" class="col-md-2 control-label">Name</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="user[{index}][name]" id="user[{index}][name]" placeholder="Name" value="{{=it.name}}" />
			</div>
		</div>
		<div class="form-group">
			<label for="user[{index}][email]" class="col-md-2 control-label">Email</label>
			<div class="col-md-8">
				<input type="email" class="form-control"name="user[{index}][email]"  id="user[{index}][email]" placeholder="Email" value="{{=it.email}}" />
			</div>
		</div>
		<div class="form-group">
			<label for="user[{index}][gender]" class="col-md-2 control-label">Gender</label>
			<div class="col-md-8">
				<div class="radio-inline">
					<label>
						{{ if( it.gender === \'male\' ) { }}
						<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="male" checked="checked" />
						{{ } else { }}
						<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="male" />
						{{ } }}
						Male
					</label>
				</div>
				<div class="radio-inline">
					<label>
						{{ if( it.gender === \'female\' ) { }}
						<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="female" checked="checked" />
						{{ } else { }}
						<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="female" />
						{{ } }}
						Female
					</label>
				</div>
			</div>
			<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
		</div>
		<hr class="divider" />
	</li>
</ul>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.repeatable.item.js"></script>
<script>
( function ( window ) {
	jQuery( function( $ ) {
		$( \'.repeatable\' ).repeatable_item();
	});
} )( window );
</script>
' ); ?>
						</pre>
					</div>
				</div>
			</section>

			<section>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Using <code>script</code> template tag attribute</h3>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" role="form">
							<?php
							$data_json = htmlentities( json_encode( array (
									array (
										'name' => 'Will Smith',
										'email' => 'will.smith@mail.com',
										'gender' => 'male',
									),
									array (
										'name' => 'Emma Watson',
										'email' => 'emma.watson@mail.com',
										'gender' => 'female',
									),
									array (
										'name' => 'Sean Connery',
										'email' => 'sean.connery@mail.com',
										'gender' => 'male',
									),
							) ) );

							// default item required
							$default_item_json = htmlentities( json_encode( array (
									'name' => '',
									'email' => '',
									'gender' => '',
							) ) );
							?>

							<script type="text/template" id="item-template">
								<li class="list-item">
									<div class="form-group">
										<label for="user[{index}][name]" class="col-md-2 control-label">Name</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="user[{index}][name]" id="user[{index}][name]" placeholder="Name" value="{{=it.name}}" />
										</div>
									</div>
									<div class="form-group">
										<label for="user[{index}][email]" class="col-md-2 control-label">Email</label>
										<div class="col-md-8">
											<input type="email" class="form-control"name="user[{index}][email]"  id="user[{index}][email]" placeholder="Email" value="{{=it.email}}" />
										</div>
									</div>
									<div class="form-group">
										<label for="user[{index}][gender]" class="col-md-2 control-label">Gender</label>
										<div class="col-md-8">
											<div class="radio-inline">
												<label>
													{{ if( it.gender === 'male' ) { }}
													<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="male" checked="checked" />
													{{ } else { }}
													<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="male" />
													{{ } }}
													Male
												</label>
											</div>
											<div class="radio-inline">
												<label>
													{{ if( it.gender === 'female' ) { }}
													<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="female" checked="checked" />
													{{ } else { }}
													<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="female" />
													{{ } }}
													Female
												</label>
											</div>
										</div>
										<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
									</div>
									<hr class="divider" />
								</li>
							</script>

							<ul class="list-unstyled repeatable" data-confirm-remove="yes" data-template-selector="#item-template" data-default-item="<?php echo $default_item_json; ?>" data-values="<?php echo $data_json; ?>"></ul>
						</form>

						<p class="page-header">Code :</p>
						<pre class="prettyprint"><?php echo htmlentities( '
<!-- Data JSON -->
<?php
$data_json = htmlentities( json_encode( array (
		array (
			"name" => "Will Smith",
			"email" => "will.smith@mail.com",
			"gender" => "male",
		),
		array (
			"name" => "Emma Watson",
			"email" => "emma.watson@mail.com",
			"gender" => "female",
		),
		array (
			"name" => "Sean Connery",
			"email" => "sean.connery@mail.com",
			"gender" => "male",
		),
) ) );

// default item required
$default_item_json = htmlentities( json_encode( array (
		"name" => "",
		"email" => "",
		"gender" => "",
) ) );
?>

<!-- template -->
<script type="text/template" id="item-template">
<li class="list-item">
	<div class="form-group">
		<label for="user[{index}][name]" class="col-md-2 control-label">Name</label>
		<div class="col-md-8">
			<input type="text" class="form-control" name="user[{index}][name]" id="user[{index}][name]" placeholder="Name" value="{{=it.name}}" />
		</div>
	</div>
	<div class="form-group">
		<label for="user[{index}][email]" class="col-md-2 control-label">Email</label>
		<div class="col-md-8">
			<input type="email" class="form-control"name="user[{index}][email]"  id="user[{index}][email]" placeholder="Email" value="{{=it.email}}" />
		</div>
	</div>
	<div class="form-group">
		<label for="user[{index}][gender]" class="col-md-2 control-label">Gender</label>
		<div class="col-md-8">
			<div class="radio-inline">
				<label>
					{{ if( it.gender === "male" ) { }}
					<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="male" checked="checked" />
					{{ } else { }}
					<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="male" />
					{{ } }}
					Male
				</label>
			</div>
			<div class="radio-inline">
				<label>
					{{ if( it.gender === "female" ) { }}
					<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="female" checked="checked" />
					{{ } else { }}
					<input type="radio" name="user[{index}][gender]" id="user[{index}][gender]" value="female" />
					{{ } }}
					Female
				</label>
			</div>
		</div>
		<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
	</div>
	<hr class="divider" />
</li>
</script>

<!-- list -->
<ul class="list-unstyled repeatable" data-confirm-remove="yes" data-template-selector="#item-template" data-default-item="<?php echo $default_item_json; ?>" data-values="<?php echo $data_json; ?>"></ul>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.repeatable.item.js"></script>
<script>
( function ( window ) {
	jQuery( function( $ ) {
		$( \'.repeatable\' ).repeatable_item();
	});
} )( window );
</script>
' ); ?>
						</pre>
					</div>
				</div>
			</section>

			<section>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Events Dump</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-5">
								<ul id="catch-events" class="list-unstyled repeatable" data-confirm-remove="yes">
									<li data-template="yes">
										<div class="row">
											<p class="col-md-10"><input type="text" name="input[{index}]" placeholder="Input Label" class="form-control" /></p>
											<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
										</div>
									</li>
								</ul>
							</div>
							<ul id="events-dump" class="col-md-5 col-md-offset-2"></ul>
						</div>

						<p class="page-header">Code :</p>
						<pre class="prettyprint"><?php echo htmlentities( '
<!-- List -->
<ul id="catch-events" class="list-unstyled repeatable" data-confirm-remove="yes">
	<li data-template="yes">
		<div class="row">
			<p class="col-md-10"><input type="text" name="input[{index}]" placeholder="Input Label" class="form-control" /></p>
			<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
		</div>
	</li>
</ul>

<!-- Event List to display it -->
<ul id="events-dump"></ul>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.repeatable.item.js"></script>
<script>
( function ( window ) {
	jQuery( function( $ ) {
		// First: listen for the events
		var event_date = new Date( e.timeStamp );
		$( "#events-dump" ).append( "<li><p><code>"+ e.type +"</code> On <strong>"+ event_date.toDateString() +" "+ event_date.toLocaleTimeString( "en-us" ) +"</strong></p></li>" );

		// Second: apply the plugin
		$( ".repeatable" ).repeatable_item();
	});
} )( window );
</script>
' ); ?>
						</pre>
					</div>
				</div>
			</section>

			<footer>
				jQuery Repeatable List Item is maintained by <a href="https://github.com/N-Molham">N-Molham</a><br>
			</footer>
		</div><!-- #main-container -->

		<!-- Scripts -->
		<script src="<?php echo $output ? 'js/jquery.min.js' : 'bower_components/jquery/dist/jquery.min.js'; ?>"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="js/prettify.js"></script>
		<script src="<?php echo $output ? 'js/doT.min.js' : 'bower_components/doT/doT.min.js'; ?>"></script>
		<script src="<?php echo $output ? 'js/jquery.repeatable.item.min.js' : 'js/src/jquery.repeatable.item.js'; ?>"></script>
		<script>
		( function ( window ) {
			jQuery( function( $ ) {
				// prettyPrint init
				window.prettyPrint && prettyPrint();

				// First: listen for the events
				$( '#catch-events' ).on( 'repeatable-init repeatable-completed repeatable-new-item repeatable-removed', function( e ) {
					var event_date = new Date( e.timeStamp );
					$( '#events-dump' ).append( '<li><p><code>'+ e.type +'</code> On <strong>'+ event_date.toDateString() +' '+ event_date.toLocaleTimeString( 'en-us' ) +'</strong></p></li>' );
				} );

				// Second: apply the plugin
				$( '.repeatable' ).repeatable_item();
			} );
		} )( window );
		</script>
	</body>
</html><?php 
if ( $output )
	file_put_contents( 'index.html', ob_get_flush() );