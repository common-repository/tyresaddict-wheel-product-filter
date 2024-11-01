<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 * @package    TyresAddict/WFilter
 * @author     TyresAddict
 * @link       http://b2b.tyresaddict.com
 */

namespace TyresAddict\WFilter;


// The public-facing functionality of the plugin.

class PluginPublic 
{

	/**
	 * Filter products to match filter parameters | Woo
	 *
	 * @param array $meta_query Meta query.
	 * @return array
	 */
	public function woocommerce_product_query_meta_query( $meta_query = array() ) 
	{
		// set only in categories

		if ( PluginOptions::value('category') != '' && !Woo::product_category_of( PluginOptions::value('category') ) )
			return $meta_query;

		$meta_query = [];

		if ( Request::width() ) 
			$meta_query[] = [ 'relation' => 'AND', [ 'key' => 'width', 		'value' => str_replace(",", ".", Request::width()), 'compare' => '=' ] ];

		if ( Request::r() ) 
			$meta_query[] = [ 'relation' => 'AND', [ 'key' => 'diameter', 	'value' => Request::r(), 'compare' => '=' ] ];

		if ( Request::pcd() ) 
			$meta_query[] = [ 'relation' => 'AND', [ 'key' => 'pcd', 		'value' => Request::pcd(), 'compare' => '=' ] ];
		
		if ( Request::dia() ) 
			$meta_query[] = [ 'relation' => 'AND', [ 'key' => 'dia', 		'value' => str_replace(",", ".", Request::dia() ), 'compare' => '=' ] ];

		if ( Request::et() ) 
		{
			$_et = DB::wheel_et_minmax( Request::et() );

			$meta_query[] = [ 'relation' => 'AND', [ 'key' => 'et', 		'value' => $_et['min'], 'compare' => '>=' ] ];
			$meta_query[] = [ 'relation' => 'AND', [ 'key' => 'et', 		'value' => $_et['max'], 'compare' => '<' ] ];
		}
			
		if ( Request::type() && Request::type() != 'all' )
			$meta_query[] = [ 'relation' => 'AND', [ 'key' => 'wheel_type', 'value'   => Request::type(), 'compare' => '=' ] ];


		if ( Request::brand() && Request::brand() != 'all' && Request::brand() != ['all'] )
		{
		    if ( !is_array( Request::brand() ) )
				$meta_query[] = [ 'relation' => 'AND', [ 'key' => 'wheel_brand', 'value'   => Request::brand(), 'compare' => '=' ] ];
			else 
				$meta_query[] = [ 'relation' => 'AND', [ 'key' => 'wheel_brand', 'value'   => Request::brand(), 'compare' => 'IN' ] ];
		}

		return $meta_query;
	}
	
	

	// Enqueue styles

	public function enqueue_inline_styles_css()
	{
		if ( is_single() || is_page() ) {
			echo '<style type="text/css"><!-- TyresAddict Wheel Product Filter CSS -->' . PluginOptions::value('custom_css') . '</style>';
		}
	}

	public function enqueue_styles() 
	{                                   
		wp_enqueue_style( Plugin::name, plugins_url() . '/' . Plugin::name . '/public/css/filter-' . 'white' . '.css', [], Plugin::version, 'all' );
	}

	// Register the JavaScript for the public-facing side of the site.

	public function enqueue_scripts() 
	{                          
		wp_register_script( Plugin::name, plugins_url() . '/' . Plugin::name . '/public/js/taw-wheel-filter.js', [ 'jquery' ], Plugin::version, false );
	}

}


