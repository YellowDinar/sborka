<?php
/**
* Class for settings page
*/
class Wphf_SettingsPage extends Wphf_Base {
	
	public function bootstrap() {

		// Add settings
		add_action( 'admin_init', array( $this, 'register_settings') );
	
		// Add settings page
		add_action( 'admin_menu', array( $this, 'add_menu_and_page'));
	}
	
	public function add_menu_and_page(){
		// Use built-in WP function
		add_submenu_page(
			$this->plugin['settings_page.parent_slug'],
			$this->plugin['settings_page.page_title'],
			$this->plugin['settings_page.menu_title'],
			$this->plugin['settings_page.capability'],
			$this->plugin['settings_page.menu_slug'],
			array( $this, 'render_settings_page')
		);
	}
	
	/**
	* Render settings page. This function should echo the HTML form of the settings page.
	*/
	public function render_settings_page($post){
		global $wp_version;
		
        $vars = array();
        $vars['page_title'] = $this->page_title;
        $vars['textdomain'] = $this->plugin['textdomain'];
		
		if ( version_compare( $wp_version, '3.7', '<=' ) ) { // WP 3.7 and below
			$vars['screen_icon'] = get_screen_icon('options-general');
		} else { // WP 3.8+
			$vars['screen_icon'] = ''; // Screen icons are no longer used as of WordPress 3.8
		}
        
        $vars['settings_fields'] = $this->settings_fields( $this->plugin['settings_page.option_group'] );
        $vars['option_name'] = $this->plugin['settings_page.option_name'];
        $vars['settings_data'] = $this->get_settings_data();
		$debug = filter_var( trim(print_r( $vars['settings_data'], true )), FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        $vars['debug'] = ($this->plugin['debug']) ? '<pre>'.$debug.'</pre>' : '';
        
        $this->plugin['view']->render('settings-page.php', $vars);
	}
	
	/**
	* Prepare option data
	*/
	public function register_settings() {
		register_setting(
			$this->plugin['settings_page.option_group'],
			$this->plugin['settings_page.option_name'],
			array( $this, 'validate_options')
		);
	}
		
	/**
	* Validate data from HTML form
	*/
	public function validate_options( $input ) {
		$input = wp_parse_args($input, $this->get_settings_data());
		
		if( isset($_POST['reset']) ){
			$input = $this->get_default_settings_data();
			add_settings_error( $this->plugin['settings_page.menu_slug'], 'restore_defaults', __( 'Saved data cleared.', $this->plugin['textdomain']), 'updated fade' );
		}
		return $input;
	}
	
	/**
	* Get settings data. If there is no data from database, use default values
	*/
	public function get_settings_data(){
		return get_option( $this->plugin['settings_page.option_name'], $this->get_default_settings_data() );
	}
	
	/**
	* Apply default values
	*/
	public function get_default_settings_data() {
		$defaults = array();
		
		$defaults['wp_head'] = '';
        $defaults['wp_footer'] = '';
		
		return $defaults;
	}
	
	/**
	* Output needed fields for security
	*/
	function settings_fields( $option_group ) {
		$fields = "<input type='hidden' name='option_page' value='" . esc_attr($option_group) . "' />";
		$fields .= '<input type="hidden" name="action" value="update" />';
		$fields .= wp_nonce_field("$option_group-options", '_wpnonce', true, false);
		return $fields;
	}
	
		
	
	/**
	* Get settings data by uid
	*/
	public function get_data($uid){
		$settings_data = $this->get_settings_data();
		if(isset($settings_data[$uid])){
			return $settings_data[$uid];
		}
		return false;
	}
	
} // end class
