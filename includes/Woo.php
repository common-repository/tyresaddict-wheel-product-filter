<?php
/**
 * WP & WooCommerce helpers
 *
 * @since      1.0.0
 * @package    TyresAddict/WFilter
 * @author     TyresAddict
 * @link       http://b2b.tyresaddict.com
 */

namespace TyresAddict\WFilter;


class Woo
{

	// check multiply filter options

	static function checked_multiple( $checked, $list )
	{
		if ( $list === 'all' )
		{
			if ( $checked == $list )
				echo ' checked ';
		
			return;
		}

		foreach($list as $select)
		{
			if ( $checked == $select )
			{
				echo ' checked ';
				return;
			}
		}
	}

	static function shop_url()
	{
		return wc_get_page_permalink( 'shop' );
	}

	static function category_url( $slug )
	{
        $category = get_term_by("slug", $slug, "product_cat");
        return get_category_link( $category );
	}

	public static function is_product_list() {
		if ( ! function_exists( 'is_shop' ) )
			return false;

		return is_shop() || is_product_taxonomy();
	}


	static function activate_notices()
	{
		add_action('admin_notices', [ 'TyresAddict\WFilter\Woo', 'admin_notices' ]);
	}

	static function admin_notices() 
	{
		if ($notices = get_option( Plugin::prefix . 'deferred-admin-notices')) 
		{                    
		    foreach ($notices as $notice) {
				echo "<div class='error notice'><p>$notice</p></div>";
			}
			
			delete_option( Plugin::prefix . 'deferred-admin-notices');
		}
	}

	static function admin_notice( $notice ) 
	{
		$notices = get_option(Plugin::prefix . 'deferred-admin-notices', []);
    	$notices[] = $notice;
		update_option(Plugin::prefix . 'deferred-admin-notices', $notices);
	}

	// categories

	static function product_category_of( $top_category_slug )
	{
		global $wp_query;

		if ( is_product_category( $top_category_slug ) )
			return true;

		if ( is_product_category() )
		{
	        $q_obj = $wp_query->get_queried_object();
    	    $current_cat_id = $q_obj->term_id;

        	$ancestors = get_ancestors($current_cat_id, 'product_cat');
    
        	if ( count($ancestors) == 0 )
	        	return false;
	        
	        $ancestors = array_reverse($ancestors);

        	$top_category = get_term_by("id", $ancestors[0], "product_cat");

    		if ( $top_category->slug == $top_category_slug )
    			return true;
    	}

    	return false;
	}

	static function top_product_categories()
	{
		$result = get_categories( [ 'taxonomy' => 'product_cat', 'parent' => 0 ] );
		$top = [];
		foreach( $result as $category )
		{
			$top[ $category->slug ] = $category->name;
		}
		return $top;
	}

}


