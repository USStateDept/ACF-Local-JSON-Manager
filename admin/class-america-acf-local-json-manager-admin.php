<?php

/**
	* The admin-specific functionality of the plugin.
	*
	* @link       https://github.com/IIP-Design/ACF-Local-JSON-Manager
	* @since      1.0.0
	*
	* @package    America_ACF_Local_Json_Manager
	* @subpackage America_ACF_Local_Json_Manager/admin
	*/




/**
	* The admin-specific functionality of the plugin.
	*
	* Defines the plugin name, version, and two examples hooks for how to
	* enqueue the admin-specific stylesheet and JavaScript.
	*
	* @package    America_ACF_Local_Json_Manager
	* @subpackage America_ACF_Local_Json_Manager/admin
	* @author     Office of Design, U.S. Department of State
	*/

class America_ACF_Local_Json_Manager_Admin {
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
		* The value we will override ACF's `save_json` location
		*
		* @since 		1.0.0
		* @access		private
		* @var			string		$save_json_location		The save location (absolute directory path)
		*/

	private $save_json_location;


	/**
		* Initialize the class and set its properties.
		*
		* @since    1.0.0
		* @param    string    $America_ACF_Local_Json_Manager       The name of this plugin.
		* @param    string    $version    The version of this plugin.
		*/

	public function __construct( $America_ACF_Local_Json_Manager, $version ) {
		$this->America_ACF_Local_Json_Manager = $America_ACF_Local_Json_Manager;
		$this->version = $version;
	}


	/**
		* Register the stylesheets for the admin area.
		*
		* @since    1.0.0
		*/

	public function enqueue_styles() {
		wp_enqueue_style( $this->America_ACF_Local_Json_Manager, plugin_dir_url( __FILE__ ) . 'css/america-acf-local-json-manager-admin.css', array(), $this->version, 'all' );
	}


	/**
		* Register the JavaScript for the admin area.
		*
		* @since    1.0.0
		*/

	public function enqueue_scripts() {
		wp_enqueue_script( $this->America_ACF_Local_Json_Manager, plugin_dir_url( __FILE__ ) . 'js/america-acf-local-json-manager-admin.js', array( 'jquery' ), $this->version, false );
	}


	/**
		* Deactivate if ACF no longer found
		*
		* @since 		1.0.0
		*/

	public function automatically_deactivate() {
		$file = AMERICA_ACF_LJM_DIR . 'america-acf-local-json-manager.php';

		if ( ! class_exists( 'acf' ) ) {
			deactivate_plugins( $file );
			add_action( 'admin_notices', array( $this, 'disabled_notice' ) );
		}
	}


	/**
		* Notify user this plugin was deactivated
		*
		* @since 		1.0.0
		*/

	public function disabled_notice() {
		$classes = 'notice notice-error';
		$message = __( 'ACF Local JSON Manager was deactivated because Advanced Custom Fields could not be found.', 'america' );

		$html = sprintf( '<div class="%s"><p>%s</p></div>', $classes, $message );
		echo $html;
	}


	/**
		* Returns the load_json paths registered with ACF
		*
		* @return 	array
		* @since 		1.0.0
		*/

	public function get_acf_load_json() {
		if ( ! class_exists( 'acf' ) ) {
			return;
		}

		$load_json_paths = acf_get_setting( 'load_json' );

		// Check that directory is readable and writeable. If not, remove it from the `load_json` settings
		foreach ( $load_json_paths as $path ) {
			if ( ! is_writable( $path) || ! is_readable( $path ) ) {
				$load_json_paths = array_diff( $load_json_paths, array( $path ) );
			}
		}

		return $load_json_paths;
	}


	/**
		* Get a shorter file path, starting from `wp-content` by default for a nicer
		* display, for example in the `acf_save_location` select box
		*
		* @param 		string		$path 		A directory path
		* @return 	string
		* @since		1.0.0
		*/

