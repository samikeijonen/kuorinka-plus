<?php

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add wrapper around archive page for Our Team Plugin.
 *
 * @since  1.0.0
 */
function kuorinka_plus_before_loop() {

	if( is_post_type_archive( 'team-member' ) || is_tax( 'team-member-category' ) || is_post_type_archive( 'portfolio_item' ) || is_tax( 'portfolio' ) || is_tax( 'post_format', 'post-format-video' ) ) { ?>
		<div class="kuorinka-plus-wrapper">
	<?php }
	
}
add_action( 'kuorinka_before_loop' , 'kuorinka_plus_before_loop' );

/**
 * Add wrapper around archive page for Our Team Plugin.
 *
 * @since  1.0.0
 */
function kuorinka_plus_after_loop() {

	if( is_post_type_archive( 'team-member' ) || is_tax( 'team-member-category' ) | is_post_type_archive( 'portfolio_item' ) || is_tax( 'portfolio' ) || is_tax( 'post_format', 'post-format-video' ) ) { ?>
		</div>
	<?php }
	
}
add_action( 'kuorinka_close_loop' , 'kuorinka_plus_after_loop' );

/**
 * Remove content filter from Our Team Plugin.
 *
 * @since  1.0.0
 */
remove_filter( 'the_content', 'woothemes_our_team_content' );

/**
 * Add content from Our Team Plugin.
 *
 * @since  1.0.0
 */
function kuorinka_plus_our_theme_author_details() {

	/* Get our theme details. */
	$team_member_email 	= esc_attr( get_post_meta( get_the_ID(), '_gravatar_email', true ) );
	$user 				= esc_attr( get_post_meta( get_the_ID(), '_user_id', true ) );
	$user_search 		= esc_attr( get_post_meta( get_the_ID(), '_user_search', true ) );
	$twitter 			= esc_attr( get_post_meta( get_the_ID(), '_twitter', true ) );
	$role				= esc_attr( get_post_meta( get_the_ID(), '_byline', true ) );
	$url 				= esc_url( get_post_meta( get_the_ID(), '_url', true ) );
	$tel 				= esc_attr( get_post_meta( get_the_ID(), '_tel', true ) );
	$contact_email 		= esc_attr( get_post_meta( get_the_ID(), '_contact_email', true ) );
	
	if( empty( $team_member_email ) && empty( $user ) && empty( $user_search ) && empty( $twitter ) && empty( $role ) && empty( $url ) && empty( $tel ) && empty( $contact_email ) ) {
		return;
	}
	
	$author = '';
	
	$author .= '<div class="author-details">';
 
	$member_fields = '';
				
	if ( '' != $contact_email && apply_filters( 'woothemes_our_team_member_contact_email', true ) ) {
		$member_fields .= '<span class="our-team-contact-email" itemprop="email"><a href="mailto:' . esc_html( $contact_email ) . '">' . sprintf( __( 'Email %1$s', 'kuorinka-plus' ), get_the_title() ) . '</a></span>';
	}
 
	if ( '' != $tel && apply_filters( 'woothemes_our_team_member_tel', true ) ) {
		$call_protocol = apply_filters( 'woothemes_our_team_call_protocol', $protocol = 'tel' );
		$member_fields .= '<span class="our-team-tel" itemprop="telephone"><span>' . __( 'Tel: ', 'kuorinka-plus' ) . '</span><a href="' . $call_protocol . ':' . esc_html( $tel ) . '">' . esc_html( $tel ) . '</a></span>';
	}
				
	if ( apply_filters( 'woothemes_our_team_member_user_id', true ) ) {
		if ( 0 == $user && '' != $user_search ) {
			$user = get_user_by( 'slug', $user_search );
			if ( $user ) {
				$user = $user;
			}
		}
 
		if ( 0 != $user ) {
			$member_fields .= '<span class="our-team-author-archive" itemprop="url"><a href="' . get_author_posts_url( $user ) . '">' . sprintf( __( 'Read posts by %1$s', 'kuorinka-plus' ), get_the_title() ) . '</a></span>' . "\n";
		}
	}
 
	if ( '' != $twitter && apply_filters( 'woothemes_our_team_member_twitter', true ) ) {
		$member_fields .= '<span class="our-team-twitter" itemprop="contactPoint"><a href="//twitter.com/' . esc_html( $twitter ) . '" class="twitter-follow-button">' . sprintf( __( 'Follow @%1$s', 'kuorinka-plus' ), esc_html( $twitter ) ) . '</a></span>'  . "\n";
	}
	if ( '' != $url && apply_filters( 'woothemes_our_team_member_url', true ) ) {
		$member_fields .= '<span class="our-team-url" itemprop="url"><a href="' . $url . '" class="url-follow-link">' . __( 'Personal website', 'kuorinka-plus' ) . '</a></span>'  . "\n";
	}
 
	$author .= apply_filters( 'woothemes_our_member_fields_display', $member_fields );
 
	$author .= '</div>';
 
	return $author;
}

function kuorinka_plus_team_order( $query ) {

	if ( ( is_post_type_archive( 'team-member' ) || is_tax( 'team-member-category' ) ) && $query->is_main_query() ) {
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
	}

}
add_action( 'pre_get_posts', 'kuorinka_plus_team_order' );

/**
 * Change Schema to Person when visiting team member page or archive.
 *
 * @since  1.0.0
 */
