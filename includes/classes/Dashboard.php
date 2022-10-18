<?php
/**
 * Dashboard
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
 * Dashboard
 *
 * @author Jason Witt
 * @since  1.0.0
 */
class Dashboard {

	/**
	 * Reports
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var object
	 */
	protected $reports_obj;

	/**
	 * Initialize the class
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->reports_obj = json_decode( SITE_REPORTS_JSON );
		$this->reports();
	}

	/**
	 * Init
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function reports() {
		$reports =  $this->reports_obj->reports;

		foreach( $reports as $report ) {
			$classname = SITE_REPORTS_NAMESPACE . 'Reports\\' . $report->name . '\\Template';
			new $classname();
		}
	}
}
