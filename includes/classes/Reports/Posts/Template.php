<?php
/**
 * Posts Template
 *
 * @package    Site_Reports
 * @subpackage Site_Reports/Inlcudes/Classes/Reports/Posts
 * @author     Jason Witt
 * @copyright  Copyright (c) 2022, Jason Witt
 * @license    GNU General Public License v2 or later
 * @since      1.0.0
 */

namespace Site_Reports\Includes\Classes\Reports\Posts;

use Site_Reports\Includes\Classes\Abstracts\TemplateAbstract;

if ( ! defined( 'WPINC' ) ) {
	wp_die( 'No Access Allowed!', 'Error!', array( 'back_link' => true ) );
}

/**
 * Template
 *
 * @author Jason Witt
 * @since  1.0.0
 */
class Template extends TemplateAbstract {

	/**
	 * Initialize the class
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Report
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function report() {
		// Bail if nonce check fails.
		if ( $this->nonce !== $_POST['nonce'] ) { // phpcs:ignore
			wp_die();
		}

		$data = ( new Data() )->get();

		echo wp_json_encode( $data, true );
		wp_die();
	}
}
