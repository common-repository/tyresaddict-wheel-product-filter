<?php
/**
 * Define the internationalization functionality
 *
 * @since      1.0.0
 * @package    TyresAddict/WFilter
 * @author     TyresAddict
 * @link       http://b2b.tyresaddict.com
 */

namespace TyresAddict\WFilter;


/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 */
class PluginI18n 
{
	static public function textdomains() 
	{                                       
	    // load WP translations
		load_plugin_textdomain( Plugin::lang, false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' );

	    // merge local translations, WP used first
		load_textdomain( Plugin::lang, WP_PLUGIN_DIR .'/'. dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' . Plugin::lang . '-' . get_locale() . '.mo' );
	}
}
