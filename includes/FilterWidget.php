<?php
/**
 * The main Filter widget
 *
 * @since      1.0.0
 * @package    TyresAddict/WFilter
 * @author     TyresAddict
 * @link       http://b2b.tyresaddict.com
 */

namespace TyresAddict\WFilter;


/**
 * Widget class
 */
class FilterWidget extends \WP_Widget 
{
	const shortcode = 'tyresaddict-wheel-filter';


	// Register widget with WordPress.

	function __construct() 
	{
		parent::__construct(
			'tyresaddict_wheel_filter_widget', // Base ID
			__( 'TyresAddict Wheel Product Filter', Plugin::lang ), // Name
			[ 'description' => __( 'TyresAddict Wheel Product Filter. Wheels by Size and Parameters', Plugin::lang ), ] // Args
		);
	}


	public function register() 
	{
		add_shortcode( FilterWidget::shortcode, [ $this, 'widget_shortcode' ] );
	}
	
	
	public function widget_shortcode( $atts, $content = null ) 
	{
		if ( !Woo::product_category_of('wheels') )
			return;

		ob_start();
			$this->template();
		return ob_get_clean();
	}
	
	public static function template( $options ) 
	{
		// data

		$params['wheel_width']	= DB::wheel_width();
		$params['wheel_pcd']	= DB::wheel_pcd();
		$params['wheel_r']		= DB::wheel_r();
		$params['wheel_dia']	= DB::wheel_dia();
		$params['wheel_et']		= DB::wheel_et();

		$params['types'] 		= Db::wheel_types();

		$params['brands'] 		= Db::brands();

		// params

		$params['r_width']		= Request::width();
		$params['r_r']			= Request::r();
		$params['r_pcd']		= Request::pcd();
		$params['r_dia']		= Request::dia();
		$params['r_et']			= DB::wheel_et_minmax( Request::et() )['ui'];

		$params['r_type']			= Request::type();

		$params['r_wheel_brand']	= Request::brand();


		wp_enqueue_script( Plugin::name );
		wp_localize_script( Plugin::name, 'taw_wheel_filter', [
			'ajax_url'   => admin_url( 'admin-ajax.php' ),
		] );

		$params['form_url']	= ( $options['category'] == '' ) ? Woo::shop_url() : Woo::category_url( $options['category'] );

		$template = new Template();
		$template->display('filter', 'white', $params);
	}
	
	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) 
	{
		if ( !Woo::is_product_list() )
			return;

		$category = !empty( $instance['category'] ) ? $instance['category'] : '';

		if ( $category != '' && !Woo::product_category_of( $category ) )
			return;

		echo $args['before_widget'];
	
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		
		$this->template( [ 'category' => $category ] );
		
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) 
	{
		$title 			= !empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Find Wheels' );
		$category_slug 	= !empty( $instance['category'] ) ? $instance['category'] : '';

		$categories = Woo::top_product_categories();
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_attr_e( 'Work and show only in category:' ); ?></label> 
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
			 	<option 
			 		<?php selected( '', $category_slug ); ?>
			 		value="">All categories</option>
			 	<?php foreach( $categories as $slug => $category ): ?>
				 	<option 
				 		<?php selected( $slug, $category_slug ); ?>
				 		value="<?=$slug ?>"><?=$category ?></option>
			 	<?php endforeach ?>
			</select>
		</p>
		
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 */
	public function update( $new_instance, $old_instance ) 
	{
		$instance = [];
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['category'] = ( !empty( $new_instance['category'] ) ) ? sanitize_text_field( $new_instance['category'] ) : '';

		PluginOptions::update( 'category', $instance['category'] );
		return $instance;
	}

} // class FilterWidget


