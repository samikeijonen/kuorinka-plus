<?php
/**
 * Template tags for using site logos.
 *
 * @package Site_Logo
 */

/**
 * Retrieve the site logo URL or ID (URL by default). Pass in the string 'id' for ID.
 *
 * @uses get_theme_mod()
 * @uses esc_url_raw()
 * @uses set_url_scheme()
 * @return mixed The URL or ID of our site logo, false if not set
 * @since 1.0.0
 */
function kuorinka_plus_logo( $show = 'url' ) {

	$logo = get_theme_mod( 'site_logo' );

	// Return false if no logo is set
	if ( ! $logo ) {
		return false;
	}

	// Return the ID if specified, otherwise return the URL by default
	if ( 'id' == $show ) {
		return $logo;
	} else {
		$image_attributes = wp_get_attachment_image_src( absint( $logo ), apply_filters( 'kuorinka_plus_logo_size', 'full' ) ); // returns an array
		return esc_url( $image_attributes[0] );
	}
	
}

function kuorinka_plus_logo_dimensions( $dimension = 'width' ) {

	$logo = get_theme_mod( 'site_logo' );

	/* Return false if no logo is set. */
	if ( ! isset( $logo ) || '' == $logo ) {
		return false;
	}
	
	$image_attributes = wp_get_attachment_image_src( absint( $logo ), apply_filters( 'kuorinka_plus_logo_size', 'full' ) ); // returns an array
	
	/* Calculate ratio. */
	$image_ratio = $image_attributes[2] / $image_attributes[1] * 100;
	
	/* Return the ratio or height if specified, otherwise return the width by default. */
	if ( 'ratio' == $dimension ) {
		return esc_attr( $image_ratio );
	} elseif ( 'height' == $dimension ) {
		return absint( $image_attributes[2] );
	} else {
		return absint( $image_attributes[1] );
	}
	
}

function kuorinka_plus_logo_styles() {

	/* If no logo, return. */
	if ( ! kuorinka_plus_has_site_logo() ) {
		return;
	}
	?>
	<style type="text/css">
	
		@media screen and (max-width: 899px) {
			
			.has-site-logo #site-title .site-title-inner {
				margin-left: auto;
				margin-right: auto;
				
			}
		
		}
	
		.has-site-logo #site-title .site-title-inner {
			display: block;
			width: <?php echo kuorinka_plus_logo_dimensions(); ?>px;
			max-width: 100%;
			background: url(<?php echo kuorinka_plus_logo(); ?>) no-repeat;
			background-size: contain;
			background-position: center center;
		}


		/* Retina background for logo. */
		@media screen and (-webkit-min-device-pixel-ratio: 1.3),
		screen and (min--moz-device-pixel-ratio: 1.3), 
		screen and (-o-min-device-pixel-ratio: 2 / 1),
		screen and (min-device-pixel-ratio: 1.3),
		screen and (min-resolution: 192dpi),
		screen and (min-resolution: 2dppx) {

			/* For somehow we need to put styles again, background is not enough. At least for chrome in Samsung II it didn't work. */
			.has-site-logo #site-title .site-title-inner {
				display: block;
				width: <?php echo kuorinka_plus_logo_dimensions(); ?>px;
				max-width: 100%;
				background: url(<?php echo kuorinka_plus_logo(); ?>) no-repeat;
				background-size: contain;
				background-position: center center;
			}

		}

		.has-site-logo #site-title .site-title-inner a {
			display: block;
			width: 100%;
			height: 0;
			padding-bottom: <?php echo kuorinka_plus_logo_dimensions( 'ratio' ); ?>%; /* height/width = something */	
			overflow: hidden;
			text-indent: 100%;
			white-space: nowrap;
			text-shadow: none;
			color: transparent;
		}
		
	</style>
	<?php
	
}
add_action( 'wp_head', 'kuorinka_plus_logo_styles' );

/**
 * Determine if a site logo is assigned or not.
 *
 * @uses get_theme_mod
 * @return boolean True if there is an active logo, false otherwise
 * @since 1.0.0
 */
function kuorinka_plus_has_site_logo() {

	$logo = get_theme_mod( 'site_logo' );
	return ( $logo ) ? true : false;
	
}
