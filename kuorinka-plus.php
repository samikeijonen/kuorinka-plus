<?php
/**
 * Plugin Name: Kuorinka Plus
 * Plugin URI:  https://foxland.fi/downloads/kuorinka-plus
 * Description: Adds new features for Kuorinka Theme.
 * Version:     1.0.3
 * Author:      Sami Keijonen
 * Author URI:  https://foxland.fi
 * Text Domain: kuorinka-plus
 * Domain Path: /languages
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Kuorinka Plus
 * @version    1.0.3
 * @author     Sami Keijonen <sami.keijonen@foxnet.fi>
 * @copyright  Copyright (c) 2014, Sami Keijonen
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
 
/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Sets up and initializes the Kuorinka Plus plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
final class Kuorinka_Plus {

	/**
	 * Holds the instances of this class.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance;
	
    /**
     * The name of the plugin.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $plugin_name = 'Kuorinka Plus';

    /**
     * Unique plugin slug identifier.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $plugin_slug = 'kuorinka-plus';
	
    /**
     * Theme/Plugin shop URL.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $remote_api_url = 'http://foxland.fi';
	
    /**
     * Plugin author.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $author = 'Sami Keijonen';

    /**
     * Plugin file.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $file = __FILE__;

	/**
	 * Sets up needed actions/filters for the plugin to initialize.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Set the constants needed by the plugin. */
		add_action( 'plugins_loaded', array( $this, 'constants' ), 1 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 2 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( $this, 'includes' ), 3 );
		
		/* Register scripts and styles. */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 11 );
		
		/* Enable Plugin Updater. */
		add_action( 'init', array( $this, 'plugin_updater' ) );
		
		/* Disable updates for this plugin name from WordPress.org. */
		add_filter( 'http_request_args', array( $this, 'disable_wporg_request' ), 5, 2 );
		
	}

	/**
	 * Defines constants for the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	function constants() {

		/* Set the version number of the plugin. */
		define( 'KUORINKA_PLUS_VERSION', '1.0.3' );

		/* Set constant path to the plugin directory. */
		define( 'KUORINKA_PLUS_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		/* Set constant path to the plugin URI. */
		define( 'KUORINKA_PLUS_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
	}
	
	/**
	 * Loads the translation files.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	function i18n() {
		load_plugin_textdomain( 'kuorinka-plus', false, 'kuorinka-plus/languages' );
	}

	/**
	 * Loads files from the '/inc' folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	function includes() {
	
		require_once( KUORINKA_PLUS_DIR . 'inc/meta-boxes.php' );
		require_once( KUORINKA_PLUS_DIR . 'inc/functions.php' );
		require_once( KUORINKA_PLUS_DIR . 'site-logo/site-logo.php' );
		require_once( KUORINKA_PLUS_DIR . 'inc/customize.php' );
		require_once( KUORINKA_PLUS_DIR . 'inc/output-styles.php' );
		
	}
	
	/**
	 * Loads the stylesheet for the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public static function enqueue_scripts() {

		/* Use the .min stylesheet if SCRIPT_DEBUG is turned off. */
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		/* Dequeue Grid Columns CSS and roll your own. */
		wp_dequeue_style( 'grid-columns' );		

		/* Enqueue the stylesheet. */
		wp_enqueue_style(
			'kuorinka-plus',
			trailingslashit( plugin_dir_url( __FILE__ ) ) . "css/kuorinka-plus$suffix.css",
			null,
			KUORINKA_PLUS_VERSION
		);
	}
	
	/**
	 * Loads the plugin updater.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function plugin_updater() {
	
		/* If we're not in admin, get out. */
		if( ! is_admin() ) {
			return;
		}

		/* Includes the files needed for the plugin updater in admin. */
		if ( !class_exists( 'EDD_Plugin_Updater_Admin' ) ) {
			include( dirname( __FILE__ ) . '/plugin-updater/plugin-updater-admin.php' );
		}

		/* Loads the admin updater class */
		$updater = new EDD_Plugin_Updater_Admin(
			array(
				'remote_api_url' => $this->remote_api_url,  // Site where EDD is hosted
				'item_name'      => $this->plugin_name,     // Name of the plugin
				'plugin_slug'    => $this->plugin_slug,     // Plugin slug
				'version'        => KUORINKA_PLUS_VERSION,  // The current version of this theme
				'author'         => $this->author           // The author of this plugin
			)
		);
		
		/* If there is no valid license key status, don't allow updates. */
		if ( 'valid' != get_option( $this->plugin_slug . '_license_key_status', false ) ) {
			return;
		}

		/* Includes the files needed for the plugin updater. */
		if ( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			// Load our custom theme updater
			include( dirname( __FILE__ ) . '/plugin-updater/plugin-updater-class.php' );
		}
		
        /* Go ahead and initialize the updater. */
		$edd_updater = new EDD_SL_Plugin_Updater( $this->remote_api_url, __FILE__, array(
				'version'   => KUORINKA_PLUS_VERSION,
				'license'   => trim( get_option( $this->plugin_slug . '_license_key' ) ),
				'item_name' => $this->plugin_name,
				'author'    => $this->author
			)
		);
	}
	
	/**
	 * Disable requests to wp.org repository for this plugin.
	 *
	 * @since 1.0.0
	 */
	function disable_wporg_request( $r, $url ) {

		// If it's not a plugin update request, bail.
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/plugins/update-check/1.1/' ) ) {
 			return $r;
 		}

 		// Decode the JSON response
 		$plugins = json_decode( $r['body']['plugins'], true );

 		// Remove plugin from the check
		unset( $plugins['plugins'][plugin_basename( __FILE__ )] );

 		// Encode the updated JSON response
 		$r['body']['plugins'] = json_encode( $plugins );

 		return $r;
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

Kuorinka_Plus::get_instance();
