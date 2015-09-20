<?php

/**
 * Activate the Site Logo plugin. Code is based on site logo on WordPress.com
 *
 * Author: Automattic
 * Author URI: http://wordpress.com
 * License: GPL2 or later
 *
 * @link https://github.com/Automattic/site-logo
 *
 * @since 1.0.0
 */
function kuorinka_plus_logo_activate() {
	
	// Load hooks and functions.
	require( dirname( __FILE__ ) . '/inc/functions.php' );

	// Load template tags.
	require( dirname( __FILE__ ) . '/inc/template-tags.php' );
	
}
add_action( 'init', 'kuorinka_plus_logo_activate' );

