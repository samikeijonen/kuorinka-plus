<?php

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Converts a hex color to RGB.  Returns the RGB values as an array.
 *
 * @since  1.0.0
 * @return array
 */
function kuorinka_plus_hex_to_rgb( $hex ) {

	/* Remove "#" if it was added. */
	$color = trim( $hex, '#' );

	/* If the color is three characters, convert it to six. */
        if ( 3 === strlen( $color ) )
		$color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];

	/* Get the red, green, and blue values. */
	$red   = hexdec( $color[0] . $color[1] );
	$green = hexdec( $color[2] . $color[3] );
	$blue  = hexdec( $color[4] . $color[5] );

	/* Return the RGB colors as an array. */
	return array( 'r' => $red, 'g' => $green, 'b' => $blue );
}

/**
 * Output styles from the Customizer.
 *
 * @since  1.0.0
 * @return void
 */

function kuorinka_plus_output_styles() {
 
/* Get out if we do not want to output styles. */
if( ! get_theme_mod( 'enable_colors', 0 ) ) {
	return;
}

/* Here is a list of used colors to help you out.
 *
 * Dark color for text and hover:           #303030
 * Lighter color for text:                  #555
 *
 * Dark color for titles and borders:       #054e92
 * Lighter color for links and backgrounds: #1668b5
 * Color for text with above backgrounds:   #fff
 *
 * Light background color:                  #e6eff7
 
 * For front page sticky post border:       #aacef0
 */

$kuorinka_plus_body_color      = get_theme_mod( 'body_color', '303030' );

$kuorinka_plus_light_color     = get_theme_mod( 'light_color', '555555' );

$kuorinka_plus_dark_color      = get_theme_mod( 'dark_color', '054e92' );
$kuorinka_plus_dark_color_rgb  = kuorinka_plus_hex_to_rgb( $kuorinka_plus_dark_color );

$kuorinka_plus_link_color      = get_theme_mod( 'link_color', '1668b5' );

$kuorinka_plus_link_text_color = get_theme_mod( 'link_text_color', 'ffffff' );

$kuorinka_plus_light_bg_color  =  get_theme_mod( 'light_bg_color', 'e6eff7' );
 
?>

<style id="kuorinka-plus-colors">

body,
button,
input,
select,
textarea {
	color: #<?php echo $kuorinka_plus_body_color; ?>;
}

.breadcrumb-trail,
.loop-description,
.wp-caption-text,
#colophon .site-info,
input[type="text"],
input[type="email"],
input[type="url"],
input[type="password"],
input[type="search"],
textarea,
input,
blockquote {
	color: #<?php echo $kuorinka_plus_light_color; ?>;
}

.entry-title,
.sidebar .genericon,
.sidebar .genericon::before,
.kuorinka-front-page-content .genericon,
.kuorinka-front-page-content .genericon::before,
.screen-reader-text:hover,
.screen-reader-text:active,
.screen-reader-text:focus {
	color: #<?php echo $kuorinka_plus_dark_color; ?>;
}

a,
a:visited,
a:hover,
a:focus,
a:active {
	color: #<?php echo $kuorinka_plus_link_color; ?>;
}

button,
input[type="button"],
input[type="reset"],
input[type="submit"],
.entry a.portfolio-item-link,
.kuorinka-callout .kuorinka-button,
body #infinite-handle span {
	color: #fff;
}

/* == Menu colors and backgrounds == */

#menu-primary li:hover > a,
#menu-primary li.focus > a,
button#nav-toggle:hover,
button#nav-toggle:focus,
button#nav-toggle.focus,
#menu-primary li.current-menu-item,
#menu-primary li.current-menu-item > a,
#menu-primary ul ul a:hover,
#menu-primary ul ul li.focus > a {
	background-color: #<?php echo $kuorinka_plus_body_color; ?>;
	color: #<?php echo kuorinka_plus_link_text_color; ?>;
}

