<?php

/**
	* Define the internationalization functionality
	*
	* Loads and defines the internationalization files for this plugin
	* so that it is ready for translation.
	*
	* @link       https://github.com/IIP-Design/ACF-Local-JSON-Manager
	* @since      1.0.0
	*
	* @package    America_ACF_Local_Json_Manager
	* @subpackage America_ACF_Local_Json_Manager/includes
	*/




/**
	* Define the internationalization functionality.
	*
	* Loads and defines the internationalization files for this plugin
	* so that it is ready for translation.
	*
	* @since      1.0.0
	* @package    America_ACF_Local_Json_Manager
	* @subpackage America_ACF_Local_Json_Manager/includes
	* @author     Office of Design, U.S. Department of State
	*/

class America_ACF_Local_Json_Manager_i18n {
	/**
		* Load the plugin text domain for translation.
		*
		* @since    1.0.0
		*/

	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'america-acf-local-json-manager',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
