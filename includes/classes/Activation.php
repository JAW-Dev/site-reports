<?php
/**
 * Activation.
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

if ( ! class_exists( __NAMESPACE__ . '\\Activation' ) ) {

	/**
	 * Activation.
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 */
	class Activation {

		/**
		 * Run
		 *
		 * @author Jason Witt
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public static function run() {
			// code...
			flush_rewrite_rules();
		}
	}
}
