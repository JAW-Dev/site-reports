<?php
/**
 * Filters
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
 * Date Filter
 *
 * @author Jason Witt
 * @since  1.0.0
 */
class Date {

	/**
	 * Initialize the class
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function __construct() {}

	/**
	 * Date Range
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @param string $id The report id.
	 *
	 * @return void
	 */
	public static function get( $id ) {
		$from_value        = sanitize_text_field( wp_unslash( $_GET['from-date'] ?? '' ) );
		$to_value          = sanitize_text_field( wp_unslash( $_GET['to-date'] ?? '' ) );
		?>
		<div class="custom-reports__filters-date-range" style="display: inline;">
			<label for="<?php echo esc_attr( $id ); ?>-from-date">From</label>
			<input type="text" id="<?php echo esc_attr( $id ); ?>-from-date" name="date_from" class="report-filter" placeholder="Date From" value="<?php echo esc_attr( $from_value ); ?>">
			<label for="<?php echo esc_attr( $id ); ?>-to-date">To</label>
			<input type="text" id="<?php echo esc_attr( $id ); ?>-to-date" name="date_to" class="report-filter" placeholder="Date To" value="<?php echo esc_attr( $to_value ); ?>">
		</div>
		<?php
	}
}
