
<!DOCTYPE html>
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
							'value' => '<strong>String</strong>, default <code>No Items Found</code>',
							'description' => 'The message users sees if there are no items added yet in the list.',
					),
					'data-values' => array ( 
							'value' => '<strong>JSON</strong>, default <code>[]</code> empty Array',
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
									<col class="col-xs-2">
									<col class="col-xs-3">
									<col class="col-xs-7">
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
									<col class="col-xs-2">
									<col class="col-xs-4">
									<col class="col-xs-6">
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
						<ul class="list-unstyled repeatable" data-empty-list-message="<?php echo htmlentities( '<p class="alert alert-info">No Items Yet</p>' ); ?>">
							<li data-template="yes" class="list-item">
								<div class="row">
									<p class="col-md-10"><input type="text" name="input[{index}]" placeholder="Input Label" class="form-control" /></p>
									<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
								</div>
							</li>
						</ul>
			
						<p class="page-header">Code :</p>
						<pre class="prettyprint"><?php echo htmlentities( '
<!-- Empty list html entities -->
<?php 
$empty_msg = \'No Items Yet\';
?>

<!-- If you want HTML content as the empty message, just escape HTML entities, ex: in PHP -->
<?php 
$empty_msg = htmlentities( \'<p class="alert alert-info">No Items Yet</p>\' );
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
						<h3 class="panel-title">List With Multidimensional Data Array</h3>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" role="form">
							<ul class="list-unstyled repeatable" data-confirm-remove="yes" data-values="[{&quot;name&quot;:&quot;Jeo Deo&quot;,&quot;email&quot;:&quot;jon.deo@mail.com&quot;},{&quot;name&quot;:&quot;Will Smith&quot;,&quot;email&quot;:&quot;will.smith@mail.com&quot;},{&quot;name&quot;:&quot;Sean Connery&quot;,&quot;email&quot;:&quot;sean.connery@mail.com&quot;}]">
								<li data-template="yes" class="list-item">
									<div class="form-group">
										<label for="user[{index}][name]" class="col-md-2 control-label">Name</label>
										<div class="col-md-8">
											<input type="email" class="form-control" id="user[{index}][name]" placeholder="Name" value="{{=it.name}}" />
										</div>
									</div>
									<div class="form-group">
										<label for="user[{index}][email]" class="col-md-2 control-label">Email</label>
										<div class="col-md-8">
											<input type="email" class="form-control" id="user[{index}][email]" placeholder="Email" value="{{=it.email}}" />
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
$data = array (
	array (
		"name" => "Jeo Deo",
		"email" => "jon.deo@mail.com",
	),
	array (
		"name" => "Will Smith",
		"email" => "will.smith@mail.com",
	),
	array (
		"name" => "Sean Connery",
		"email" => "sean.connery@mail.com",
	),
);

$data_json = htmlentities( json_encode( $data ) );
?>

<!-- List -->
<ul class="repeatable" data-confirm-remove="yes" data-values="<?php echo $data_json; ?>">
	<li data-template="yes" class="list-item">
		<div class="form-group">
			<label for="user[{index}][name]" class="col-md-2 control-label">Name</label>
			<div class="col-md-8">
				<input type="email" class="form-control" id="user[{index}][name]" placeholder="Name" value="{name}" />
			</div>
		</div>
		<div class="form-group">
			<label for="user[{index}][email]" class="col-md-2 control-label">Email</label>
			<div class="col-md-8">
				<input type="email" class="form-control" id="user[{index}][email]" placeholder="Email" value="{email}" />
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
						<h3 class="panel-title">Events Dump</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6">
								<ul id="catch-events" class="list-unstyled repeatable" data-confirm-remove="yes">
									<li data-template="yes">
										<div class="row">
											<p class="col-md-10"><input type="text" name="input[{index}]" placeholder="Input Label" class="form-control" /></p>
											<p class="col-md-2"><a href="#" class="btn btn-default" data-remove="yes">Remove</a></p>
										</div>
									</li>
								</ul>
							</div>
							<ul id="events-dump" class="col-md-4 col-md-offset-1"></ul>
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
		$( \'#catch-events\' ).on( \'repeatable-init repeatable-completed repeatable-new-item repeatable-removed\', function( e ) {
			$( \'#events-dump\' ).append( \'<li><p><code>\'+ e.type +\'</code> On <strong>\'+ e.timeStamp +\'</strong></p></li>\' );
		} );

		// Second: apply the plugin
		$( \'.repeatable\' ).repeatable_item();
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
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="js/prettify.js"></script>
		<script src="bower_components/doT/doT.min.js"></script>
		<script src="js/src/jquery.repeatable.item.js"></script>
		<script>
		( function ( window ) {
			jQuery( function( $ ) {
				window.prettyPrint && prettyPrint();
				$( '.repeatable' ).repeatable_item();
			} );
		} )( window );
		</script>
	</body>
</html>