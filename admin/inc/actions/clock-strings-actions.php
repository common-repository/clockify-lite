<?php
defined( 'ABSPATH' ) or die();

class BTCLite_SaveTranslateStrings {
	/* Register settings */
	public static function btclite_save_settings() {
		if ( ! wp_verify_nonce( $_REQUEST['btcl_strings_options'], 'btcl_save_template_options' ) ) {
			die();
		}

        $clock_in   = isset( $_POST['clock_in'] ) ? sanitize_text_field( $_POST['clock_in'] ) : esc_html__( 'Clock In', 'clockinator-lite' );
        $clock_out  = isset( $_POST['clock_out'] ) ? sanitize_text_field( $_POST['clock_out'] ) : esc_html__( 'Clock Out', 'clockinator-lite' );
        $break_in   = isset( $_POST['break_in'] ) ? sanitize_text_field( $_POST['break_in'] ) : esc_html__( 'Break In', 'clockinator-lite' );
        $break_out  = isset( $_POST['break_out'] ) ? sanitize_text_field( $_POST['break_out'] ) : esc_html__( 'Break Out', 'clockinator-lite' );
        $reports    = isset( $_POST['session_report'] ) ? sanitize_text_field( $_POST['session_report'] ) : esc_html__( 'Submit Session Report', 'clockinator-lite' );
        $holidays   = isset( $_POST['upcoming_holidays'] ) ? sanitize_text_field( $_POST['upcoming_holidays'] ) : esc_html__( 'Up coming Holidays', 'clockinator-lite' );
        $events     = isset( $_POST['upcoming_events'] ) ? sanitize_text_field( $_POST['upcoming_events'] ) : esc_html__( 'Up coming Events', 'clockinator-lite' );
        $attendance = isset( $_POST['attendance_report'] ) ? sanitize_text_field( $_POST['attendance_report'] ) : esc_html__( 'Attendance Report', 'clockinator-lite' );
        $requests   = isset( $_POST['leave_requests'] ) ? sanitize_text_field( $_POST['leave_requests'] ) : esc_html__( 'Leave requests', 'clockinator-lite' );
        $profile    = isset( $_POST['your_profile'] ) ? sanitize_text_field( $_POST['your_profile'] ) : esc_html__( 'Your profile', 'clockinator-lite' );

        /* validations */
		$errors = [];
		if ( empty ( $clock_in ) ) {
			$errors['clock_in'] = esc_html__( 'Please enter string for Clock In button', 'clockinator-lite' );
		}
		if ( empty ( $clock_out ) ) {
			$errors['clock_out'] = esc_html__( 'Please enter string for Clock Out button', 'clockinator-lite' );
		}
		if ( empty( $break_in ) ) {
			$errors['break_in'] = esc_html__('Please enter string for Break In button', 'clockinator-lite');
		}
		if ( empty ( $break_out ) ) {
			$errors['break_out'] = esc_html__( 'Please enter string for Break Out button', 'clockinator-lite' );
		}
        if ( empty ( $reports ) ) {
			$errors['session_report'] = esc_html__( 'Please enter string for Submit session button', 'clockinator-lite' );
		}
		if ( empty ( $holidays ) ) {
			$errors['upcoming_holidays'] = esc_html__( 'Please enter string for Upcoming holiday heading', 'clockinator-lite' );
		}
        if ( empty ( $events ) ) {
			$errors['upcoming_events'] = esc_html__( 'Please enter string for Upcoming Events heading', 'clockinator-lite' );
		}
        if ( empty ( $attendance ) ) {
			$errors['attendance_report'] = esc_html__( 'Please enter string for Attendance Report heading', 'clockinator-lite' );
		}
        if ( empty ( $requests ) ) {
			$errors['leave_requests'] = esc_html__( 'Please enter string for Leave requests heading', 'clockinator-lite' );
		}
        if ( empty ( $profile ) ) {
			$errors['your_profile'] = esc_html__( 'Please enter string for Your Profile heading', 'clockinator-lite' );
		}
        /* End validations */

		if ( count( $errors ) < 1 ) {
			$btcl_settings = array(
				'clock_in'          => $clock_in,
				'clock_out'         => $clock_out,
				'break_in'          => $break_in,
				'break_out'         => $break_out,
				'session_report'    => $reports,
				'upcoming_holidays' => $holidays,
				'upcoming_events'   => $events,
				'attendance_report' => $attendance,
				'leave_requests'    => $requests,
				'your_profile'      => $profile,
			);

			update_option( 'btcl_string_translation', $btcl_settings );
			wp_send_json_success( array( 'message' => __( 'Strings updated successfully', 'clockinator-lite' ) ) );
		}
		wp_send_json_error( $errors );
    }
}