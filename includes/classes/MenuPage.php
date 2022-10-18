<?php
/**
 * Menu Page
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
 * Menu Page
 *
 * @author Jason Witt
 * @since  1.0.0
 */
class MenuPage {

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
		$this->menu_page();
	}

	/**
	 * Menu Page
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function menu_page() {
		$icon = 'PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzODQgNTEyIj48cGF0aCBmaWxsPSJibGFjayIgZD0iTTM2MCAwSDI0QzEwLjcgMCAwIDEwLjcgMCAyNHY0NjRjMCAxMy4zIDEwLjcgMjQgMjQgMjRoMzM2YzEzLjMgMCAyNC0xMC43IDI0LTI0VjI0YzAtMTMuMy0xMC43LTI0LTI0LTI0ek0xMjggNDAwYzAgOC44LTcuMiAxNi0xNiAxNkg4MGMtOC44IDAtMTYtNy4yLTE2LTE2di0zMmMwLTguOCA3LjItMTYgMTYtMTZoMzJjOC44IDAgMTYgNy4yIDE2IDE2djMyem0wLTEyOGMwIDguOC03LjIgMTYtMTYgMTZIODBjLTguOCAwLTE2LTcuMi0xNi0xNnYtMzJjMC04LjggNy4yLTE2IDE2LTE2aDMyYzguOCAwIDE2IDcuMiAxNiAxNnYzMnptMC0xMjhjMCA4LjgtNy4yIDE2LTE2IDE2SDgwYy04LjggMC0xNi03LjItMTYtMTZ2LTMyYzAtOC44IDcuMi0xNiAxNi0xNmgzMmM4LjggMCAxNiA3LjIgMTYgMTZ2MzJ6bTE5MiAyNDhjMCA0LjQtMy42IDgtOCA4SDE2OGMtNC40IDAtOC0zLjYtOC04di0xNmMwLTQuNCAzLjYtOCA4LThoMTQ0YzQuNCAwIDggMy42IDggOHYxNnptMC0xMjhjMCA0LjQtMy42IDgtOCA4SDE2OGMtNC40IDAtOC0zLjYtOC04di0xNmMwLTQuNCAzLjYtOCA4LThoMTQ0YzQuNCAwIDggMy42IDggOHYxNnptMC0xMjhjMCA0LjQtMy42IDgtOCA4SDE2OGMtNC40IDAtOC0zLjYtOC04di0xNmMwLTQuNCAzLjYtOCA4LThoMTQ0YzQuNCAwIDggMy42IDggOHYxNnoiLz48L3N2Zz4=';

		add_menu_page(
			__( 'Site Reports', 'site-reports' ),
			__( 'Site Reports', 'site-reports' ),
			'manage_options',
			'site-reports',
			array( $this, 'site_reports_page' ),
			'data:image/svg+xml;base64,' . $icon
		);
	}

	/**
	 * Site Reports Page
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function site_reports_page() {
		$reports =  $this->reports_obj->reports;

		?>
		<div class="wrap">
			<h1>Site Reports</h1>
			<div class="site-reports">
				<?php
				foreach( $reports as $report ) {
					$classname = SITE_REPORTS_NAMESPACE . 'Reports\\' . $report->name . '\\Template';
					( new $classname() )->init();
				}
				?>
			</div>
		</div>
		<?php
	}
}