	public function plugin_theme_basename( $path ) {
		$wp_content = 'wp-content/';

		if ( has_filter( 'america_acf_plugin_theme_location' ) ) {
			$wp_content = apply_filter( 'america_acf_plugin_theme_location' );
		}

		$offset = strpos( $path, $wp_content);

		if ( $offset === false ) {
			return $path;
		}

		return substr( $path, $offset + strlen( $wp_content ) );
	}


	/**
		* The select box for choosing the correct save directory
		*
		* @param 		array 	$options		The possible local json save locations
		* @param 		string 	$selected		The previously stored save location
		* @since 		1.0.0
		*/

	public function america_acf_ljm_select( $options, $selected ) {
		$html = '<div class="misc-pub-section acf-location">';
			$html .= '<span class="america-acf-save-location-icon"></span>';
			$html .= sprintf( '<label for="acf_save_location">%s</label>', __( 'Local JSON Save Location:', 'america' ) );
			$html .= wp_nonce_field( 'america_acf_save_location_nonce', '_america_acf_save_location_nonce' );
			$html .= '<select id="acf_save_location" name="acf_save_location" class="america-acf-save-location required" autocomplete="off" required>';
			$html .= sprintf( '<option value="default">%s</option>', __( 'Choose Save Location', 'america' ) );

			foreach ( $options as $option ) {
				$html .= sprintf( '<option value=%s %s>%s</option>', esc_attr( $option ), ( $option === $selected ? 'selected="selected"' : null ), $this->plugin_theme_basename( esc_attr( $option ) ) );
			}

			$html .= '</select>';
		$html .= '</div>';

		echo $html;
	}


	/**
		* Get the previously saved value from the db, get the possible save locations, and
		* display the select box.
		*
		* @since 		1.0.0
		*/

	public function america_acf_ljm_publish_location() {
		global $post;

		// Paranoid check user is an admin. If not, bail
		if ( ! current_user_can( 'activate_plugins' ) ) return;

		// Bail if not an acf-field-group
		if ( get_post_type( $post ) != 'acf-field-group' ) {
			return false;
		}

		// readable/writable save locations
		$options = $this->get_acf_load_json();

		// if there aren't any possible save locations, bail
		if ( empty( $options) ) {
			return;
		}

		// limit the choice of saving locations to the location it was loaded from
		foreach ( $options as $option ) {
			if ( file_exists( sprintf( '%s/%s.json', $option, $post->post_name ) ) ) {
				$options = array( $option );
				$this->save_json_location = $option;
			}
		}

		// override acf's `save_json`
		$this->america_acf_ljm_override_save_json();

		// display the select box
		$this->america_acf_ljm_select( $options, $this->save_json_location );
	}


	/**
		* Save the load/save full path to the `acf_save_location` wp_postmeta field
		*
		* @param		integer		$post_id
		*/

	public function america_acf_ljm_save( $post_id ) {
		// If autosaving, bail
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		// Paranoid check user is an admin. If not, bail
		if ( ! current_user_can( 'activate_plugins' ) ) return;

		// if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['_america_acf_save_location_nonce'] ) || !wp_verify_nonce( $_POST['_america_acf_save_location_nonce'], 'america_acf_save_location_nonce' ) ) {
			wp_die('Bad nonce!');
			return;
		}

		// Bail if not an acf-field-group
		if ( empty( $post_id ) || $_POST['post_type'] != 'acf-field-group' ) return false;

		// Save
		if( isset( $_POST['acf_save_location'] ) ) {
			// Get choice from the select box
			$this->save_json_location = esc_attr( $_POST['acf_save_location'] );

			// override acf's `save_json`
			$this->america_acf_ljm_override_save_json();
		}
	}


	/**
		*	A utility method for overriding ACF's `save_json` with `$this->save_json_location`
		*
		* @since 		1.0.0
		*/

	public function america_acf_ljm_override_save_json() {
		add_action('acf/settings/save_json', function( $path ) {
			$path = $this->save_json_location;
			return $path;
		});
	}
}