function kuorinka_plus_team_member_schema( $attr ) {

	if( is_post_type_archive( 'team-member' ) || is_tax( 'team-member-category' ) || is_singular( 'team-member' ) ) {
		$attr['itemtype'] = "http://schema.org/Person";
	}
	
	return $attr;
}
add_filter( 'hybrid_attr_post', 'kuorinka_plus_team_member_schema' );

/**
 * Change entry-title Schema to name when visiting team member page or archive.
 *
 * @since  1.0.0
 */
function kuorinka_plus_team_member_title( $attr ) {

	if( is_post_type_archive( 'team-member' ) || is_tax( 'team-member-category' ) || is_singular( 'team-member' ) ) {
		$attr['itemprop'] = 'name';
	}
	
	return $attr;
}
add_filter( 'hybrid_attr_entry-title', 'kuorinka_plus_team_member_title' );

/**
 * Function for deciding which pages should have a one-column layout.
 *
 * @since  1.0.0
 */
function kuorinka_plus_one_column( $layout ) {

	if ( is_post_type_archive( 'team-member' ) || is_tax( 'team-member-category' ) ) {
		$layout = '1c';
	} elseif ( is_post_type_archive( 'portfolio_item' ) || is_tax( 'portfolio' ) || is_tax( 'post_format', 'post-format-video' ) ) {
		$layout = '1c';
	}
	
	return $layout;
	
}
add_filter( 'theme_mod_theme_layout', 'kuorinka_plus_one_column', 1 );

/**
* Callout text and link in front page template.
*
* @since  1.0.0
*/
function kuorinka_plus_callout_output() {
	
	/* Start output. */
	$output = '';

	/* Output callout link and text on front page template. */
	if ( is_page_template( 'pages/front-page.php' ) && ( get_theme_mod( 'callout_title' ) || get_theme_mod( 'callout_url' ) || get_theme_mod( 'callout_url_text' ) || get_theme_mod( 'callout_text' ) ) ) {
		
		/* Start output. */
		$output .= '<section id="kuorinka-callout" class="kuorinka-callout">';
		
		/* Callout title. */
		if( get_theme_mod( 'callout_title' ) ) {
			$output .= '<h1 class="kuorinka-callout-title">' . esc_attr( get_theme_mod( 'callout_title' ) ) . '</h1>';
		}
		
		/* Callout text. */
		if( get_theme_mod( 'callout_text' ) ) {
			$output .= '<div class="kuorinka-callout-text">' . apply_filters( 'kuorinka_plus_the_content', esc_textarea( get_theme_mod( 'callout_text' ) ) ) . '</div>';
		}
		
		/* Callout link. */
		if( get_theme_mod( 'callout_url' ) && get_theme_mod( 'callout_url_text' ) ) {
			$output .= '<div class="kuorinka-callout-link"><a class="kuorinka-button kuorinka-callout-link-anchor" href="' . esc_url( get_theme_mod( 'callout_url' ) ) . '">' . esc_textarea( get_theme_mod( 'callout_url_text' ) ) . '</a></div>';
		}
		
		/* End output. */
		$output .= '</section>';
		
	}
	
	return $output;
	
}

/**
* Echo Callout in front page template.
*
* @since  1.0.0
*/
function kuorinka_plus_echo_callout() {

	$echo_output = kuorinka_plus_callout_output();

	if( !empty( $echo_output ) ) {
		echo $echo_output;
	}

}
add_action( 'kuorinka_after_front_page_sidebar', 'kuorinka_plus_echo_callout' );

/**
* Add icons in front page widgets.
*
* @since  1.0.0
*/
function kuorinka_plus_after_widget_title( $args ) {

	/* Get location. */
	$location = esc_attr( get_theme_mod( 'show_icons', 'after' ) );
	
	/* Check where to show icons. If none match, do not show at all. */
	if( 'before' == $location ) {
		$args['before_title'] = '<p class="kuorinka-after-widget-title"><i class="genericon genericon-front-page-widget"></i></p>' . $args['before_title'];
	} elseif ( 'after' == $location ) {
		$args['after_title'] = $args['after_title'] . '<p class="kuorinka-after-widget-title"><i class="genericon genericon-front-page-widget"></i></p>';
	}
	
	/* Return arguments. */
	return $args;
	
}
add_filter( 'kuorinka_sidebar_front_page_args' , 'kuorinka_plus_after_widget_title' ); // we use the default priority and 3 arguments in the callback function

/**
 * Duplicate 'the_content' filters.
 *
 * @since  1.0.2
 */
add_filter( 'kuorinka_plus_the_content', 'wptexturize'        );
add_filter( 'kuorinka_plus_the_content', 'convert_smilies'    );
add_filter( 'kuorinka_plus_the_content', 'convert_chars'      );
add_filter( 'kuorinka_plus_the_content', 'wpautop'            );
add_filter( 'kuorinka_plus_the_content', 'shortcode_unautop'  );
add_filter( 'kuorinka_plus_the_content', 'do_shortcode'       );
add_filter( 'kuorinka_plus_the_content', 'prepend_attachment' );
add_filter( 'kuorinka_plus_the_content', 'capital_P_dangit'   );

// Add filters for oEmbed.
global $wp_embed;
add_filter( 'kuorinka_plus_the_content', array( $wp_embed, 'autoembed' ), 8 );