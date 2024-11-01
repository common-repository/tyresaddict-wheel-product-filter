<?php
/**
 * The core plugin class.
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


class Plugin 
{
	const title 	= \TyresAddictWheelProductFilterPluginVer::title;
	const name 		= \TyresAddictWheelProductFilterPluginVer::name;
	const lang 		= \TyresAddictWheelProductFilterPluginVer::lang;
	const code 		= \TyresAddictWheelProductFilterPluginVer::code;
	const version 	= \TyresAddictWheelProductFilterPluginVer::version;
	const prefix 	= \TyresAddictWheelProductFilterPluginVer::name . '-';
	const features 	= \TyresAddictWheelProductFilterPluginVer::features;


	protected $_features = [];	
	protected $loader;

	protected $plugin_public 	= null;		// public part of plugin
	protected $plugin_admin 	= null;		// admin part of plugin
	
	protected $page_options 	= null;

	protected $filter_widget = null;


	// singleton

	protected static $instance;

	public static function get_instance() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new static;
			static::$instance->run();			// run loader
		}
		return static::$instance;
	}
	

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 */
	public function __construct() 
	{              
		$this->load_dependencies();

		PluginI18n::textdomains();

		$this->filter_widget = new FilterWidget;
		$this->filter_widget->register();
		
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - PluginLoader. Orchestrates the hooks of the plugin.
	 * - PluginI18n. Defines internationalization functionality.
	 * - PluginAdmin. Defines all hooks for the admin area.
	 * - PluginPublic. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() 
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/PluginLoader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/PluginI18n.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/PluginPublic.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/PluginOptions.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/DB.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/Request.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/Template.php';

		foreach( Plugin::features as $feature )
		{
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/' . $feature . '.php';

			$feature_class = __NAMESPACE__ . "\\" . $feature;
			$this->_features[ $feature ] = new $feature_class();
		}

		$this->loader = new PluginLoader();
	}

	// Register all of the hooks related to the admin area functionality

	private function define_admin_hooks() 
	{
	}


	// Register all of the hooks related to the public-facing functionality

	private function define_public_hooks() 
	{
		$this->plugin_public = new PluginPublic();

		add_filter( 'woocommerce_product_query_meta_query', [ $this->plugin_public, 'woocommerce_product_query_meta_query' ] );

		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_scripts' );
	}


	public function run() 
	{
		$this->loader->run();
		
		foreach( Plugin::features as $feature )
		{
			$this->_features[ $feature ]->run();
		}
	}

	public function get_loader() {
		return $this->loader;
	}

	static function path() {
		return plugin_dir_path( dirname( __FILE__ ) );
	}
}

