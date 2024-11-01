<?php
/**
 * Plugin Name: TyresAddict - Wheel Product Filter
 * Plugin URI: http://b2b.tyresaddict.com/
 * Description: The Wheel Product Filter for WooCommerce shops. Search wheels by size, type and other parameters. Use wheel metadata for filtering, works better with Tyre Custom Metadata plugin.
 * Version: 1.4.14
 * Author: TyresAddict
 * Author URI: http://www.tyresaddict.com
 * License: GPLv2
 *
 */


defined( 'ABSPATH' ) || exit;



// Current plugin version

class TyresAddictWheelProductFilterPluginVer
{
	const title 	= 'TyresAddict Wheel Product Filter';
	const name 		= 'tyresaddict-wheel-product-filter';
	const lang 		= 'tyresaddict-wheel-product-filter';
	const code 		= 'wpf';
	const version 	= '1.4.14';
	const features 	= [ ];
}




// Install \ UnInstall

require plugin_dir_path( __FILE__ ) . 'includes/Woo.php';

require_once plugin_dir_path( __FILE__ ) . 'includes/PluginInstaller.php';

register_activation_hook( __FILE__, [ '\TyresAddict\WFilter\PluginInstaller', 'activate' ] );
register_deactivation_hook( __FILE__, [ '\TyresAddict\WFilter\PluginInstaller', 'deactivate' ] );



// The core plugin class that is used to define locale, admin-specific hooks, and public-facing site hooks.

require plugin_dir_path( __FILE__ ) . 'includes/DB.php';
require plugin_dir_path( __FILE__ ) . 'includes/Plugin.php';

function tyresaddict_woo_wheel_filter_plugin_init() 
{
	\TyresAddict\WFilter\Woo::activate_notices();

    if ( \TyresAddict\WFilter\PluginInstaller::check_environment() )		// check depended plugins
		\TyresAddict\WFilter\Plugin::get_instance();
}

add_action( 'plugins_loaded', 'tyresaddict_woo_wheel_filter_plugin_init' );



// Widgets

require plugin_dir_path( __FILE__ ) . 'includes/FilterWidget.php';

function tyresaddict_woo_wheel_filter_register_widget() 
{
    register_widget( 'TyresAddict\WFilter\FilterWidget' );
}

add_action( 'widgets_init', 'tyresaddict_woo_wheel_filter_register_widget' );


