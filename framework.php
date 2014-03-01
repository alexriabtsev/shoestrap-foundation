<?php
/*
Plugin Name: Shoestrap Foundation
Plugin URI: http://wpmu.io
Description: Foundation support for the Shoestrap theme
Version: 0.1
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
*/

define( 'SS_FRAMEWORK', 'foundation' );
define( 'SS_FRAMEWORK_PATH', dirname( __FILE__ ) );

function ss_foundation() {
	// Framework class.
	require_once( dirname( __FILE__ ) . '/class-SS_Framework_Foundation.php' );
}
add_action( 'shoestrap_include_frameworks', 'ss_foundation' );

/**
 * Define the framework.
 * These will be used in the redux admin option to choose a framework.
 */
function ss_define_foundation() {
	$framework = array(
		'shortname' => 'foundation',
		'name'      => 'Foundation',
		'classname' => 'SS_Framework_Foundation',
		'compiler'  => 'sass_php'
	);

	return $framework;
}
add_filter( 'shoestrap_frameworks_array', 'ss_add_framework_foundation', 20 );

/**
 * Add the framework to redux
 */
function ss_add_framework_foundation( $frameworks ) {
	$frameworks[] = ss_define_foundation();

	return $frameworks;
}