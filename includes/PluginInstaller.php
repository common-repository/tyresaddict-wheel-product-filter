<?php
/**
 * Fired during plugin de/activation
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 * @package    TyresAddict/WFilter
 * @author     TyresAddict
 * @link       http://b2b.tyresaddict.com
 */


namespace TyresAddict\WFilter;


class PluginInstaller
{

	public static function activate() 
	{
	}

	public static function deactivate() 
	{
	}

	public static function check_environment()
	{
		// Check Woo
		
		if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			Woo::admin_notice( __( Plugin::title . ' need WooCommerce plugin for working, please, install it' ) );
			return false;
		}

		return true;
	}

}
