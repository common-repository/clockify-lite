<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );

/**
 *  Action calls for Clock In/Clock Out
 */
class BTCLite_ClockAction {
	
	public static function btclite_add_clock_in() {
		check_ajax_referer( 'front_ajax_nonce', 'nounce' );

		if ( isset ( $_POST['user_id'] ) ) {
			global $wpdb;
			date_default_timezone_set( BTCLite_Helper::btclite_get_setting_timezone() );
			$user_id        = sanitize_text_field( $_POST['user_id'] );
			$btcl_employees = esc_sql( $wpdb->base_prefix . "btcl_employees" );
			$employer       = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_employees WHERE user_id = %s", $user_id ) );
			$name           = $employer->first_name.' '.$employer->last_name;
			$email          = $employer->user_email;
			$shift_id       = $employer->shift_id;
			$office_in      = strtotime( date( 'H:i:s' ) );

			$data = array(
				'user_id'       => $user_id,
				'name'          => $name,
				'email'         => $email,
				'office_in'     => date( 'H:i:s' ),
				'date_in'       => date( 'Y-m-d' ),
				'office_out'    => '',
				'date_out'      => '',
				'late'          => '',
				'late_reason'  	=> '',
				'report'        => '',
				'working_hours' => '',
				'login_date'    => date( 'Y-m-d' ),
				'user_ip'       => '',
				'shift_id'      => $shift_id,
				'shift_name'    => '',
				'location'      => BTCLite_Helper::btclite_get_user_location( $_SERVER['REMOTE_ADDR'] ),
			);

			$table_name = 'btcl_reports';
			$query      = BTCLite_Helper::btclite_insert_intoDB( $table_name, $data );
			if ( $query == true ) {
				$message = esc_html__( 'Successfully clock in, Your login session is started now.', 'clockinator-lite' );
				$status  = 'success';
				if ( ! empty ( BTCLite_Helper::btclite_get_user_location( $_SERVER['REMOTE_ADDR'] ) ) ) {
					$location = BTCLite_Helper::btclite_get_user_location( $_SERVER['REMOTE_ADDR'] );
				} else {
					$location = esc_html__( 'Not Found', 'clockinator-lite' );
				}
				BTCLite_Helper::btclite_employee_login_status( $user_id, date( 'H:i:s' ), '', $location, $_SERVER['REMOTE_ADDR'] );
			} else {
				$message = esc_html__( 'Clock-in not successfull.', 'clockinator-lite' );
				$status  = 'error';
			}
		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
		}
		$return = array(
			'status'  => $status,
			'message' => $message
		);
		wp_send_json( $return );
		wp_die();
	}

	public static function btclite_add_clock_out() {
		check_ajax_referer( 'front_ajax_nonce', 'nounce' );
		if ( isset ( $_POST['user_id'] ) ) {
			global $wpdb;
			date_default_timezone_set( BTCLite_Helper::btclite_get_setting_timezone() );
			$user_id      = sanitize_text_field( $_POST['user_id'] );
			$row_id       = sanitize_text_field( $_POST['row_id'] );
			$office_out   = date( "H:i:s" );
			$date         = date( 'Y-m-d' );
			$btcl_reports = esc_sql( $wpdb->base_prefix . "btcl_reports" );
			$reports      = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE id = %s", $row_id ) );

			if ( ! empty( $reports ) ) {
				$office_in = isset( $reports->office_in ) ? $reports->office_in : '';
				$datein    = isset( $reports->date_in ) ? $reports->date_in : '';
				$start     = date( "H:i:s", strtotime( $office_in ) );
				$end       = date( "H:i:s", strtotime( $office_out ) );
				$totaltime = BTCLite_Helper::btclite_get_work_time_difference( $start, $datein, $end, $date );
				$data      = array(
					'office_out'    => $office_out,
					'date_out'      => date( 'Y-m-d' ),
					'working_hours' => $totaltime,
				);
				$where = array(
					'id' => $row_id
				);
			}

			$table_name = 'btcl_reports';
			$query      = BTCLite_Helper::btclite_update_intoDB( $table_name, $data, $where );
			if ( $query == true ) {
				$message = esc_html__( 'Successfully clock out, Your login session is end now.', 'clockinator-lite' );
				$status  = 'success';
				if ( ! empty ( BTCLite_Helper::btclite_get_user_location( $_SERVER['REMOTE_ADDR'] ) ) ) {
					$location = BTCLite_Helper::btclite_get_user_location( $_SERVER['REMOTE_ADDR'] );
				} else {
					$location = esc_html__( 'Not Found', 'clockinator-lite' );
				}
				BTCLite_Helper::btclite_employee_login_status( $user_id, $office_in, date( 'H:i:s' ), $location, $_SERVER['REMOTE_ADDR'] );
			} else {
				$message = esc_html__( 'Clock-out not successfull.', 'clockinator-lite' );
				$status  = 'error';
			}

		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
		}
		$return = array(
			'status'  => $status,
			'message' => $message
		);
		wp_send_json( $return );
		wp_die();
	}

