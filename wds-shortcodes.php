<?php
/**
 * Plugin Name: WDS Shortcodes
 * Plugin URI:  http://webdevstudios.com
 * Description: Base plugin/classes/functionality for creating shortcodes.
 * Version:     1.0.6
 * Author:      WebDevStudios
 * Author URI:  http://webdevstudios.com
 * Donate link: http://webdevstudios.com
 * License:     GPLv2
 * Text Domain: wds-shortcodes
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/WebDevStudios/WDS-Shortcodes
 */

/**
 * WDS_Shortcodes loader
 *
 * Handles checking for and smartly loading the newest version of this library.
 *
 * @category  WordPressLibrary
 * @package   WDS_Shortcodes
 * @author    WebDevStudios <contact@webdevstudios.com>
 * @copyright 2016 WebDevStudios <contact@webdevstudios.com>
 * @license   GPL-2.0+
 * @version   1.0.6
 * @link      https://github.com/WebDevStudios/WDS-Shortcodes
 * @since     1.0.0
 */

/**
 * Copyright (c) 2016 WebDevStudios (email : contact@webdevstudios.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Loader versioning: http://jtsternberg.github.io/wp-lib-loader/
 */

if ( ! class_exists( 'WDS_Shortcodes_106', false ) ) {

	/**
	 * Versioned loader class-name
	 *
	 * This ensures each version is loaded/checked.
	 *
	 * @category WordPressLibrary
	 * @package  WDS_Shortcodes
	 * @author   WebDevStudios <contact@webdevstudios.com>
	 * @license  GPL-2.0+
	 * @version  1.0.6
	 * @link     https://github.com/WebDevStudios/WDS-Shortcodes
	 * @since    1.0.0
	 */
	class WDS_Shortcodes_106 {

		/**
		 * WDS_Shortcodes version number
		 * @var   string
		 * @since 1.0.0
		 */
		const VERSION = '1.0.6';

		/**
		 * Current version hook priority.
		 * Will decrement with each release
		 *
		 * @var   int
		 * @since 1.0.0
		 */
		const PRIORITY = 9993;

		/**
		 * Starts the version checking process.
		 * Creates WDS_SHORTCODES_LOADED definition for early detection by
		 * other scripts.
		 *
		 * Hooks WDS_Shortcodes_Base inclusion to the wds_shortcodes_load hook
		 * on a high priority which decrements (increasing the priority) with
		 * each version release.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			if ( ! defined( 'WDS_SHORTCODES_LOADED' ) ) {
				/**
				 * A constant you can use to check if WDS_Shortcodes is loaded
				 * for your plugins/themes with WDS_Shortcodes dependency.
				 *
				 * Can also be used to determine the priority of the hook
				 * in use for the currently loaded version.
				 */
				define( 'WDS_SHORTCODES_LOADED', self::PRIORITY );
			}

			// Use the hook system to ensure only the newest version is loaded.
			add_action( 'wds_shortcodes_load', array( $this, 'include_lib' ), self::PRIORITY );

			/*
			 * Hook in to the first hook we have available and
			 * fire our `wds_shortcodes_load' hook.
			 */
			add_action( 'muplugins_loaded', array( __CLASS__, 'fire_hook' ), 9 );
			add_action( 'plugins_loaded', array( __CLASS__, 'fire_hook' ), 9 );
			add_action( 'after_setup_theme', array( __CLASS__, 'fire_hook' ), 9 );
		}

		/**
		 * Fires the wds_shortcodes_load action hook.
		 *
		 * @since 1.0.0
		 */
		public static function fire_hook() {
			if ( ! did_action( 'wds_shortcodes_load' ) ) {
				// Then fire our hook.
				do_action( 'wds_shortcodes_load' );
			}
		}

		/**
		 * A final check if the wds_shortcodes function exists before kicking off
		 * our WDS_Shortcodes_Base loading.
		 *
		 * WDS_SHORTCODES_VERSION, WDS_SHORTCODES_DIR, WDS_SHORTCODES_URL, and WDS_SHORTCODES_BASENAME
		 * constants are set at this point.
		 *
		 * @since  1.0.0
		 */
		public function include_lib() {
			if ( function_exists( 'wds_shortcodes' ) ) {
				return;
			}

			if ( ! defined( 'WDS_SHORTCODES_VERSION' ) ) {
				/**
				 * Defines the currently loaded version of WDS_Shortcodes.
				 */
				define( 'WDS_SHORTCODES_VERSION', self::VERSION );
			}

			if ( ! defined( 'WDS_SHORTCODES_DIR' ) ) {
				/**
				 * Defines the directory of the currently loaded version of WDS_Shortcodes.
				 */
				define( 'WDS_SHORTCODES_DIR', dirname( __FILE__ ) . '/' );
			}

			if ( ! defined( 'WDS_SHORTCODES_URL' ) ) {
				$url = apply_filters( 'wds_shortcodes_plugin_url', plugin_dir_url( __FILE__ ) );
				/**
				 * Defines the URL of the currently loaded version of WDS_Shortcodes.
				 */
				define( 'WDS_SHORTCODES_URL', $url );
			}

			if ( ! defined( 'WDS_SHORTCODES_BASENAME' ) ) {
				/**
				 * Defines the basename of the currently loaded version of WDS_Shortcodes.
				 */
				define( 'WDS_SHORTCODES_BASENAME', plugin_basename( __FILE__ ) );
			}

			// Include and initiate WDS_Shortcodes_Base.
			require_once WDS_SHORTCODES_DIR . 'includes/init.php';
		}

	}

	// Kick it off.
	new WDS_Shortcodes_106;
}
