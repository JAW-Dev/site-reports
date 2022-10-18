<?php
/**
 * Report Properties Trait
 *
 * @package    Site_Reports
 * @subpackage Site_Reports/Inlcudes/Classes
 * @author     Jason Witt
 * @copyright  Copyright (c) 2022, Jason Witt
 * @license    GNU General Public License v2 or later
 * @since      1.0.0
 */

namespace Site_Reports\Includes\Classes\Traits;

if ( ! defined( 'WPINC' ) ) {
	wp_die( 'No Access Allowed!', 'Error!', array( 'back_link' => true ) );
}

/**
 * Report Properties Trait
 *
 * @author Jason Witt
 * @since  1.0.0
 */
trait ReportProperties {

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
	 * Slug
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var string
	 */
	protected $slug;

	/**
	 * Description
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Name
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Title
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * ID
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * Has Table
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var boolean
	 */
	protected $has_table;

	/**
	 * Columns
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var object;
	 */
	protected $columns;

	/**
	 * Has Filters
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var bool
	 */
	protected $has_filters = false;

	/**
	 * Filters
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var object
	 */
	protected $filters;

	/**
	 * Set Properties
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function set_properties( $class ) {
		$this->reports_obj = json_decode( SITE_REPORTS_JSON );
		$reports           = $this->reports_obj->reports;

		foreach( $reports as $report ) {

			foreach( $class as $type ) {
				if ( $report->name === $type ) {
					$this->slug        = $report->slug . '_report';
					$this->description = $report->description;
					$this->has_table   = $report->has_table;
					$this->title       = $report->name;
					$this->id          = str_replace( array( '_', ' ' ), '-', $this->slug );
					$this->nonce       = str_replace( array( '_', ' ' ), '-', $this->slug );
					$this->columns     = $report->columns;
					$this->has_filters = ! empty( $report->filters ) ? true : false;
					$this->filters     = $this->has_filters === true ? $report->filters : [];
					break;
				}
			}
		}
	}
}
