<?php

/**
	* The file that defines the core plugin class
	*
	* A class definition that includes attributes and functions used across both the
	* public-facing side of the site and the admin area.
	*
	* @link       https://github.com/IIP-Design/ACF-Local-JSON-Manager
	* @since      1.0.0
	*
	* @package    America_ACF_Local_Json_Manager
	* @subpackage America_ACF_Local_Json_Manager/includes
	*/




/**
	* The core plugin class.
	*
	* This is used to define internationalization, admin-specific hooks, and
	* public-facing site hooks.
	*
	* Also maintains the unique identifier of this plugin as well as the current
	* version of the plugin.
	*
	* @since      1.0.0
	* @package    America_ACF_Local_Json_Manager
	* @subpackage America_ACF_Local_Json_Manager/includes
	* @author     Office of Design, U.S. Department of State
	*/

class America_ACF_Local_Json_Manager {
	/**
		* The loader that's responsible for maintaining and registering all hooks that power
		* the plugin.
		*
		* @since    1.0.0
		* @access   protected
		* @var      America_ACF_Local_Json_Manager_Loader    $loader    Maintains and registers all hooks for the plugin.
		*/

	protected $loader;


	/**
		* The unique identifier of this plugin.
		*
		* @since    1.0.0
		* @access   protected
		* @var      string    $America_ACF_Local_Json_Manager    The string used to uniquely identify this plugin.
		*/

	protected $America_ACF_Local_Json_Manager;


	/**
		* The current version of the plugin.
		*
		* @since    1.0.0
		* @access   protected
		* @var      string    $version    The current version of the plugin.
		*/

	protected $version;


	/**
		* Define the core functionality of the plugin.
		*
		* Set the plugin name and the plugin version that can be used throughout the plugin.
		* Load the dependencies, define the locale, and set the hooks for the admin area and
		* the public-facing side of the site.
		*
		* @since    1.0.0
		*/

	public function __construct() {
		$this->America_ACF_Local_Json_Manager = 'america-acf-local-json-manager';
		$this->version = '1.0.0';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
		* Load the required dependencies for this plugin.
		*
		* Include the following files that make up the plugin:
		*
		* - America_ACF_Local_Json_Manager_Loader. Orchestrates the hooks of the plugin.
		* - America_ACF_Local_Json_Manager_i18n. Defines internationalization functionality.
		* - America_ACF_Local_Json_Manager_Admin. Defines all hooks for the admin area.
		* - America_ACF_Local_Json_Manager_Public. Defines all hooks for the public side of the site.
		*
		* Create an instance of the loader which will be used to register the hooks
		* with WordPress.
		*
		* @since    1.0.0
		* @access   private
		*/

	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-america-acf-local-json-manager-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-america-acf-local-json-manager-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-america-acf-local-json-manager-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-america-acf-local-json-manager-public.php';
		$this->loader = new America_ACF_Local_Json_Manager_Loader();
	}


	/**
		* Define the locale for this plugin for internationalization.
		*
		* Uses the America_ACF_Local_Json_Manager_i18n class in order to set the domain and to register the hook
		* with WordPress.
		*
		* @since    1.0.0
		* @access   private
		*/

	private function set_locale() {
		$plugin_i18n = new America_ACF_Local_Json_Manager_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}


	/**
		* Register all of the hooks related to the admin area functionality
		* of the plugin.
		*
		* @since    1.0.0
		* @access   private
		*/

	private function define_admin_hooks() {
		$plugin_admin = new America_ACF_Local_Json_Manager_Admin( $this->get_America_ACF_Local_Json_Manager(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}


	/**
		* Register all of the hooks related to the public-facing functionality
		* of the plugin.
		*
		* @since    1.0.0
		* @access   private
		*/

	private function define_public_hooks() {
		$plugin_public = new America_ACF_Local_Json_Manager_Public( $this->get_America_ACF_Local_Json_Manager(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}


	/**
		* Run the loader to execute all of the hooks with WordPress.
		*
		* @since    1.0.0
		*/

	public function run() {
		$this->loader->run();
	}


	/**
		* The name of the plugin used to uniquely identify it within the context of
		* WordPress and to define internationalization functionality.
		*
		* @since     1.0.0
		* @return    string    The name of the plugin.
		*/

	public function get_America_ACF_Local_Json_Manager() {
		return $this->America_ACF_Local_Json_Manager;
	}


	/**
		* The reference to the class that orchestrates the hooks with the plugin.
		*
		* @since     1.0.0
		* @return    America_ACF_Local_Json_Manager_Loader    Orchestrates the hooks of the plugin.
		*/

	public function get_loader() {
		return $this->loader;
	}


	/**
		* Retrieve the version number of the plugin.
		*
		* @since     1.0.0
		* @return    string    The version number of the plugin.
		*/

	public function get_version() {
		return $this->version;
	}
}
