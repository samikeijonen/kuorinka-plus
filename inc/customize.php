<?php

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add settings for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function kuorinka_plus_customize_register( $wp_customize ) {

	$wp_customize->add_panel( 'kuorinka_plus_panel', array(
		'title'    => esc_html__( 'Kuorinka Plus Settings', 'kuorinka-plus' ),
		'priority' => 10
	) );
	
	/* == Navigation section == */
	
	/* Add the navigation section. */
	$wp_customize->add_section(
		'multilevel-navigation',
		array(
			'title'    => esc_html__( 'Navigation settings', 'kuorinka-plus' ),
			'priority' => 5,
			'panel'    => 'kuorinka_plus_panel'
		)
	);
	
	$wp_customize->add_setting(
		'enable_dropdown',
		array(
			'default'           => '',
			'sanitize_callback' => 'kuorinka_plus_sanitize_checkbox'
		)
	);
	
	/* Add multi-level menu control. */
	$wp_customize->add_control(
		'enable_dropdown',
		array(
			'label'       => esc_html__( 'Enable multi-level menu', 'kuorinka-plus' ),
			'description' => esc_html__( 'Check this if you want to enable multi-level dropdown in Primary menu.', 'kuorinka-plus' ),
			'section'     => 'multilevel-navigation',
			'priority'    => 15,
			'type'        => 'checkbox'
		)
	);
	
	/* == Callout section == */
	
	/* Add the callout section. */
	$wp_customize->add_section(
		'front-page',
		array(
			'title'    => esc_html__( 'Front Page Settings', 'kuorinka-plus' ),
			'priority' => 20,
			'panel'    => 'kuorinka_plus_panel'
		)
	);
	
	/* Add the callout title setting. */
	$wp_customize->add_setting(
		'callout_title',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	
	/* Add the callout title control. */
	$wp_customize->add_control(
		'callout-title',
		array(
			'label'    => esc_html__( 'Callout title', 'kuorinka-plus' ),
			'section'  => 'front-page',
			'settings' => 'callout_title',
			'priority' => 20,
			'type'     => 'text'
		)
	);
	
	/* Add the callout text setting. */
	$wp_customize->add_setting(
		'callout_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'kuorinka_plus_customize_sanitize'
		)
	);
	
	/* Add the callout text control. */
	$wp_customize->add_control(
		'callout-text',
		array(
			'label'    => esc_html__( 'Callout text', 'kuorinka-plus' ),
			'section'  => 'front-page',
			'settings' => 'callout_text',
			'priority' => 30,
			'type'     => 'textarea'
		)
	);
	
	/* Add the callout link setting. */
	$wp_customize->add_setting(
		'callout_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw'
 		)
 	);
 	
 	/* Add the callout link control. */
 	$wp_customize->add_control(
 		'callout-url',
 		array(
 			'label'    => esc_html__( 'Callout URL', 'kuorinka-plus' ),
 			'section'  => 'front-page',
 			'settings' => 'callout_url',
 			'priority' => 50,
 			'type'     => 'text'
 		)
 	);
 	
 	/* Add the callout url text setting. */
 	$wp_customize->add_setting(
 		'callout_url_text',
 		array(
 			'default'           => '',
 			'sanitize_callback' => 'sanitize_text_field'
 		)
 	);
 	
 	/* Add the callout url text control. */
 	$wp_customize->add_control(
 		'callout-url-text',
 		array(
 			'label'    => esc_html__( 'Callout URL text', 'kuorinka-plus' ),
 			'section'  => 'front-page',
 			'settings' => 'callout_url_text',
 			'priority' => 60,
			'type'     => 'text'
 		)
	);
	
	/* Add the show icons setting. */
	$wp_customize->add_setting(
		'show_icons',
		array(
			'default'           => 'after',
			'sanitize_callback' => 'kuorinka_plus_sanitize_icons'
		)
	);
	
	$location_choices = array( 
		'no'     => __( 'Do not show icons', 'kuorinka-plus' ),
		'after'  => __( 'Show icons after widget title', 'kuorinka-plus' ),
		'before' => __( 'Show icons before widget title', 'kuorinka-plus' )
	);
	
	/* Add the show icons control. */
	$wp_customize->add_control(
		'show-icons',
		array(
			'label'       => esc_html__( 'Show icons', 'kuorinka-plus' ),
			'description' => esc_html__( 'Select do you want to show icons after or before widget title in front page.', 'kuorinka-plus' ),
			'section'     => 'front-page',
			'settings'    => 'show_icons',
			'priority'    => 70,
			'type'        => 'radio',
			'choices'     => $location_choices
		)
	);
	
	/* Add hide posts setting. */
	$wp_customize->add_setting(
		'hide_front_page_posts',
		array(
			'default'           => '',
			'sanitize_callback' => 'kuorinka_plus_sanitize_checkbox'
		)
	);
	
	/* Add site info control. */
	$wp_customize->add_control(
		'hide-front-page-posts',
		array(
			'label'       => esc_html__( 'Hide posts from front page', 'kuorinka-plus' ),
			'description' => esc_html__( 'Check this if you want to hide latest posts from front page.', 'kuorinka-plus' ),
			'section'     => 'front-page',
			'settings'    => 'hide_front_page_posts',
			'priority'    => 80,
			'type'        => 'checkbox'
		)
	);
	
	/* === Colors section === */
	
	/* Add the colors section. */
	$wp_customize->add_section(
		'add-colors',
		array(
			'title'    => esc_html__( 'Colors', 'kuorinka-plus' ),
			'priority' => 60,
			'panel'    => 'kuorinka_plus_panel'
		)
	);
	
	/* Add enable setting. */
	$wp_customize->add_setting(
		'enable_colors',
		array(
			'default'           => '',
			'sanitize_callback' => 'kuorinka_plus_sanitize_checkbox'
		)
	);
	
	/* Add enable control. */
	$wp_customize->add_control(
		'enable-colors',
		array(
			'label'       => esc_html__( 'Enable colors', 'kuorinka-plus' ),
			'section'     => 'add-colors',
			'settings'    => 'enable_colors',
			'priority'    => 1,
			'description' => esc_html__( 'It is best if you use colors only with parent theme. For more control you should use child themes. Remember to enable colors before they appear on your site.', 'kuorinka-plus' ),
			'type'        => 'checkbox'
		)
	);
	
	/* Add dark color for text and hover setting. */
	$wp_customize->add_setting(
		'body_color',
		array(
			'default'              => '#303030',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
			'sanitize_js_callback' => 'maybe_hash_hex_color'
		)
	);
	
	/* Add dark color for text and hover control. */
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'body-color', 
		array(
			'label'    => __( 'Body Color', 'kuorinka-plus' ),
			'description' => esc_html__( 'Used in body text and buttons hover.', 'kuorinka-plus' ),
			'section'  => 'add-colors',
			'settings' => 'body_color',
			'priority'    => 10
		) ) 
	);
	
	/* Add light color setting. */
	$wp_customize->add_setting(
		'light_color',
		array(
			'default'              => '#555555',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
			'sanitize_js_callback' => 'maybe_hash_hex_color'
		)
	);
	
	/* Add light color control. */
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'light-color', 
		array(
			'label'    => __( 'Light Color', 'kuorinka-plus' ),
			'description' => esc_html__( 'Used in descriptions.', 'kuorinka-plus' ),
			'section'  => 'add-colors',
			'settings' => 'light_color',
			'priority'    => 20
		) ) 
	);
	
	/* Add dark color setting. */
	$wp_customize->add_setting(
		'dark_color',
		array(
			'default'              => '#054e92',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
			'sanitize_js_callback' => 'maybe_hash_hex_color'
		)
	);
	
	/* Add dark color control. */
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'dark-color', 
		array(
			'label'       => __( 'Darker Color', 'kuorinka-plus' ),
			'description' => esc_html__( 'Used for titles and borders.', 'kuorinka-plus' ),
			'section'     => 'add-colors',
			'settings'    => 'dark_color',
			'priority'    => 30
		) ) 
	);
	
	/* Add link color setting. */
	$wp_customize->add_setting(
		'link_color',
		array(
			'default'              => '#1668b5',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
			'sanitize_js_callback' => 'maybe_hash_hex_color'
		)
	);
	
	/* Add link color control. */
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'link-color', 
		array(
			'label'       => __( 'Link Color', 'kuorinka-plus' ),
			'description' => esc_html__( 'Used for links and borders.', 'kuorinka-plus' ),
			'section'     => 'add-colors',
			'settings'    => 'link_color',
			'priority'    => 40,
		) ) 
	);
	
	/* Add link text color setting. */
	$wp_customize->add_setting(
		'link_text_color',
		array(
			'default'              => '#ffffff',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
			'sanitize_js_callback' => 'maybe_hash_hex_color'
		)
	);
	
	/* Add link text color control. */
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'link-text-color', 
		array(
			'label'       => __( 'Link text Color', 'kuorinka-plus' ),
			'description' => esc_html__( 'Used for text and backgrounds.', 'kuorinka-plus' ),
			'section'     => 'add-colors',
			'settings'    => 'link_text_color',
			'priority'    => 50
		) ) 
	);
	
	/* Add light background setting. */
	$wp_customize->add_setting(
		'light_bg_color',
		array(
			'default'              => '#e6eff7',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
			'sanitize_js_callback' => 'maybe_hash_hex_color'
		)
	);
	
	/* Add light background control. */
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'link-bg-color', 
		array(
			'label'       => __( 'Light Background Color', 'kuorinka-plus' ),
			'description' => esc_html__( 'Used for light backgrounds.', 'kuorinka-plus' ),
			'section'     => 'add-colors',
			'settings'    => 'light_bg_color',
			'priority'    => 60,
		) ) 
	);
	
	/* === Footer section === */

	/* Add the footer section. */
	$wp_customize->add_section(
		'footer',
		array(
			'title'    => esc_html__( 'Footer', 'kuorinka-plus' ),
			'priority' => 100,
			'panel'    => 'kuorinka_plus_panel'
		)
	);
	
	/* Add site info setting. */
	$wp_customize->add_setting(
		'hide_site_info',
		array(
			'default'           => '',
			'sanitize_callback' => 'kuorinka_plus_sanitize_checkbox'
		)
	);
	
	/* Add site info control. */
	$wp_customize->add_control(
		'hide-site-info',
		array(
			'label'    => esc_html__( 'Hide site info in footer.', 'kuorinka-plus' ),
			'section'  => 'footer',
			'settings' => 'hide_site_info',
			'priority' => 10,
			'type'     => 'checkbox'
		)
	);
	
	/* Add footer text setting. */
	$wp_customize->add_setting(
		'footer_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'kuorinka_plus_customize_sanitize'
		)
	);
	
	/* Add footer text control. */
	$wp_customize->add_control(
		'footer-text',
		array(
			//'description' => esc_html__( 'Enter footer text.', 'kuorinka-plus' ),
			'label'       => esc_html__( 'Footer text:', 'kuorinka-plus' ),
			'section'     => 'footer',
			'settings'    => 'footer_text',
			'priority'    => 20,
			'type'        => 'textarea'
		)
	);

}
add_action( 'customize_register', 'kuorinka_plus_customize_register' );

/**
 * Sanitize the checkbox value.
 *
 * @since 1.0.0
 *
 * @param string $input checkbox.
 * @return string (1 or null).
 */
function kuorinka_plus_sanitize_checkbox( $input ) {

	if ( 1 == $input ) {
		return 1;
	} else {
		return '';
	}

}

/**
 * Sanitizes the footer content on the customize screen.  Users with the 'unfiltered_html' cap can post 
 * anything. For other users, wp_filter_post_kses() is ran over the setting.
 *
 * @since 1.0.0
 */
function kuorinka_plus_customize_sanitize( $setting, $object ) {

	/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
	if ( 'footer_text' == $object->id && !current_user_can( 'unfiltered_html' ) ) {
		$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
	}

	/* Return the sanitized setting. */
	return $setting;
	
}

/**
 * Sanitize the location of widget icon value.
 *
 * @since 1.0.0
 * @return string Filtered location type (no|after|before).
 */
function kuorinka_plus_sanitize_icons( $location ) {

	if ( ! in_array( $location, array( 'no', 'after', 'before' ) ) ) {
		$location = 'after';
	}

	return $location;
	
}