<?php
defined( 'ABSPATH' ) or die();

class BTCLite_SaveSettings {
	/* Register settings */
	public static function btclite_save_settings() {
		if ( ! wp_verify_nonce( $_REQUEST['btcl_setting_options'], 'btcl_save_settings' ) ) {
			die();
		}

		$company_name      = isset( $_POST['company_name'] ) ? sanitize_text_field( $_POST['company_name'] ) : '';
		$timezone          = isset( $_POST['timezone'] ) ? sanitize_text_field( $_POST['timezone'] ) : 'Asia/Kolkata';
		$date_format       = isset( $_POST['date_format'] ) ? sanitize_text_field( $_POST['date_format'] ) : 'F j Y';
		$time_format       = isset( $_POST['time_format'] ) ? sanitize_text_field( $_POST['time_format'] ) : 'g:i A';
		$halfday_start     = isset( $_POST['halfday_start'] ) ? sanitize_text_field( $_POST['halfday_start'] ) : '';
		$halfday_end       = isset( $_POST['halfday_end'] ) ? sanitize_text_field( $_POST['halfday_end'] ) : '';
		$monday_status     = isset( $_POST['monday_status'] ) ? sanitize_text_field( $_POST['monday_status'] ) : 'working';
		$tuesday_status    = isset( $_POST['tuesday_status'] ) ? sanitize_text_field( $_POST['tuesday_status'] ) : 'working';
		$wednesday_status  = isset( $_POST['wednesday_status'] ) ? sanitize_text_field( $_POST['wednesday_status'] ) : 'working';
		$thursday_status   = isset( $_POST['thursday_status'] ) ? sanitize_text_field( $_POST['thursday_status'] ) : 'working';
		$friday_status     = isset( $_POST['friday_status'] ) ? sanitize_text_field( $_POST['friday_status'] ) : 'working';
		$saturday_status   = isset( $_POST['saturday_status'] ) ? sanitize_text_field( $_POST['saturday_status'] ) : 'working';
		$sunday_status     = isset( $_POST['sunday_status'] ) ? sanitize_text_field( $_POST['sunday_status'] ) : 'off';
		$ip_match          = isset( $_POST['ip_match'] ) ? sanitize_text_field( $_POST['ip_match'] ) : 'exact';
		$restricted_ips    = isset( $_POST['restricted_ips'] ) ? sanitize_text_field( $_POST['restricted_ips'] ) : '';
		$cur_symbol        = isset( $_POST['currency_symbol'] ) ? sanitize_text_field( $_POST['currency_symbol'] ) : '₹';
		$cur_position      = isset( $_POST['currency_position'] ) ? sanitize_text_field( $_POST['currency_position'] ) : 'Right';
		$salary_method     = isset( $_POST['salary_method'] ) ? sanitize_text_field( $_POST['salary_method'] ) : 'monthly';
		$employee_avatar   = isset( $_POST['employee_avatar'] ) ? sanitize_text_field( $_POST['employee_avatar'] ) : 'yes';
		$ip_restriction    = isset( $_POST['ip_restriction'] ) ? sanitize_text_field( $_POST['ip_restriction'] ) : 'yes';

		/* validations */
		$errors = [];
		if ( empty ( $timezone ) ) {
			$errors['timezone'] = esc_html__( 'Please select TimeZone', 'clockinator-lite' );
		}
		if ( empty ( $date_format ) ) {
			$errors['date_format'] = esc_html__( 'Please select Date format', 'clockinator-lite' );
		}
		if ( empty ( $time_format ) ) {
			$errors['time_format'] = esc_html__( 'Please select time format', 'clockinator-lite' );
		}
		if ( empty( $halfday_start ) ) {
			$errors['halfday_start'] = esc_html__('Please enter half start time', 'clockinator-lite');
		}
		if ( empty( $halfday_end ) ) {
			$errors['halfday_end'] = esc_html__('Please enter half end time', 'clockinator-lite');
		}
		if ( empty ( $cur_symbol ) ) {
			$errors['currency_symbol'] = esc_html__( 'Please enter currency symbol', 'clockinator-lite' );
		}
		if ( empty ( $cur_position ) ) {
			$errors['currency_position'] = esc_html__( 'Please select currency position', 'clockinator-lite' );
		}

		/* End validations */

		if ( count( $errors ) < 1 ) {
			$btcl_settings = array(
				'timezone'          => $timezone,
				'date_format'       => $date_format,
				'time_format'       => $time_format,
				'monday_status'     => $monday_status,
				'tuesday_status'    => $tuesday_status,
				'wednesday_status'  => $wednesday_status,
				'thursday_status'   => $thursday_status,
				'friday_status'     => $friday_status,
				'saturday_status'   => $saturday_status,
				'sunday_status'     => $sunday_status,
				'halfday_start'     => $halfday_start,
				'halfday_end'       => $halfday_end,
				'cur_symbol'        => $cur_symbol,
				'cur_position'      => $cur_position,
				'salary_method'     => $salary_method,
				'ip_match'          => $ip_match,
				'restricted_ips'    => $restricted_ips,
				'employee_avatar'   => $employee_avatar,
				'ip_restriction'    => $ip_restriction,
				'company_name'      => $company_name,
			);

			update_option( 'btcl_settings', $btcl_settings );
			wp_send_json_success( array( 'message' => __( 'Settings updated successfully', 'clockinator-lite' ) ) );
		}
		wp_send_json_error( $errors );
	}
} 
?>