<?php
/**
 * Plugin Name: Site Reports
 * Description: Custom WordPress Reports
 * Version:     1.0.0
 * Author:      Jason Witt
 * Author URI:  https://github.com/JAW-Dev
 * License:     GNU General Public License v2 or later
 * Text Domain: site-reports
 * Domain Path: /languages
 *
 * @package    Site_Reports
 * @author     Jason Witt
 * @copyright  Copyright (c) 2022, Jason Witt
 * @license    GNU General Public License v2 or later
 * @version    1.0.0
 */

namespace Site_Reports;

if ( ! defined( 'WPINC' ) ) {
	wp_die( 'No Access Allowed!', 'Error!', array( 'back_link' => true ) );
}

/**
 * Autoloader
 */
if ( file_exists( trailingslashit( plugin_dir_path( __FILE__ ) ) . trailingslashit( 'vendor' ) . 'autoload.php' ) ) {
	require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . trailingslashit( 'vendor' ) . 'autoload.php';
}

/**
 * Constants
 */
if ( file_exists( trailingslashit( plugin_dir_path( __FILE__ ) ) . trailingslashit( 'includes' ) . 'constants.php' ) ) {
	require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . trailingslashit( 'includes' ) . 'constants.php';
}

if ( ! class_exists( __NAMESPACE__ . '\\Site_Reports' ) ) {

	/**
	 * Name
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 */
	class Site_Reports {

		/**
		 * Singleton instance of plugin.
		 *
		 * @var   static
		 * @since 1.0.0
		 */
		protected static $single_instance = null;

		/**
		 * Creates or returns an instance of this class.
		 *
		 * @author Jason Witt
		 * @since  1.0.0
		 *
		 * @return static
		 */
		public static function get_instance() {
			if ( null === self::$single_instance ) {
				self::$single_instance = new self();
			}

			return self::$single_instance;
		}

		/**
		 * Run
		 *
		 * @author Jason Witt
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public function run() {

			// Load translated strings for plugin.
			load_plugin_textdomain( 'site-reports', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

			// Init Classes.
			new Includes\Classes\Init();
		}
	}
}

/**
 * Return an instance of the plugin class.
 *
 * @author Jason Witt
 * @since  1.0.0
 *
 * @return Site_Reports instance of plugin class.
 */
function site_reports() {
	return Site_Reports::get_instance();
}

add_action( 'plugins_loaded', array( site_reports(), 'run' ) );


/**
 * Activation Hook
 *
 * @author Jason Witt
 * @since  1.0.0
 *
 * @return void
 */
register_activation_hook( __FILE__, 'Site_Reports\Includes\Classes\Activation::run' );

/**
 * Deactivation Hook
 *
 * @author Jason Witt
 * @since  1.0.0
 *
 * @return void
 */
register_deactivation_hook( __FILE__, 'Site_Reports\Includes\Classes\Deactivation::run' );
