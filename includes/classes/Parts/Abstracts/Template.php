<?php
/**
 * Report Abstract
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

if ( ! defined( 'WPINC' ) ) {
	wp_die( 'No Access Allowed!', 'Error!', array( 'back_link' => true ) );
}

/**
 * Report Abstract
 *
 * @author Jason Witt
 * @since  1.0.0
 */
abstract class TemplateAbstract {

	use ReportProperties;

	/**
	 * Table
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @var object
	 */
	protected $table;

	/**
	 * Initialize the class
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @param string $slug        The report slug.
	 * @param string $description The report description.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->set_properties( explode( '\\', get_class( $this ) ) );
		$this->hooks();
	}

	/**
	 * Render
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function init() {
		?>
		<div class="site-reports__item">
			<h2><?php echo esc_html( $this->title ); ?></h2>
			<?php if ( ! empty( $this->description ) ) { ?>
				<p><?php echo wp_kses_post( $this->description ); ?></p>
			<?php } ?>
			<p><a href="<?php echo esc_url( admin_url( "admin.php?page={$this->slug}" ) ); ?>" class="button">View Report</a></p>
			<br/>
			<hr/>
		</div>
		<?php
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
		if ( $this->has_table ) {
			add_action( 'admin_menu', array( $this, 'full_report' ) );
			add_filter( 'set-screen-option', array( $this, 'table_set_option' ), 10, 3 );
		}
	}

	/**
	 * Full Report
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function full_report() {
		$hook = add_submenu_page(
			'site-reports',
			$this->title . ' Report',
			$this->title . ' Report',
			'manage_options',
			$this->slug,
			array( $this, 'sub_page' )
		);

		add_action( "load-$hook", array( $this, 'add_options' ) );
	}

	/**
	 * Table set option
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @param boolean $status Whether to save or skip saving the screen option value. Default false.
	 * @param string  $option The option name.
	 * @param int     $value  The number of rows to use.
	 *
	 * @return int
	 */
	public function table_set_option( $status, $option, $value ) {
		return $value;
	}

	/**
	 * Add Options
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function add_options() {
		$class      = get_class( $this );
		$namespace  = substr( $class, 0, strrpos( $class, '\\' ) );
		$class_name = $namespace . '\Table';
		$option     = 'per_page';
		$args       = array(
			'label'   => 'Posts Per Page',
			'default' => 25,
			'option'  => 'posts_per_page',
		);
		add_screen_option( $option, $args );
		$this->table = new $class_name();
	}

	/**
	 * Sub Page
	 *
	 * @author Jason Witt
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function sub_page() {
		$this->table->prepare_items();
		?>
		<div class="wrap">
			<h2><?php echo esc_html( $this->title ); ?></h2>
			<?php $this->table->views(); ?>
			<form method="get">
				<input type="hidden" name="page" value="<?php echo esc_html( $_REQUEST['page'] ); ?>" />
				<?php
				$this->table->search_box( __( 'Search', 'custom-reports' ), 'search_id' );
				$this->table->display();
				?>
			</form>
		</div>
		<?php
	}
}
