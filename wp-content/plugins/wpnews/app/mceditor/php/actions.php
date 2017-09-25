<?php


	// load wordpress functions
	require( '../../../../../../wp-load.php' );

	define('_PLUGINPATH_',plugin_dir_path( __FILE__ ).'/');
	define('_PLUGINURL_',plugin_dir_url( __FILE__ ).'/');

$args = array(
      'orderby' => 'id',
      'hide_empty'=> 0  
  );
  $categories = get_categories($args);

		echo json_encode($categories);