	public static function btclite_add_break_in() {
		check_ajax_referer( 'front_ajax_nonce', 'nounce' );
		if ( isset ( $_POST['user_id'] ) && isset ( $_POST['row_id'] ) ) {
			global $wpdb;
			date_default_timezone_set( BTCLite_Helper::btclite_get_setting_timezone() );
			$user_id      = sanitize_text_field( $_POST['user_id'] );
			$row_id       = sanitize_text_field( $_POST['row_id'] );
			$break_in     = date( "H:i:s" );
			$btcl_reports = esc_sql( $wpdb->base_prefix . "btcl_reports" );
			$break_report = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE id = %s", $row_id ) );
			$breaks       = $break_report->breaks;

			if ( empty ( $breaks ) ) {
				$breaks     = array();
				$break_data = array(
					'break_in'  => $break_in,
					'break_out' => '',
				);
				array_push( $breaks, $break_data );
			} else {
				$breaks_data = unserialize( $breaks );
				$breaks      = array();
				foreach ( $breaks_data as $key => $b_value ) {
					if ( ! empty( $b_value['break_in'] ) && ! empty( $b_value['break_out'] ) ) {
						$break_data = array(
							'break_in'  => $b_value['break_in'],
							'break_out' => $b_value['break_out'],
						);
						array_push( $breaks, $break_data );
					}
				}
				$break_data = array(
					'break_in'  => $break_in,
					'break_out' => '',
				);
				array_push( $breaks, $break_data );
			}
			$data = array(
				'breaks' => serialize( $breaks ),
			);
			$where = array(
				'id' => $row_id,
			);
			$table_name = 'btcl_reports';
			$query      = BTCLite_Helper::btclite_update_intoDB( $table_name, $data, $where );
			if ( $query == true ) {
				$message = esc_html__( 'Successfully break in, Your break session is started now.', 'clockinator-lite' );
				$status  = 'success';
			} else {
				$message = esc_html__( 'Break in not successfull.', 'clockinator-lite' );
				$status  = 'error';
			}

		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
		}
		$return = array(
			'status'  => $status,
			'message' => $message
		);
		wp_send_json( $return );
		wp_die();
	}

	public static function btclite_add_break_out() {
		check_ajax_referer( 'front_ajax_nonce', 'nounce' );
		if ( isset ( $_POST['user_id'] ) && isset ( $_POST['row_id'] ) ) {
			global $wpdb;
			date_default_timezone_set( BTCLite_Helper::btclite_get_setting_timezone() );
			$user_id      = sanitize_text_field( $_POST['user_id'] );
			$row_id       = sanitize_text_field( $_POST['row_id'] );
			$break_out    = date( "H:i:s" );
			$btcl_reports = esc_sql( $wpdb->base_prefix . "btcl_reports" );
			$break_report = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE id = %s", $row_id ) );
			$breaks_data  = $break_report->breaks;
			$breaks_data  = unserialize( $breaks_data );
			$breaks       = array();

			foreach ( $breaks_data as $key => $b_value ) {
				if ( ! empty ( $b_value['break_in'] ) && empty ( $b_value['break_out'] ) ) {
					$break_data = array(
						'break_in'  => $b_value['break_in'],
						'break_out' => $break_out,
					);
					array_push( $breaks, $break_data );
				} else {
					$break_data = array(
						'break_in'  => $b_value['break_in'],
						'break_out' => $b_value['break_out'],
					);
					array_push( $breaks, $break_data );
				}
			}

			$data = array(
				'breaks' => serialize( $breaks ),
			);

			$where = array(
				'id' => $row_id,
			);

			$table_name = 'btcl_reports';
			$query      = BTCLite_Helper::btclite_update_intoDB( $table_name, $data, $where );
			if ( $query == true ) {
				$message = esc_html__( 'Successfully break out, Your break session is end now.', 'clockinator-lite' );
				$status  = 'success';
			} else {
				$message = esc_html__( 'Break out not successfull.', 'clockinator-lite' );
				$status  = 'error';
			}

		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
		}
		$return = array(
			'status'  => $status,
			'message' => $message
		);
		wp_send_json( $return );
		wp_die();
	}

	public static function btclite_submit_work_report() {
		check_ajax_referer( 'front_ajax_nonce', 'nounce' );
		if ( ! empty ( $_POST['data'] ) ) {
			$values  = isset( $_POST['data'] ) ? (array) $_POST['data'] : array();
			$report  = $values[0]['value'];
			$row_id  = $values[1]['value'];
			$user_id = $values[3]['value'];

			$data    = array(
				'report' => $report,
			);
			$where   = array(
				'id' => $row_id
			);
			$table_name = 'btcl_reports';
			$query      = BTCLite_Helper::btclite_update_intoDB( $table_name, $data, $where );

			if ( $query == true ) {
				$message = esc_html__( 'Work report submitted successfully.', 'clockinator-lite' );
				$status  = 'success';
			} else {
				$message = esc_html__( 'Work report not submitted successfully.', 'clockinator-lite' );
				$status  = 'error';
			}

		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
		}
		$return = array(
			'status'  => $status,
			'message' => $message
		);
		wp_send_json( $return );
		wp_die();
	}
}