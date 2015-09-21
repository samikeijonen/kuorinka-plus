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
	$wp_customize->add_setting(
		'site_logo',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint'
		)
	);

	/* Add our image uploader. */
	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
				'site_logo',
				array(
					'label'       => __( 'Site Logo', 'kuorinka-plus' ),
					'section'     => 'logo',
					'flex_width'  => true,
					'flex_height' => true,
					'width'       => 240,
					'height'      => 80,
				)
		)
	);
	
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

