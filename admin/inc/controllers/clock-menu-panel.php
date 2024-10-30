<?php
defined( 'ABSPATH' ) or die();

/**
 *  Menu class to add menu panels
 */
class BTCLite_AdminMenu {
	
	public static function btclite_create_menu() {
		$dashboard = add_menu_page( esc_html__( 'Clockinator Lite', 'clockinator-lite' ), esc_html__( 'Clockinator Lite', 'clockinator-lite' ), 'manage_options', 'clockify-lite-panel', array(
			'BTCLite_AdminMenu',
			'btclite_dashboard'
		), 'dashicons-clock', 25 );
		add_action( 'admin_print_styles-' . $dashboard, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

		$dashboard1 = add_submenu_page( 'clockify-lite-panel', esc_html__( 'Clockinator Lite', 'clockinator-lite' ), esc_html__( 'Dashboard', 'clockinator-lite' ), 'manage_options', 'clockify-lite-panel', array(
			'BTCLite_AdminMenu',
			'btclite_dashboard'
		) );
		add_action( 'admin_print_styles-' . $dashboard1, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

		$employees = add_submenu_page( 'clockify-lite-panel', esc_html__( 'Employees', 'clockinator-lite' ), esc_html__( 'Employees', 'clockinator-lite' ), 'manage_options', 'clockify-lite-employee', array(
			'BTCLite_AdminMenu',
			'btclite_employees'
		) );
		add_action( 'admin_print_styles-' . $employees, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

		$departments = add_submenu_page( 'clockify-lite-panel', esc_html__( 'Departments', 'clockinator-lite' ), esc_html__( 'Departments', 'clockinator-lite' ), 'manage_options', 'clockify-lite-department', array(
			'BTCLite_AdminMenu',
			'btclite_departments'
		) );
		add_action( 'admin_print_styles-' . $departments, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

		$Shifts = add_submenu_page( 'clockify-lite-panel', esc_html__( 'Shifts', 'clockinator-lite' ), esc_html__( 'Shifts', 'clockinator-lite' ), 'manage_options', 'clockify-lite-shift', array(
			'BTCLite_AdminMenu',
			'btclite_shifts'
		) );
		add_action( 'admin_print_styles-' . $Shifts, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

		$events = add_submenu_page( 'clockify-lite-panel', esc_html__( 'Events', 'clockinator-lite' ), esc_html__( 'Events', 'clockinator-lite' ), 'manage_options', 'clockify-lite-events', array(
			'BTCLite_AdminMenu',
			'btclite_events'
		) );
		add_action( 'admin_print_styles-' . $events, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

		$holidays = add_submenu_page( 'clockify-lite-panel', esc_html__( 'Holidays', 'clockinator-lite' ), esc_html__( 'Holidays', 'clockinator-lite' ), 'manage_options', 'clockify-lite-holidays', array(
			'BTCLite_AdminMenu',
			'btclite_holidays'
		) );
		add_action( 'admin_print_styles-' . $holidays, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

		$notification_count = BTCLite_Helper::btclite_get_total_leaves();
		if ( $notification_count == 0 ) {
			$notification_count = '';
		}
		$leave_notification =  ! empty( $notification_count ) ? sprintf( __( 'Leaves <span class="awaiting-mod">%d</span>', 'clockinator-lite' ), $notification_count ) : esc_html__( 'Leaves', 'clockinator-lite' );

		$leaves = add_submenu_page( 'clockify-lite-panel', esc_html__( 'Leaves', 'clockinator-lite' ), $leave_notification, 'manage_options', 'clockify-lite-leaves', array(
			'BTCLite_AdminMenu',
			'btclite_leaves'
		) );
		add_action( 'admin_print_styles-' . $leaves, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

		$target = add_submenu_page( 'clockify-lite-panel', esc_html__( 'Targets', 'clockinator-lite' ), esc_html__( 'Targets', 'clockinator-lite' ), 'manage_options', 'clockify-lite-target', array(
			'BTCLite_AdminMenu',
			'btclite_targets'
		) );
		add_action( 'admin_print_styles-' . $target, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

		$reports = add_submenu_page( 'clockify-lite-panel', esc_html__( 'Reports', 'clockinator-lite' ), esc_html__( 'Reports', 'clockinator-lite' ), 'manage_options', 'clockify-lite-reports', array(
			'BTCLite_AdminMenu',
			'btclite_reports'
		) );
		add_action( 'admin_print_styles-' . $reports, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

		$settings = add_submenu_page( 'clockify-lite-panel', esc_html__( 'Settings', 'clockinator-lite' ), esc_html__( 'Settings', 'clockinator-lite' ), 'manage_options', 'clockify-lite-settings', array(
			'BTCLite_AdminMenu',
			'btclite_settings'
		) );
		add_action( 'admin_print_styles-' . $settings, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

		$help = add_submenu_page( 'clockify-lite-panel', esc_html__( 'Go Pro', 'clockinator-lite' ). ' <i class="fas fa-star go-pro-icon"></i>', esc_html__( 'Go Pro', 'clockinator-lite' ). ' <i class="fas fa-star go-pro-icon"></i>', 'manage_options', 'clockify-lite-help', array(
			'BTCLite_AdminMenu',
			'btclite_help'
		) );
		add_action( 'admin_print_styles-' . $help, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

		$products = add_submenu_page( 'clockify-lite-panel', esc_html__( 'Our Products', 'clockinator-lite' ). ' <i class="fas fa-star go-pro-icon"></i>', esc_html__( 'Our Products', 'clockinator-lite' ). ' <i class="fas fa-star go-pro-icon"></i>', 'manage_options', 'clockify-lite-products', array(
			'BTCLite_AdminMenu',
			'btclite_products'
		) );
		add_action( 'admin_print_styles-' . $products, array( 'BTCLite_AdminMenu', 'btclite_dashboard_assets' ) );

	}

	/* Dashboard menu/submenu callback */
	public static function btclite_dashboard() {
		require_once( 'clock-dashboard-panel.php' );
	}

	public static function btclite_employees() {
		require_once( 'clock-employees-panel.php' );
	}

	public static function btclite_shifts() {
		require_once( 'clock-shifts-panel.php' );
	}

	public static function btclite_notices() {
		require_once( 'clock-notices-panel.php' );
	}

	public static function btclite_events() {
		require_once( 'clock-events-panel.php' );
	}

	public static function btclite_holidays() {
		require_once( 'clock-holidays-panel.php' );
	}

	public static function btclite_leaves() {
		require_once( 'clock-leaves-panel.php' );
	}

	public static function btclite_targets() {
		require_once( 'clock-targets-panel.php' );
	}

	public static function btclite_reports() {
		require_once( 'clock-reports-panel.php' );
	}

	public static function btclite_settings() {
		require_once( 'clock-settings-panel.php' );
	}

	public static function btclite_help() {
		require_once( 'clock-help-panel.php' );
	}

	public static function btclite_products() {
		require_once( 'clock-products-panel.php' );
	}

	public static function btclite_departments() {
		require_once( 'clock-departments-panel.php' );
	}

	/* Dashboard menu/submenu assets */
	public static function btclite_dashboard_assets() {
		self::btclite_enqueue_libraries();
		self::btclite_enqueue_custom_assets();
	}

	/* Enqueue third party libraties */
	public static function btclite_enqueue_libraries() {

		/* Enqueue styles */
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'toastr', BTCLite_PLUGIN_URL . 'assets/css/toastr.min.css');
        wp_enqueue_style( 'jquery-confirm', BTCLite_PLUGIN_URL . 'assets/css/jquery-confirm.min.css');
		wp_enqueue_style( 'fontawesome', BTCLite_PLUGIN_URL . 'assets/css/fontawesome/css/all.min.css' );
		wp_enqueue_style( 'btcl-horizontal-layout', BTCLite_PLUGIN_URL . 'assets/css/layout/style.css' );
		wp_enqueue_style( 'dataTables', BTCLite_PLUGIN_URL . 'assets/css/dataTables.bootstrap4.min.css' );
		wp_enqueue_style( 'datetimepicker', BTCLite_PLUGIN_URL . 'assets/css/bootstrap-datetimepicker.min.css' );

		/* Enqueue Scripts */
		wp_enqueue_script( 'jquery' );
		wp_enqueue_media();
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( 'moment-2.24.0', BTCLite_PLUGIN_URL . 'assets/js/moment.min.js', array( 'jquery' ), true, true );
		wp_enqueue_script( 'bootstrap', BTCLite_PLUGIN_URL . 'assets/js/bootstrap.min.js', array( 'jquery' ), true, true );
		wp_enqueue_script( 'toastr-js', BTCLite_PLUGIN_URL . 'assets/js/toastr.min.js', array( 'jquery' ), true, true );
		wp_enqueue_script( 'jquery-confirm-js', BTCLite_PLUGIN_URL . 'assets/js/jquery-confirm.min.js', array( 'jquery' ), true, true );
		wp_enqueue_script( 'jquery.dataTables', BTCLite_PLUGIN_URL . 'assets/js/jquery.dataTables.min.js', array( 'jquery' ), true, true );
		wp_enqueue_script( 'bootstrap-datetimepicker', BTCLite_PLUGIN_URL . 'assets/js/bootstrap-datetimepicker.min.js', array( 'jquery' ), true, true );
		wp_enqueue_script( 'chart-min', BTCLite_PLUGIN_URL . 'assets/js/chart.min.js', array( 'jquery' ), true, true );
	}

	/* Enqueue custom libraties */
	public static function btclite_enqueue_custom_assets() {
		wp_enqueue_style( 'btcl-custom-style', BTCLite_PLUGIN_URL . 'admin/css/admin-style.css' );
		wp_enqueue_script( 'btcl-custom-script', BTCLite_PLUGIN_URL . 'admin/js/admin-script.js' );
		wp_localize_script( 'btcl-custom-script', 'ajax_admin', array(
            'ajax_url'   => admin_url( 'admin-ajax.php' ),
            'btcl_nonce' => wp_create_nonce( 'btcl_ajax_nonce' ),
        ));

        wp_enqueue_script( 'btcl-inline-script', BTCLite_PLUGIN_URL . 'admin/js/admin-inline-script.js', array( 'jquery', 'chart-min' ), true, true );
	}
}