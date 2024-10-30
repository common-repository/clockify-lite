<?php
/*
Plugin Name: Clockinator Lite
Plugin URI:  https://beastthemes.com/plugins/clockify-pro
Description: World's most advanced employee/staff management Plugin to track their time & Attendance. You can manage Attendance, Departments, Employees, Shifts,  Salary, Real-Time Working Hours, Monthly Report Generation, Leaves, Notices, Holidays, User Roles. 
Author: beastthemes
Author URI: https://beastthemes.com/
Version: 1.0.7
Text Domain: clockinator-lite
Domain Path: /lang/
*/

defined( 'ABSPATH' ) or die();

if ( ! defined( 'BTCLite_PLUGIN_URL' ) ) {
	define( 'BTCLite_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'BTCLite_PLUGIN_DIR_PATH' ) ) {
	define( 'BTCLite_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'BTCLite_PLUGIN_BASENAME' ) ) {
	define( 'BTCLite_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'BTCLite_PLUGIN_FILE' ) ) {
	define( 'BTCLite_PLUGIN_FILE', __FILE__ );
}

final class BTClockifyLite {
	private static $instance = null;

	private function __construct() {
		$this->initialize_hooks();
	}

	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function initialize_hooks() {
		if ( is_admin() ) {
			require_once( 'admin/admin.php' );
			require_once( 'public/inc/controllers/class-page-template.php' );
			register_activation_hook( __FILE__, array( 'BTCLite_CustomPageTemplates', 'btclite_setup_clockify_dashboard' ) );
		}
		require_once( 'public/public.php' );
	}
}
BTClockifyLite::get_instance();

function btclite_pro_action_links ( $links ) {
    $mylinks = array(
        '<a class="delete" href="https://beastthemes.com/plugins/clockify-pro/"><b>'.esc_html__( 'Go Pro', 'clockify' ).'</b></a>',
        '<a class="delete" href="https://beastthemes.com/account/signup/clockify-pro-plugin"><b>'.esc_html__( 'Buy Now', 'clockinator-lite' ).'</b></a>',
    );
    return array_merge( $mylinks, $links );
}
add_filter( 'plugin_action_links_' . BTCLite_PLUGIN_BASENAME, 'btclite_pro_action_links' );