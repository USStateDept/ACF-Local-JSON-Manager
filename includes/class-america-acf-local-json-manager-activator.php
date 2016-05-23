<?php

/**
	* Fired during plugin activation
	*
	* @link       https://github.com/IIP-Design/ACF-Local-JSON-Manager
	* @since      1.0.0
	*
	* @package    America_ACF_Local_Json_Manager
	* @subpackage America_ACF_Local_Json_Manager/includes
	*/




/**
	* Fired during plugin activation.
	*
	* This class defines all code necessary to run during the plugin's activation.
	*
	* @since      1.0.0
	* @package    America_ACF_Local_Json_Manager
	* @subpackage America_ACF_Local_Json_Manager/includes
	* @author     Office of Design, U.S. Department of State
	*/

class America_ACF_Local_Json_Manager_Activator {
	/**
		* Short Description. (use period)
		*
		* Long Description.
		*
		* @since    1.0.0
		*/

	public static function activate() {
		if ( ! class_exists( 'acf' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( 'Could not activate plugin because Advanced Custom Fields was not found. Please activate ACF or a plugin/theme that includes it as a dependency.' );
		}
	}
}
