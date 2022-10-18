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
		// add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'menu_styles' ) );
	}

	/**
	 * Scripts
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function scripts() {
		$filename = 'src/js/global.js';
		$file     = FP_ACCOUNT_SETTINGS_DIR_PATH . $filename;
		$version  = file_exists( $file ) ? filemtime( $file ) : '1.0.0';
		$handle   = 'fp-account-settings-global';

		wp_register_script( $handle, FP_ACCOUNT_SETTINGS_DIR_URL . $filename, array(), $version, true );
		wp_enqueue_script( $handle );

		wp_localize_script(
			$handle,
			FP_ACCOUNT_SETTINGS_PREFIX . 'AdminAjax',
			admin_url( 'admin-ajax.php' )
		);
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
		$this->reports_obj = json_decode( SITE_REPORTS_JSON );
		$reports           = $this->reports_obj->reports;
		$pages             = [];

		foreach( $reports as $report ) {

		}

		$hooks = [
			'toplevel_page_site-reports',
			// 'dashboard_page_member_report',
			// 'dashboard_page_pdf_bundles_report',
		];

		if ( in_array( $hook, $hooks, true ) ) {
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
	 * Styles
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function menu_styles() {
		$file     = 'src/css/index.css';
		$css      = trailingslashit( SITE_REPORTS_DIR_PATH ) . $file;
		$filetime = file_exists( $css ) ? filemtime( $css ) : '1.0.0';
		$handle   = 'site-reports-menu';

		wp_register_style( $handle, trailingslashit( SITE_REPORTS_DIR_URL ) . $file, array(), $filetime, 'all' );
		wp_enqueue_style( $handle );
	}
}
