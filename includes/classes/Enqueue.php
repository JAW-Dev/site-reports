<?php
/**
 * Enqueue.
 *
 * @package    Site_Reports
 * @subpackage Site_Reports/Inlcudes/Classes
 * @author     Jason Witt
 * @copyright  Copyright (c) 2022, Jason Witt
 * @license    GNU General Public License v2 or later
 * @since      1.0.0
 */

namespace Site_Reports\Includes\Classes;

if ( ! defined( 'WPINC' ) ) {
	wp_die( 'No Access Allowed!', 'Error!', array( 'back_link' => true ) );
}

/**
 * Enqueue.
 *
 * @author Jason Witt
 * @since  1.0.0
 */
class Enqueue {

	/**
	 * Initialize the class
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Hooks
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'styles' ) );
	}

	/**
	 * Scripts
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @param string $hook The page hook.
	 *
	 * @return void
	 */
	public function scripts( $hook ) {
		if ( in_array( $hook, $this->get_hooks(), true ) ) {
			$filename = 'src/js/admin.js';
			$file     = SITE_REPORTS_DIR_PATH . $filename;
			$version  = file_exists( $file ) ? filemtime( $file ) : '1.0.0';
			$handle   = 'fp-account-settings-admin';

			wp_register_script( $handle, SITE_REPORTS_DIR_URL . $filename, array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ), $version, true );
			wp_enqueue_script( $handle );

				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'jquery-ui-core' );
				wp_enqueue_script( 'jquery-ui-datepicker' );

			wp_localize_script(
				$handle,
				FP_ACCOUNT_SETTINGS_PREFIX . 'AdminAjax',
				admin_url( 'admin-ajax.php' )
			);
		}
	}

	/**
	 * Styles
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @param string $hook The page hook.
	 *
	 * @return void
	 */
	public function styles( $hook ) {
		if ( in_array( $hook, $this->get_hooks(), true ) ) {
			$admin_file     = 'src/css/admin.css';
			$admin_css      = trailingslashit( SITE_REPORTS_DIR_PATH ) . $admin_file;
			$admin_filetime = file_exists( $admin_css ) ? filemtime( $admin_css ) : '1.0.0';
			$admin_handle   = 'site-reports';

			wp_register_style( $admin_handle, trailingslashit( SITE_REPORTS_DIR_URL ) . $admin_file, array(), $admin_filetime, 'all' );
			wp_enqueue_style( $admin_handle );

			wp_enqueue_style( 'jquery-ui-datepicker-style', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.min.css', array(), '1.11.4', 'all' ); // phpcs:ignore
		}
	}

	/**
	 * Get Hooks
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function get_hooks() {
		$slugs = $this->get_reports_slugs();
		$hooks = [ 'toplevel_page_site-reports' ];

		foreach( $slugs as $slug ) {
			$hooks[] = "site-reports_page_${slug}_report";
		}

		return $hooks;
	}

	/**
	 * Get Reports Slugs
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function get_reports_slugs() {
		$this->reports_obj = json_decode( SITE_REPORTS_JSON );
		$reports           = $this->reports_obj->reports;
		$slugs             = [];

		foreach( $reports as $report ) {
			$slugs[] = $report->slug;
		}

		return $slugs;
	}
}
