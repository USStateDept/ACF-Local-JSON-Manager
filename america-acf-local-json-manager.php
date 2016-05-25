<?php

/**********************************************************************************************************
Plugin Name:    America ACF Local JSON Manager
Description:    A Wordpress plugin that gives administrators the ability to choose where to save an ACF field group's local JSON.
Version:        1.0.0
Author:         Office of Design, U.S. Department of State
License:        MIT
Text Domain:    america
Domain Path:    /languages/
************************************************************************************************************/


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


// Constants
define( 'AMERICA_ACF_LJM_DIR', plugin_dir_path( dirname( __FILE__ ) ) . 'america-acf-local-json-manager/' );


// Activate
function activate_America_ACF_Local_Json_Manager() {
	require_once AMERICA_ACF_LJM_DIR . 'includes/class-america-acf-local-json-manager-activator.php';
	America_ACF_Local_Json_Manager_Activator::activate();
}



// Deactivate
function deactivate_America_ACF_Local_Json_Manager() {
	require_once AMERICA_ACF_LJM_DIR . 'includes/class-america-acf-local-json-manager-deactivator.php';
	America_ACF_Local_Json_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_America_ACF_Local_Json_Manager' );
register_deactivation_hook( __FILE__, 'deactivate_America_ACF_Local_Json_Manager' );


// Core plugin file
require AMERICA_ACF_LJM_DIR . 'includes/class-america-acf-local-json-manager.php';


/**
	* Begins execution of the plugin.
	*
	* Since everything within the plugin is registered via hooks,
	* then kicking off the plugin from this point in the file does
	* not affect the page life cycle.
	*
	* @since    1.0.0
	*/
function run_america_acf_local_json_manager() {
	$plugin = new America_ACF_Local_Json_Manager();
	$plugin->run();
}

add_action( 'plugins_loaded', 'run_america_acf_local_json_manager' );
