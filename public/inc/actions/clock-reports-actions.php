<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );

/**
 * Action calls to generate reports
 */
class BTCLite_RepertsGenerateAction{
	
	public static function btclite_generate_staff_report() {
		check_ajax_referer( 'front_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['data'] ) ) {
			$values   = isset( $_POST['data'] ) ? (array) $_POST['data'] : array();
			$month    = $values[0]['value'];
			$type     = $values[1]['value'];
			$user_id  = $values[2]['value'];
			$html     = '';
			$Reports  = array();
            $date_arr = array();
			$off_days = BTCLite_Helper::btclite_get_offdays();
			$settings = get_option( 'btcl_settings' );

			/* Get employer data */
			global $wpdb;
			$btcl_employees = esc_sql( $wpdb->base_prefix . "btcl_employees" );
			$employer_data  = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_employees WHERE user_id = %d", $user_id ) );
			$shift_id       = $employer_data->shift_id;

			/* Get all holidays */
	        $all_dates      = BTCLite_Helper::btclite_get_all_dates_reports( $month );
			$all_holidays   = BTCLite_Helper::btclite_all_holidays();

			/* Get Attendence data */
			$btcl_reports      = esc_sql( $wpdb->base_prefix . "btcl_reports" );
			
			foreach ( $all_dates as $date_key => $date ) {
				$report_data  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %d AND login_date = %s", $user_id, $date ) );

				if ( $type == 'all' || $type == 'present' ) {
					if ( ! empty ( $report_data ) ) {
						foreach ( $report_data as $r_key => $report_value ) {
							if ( ! empty( $report_value->working_hours ) ) {
								$working_hours = $report_value->working_hours;
								$working_hours = $working_hours . ' hours';
							} else {
								$working_hours = '';
							}

							if ( ! empty( $report_value->office_in ) ) {
								$formated_office_in = BTCLite_Helper::btclite_get_formated_time( $report_value->office_in );
							} else {
								$formated_office_in = '-';
							}

							if ( ! empty( $report_value->office_out ) ) {
								$formated_office_out = BTCLite_Helper::btclite_get_formated_time( $report_value->office_out );
							} else {
								$formated_office_out = '-';
							}

							$data = array(
								esc_html( BTCLite_Helper::btclite_get_formated_date( $report_value->login_date ) ),
								esc_html( date( 'l', strtotime( $date ) ) ),
								esc_html( $formated_office_in ),
								esc_html( $formated_office_out ),
								wp_kses_post( '<label class="badge badge-success text-white">' . esc_html__( 'Present', 'clockinator-lite' ) . '</label>' ),
								wp_kses_post( '<button class="btn btn-outline-primary edit-report_data-details" data-user="' . esc_attr( $report_value->user_id ) . '" data-id="' . esc_attr( $report_value->id ) . '" data-table="' . esc_attr( 'btcl_reports' ) . '" data-date="' . esc_attr( $date ) . '">' . esc_html__( 'View', 'clockinator-lite' ) . '
																		</button>' ),
							);
							array_push( $Reports, $data );
						}
					}
				}
				if ( $type == 'absent' || $type == 'all' ) {
					if ( empty ( $report_data ) ) {
						if ( in_array( date( 'l', strtotime( $date ) ), $off_days ) ) {
							$data = array( 
								esc_html( BTCLite_Helper::btclite_get_formated_date( $date ) ), 
								esc_html( date( 'l', strtotime( $date ) ) ), 
								esc_html__( 'Off day!', 'clockinator-lite' ),
								esc_html__( 'Off day!', 'clockinator-lite' ),
								esc_html__( 'Off day!', 'clockinator-lite' ),
								esc_html__( 'Off day!', 'clockinator-lite' )
							);
							array_push( $Reports, $data );

						} elseif ( ! in_array( date( 'l', strtotime( $date ) ), $off_days ) && in_array( $date, $all_holidays ) ) {
						$data = array( 
							esc_html( BTCLite_Helper::btclite_get_formated_date( $date ) ), 
							esc_html( date( 'l', strtotime( $date ) ) ), 
							'-',
							'-',
							wp_kses_post( '<label class="badge badge-warning text-white">'.esc_html__( 'Holiday', 'clockinator-lite' ).'</label>' ),
							'-' 
						);
							array_push( $Reports, $data );
						} else {
							$data = array( 
								esc_html( BTCLite_Helper::btclite_get_formated_date( $date ) ), 
								esc_html( date( 'l', strtotime( $date ) ) ),
								'-',
								'-',
								wp_kses_post( '<label class="badge badge-danger text-white">'.esc_html__( 'Absent', 'clockinator-lite' ).'</label>' ), 
								'-' 
							);
								array_push( $Reports, $data );
						}
					}
				}
			}

			$status  = 'success';
			$message = esc_html__( 'Report generated successfully!', 'clockinator-lite' );
			$time    = '';

		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
			$Reports = '';
			$time    = '';
		}
		$return = array(
			'status'  => $status,
			'message' => $message,
			'reports' => $Reports,
			'time'    => $time
		);
		wp_send_json( $return );
		wp_die();
	}

	public static function btclite_edit_staff_report() {
		check_ajax_referer( 'front_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['id'] ) && ! empty ( $_POST['table'] ) && ! empty ( $_POST['user_id'] ) ) {
			$row_id  = sanitize_text_field( $_POST['id'] );
			$table   = sanitize_text_field( $_POST['table'] );
			$user_id = sanitize_text_field( $_POST['user_id'] );
			$html    = '';
			$date    = sanitize_text_field( $_POST['date'] );

			/* Get employer data */
			global $wpdb;
			$btcl_reports = esc_sql( $wpdb->base_prefix . "" . $table );
			$reports_data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %d AND id = %s", $user_id, $row_id ) );

			$html .= '<div class="staff-session-details bg-gradient-primary">
									<h4 class="text-white">Attendence for staff (' . esc_html( BTCLite_Helper::btclite_get_current_user_data( $user_id, 'fullname' ) ) . ') <span>Date (' . esc_html( BTCLite_Helper::btclite_get_formated_date( $date ) ) . ')</span></h4>
								</div>';

			$total_hours = array();
			$totalb_hours = array();

			$office_in     = ! empty( $reports_data->office_in ) ? BTCLite_Helper::btclite_get_formated_time( $reports_data->office_in ) : '';
			$office_out    = ! empty( $reports_data->office_out ) ? BTCLite_Helper::btclite_get_formated_time( $reports_data->office_out ) : '';
			$working_hours = ! empty( $reports_data->working_hours ) ? BTCLite_Helper::btclite_total_working_time( array($reports_data->working_hours ) ) : '';
			$work_report   = ! empty( $reports_data->report ) ? $reports_data->report : '';
			$user_ip       = ! empty( $reports_data->user_ip ) ? $reports_data->user_ip : '';
			$location      = ! empty( $reports_data->location ) ? $reports_data->location : '';
			$breaks_data   = ! empty( $reports_data->breaks ) ? unserialize( $reports_data->breaks ) : '';

			array_push( $total_hours, $reports_data->working_hours );

			$html .= '<div class="staff-session-items">';
			$html .= '<h5>' . esc_html__( 'Work Session', 'clockinator-lite' ) . '</h5><hr><div class="row">';
			$html .= '<div class="col-md-4"><div class="form-group row">
							<label for="name" class="col-sm-5 col-form-label">' . esc_html__( 'Clock In Time', 'clockinator-lite' ) . '</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="clock_in" id="clock_in" placeholder="' . esc_html__( 'HH:MM:SS', 'clockinator-lite' ) . '" value="' . esc_attr( $office_in ) . '">
							</div>
						</div></div>';
			$html .= '<div class="col-md-4"><div class="form-group row">
							<label for="name" class="col-sm-5 col-form-label">' . esc_html__( 'Clock Out Time', 'clockinator-lite' ) . '</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="clock_out" id="clock_out" placeholder="' . esc_html__( 'HH:MM:SS', 'clockinator-lite' ) . '" value="' . esc_attr( $office_out ) . '">
							</div>
						</div></div>';
			$html .= '<div class="col-md-4"><div class="form-group row">
							<label for="name" class="col-sm-5 col-form-label">' . esc_html__( 'Working Hours', 'clockinator-lite' ) . '</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="working_hour" id="working_hour" placeholder="' . esc_html__( 'HH:MM:SS', 'clockinator-lite' ) . '" value="' . esc_attr( $working_hours ) . '">
							</div>
						</div></div>';
			$html .= '<div class="col-md-12"><div class="form-group row">
							<label for="name" class="col-sm-2 col-form-label">' . esc_html__( 'Work Report', 'clockinator-lite' ) . '</label>
							<div class="col-sm-10">
								<textarea class="form-control" name="work_report" id="work_report" readonly="readonly" disabled="disabled">' . esc_html( $work_report ) . '</textarea>
							</div>
						</div></div>';
			$html .= '</div></div>';
			$html .= '<hr>';

			foreach ( $breaks_data as $key => $breaks ) {
				$no        = $key + 1;
				$break_in  = ! empty( $breaks['break_in'] ) ? BTCLite_Helper::btclite_get_formated_time( $breaks['break_in'] ) : '';
				$break_out = ! empty( $breaks['break_out'] ) ? BTCLite_Helper::btclite_get_formated_time( $breaks['break_out'] ) : '';
				if ( ! empty( $break_in ) && ! empty( $break_out ) ) {
					$break_time = BTCLite_Helper::btclite_get_time_difference( $break_in, $break_out );
					array_push( $totalb_hours, $break_time );
				} else {
					$break_time = '';
				}

				$html .= '<div class="staff-break-items">';
				$html .= '<h5>' . esc_html__( 'Break Session ' . $no, 'clockinator-lite' ) . '</h5><hr><div class="row">';
				$html .= '<div class="col-md-4"><div class="form-group row">
								<label for="name" class="col-sm-5 col-form-label">' . esc_html__(' Break In Time', 'clockinator-lite' ) . '</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="break_in_' . $no . '" id="break_in_' . $no . '" placeholder="' . esc_html__( 'HH:MM:SS', 'clockinator-lite' ) . '" value="' . esc_attr( $break_in ) . '">
								</div>
							</div></div>';
				$html .= '<div class="col-md-4"><div class="form-group row">
								<label for="name" class="col-sm-5 col-form-label">' . esc_html__( 'Break Out Time', 'clockinator-lite' ) . '</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="break_out_' . $no . '" id="break_out_' . $no . '" placeholder="' . esc_html__( 'HH:MM:SS', 'clockinator-lite' ) . '" value="' . esc_attr( $break_out ) . '">
								</div>
							</div></div>';
				$html .= '<div class="col-md-4"><div class="form-group row">
								<label for="name" class="col-sm-5 col-form-label">' . esc_html__( 'Total Break Time', 'clockinator-lite' ) . '</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="break_time_' . $no . '" id="break_time_' . $no . '" placeholder="' . esc_html__( 'HH:MM:SS', 'clockinator-lite' ) . '" value="' . esc_attr( $break_time ) . '" readonly="readonly">
								</div>
							</div></div>';
				$html .= '</div></div>';
			}

			$html .= '<div class="staff-total-details bg-gradient-primary">
						<h5 class="text-white">' . esc_html__( 'Working hours according to all work sessions', 'clockinator-lite' ) . ':- <span>' . esc_html( BTCLite_Helper::btclite_total_working_time( $total_hours ) ) . ' Hours</span></h5>
						<h5 class="text-white">' . esc_html__( 'Total break time according to all break sessions', 'clockinator-lite' ) . ':- <span>' . esc_html( BTCLite_Helper::btclite_total_working_time( $totalb_hours ) ) . ' Hours</span></h5>
						<h5 class="text-white">' . esc_html__( 'Total working hours after eliminating break time for date ( ', 'clockinator-lite' ) . '' . esc_html( BTCLite_Helper::btclite_get_formated_date( $date ) ) . ' ) :- <span>' . esc_html( BTCLite_Helper::btclite_get_time_difference( BTCLite_Helper::btclite_total_working_time( $total_hours ), BTCLite_Helper::btclite_total_working_time( $totalb_hours ) ) ) . ' Hours</span></h5>
					</div>';

			$status  = 'success';
			$message = esc_html__( 'Detailed report generated!', 'clockinator-lite' );

		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
		}
		$return = array(
			'status'  => $status,
			'message' => $message,
			'html'    => $html,
		);
		wp_send_json( $return );
		wp_die();
	}

	public static function btclite_display_target() {
		check_ajax_referer( 'front_ajax_nonce', 'nounce' );

		if ( isset ( $_POST['id'] ) ) {
			$pid     = isset( $_POST['id'] ) ? sanitize_text_field( $_POST['id'] ) : '';
			$type    = isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';
			$purl    = isset( $_POST['url'] ) ? sanitize_text_field( $_POST['url'] ) : '';
			$message = esc_html__( 'Details Fetch!.', 'clockinator-lite' );
			$status  = 'success';

			if ( $type == 'target' ) {
				$url = add_query_arg( array( 'action'  => 'tar_view', 'row_id'  => $pid ), $purl );
			}
			
		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
			$url     = '';
		}
		$return = array(
			'status'  => $status,
			'message' => $message,
			'url'     => $url
		);
		wp_send_json( $return );
		wp_die();
	}
}