.custom-header-image #kuorinka-header-image img.header-image {
	border-top: 6px solid #<?php echo $kuorinka_plus_dark_color; ?>;
}

@media screen and (max-width: 899px) {

	.nav-collapse li a,
	button#nav-toggle {
		background: #<?php echo $kuorinka_plus_dark_color; ?>;
		background: rgba(<?php echo $kuorinka_plus_dark_color_rgb['r'] . ',' . $kuorinka_plus_dark_color_rgb['g'] . ',' . $kuorinka_plus_dark_color_rgb['b']; ?>,0.92);
		border-bottom: 1px solid #<?php echo $kuorinka_plus_light_bg_color; ?>;
		color: #<?php echo $kuorinka_plus_link_text_color; ?>;
	}
	button#nav-toggle.active {
		border-bottom: 1px solid #<?php echo $kuorinka_plus_light_bg_color; ?>;
	}

}

@media screen and (min-width: 900px) {
	
	#menu-primary .wrap {
		background: #<?php echo $kuorinka_plus_dark_color; ?>;
	}
	.custom-header-image.primary-menu-active #menu-primary .wrap {
		background-color: rgba(<?php echo $kuorinka_plus_dark_color_rgb['r'] . ',' . $kuorinka_plus_dark_color_rgb['g'] . ',' . $kuorinka_plus_dark_color_rgb['b']; ?>,0.92);
	}

	#menu-primary a {
		color: #<?php echo $kuorinka_plus_link_text_color; ?>;
	}

	#menu-primary ul ul {
		background-color: #<?php echo $kuorinka_plus_dark_color; ?>;
		background-color: rgba(<?php echo $kuorinka_plus_dark_color_rgb['r'] . ',' . $kuorinka_plus_dark_color_rgb['g'] . ',' . $kuorinka_plus_dark_color_rgb['b']; ?>,0.92);
	}

	#menu-primary ul ul a {
		border-bottom: 1px solid #<?php echo $kuorinka_plus_light_bg_color; ?>;
	}

}

/* === 16.3 Backgrounds === */

pre {
	background-color: #<?php echo $kuorinka_plus_light_bg_color; ?>;
	background-image: -webkit-gradient(linear,0 0,0 100%,color-stop(.5,rgba(255,255,255,.5)),color-stop(.5,transparent),to(transparent));
	background-image: -webkit-linear-gradient(rgba(255,255,255,.5) 50%,transparent 50%,transparent);
	background-image: -moz-linear-gradient(rgba(255,255,255,.5) 50%,transparent 50%,transparent);
	background-image: -o-linear-gradient(rgba(255,255,255,.5) 50%,transparent 50%,transparent);
	background-image: linear-gradient(rgba(255,255,255,.5) 50%,transparent 50%,transparent);
}

mark,
ins {
	background: #fff9c0;
}

button,
input[type="button"],
input[type="reset"],
input[type="submit"],
.entry a.portfolio-item-link,
.kuorinka-callout .kuorinka-button,
body #infinite-handle span {
	background: #<?php echo $kuorinka_plus_link_color; ?>;
}
button:hover,
input[type="button"]:hover,
input[type="reset"]:hover,
input[type="submit"]:hover,
.entry a.portfolio-item-link:hover,
.kuorinka-callout .kuorinka-button:hover,
button:focus,
input[type="button"]:focus,
input[type="reset"]:focus,
input[type="submit"]:focus,
.entry a.portfolio-item-link:focus,
.kuorinka-callout .kuorinka-button:focus,
button:active,
input[type="button"]:active,
input[type="reset"]:active,
input[type="submit"]:active,
.entry a.portfolio-item-link:active,
.kuorinka-callout .kuorinka-button:active,
body #infinite-handle span:hover,
body #infinite-handle span:focus,
body #infinite-handle span:active {
	background: #<?php echo $kuorinka_plus_body_color; ?>;
}

