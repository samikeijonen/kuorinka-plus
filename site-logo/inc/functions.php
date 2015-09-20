<?php
/**
 * Our site logo functions and hooks.
 *
 * @package Site_Logo
 * @since 1.0
 */

/**
 * Add our logo uploader to the Customizer.
 *
 * @param object $wp_customize Customizer object.
 * @uses $wp_customize->add_setting
 * @uses $wp_customize->add_control
 * @since 1.0.0
 */
function kuorinka_plus_logo_customize_register( $wp_customize ) {

	/* Include our custom control. */
	require( dirname( __FILE__ ) . '/class-site-logo-control.php' );

	/* === Logo upload. === */
	
	/* Add the logo section. */
	$wp_customize->add_section(
		'logo',
		array(
			'title'    => esc_html__( 'Logo', 'kuorinka-plus' ),
			'priority' => 10,
			'panel'    => 'kuorinka_plus_panel'
		)
	);

	/* Add the setting for our logo value. */
	$wp_customize->add_setting( 'site_logo', array(
		'default' => array(
			'url' => false,
			'id' => 0,
		),
	) );

	/* Add our image uploader. */
	$wp_customize->add_control( new Kuorinka_Plus_Logo_Image_Control( $wp_customize, 'site_logo', array(
	    'label'    => __( 'Site Logo', 'kuorinka-plus' ),
	    'section'  => 'logo',
	    'settings' => 'site_logo',
	) ) );
	
}
add_action( 'customize_register', 'kuorinka_plus_logo_customize_register' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @uses kuorinka_plus_has_site_logo
 * @return array Array of <body> classes
 */
function kuorinka_plus_logo_body_classes( $classes ) {

	/* Add a class if a Site Logo is active. */
	if ( kuorinka_plus_has_site_logo() ) {
		$classes[] = 'has-site-logo';
	}

	return $classes;
}
add_filter( 'body_class', 'kuorinka_plus_logo_body_classes' );

