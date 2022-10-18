<?php
/**
 * Plugin Constants.
 *
 * @package    Site_Reports
 * @subpackage Site_Reports/Inlcudes
 * @author     Jason Witt
 * @copyright  Copyright (c) 2022, Jason Witt
 * @license    GNU General Public License v2 or later
 * @since      1.0.0
 */

if ( ! defined( 'SITE_REPORTS_VERSION' ) ) {
	define( 'SITE_REPORTS_VERSION', '1.0.0.' );
}

if ( ! defined( 'SITE_REPORTS_DIR_URL' ) ) {
	define( 'SITE_REPORTS_DIR_URL', trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) );
}

if ( ! defined( 'SITE_REPORTS_DIR_PATH' ) ) {
	define( 'SITE_REPORTS_DIR_PATH', trailingslashit( plugin_dir_path( dirname( __FILE__ ) ) ) );
}

if ( ! defined( 'SITE_REPORTS_PRFIX' ) ) {
	define( 'SITE_REPORTS_PRFIX', 'site_reports' );
}

if ( ! defined( 'SITE_REPORTS_JSON' ) ) {
	$filepath = plugin_dir_path( dirname( __FILE__ ) ) . 'reports.json';

	if ( file_exists( $filepath ) ) {
		$reports = file_get_contents( $filepath );
		define( 'SITE_REPORTS_JSON', $reports );
	}
}

if ( ! defined( 'SITE_REPORTS_NAMESPACE' ) ) {
	define( 'SITE_REPORTS_NAMESPACE', 'Site_Reports\\Includes\\Classes\\' );
}
