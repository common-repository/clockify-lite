<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );

/**
 * Action calls to generate reports
 */
class BTCLite_RepertGenerateAction{
	
	public static function btclite_generate_staff_report() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['data'] ) ) {
			$values   = isset( $_POST['data'] ) ? (array) BTCLite_Helper::btclite_sanitize_array( $_POST['data'] ) : array();
			$month    = $values['month'];
			$type     = $values['status'];
			$user_id  = $values['user_id'];
			$html     = '';
			$Reports  = array();
            $date_arr = array();
			$off_days = BTCLite_Helper::btclite_get_offdays();
			$settings = get_option( 'btcl_settings' );

			/* Get employer data */
			global $wpdb;
			$btcl_employees    = esc_sql( $wpdb->base_prefix . "btcl_employees" );
			$employer_data     = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_employees WHERE user_id = %d", $user_id ) );
			$shift_id          = $employer_data->shift_id;

			/* Get all holidays */
	        $all_dates         = BTCLite_Helper::btclite_get_all_dates_reports( $month );
			$all_holidays      = BTCLite_Helper::btclite_all_holidays();

			/* Get Attendence data */
			$btcl_reports      = esc_sql( $wpdb->base_prefix . "btcl_reports" );
			
			foreach ( $all_dates as $date_key => $date ) {
				$report_data = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %d AND login_date = %s", $user_id, $date ) );
				if ( $type == 'all' || $type == 'present' ) {
					if ( ! empty ( $report_data ) ) {
						foreach ( $report_data as $r_key => $report_value ) {
							$working_hours = $report_value->working_hours;

							if ( ! empty ( $report_value->office_in ) ) {
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
								esc_html( $week_day_name ),
								wp_kses_post( '<span class="label label-light-primary label-inline label-lg">' ) .''.esc_html( $formated_office_in ).''.wp_kses_post( '</span>' ),
								wp_kses_post( '<span class="label label-light-primary label-inline label-lg">' ) .''.esc_html( $formated_office_out ).''.wp_kses_post( '</span>' ),
								wp_kses_post( '<span class="label label-light-info label-inline label-lg">' ) .''.esc_html( $working_hours ).''.wp_kses_post( '</span>' ),
								esc_html( $report_value->user_ip ),
								esc_html( $report_value->location ), 
								wp_kses_post('<label class="label label-light-success label-inline label-lg">'.esc_html__( 'Present', 'clockify' ).'</label>' ), 
								wp_kses_post( '<button class="btn btn-outline-primary edit-report_data-details" data-user="'.esc_attr( $report_value->user_id ).'" data-id="'.esc_attr( $report_value->id ).'" data-table="'.esc_attr( 'btcl_reports' ).'" data-date="'.esc_attr( $date ).'">'.esc_html__( 'View', 'clockify' ).'
												</button>
											   <button class="btn btn-outline-success update-report_data-details" data-id="'.esc_attr( $report_value->id ).'">'.esc_html__( 'Edit', 'clockify' ).'
												</button>' ) 
							);
							array_push( $Reports, $data );
						}
					}
				}
				if ( $type == 'absent' || $type == 'all' ) {
					if ( empty ( $report_data ) ) {
						if ( in_array( date( 'l', strtotime( $date ) ), $off_days ) && ! in_array( $date, $all_holidays ) ) {
							$data = array( 
								esc_html( BTCLite_Helper::btclite_get_formated_date( $date ) ), 
								esc_html( date( 'l', strtotime( $date ) ) ), 
								esc_html__( 'Off day!', 'clockinator-lite' ),
								esc_html__( 'Off day!', 'clockinator-lite' ),
								esc_html__( 'Off day!', 'clockinator-lite' ),
								esc_html__( 'Off day!', 'clockinator-lite' ),
								esc_html__( 'Off day!', 'clockinator-lite' ),
								esc_html__( 'Off day!', 'clockinator-lite' ),
								esc_html__( 'Off day!', 'clockinator-lite' ) 
							);
							array_push( $Reports, $data );

						} elseif ( in_array( $date, $all_holidays ) ) {
						$data = array( 
							esc_html( BTCLite_Helper::btclite_get_formated_date( $date ) ), 
							esc_html( date( 'l', strtotime( $date ) ) ), 
							'-',
							'-',
							'-',
							'-',
							'-',
							wp_kses_post('<label class="badge badge-warning text-white">'.esc_html__( 'Holiday', 'clockinator-lite' ).'</label>' ), 
							'-' 
						);
							array_push( $Reports, $data );
						} else {
							$data = array( 
								esc_html( BTCLite_Helper::btclite_get_formated_date( $date ) ), 
								esc_html( date( 'l', strtotime( $date ) ) ), 
								'-',
								'-',
								'-',
								'-',
								'-',
								wp_kses_post('<label class="badge badge-danger text-white">'.esc_html__( 'Absent', 'clockinator-lite' ).'</label>' ), 
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
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['id'] ) && ! empty ( $_POST['table'] ) && ! empty ( $_POST['user_id'] ) ) {
			$row_id  = sanitize_text_field( $_POST['id'] );
			$table   = sanitize_text_field( $_POST['table'] );
			$user_id = sanitize_text_field( $_POST['user_id'] );
			$html    = '';
			$date    = sanitize_text_field( $_POST['date'] );

			/* Get employer data */
			global $wpdb;
			$btcl_reports = esc_sql( $wpdb->base_prefix . "" .$table );
			$reports_data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %d AND id = %s", $user_id, $row_id ) );

			$html .= '<div class="staff-session-details bg-gradient-primary">
						<h4 class="text-white">Attendence for staff ('.esc_html( BTCLite_Helper::btclite_get_current_user_data( $user_id, 'fullname' ) ).') <span>Date ('.esc_html( BTCLite_Helper::btclite_get_formated_date( $date ) ).')</span></h4>
					</div>';
			$html .= '<hr>';

			$total_hours  = array();
			$totalb_hours = array();

			$office_in     = ! empty( $reports_data->office_in ) ? BTCLite_Helper::btclite_get_formated_time( $reports_data->office_in ) : '';
			$office_out    = ! empty( $reports_data->office_out ) ? BTCLite_Helper::btclite_get_formated_time( $reports_data->office_out ) : '';
			$working_hours = ! empty( $reports_data->working_hours ) ? $reports_data->working_hours : '';
			$work_report   = ! empty( $reports_data->report ) ? $reports_data->report : '';
			$user_ip       = ! empty( $reports_data->user_ip ) ? $reports_data->user_ip : '';
			$location      = ! empty( $reports_data->location ) ? $reports_data->location : '';
			$breaks_data   = ! empty( $reports_data->breaks ) ? unserialize( $reports_data->breaks ) : '';

			array_push( $total_hours, $working_hours );

			$html .= '<div class="staff-session-items">';
			$html .= '<h5>'.esc_html__( 'Work Session', 'clockinator-lite' ).'</h5><hr><div class="row">';
			$html .= '<div class="col-md-4"><div class="form-group row">
						<label for="name" class="col-sm-5 col-form-label">'.esc_html__( 'Clock In Time', 'clockinator-lite' ).'</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="clock_in" id="clock_in" placeholder="'.esc_html__( 'HH:MM:SS', 'clockinator-lite' ).'" value="'.esc_attr( $office_in ).'">
						</div>
					</div></div>';
			$html .= '<div class="col-md-4"><div class="form-group row">
						<label for="name" class="col-sm-5 col-form-label">'.esc_html__( 'Clock Out Time', 'clockinator-lite' ).'</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="clock_out" id="clock_out" placeholder="'.esc_html__( 'HH:MM:SS', 'clockinator-lite' ).'" value="'.esc_attr( $office_out ).'">
						</div>
					</div></div>';
			$html .= '<div class="col-md-4"><div class="form-group row">
						<label for="name" class="col-sm-5 col-form-label">'.esc_html__( 'Working Hours', 'clockinator-lite' ).'</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="working_hour" id="working_hour" placeholder="'.esc_html__( 'HH:MM:SS', 'clockinator-lite' ).'" value="'.esc_attr( $working_hours ).'" readonly="readonly" disabled="disabled">
						</div>
					</div></div>';
			$html .= '<div class="col-md-12"><div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">'.esc_html__( 'Work Report', 'clockinator-lite' ).'</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="work_report" id="work_report" readonly="readonly" disabled="disabled">'.esc_html( $work_report ).'</textarea>
						</div>
					</div></div>';
			$html .= '<input type="hidden" name="row_id" id="row_id" value="'.$reports->id.'">';
			$html .= '</div></div>';
			$html .= '<hr>';

			if ( ! empty( $breaks_data ) ) {
				foreach ( $breaks_data as $key => $breaks ) {
					$no         = $key+1;
					$break_in   = ! empty( $breaks['break_in'] ) ? BTCLite_Helper::btclite_get_formated_time( $breaks['break_in'] ) : '';
					$break_out  = ! empty( $breaks['break_out'] ) ? BTCLite_Helper::btclite_get_formated_time( $breaks['break_out'] ) : '';
					if ( ! empty ( $break_in ) && ! empty ( $break_out ) ) {
						$break_time = BTCLite_Helper::btclite_get_time_difference( $break_in, $break_out );
						array_push( $totalb_hours, $break_time );
					} else {
						$break_time = '';
					}

					$html .= '<div class="staff-break-items">';
					$html .= '<h5>' . esc_html__( 'Break Session ' . $no, 'clockinator-lite' ) . '</h5><hr><div class="row">';
					$html .= '<div class="col-md-4"><div class="form-group row">
									<label for="name" class="col-sm-5 col-form-label">' . esc_html__('Break In Time', 'clockinator-lite') . '</label>
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
			}

			$html .= '<hr>';
			$html .= '<div class="staff-total-details bg-gradient-primary">
						<h4 class="text-white">'.esc_html__( 'Working hours according to all work sessions', 'clockinator-lite' ).':- <span>'.esc_html( BTCLite_Helper::btclite_total_working_time( $total_hours ) ).' Hours</span></h4>
						<h4 class="text-white">'.esc_html__( 'Total break time according to all break sessions', 'clockinator-lite' ).':- <span>'.esc_html( BTCLite_Helper::btclite_total_working_time( $totalb_hours ) ).' Hours</span></h4>
						<h4 class="text-white">'.esc_html__( 'Total working hours after eliminating break time for date ( ', 'clockinator-lite' ).''.esc_html( BTCLite_Helper::btclite_get_formated_date( $date ) ).' ) :- <span>'.esc_html( BTCLite_Helper::btclite_get_time_difference( BTCLite_Helper::btclite_total_working_time( $total_hours ), BTCLite_Helper::btclite_total_working_time( $totalb_hours ) ) ).' Hours</span></h4>
					  </div>';
			$html .= '<hr>';

			$status  = 'success';
			$message = esc_html__( 'Detailed report generated!', 'clockinator-lite' );

		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
			$html    = '';
		}
		$return = array(
			'status'  => $status,
			'message' => $message,
			'html'    => $html,
		);
		wp_send_json( $return );
		wp_die();
	}

	public static function btclite_fetch_clock_details() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['id'] ) ) {
			global $wpdb;
			$id         = sanitize_text_field( $_POST['id'] );
			$table      = 'btcl_reports';
			$table_name = $wpdb->base_prefix . "" .$table;
			$data       = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $id ) );
			$status     = 'success';
			$message    = esc_html__( 'Data fetched!.', 'clockinator' );
			$inputs     = array(
				'#edit_clock_in',
				'#edit_datein',
				'#edit_clock_out',
				'#edit_dateout',
				'#report_id'
			);

			if ( empty ( $data->office_in ) ) {
				$office_in = '';
			} else {
				$office_in = BTCLite_Helper::btclite_get_formated_time( $data->office_in );
			}

			if ( empty ( $data->office_out ) ) {
				$office_out = '';
			} else {
				$office_out = BTCLite_Helper::btclite_get_formated_time( $data->office_out );
			}

			$values = array(
				$office_in,
				$data->date_in,
				$office_out,
				$data->date_out,
				$data->id
			);

		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator' );
			$status  = 'error';
			$inputs  = '';
			$values  = '';
		}
		$return = array(
			'status'  => $status,
			'message' => $message,
			'inputs'  => $inputs,
			'values'  => $values,
		);
		wp_send_json( $return );
		wp_die();
	}

	public static function btclite_update_reports() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['data'] ) ) {
			$values  = isset( $_POST['data'] ) ? (array) $_POST['data'] : array();
			$in      = $values[0]['value'];
			$datein  = $values[1]['value'];
			$out     = $values[2]['value'];
			$dateout = $values[3]['value'];
			$id      = $values[4]['value'];

			$start     = date( "H:i:s", strtotime( $in ) );
			$end       = date( "H:i:s", strtotime( $out ) );
			$totaltime = BTCLite_Helper::btclite_get_work_time_difference( $start, $datein, $end, $dateout );

			$data      = array(
				'office_in'     => $in,
				'date_in'       => $datein,
				'office_out'    => $out,
				'date_out'      => $dateout,
				'working_hours' => $totaltime,
			);
			$where   = array(
				'id' => $id
			);
			$table_name = 'btcl_reports';
			$query      = BTCLite_Helper::btclite_update_intoDB( $table_name, $data, $where );
			if ( $query == true ) {
				$message = esc_html__( 'Data updated successfully.', 'clockinator' );
				$status  = 'success';
			} else {
				$message = esc_html__( 'Data not updated successfully.', 'clockinator' );
				$status  = 'error';
			}
		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator' );
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