hr,
#sidebar-header,
#menu-portfolio ul li a,
li.bypostauthor,
.widget-title,
.sticky,
.sticky.entry,
.page-links a,
.single-portfolio_item .entry-terms.portfolio a,
.screen-reader-text:hover,
.screen-reader-text:active,
.screen-reader-text:focus,
body #gforms_confirmation_message,
.post-type-archive-portfolio_item .entry-header,
.tax-portfolio .entry-header,
.term-post-format-video .entry-header,
.kuorinka-callout {
	background: #<?php echo $kuorinka_plus_light_bg_color; ?>;
}

#masthead .site-branding,
.breadcrumb-trail .wrap,
#kuorinka-header-image,
#content > .wrap,
#sidebar-subsidiary .wrap,
#colophon #menu-social,
#colophon .site-info {
	background: #<?php echo $kuorinka_plus_link_text_color; ?>;
}

/* === 16.4 Borders === */

abbr,
acronym {
	border-bottom: 1px dotted #<?php echo $kuorinka_plus_light_color; ?>;
}

blockquote {
	border: 2px dotted #<?php echo $kuorinka_plus_dark_color; ?>;
}

table {
	border-right: 1px solid #<?php echo $kuorinka_plus_light_bg_color; ?>;
}
th,
td {
	border-top: 1px solid #<?php echo $kuorinka_plus_light_bg_color; ?>;
	border-left: 1px solid #<?php echo $kuorinka_plus_light_bg_color; ?>;
	border-bottom: 1px solid #<?php echo $kuorinka_plus_light_bg_color; ?>;
}

input[type="text"],
input[type="email"],
input[type="url"],
input[type="password"],
input[type="search"],
textarea {
	border: 4px solid #<?php echo $kuorinka_plus_light_bg_color; ?>;
}
input[type="text"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="password"]:focus,
input[type="search"]:focus,
textarea:focus {
	border-color: #<?php echo $kuorinka_plus_link_color; ?>;
}

fieldset {
	border: 1px solid #<?php echo $kuorinka_plus_light_bg_color; ?>;
}

.loop-meta {
	border-bottom: 1px solid #<?php echo $kuorinka_plus_light_bg_color; ?>;
}

@media screen and (max-width: 899px) {
	
	.comment-navigation .nav-previous,
	.paging-navigation .nav-previous,
	.post-navigation .nav-previous {
		border-bottom: 2px solid #<?php echo $kuorinka_plus_light_bg_color; ?>;
	}

}

.widget-title,
.sticky,
.sticky.entry,
li.bypostauthor,
.post-type-archive-portfolio_item .entry-header .entry-title,
.tax-portfolio .entry-header .entry-title,
.term-post-format-video .entry-header .entry-title {
	border-bottom: 2px solid #<?php echo $kuorinka_plus_dark_color; ?>;
}

.entry-header .entry-title {
	border-bottom: 4px double #<?php echo $kuorinka_plus_light_bg_color; ?>;
}
.sticky .entry-header .entry-title {
	border-bottom-color: #aacef0;
}

.comment-list > li {
	border-bottom: solid 3px #<?php echo $kuorinka_plus_light_bg_color; ?>;
}

body #webshare-wrapper {
	border-top-color: #<?php echo $kuorinka_plus_light_bg_color; ?>;
	border-bottom-color: #<?php echo $kuorinka_plus_light_bg_color; ?>;
}

/* === 16.5 Box Shadows === */

.page-template-pagesfront-page-php .thumbnail {
	box-shadow: 0 0 0 4px #<?php echo $kuorinka_plus_link_text_color; ?>;
}

.format-status .avatar,
.post-type-archive-team-member .avatar,
.post-type-archive-team-member .thumbnail-team-member,
.tax-team-member-category .avatar,
.tax-team-member-category .thumbnail-team-member,
.single-team-member .avatar,
.single-team-member .thumbnail-team-member {
	box-shadow: 0 0 0 4px #<?php echo $kuorinka_plus_light_bg_color; ?>;
}

</style>

<?php 

}
add_action( 'wp_head', 'kuorinka_plus_output_styles' );