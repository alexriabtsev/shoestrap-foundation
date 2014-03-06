<?php
/*
Plugin Name: Shoestrap Foundation
Plugin URI: http://wpmu.io
Description: Foundation support for the Shoestrap theme
Version: 0.2
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
GitHub Plugin URI: https://github.com/shoestrap/shoestrap-foundation
*/

define( 'SS_FRAMEWORK', 'foundation' );
define( 'SS_FRAMEWORK_PATH', dirname( __FILE__ ) );

if ( !defined( 'SSF_PLUGIN_URL' ) )
	define( 'SSF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Add the framework class.
 * We add this at using an action because it extends a class that has not been loaded yet.
 */
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
 * Add the framework to redux.
 * This simply loads the array of frameworks that already exist, and adds a row to that array.
 */
function ss_add_framework_foundation( $frameworks ) {
	$frameworks[] = ss_define_foundation();

	return $frameworks;
}