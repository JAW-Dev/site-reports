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
class Select {

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
	 * @param string $id     The report id.
	 * @param object $filter The filter.
	 *
	 * @return void
	 */
	public static function get( $id, $filter ) {
		$param = sanitize_text_field( wp_unslash( $_GET[ $filter->id ] ?? '' ) );
		?>
		<select id="<?php echo esc_attr( $id ); ?>-<?php echo esc_attr( $filter->id ); ?>" name="<?php echo esc_attr( $filter->id ); ?>" class="custom-reports__filters-"<?php echo esc_attr( $filter->id ); ?>>
			<option value="">Select <?php echo esc_html( $filter->name ); ?></option>
			<?php
			foreach ( $filter->options as $option ) {
				?>
				<option value="<?php echo esc_attr( $option->value ); ?>" <?php selected( $option->value, $param ); ?>><?php echo esc_html( $option->label ); ?></option>
				<?php
			}
			?>
		</select>
		<?php
	}
}
