<?php

/**
	* The public-facing functionality of the plugin.
	*
	* @link       https://github.com/IIP-Design/ACF-Local-JSON-Manager
	* @since      1.0.0
	*
	* @package    America_ACF_Local_Json_Manager
	* @subpackage America_ACF_Local_Json_Manager/public
	*/




/**
	* The public-facing functionality of the plugin.
	*
	* Defines the plugin name, version, and two examples hooks for how to
	* enqueue the admin-specific stylesheet and JavaScript.
	*
	* @package    America_ACF_Local_Json_Manager
	* @subpackage America_ACF_Local_Json_Manager/public
	* @author     Office of Design, U.S. Department of State
	*/

class America_ACF_Local_Json_Manager_Public {

	/**
		* The ID of this plugin.
		*
		* @since    1.0.0
		* @access   private
		* @var      string    $America_ACF_Local_Json_Manager    The ID of this plugin.
		*/

	private $America_ACF_Local_Json_Manager;


	/**
		* The version of this plugin.
		*
		* @since    1.0.0
		* @access   private
		* @var      string    $version    The current version of this plugin.
		*/

	private $version;


	/**
		* Initialize the class and set its properties.
		*
		* @since    1.0.0
		* @param      string    $America_ACF_Local_Json_Manager       The name of the plugin.
		* @param      string    $version    The version of this plugin.
		*/

	public function __construct( $America_ACF_Local_Json_Manager, $version ) {
		$this->America_ACF_Local_Json_Manager = $America_ACF_Local_Json_Manager;
		$this->version = $version;
	}


	/**
		* Register the stylesheets for the public-facing side of the site.
		*
		* @since    1.0.0
		*/

	public function enqueue_styles() {
		wp_enqueue_style( $this->America_ACF_Local_Json_Manager, plugin_dir_url( __FILE__ ) . 'css/america-acf-local-json-manager-public.css', array(), $this->version, 'all' );
	}


	/**
		* Register the JavaScript for the public-facing side of the site.
		*
		* @since    1.0.0
		*/

	public function enqueue_scripts() {
		wp_enqueue_script( $this->America_ACF_Local_Json_Manager, plugin_dir_url( __FILE__ ) . 'js/america-acf-local-json-manager-public.js', array( 'jquery' ), $this->version, false );
	}
}
