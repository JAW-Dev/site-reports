<?php
/**
 * Report Table Abstract
 *
 * @package    Site_Reports
 * @subpackage Site_Reports/Inlcudes/Classes
 * @author     Jason Witt
 * @copyright  Copyright (c) 2022, Jason Witt
 * @license    GNU General Public License v2 or later
 * @since      1.0.0
 */

namespace Site_Reports\Includes\Classes\Abstracts;

use Site_Reports\Includes\Classes\Traits\ReportProperties;
use Site_Reports\Includes\Classes\Traits\Date;
use Site_Reports\Includes\Classes\Traits\Select;

if ( ! defined( 'WPINC' ) ) {
	wp_die( 'No Access Allowed!', 'Error!', array( 'back_link' => true ) );
}

/**
 * WP_List_Table
 */
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Report Table Abstract
 *
 * @author Jason Witt
 * @since  1.0.0
 */
abstract class TableAbstract extends \WP_List_Table {

	use ReportProperties;

	/**
	 * Sho Posts Amount
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var int
	 */
	protected $show_posts_amount = 25;

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
	 * Order By
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var string
	 */
	protected $orderby;

	/**
	 * Order
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var string
	 */
	protected $order;

	/**
	 * Initialize the class
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function __construct( $args = [] ) {
		$defaults = [
			'orderby' => 'post_date',
			'order'   => 'asc'
		];

		$args = wp_parse_args( $args, $defaults );

		parent::__construct(
			[
				'singular' => __( $this->title . ' Report', 'site-reports' ),
				'plural'   => __( $this->title . ' Reports', 'site-reports' ),
				'ajax'     => false,
			]
		);

		$this->orderby = $args['orderby'];
		$this->order   = $args['order'];
		$this->set_properties( explode( '\\', get_class( $this ) ) );
	}

	/**
	 * Prepare Items
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function prepare_items() {
		$search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : ''; // phpcs:ignore
		$columns    = $this->get_columns();
		$hidden     = $this->get_hidden_columns();
		$sortable   = $this->get_sortable_columns();
		$data       = (array) $this->table_data();

		usort( $data, array( $this, 'sort_data' ) );

		if ( $search_key ) {
			$data = $this->filter_table_data( $data, $search_key );
		}

		$per_page     = $this->get_items_per_page( 'posts_per_page', $this->show_posts_amount );
		$current_page = $this->get_pagenum();
		$total_items  = count( $data );

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
			)
		);

		$data = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );

		$this->_column_headers = array( $columns, $hidden, $sortable );

		$this->items = $data;
	}

	/**
	 * Display Table Nav
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @param string $which The setion of the table (top, bottom).
	 *
	 * @return void
	 */
	public function display_tablenav( $which ) {
		?>
		<div class="tablenav <?php echo esc_attr( $which ); ?>">
			<?php
			$this->table_nav_top( $which );
			$this->table_nav_bottom( $which );
			?>
		</div>
		<?php
	}

	/**
	 * Table Nav Top
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function table_nav_top( $which ) {
		if ( 'top' === $which ) {
			?>
			<div class="alignleft actions">
				<div class="custom-reports__filters">
					<?php
					if ( $this->has_filters ) {
						foreach( $this->filters as $filter ) {
							switch( $filter->type ) {
								case 'date':
									Date::get( $this->id );
									break;
								case 'select':
									Select::get( $this->id, $filter );
									break;
							}
						}
						?>
						<input class="custom-reports__filters-submit button" type="submit" id="table-date-range-filter" value="Filter" class="button" style="display: inline;"/>
					<?php } ?>
				</div>
			</div>
			<?php
			$this->pagination( $which );
		}
	}

	/**
	 * Table Nav Bottom
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function table_nav_bottom( $which ) {
		if ( 'bottom' === $which ) {
			$this->pagination( $which );
			?>
			<form method="get" action="/">
				<button id="<?php echo esc_attr( $this->id ); ?>" class="button" data-nonce="<?php echo esc_attr( $this->id ); ?>">Download <?php echo esc_html( $this->title ); ?> CSV</button>
			</form>
			<?php
		}
	}

	/**
	 * Table Data
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function table_data() {
	}

	/**
	 * Filter Table Data
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @param array  $table_data The table data array.
	 * @param string $search_key The search term.
	 *
	 * @return array
	 */
	public function filter_table_data( $table_data, $search_key ) {
		$filtered_table_data = array_values(
			array_filter(
				$table_data,
				function( $row ) use ( $search_key ) {
					foreach ( $row as $row_val ) {
						if ( stripos( $row_val, $search_key ) !== false ) {
							return true;
						}
					}
				}
			)
		);
		return $filtered_table_data;
	}

	/**
	 * Get Columns
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function get_columns() {
		$columns = [];
		foreach( $this->columns as $column ) {
			$columns[ $column->id ] = __(  $column->name, 'site-reports' );
		}

		return $columns;
	}

	/**
	 * Get Hidden Columns
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function get_hidden_columns() {
		return array();
	}

	/**
	 * Get Sortable Columns
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable = [];

		foreach( $this->columns as $column ) {
			$sortable[ $column->id ] =  array( $column->id, true );
		}

		return $sortable;
	}

	/**
	 * Column Defualt
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @param  array  $item        The data for the item.
	 * @param  string $column_name Current column name.
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		$item = (array) $item;
		$return = '';

		foreach( $this->columns as $column ) {
			if ( $column->id === $column_name ) {
				$return = $item[ $column_name ];
				break;
			} else {
				$return = print_r( $item, true ) ; // phpcs:ignore
			}
		}

		return $return;
	}

	/**
	 * Sort Data
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @param string $a Item A.
	 * @param string $b Item B.
	 *
	 * @return array
	 */
	public function sort_data( $a, $b ) {
		$a = (array) $a;
		$b = (array) $b;

		// If orderby is set, use this as the sort column.
		if ( ! empty( $_GET['orderby'] ) ) {
			$this->orderby = $_GET['orderby'];
		}

		// If order is set use this as the order.
		if ( ! empty( $_GET['order'] ) ) {
			$this->order = $_GET['order'];
		}

		$result = strnatcmp( $a[ $this->orderby ], $b[ $this->orderby ] );

		if ( 'desc' === $this->order ) {
			return $result;
		}

		return -$result;
	}
}
