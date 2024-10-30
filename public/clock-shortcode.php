<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . '/admin/inc/helpers/clock-helper.php' );

/**
 *  Action calls for Shotcode
 */
class BTCLShortcodes {

	/* Dashboard */
	public static function btclite_front_dashboard( $attr ) {
		ob_start();
		require_once( 'inc/views/clock-dashboard.php' );
		return ob_get_clean();
	}

	/* Last Day Working Hours */
	public static function btclite_last_day_working_hours( $attr ) {
		ob_start();
		$user_id     = get_current_user_id();
		$user_status = BTCLite_Helper::btclite_check_user_availability();
		if ( $user_status == true ) {
		?>
		<div class="btcl-container">
			<div class="card bg-gradient-danger card-holder text-center card-shadow-danger">
              	<div class="card-body">
                	<h6 class="font-weight-normal text-white"><?php esc_html_e( 'Last day working hours', 'clockinator-lite' ); ?></h6>
                	<h2 class="mb-0 text-white">
						<?php echo esc_html( BTCLite_Helper::btclite_last_day_working_hours() ); ?>
					</h2>
              	</div>
            </div>
          </div>
		<?php
		}
		return ob_get_clean();
	}

	/* Total Attendance */
	public static function btclite_total_attendance( $attr ) {
		ob_start();

		$user_id     = get_current_user_id();
		$user_status = BTCLite_Helper::btclite_check_user_availability();
		if ( $user_status == true ) {
		?>
		<div class="btcl-container">
			<div class="card bg-gradient-warning card-holder text-center card-shadow-warning">
              	<div class="card-body">
                	<h6 class="font-weight-normal text-white"><?php esc_html_e( 'Total Attendance', 'clockinator-lite' ); ?></h6>
                	<h2 class="mb-0 text-white">
					<?php
						$total_presents = BTCLite_Helper::btclite_total_absents( $user_id, '1' );;
						$total_presents = sizeof( $total_presents['attend'] );
						echo esc_html( $total_presents );
					?>
					</h2>
              	</div>
            </div>
          </div>
		<?php
		}
		return ob_get_clean();
	}

	/* Total Absents */
	public static function btclite_total_absents( $attr ) {
		ob_start();
		$user_id     = get_current_user_id();
		$user_status = BTCLite_Helper::btclite_check_user_availability();
		if ( $user_status == true ) {
		?>
		<div class="btcl-container">
			<div class="card bg-gradient-info card-holder text-center card-shadow-warning">
              	<div class="card-body">
                	<h6 class="font-weight-normal text-white"><?php esc_html_e( 'Total Absents', 'clockinator-lite' ); ?></h6>
                	<h2 class="mb-0 text-white">
					<?php
						$total_absents = BTCLite_Helper::btclite_total_absents( $user_id, '1' );
						$total_absents = sizeof( $total_absents['dates1'] );
						echo esc_html( $total_absents );
					?>
					</h2>
              	</div>
            </div>
          </div>
		<?php
		}
		return ob_get_clean();
	}

	/* Clock In Buttons */
	public static function btclite_clockin_buttons( $attr ) {
		ob_start();

		$user_id     = get_current_user_id();
		$user_status = BTCLite_Helper::btclite_check_user_availability();
		if ( $user_status == true ) {
		?>
		<div class="btcl-container">
			<div class="row clock-action-outer">
	        	<div class="col-md-9 col-lg-9 clock-action-button-div ">
	        		<?php echo BTCLite_Helper::btclite_get_clock_action_buttons( $user_id ); ?>
	        	</div>
	        	<div class="col-md-3 col-lg-3 clock-div">
					<div class="card bg-dark text-white">
						<h3 class="card-title text-center">
							<div class="d-flex flex-wrap justify-content-center mt-2 text-white">
								<a><span class="badge hours"></span></a> :
								<a><span class="badge min"></span></a> :
								<a><span class="badge sec"></span></a>
							</div>
						</h3>
					</div>
				</div>
	        </div>
          </div>
		<?php
		}
		return ob_get_clean();
	}

	/* Reports Panel */
	public static function btclite_attendance_reports( $attr ) {
		ob_start();

		$user_id     = get_current_user_id();
		$user_status = BTCLite_Helper::btclite_check_user_availability();
		if ( $user_status == true ) {
			$months            = BTCLite_Helper::btclite_month_filter();
			$btcl_strings      = get_option( 'btcl_string_translation' );
			$attendance_report = isset( $btcl_strings['attendance_report'] ) ? sanitize_text_field( $btcl_strings['attendance_report'] ) : esc_html__( 'Attendance Report' );
		?>
		<div class="btcl-container">
			<h4 class="card-title"><?php echo esc_html( $attendance_report ); ?></h4>
			<div class="report-form-div">
				<form id="staff-reports-form" method="post">
					<div class="row">
			           	<div class="col-md-5">
			          		<select class="form-control form-control-sm custom-select-height" name="month" id="month">
			            		<optgroup label="<?php esc_html_e( 'Select Any Filter ( individual Months )', 'clockinator-lite' );?>">
			                        <?php foreach ( $months as $key => $month ) { ?>
			                            <option value="<?php echo esc_attr( $key + 1 ); ?>"><?php esc_html_e( $month, 'clockinator-lite' ); ?></option>
			                        <?php } ?>
			                    </optgroup>
				                <optgroup label="<?php esc_html_e( 'Select Any Filter ( Combine Months )', 'clockinator-lite' );?>">
			                        <option value="14"><?php esc_html_e( 'Previous Three Month', 'clockinator-lite' );?></option>
			                        <option value="15"><?php esc_html_e( 'Previous Six Month', 'clockinator-lite' );?></option>
			                        <option value="16"><?php esc_html_e( 'Previous Nine Month', 'clockinator-lite' );?></option>
			                        <option value="17"><?php esc_html_e( 'Previous One Year', 'clockinator-lite' );?></option>
			                    </optgroup>
			          		</select>
			            </div>
			            <div class="col-md-5">
			          		<select class="form-control form-control-sm custom-select-height" name="status" id="status">
			            		<option value="all"><?php esc_html_e( 'All days', 'clockinator-lite' ); ?></option>
			            		<option value="absent"><?php esc_html_e( 'Only Absent Days', 'clockinator-lite' ); ?></option>
			            		<option value="present"><?php esc_html_e( 'Only Attend days', 'clockinator-lite' ); ?></option>
			          		</select>
			            </div>
			            <input type="hidden" name="user_id" value="<?php echo esc_attr( get_current_user_id() ); ?>">
			           	<div class="col-md-2">
			           		<button type="button" id="GenerateReportsBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
			           	</div>
			        </div>
				</form>
			</div>
			<div class="report-table-div">
				<div class="row inner-row">
				  	<div class="col-12">
				  		<!-- Edit Modal starts -->
						<div class="modal fade" id="EditReports" tabindex="-1" role="dialog" aria-labelledby="EditReports" aria-hidden="true">
						<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="EditReports"><?php esc_html_e( 'Daily Report', 'clockinator-lite' ); ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form class="forms-sample" method="post" id="EditReportsForm">
								</form>
							</div>
							</div>
						</div>
						</div>
				    	<div class="table-responsive">
				      		<table id="reports-listing" class="table table-striped">
				      			<thead>
						            <tr>
						                <th><?php esc_html_e( 'Date', 'clockinator-lite' ); ?></th>
						                <th><?php esc_html_e( 'Day', 'clockinator-lite' ); ?></th>
						                <th><?php esc_html_e( 'Clock In', 'clockinator-lite' ); ?></th>
						                <th><?php esc_html_e( 'Clock Out', 'clockinator-lite' ); ?></th>
						                <th><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></th>
						                <th><?php esc_html_e( 'Actions', 'clockinator-lite' ); ?></th>
						            </tr>
					            </thead>
					            <tbody id="staff-report-table">

					            </tbody>
				      		</table>
				      	</div>
				    </div>
					<div class="col-12 grid-margin salary-status-div">
			            <h4 class="card-title"><?php esc_html_e( 'Summary', 'clockinator-lite' ); ?></h4>
			        	<div class="salary-form-div"></div>
			        </div>
				</div>
			</div>
        </div>
		<?php
		}
		return ob_get_clean();
	}

	/* Leave Requests Panel */
	public static function btclite_leave_requests( $attr ) {
		ob_start();
		$user_id     = get_current_user_id();
		$user_status = BTCLite_Helper::btclite_check_user_availability();
		if ( $user_status == true ) {
			$btcl_strings   = get_option( 'btcl_string_translation' );
			$leave_requests = isset( $btcl_strings['leave_requests'] ) ? sanitize_text_field( $btcl_strings['leave_requests'] ) : esc_html__( 'Leave requests' );
		?>
		<div class="btcl-container">
			<h4 class="card-title"><?php echo esc_html( $leave_requests ); ?></h4>
			<button type="button" class="btn btn-primary top-add-btn" data-toggle="modal" data-target="#AddLeaves"><?php esc_html_e( 'Add Request', 'clockinator-lite' ); ?></button>
			<div class="row inner-row">
				<div class="col-12">
			  	<div class="table-responsive">
			    		<table id="requests-listing" class="table table-striped">
			              <thead>
			                <tr>
			                  <th><?php esc_html_e( 'No.', 'clockinator-lite' ); ?></th>
			                  <th><?php esc_html_e( 'Subject', 'clockinator-lite' ); ?></th>
			                  <th><?php esc_html_e( 'Date(s)', 'clockinator-lite' ); ?></th>
			                  <th><?php esc_html_e( 'Reason', 'clockinator-lite' ); ?></th>
			                  <th><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></th>
			                  <th><?php esc_html_e( 'Actions', 'clockinator-lite' ); ?></th>
			                </tr>
			              </thead>
			              <tbody>
			          	<?php
			                  $all_leaves = BTCLite_Helper::btclite_get_leaves();
			                  foreach ( $all_leaves as $key => $leave ) {
			                  	if ( $leave->user_id == $user_id ) {
			              ?>
							<tr>
								<td><?php echo esc_html( $key+1 ); ?></td>
								<td><?php esc_html_e( $leave->name, 'clockinator-lite' ); ?></td>
								<td><?php echo esc_html( BTCLite_Helper::btclite_get_formated_date( $leave->start ).' to '.BTCLite_Helper::btclite_get_formated_date( $leave->end ) ); ?></td>
								<td><?php esc_html_e( $leave->description, 'clockinator-lite' ); ?></td>
								<td>
			                      <?php 
			                      if ( $leave->status == 'approved' ) {
			                        	$class = 'badge-success';
			                      } elseif ( $leave->status == 'cancelled' ) {
			                        	$class = 'badge-danger';
			                      } else {
			                      	$class = 'badge-warning';
			                      } ?>
			                      <label class="badge <?php echo esc_attr( $class ); ?> text-white"><?php esc_html_e( $leave->status, 'clockinator-lite' ); ?></label>
			                  </td>
			                  <td>
			                  	<?php if ( $leave->status != 'approved' ) { ?>
			                          <button class="btn btn-outline-primary edit-leave-details" data-id="<?php echo esc_attr( $leave->id ); ?>" data-table="<?php echo esc_attr( 'btcl_leaves' ); ?>">
			                            <?php esc_html_e( 'View', 'clockinator-lite' ); ?>
			                          </button>
			                  	<?php } ?>
			                      <button class="btn btn-outline-danger delete-leave-details" data-id="<?php echo esc_attr( $leave->id ); ?>" data-table="<?php echo esc_attr( 'btcl_leaves' ); ?>">
			                        <?php esc_html_e( 'Delete', 'clockinator-lite' ); ?>
			                      </button>
			                  </td>
							</tr>
							<?php } } ?>
			              </tbody>
			          </table>
			      </div>
			  </div>
			</div>

			<!-- Modal starts -->
			<div class="modal fade" id="AddLeaves" tabindex="-1" role="dialog" aria-labelledby="AddLeaves" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="AddLeaves"><?php esc_html_e( 'Submit your leave request', 'clockinator-lite' ); ?></h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <form class="forms-sample" method="post" id="LeavesForm">
			          <div class="form-group row">
			            <label for="subjectt" class="col-sm-3 col-form-label"><?php esc_html_e( 'Subject', 'clockinator-lite' ); ?></label>
			            <div class="col-sm-9">
			              <input type="text" class="form-control" name="subjectt" id="subjectt" placeholder="Subject for your leave">
			            </div>
			          </div>
			          <div class="form-group row">
			            <label for="reasonn" class="col-sm-3 col-form-label"><?php esc_html_e( 'Reason', 'clockinator-lite' ); ?></label>
			            <div class="col-sm-9">
			              <textarea class="form-control" name="reasonn" id="reasonn" placeholder=""></textarea>
			            </div>
			          </div>
			          <div class="form-group row">
			            <label for="fromm" class="col-sm-3 col-form-label"><?php esc_html_e( 'From', 'clockinator-lite' ); ?></label>
			            <div class="col-sm-9">
			              <div class="input-group date datepicker">
			                <input type="text" class="form-control" name="fromm" id="fromm" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'clockinator-lite' ); ?>">
			                <span class="input-group-addon input-group-append border-left">
			                  <span class="fa fa-calendar input-group-text"></span>
			                </span>
			              </div>
			            </div>
			          </div>
			          <div class="form-group row">
			            <label for="too" class="col-sm-3 col-form-label"><?php esc_html_e( 'To', 'clockinator-lite' ); ?></label>
			            <div class="col-sm-9">
			              <div class="input-group date datepicker">
			                <input type="text" class="form-control" name="too" id="too" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'clockinator-lite' ); ?>">
			                <span class="input-group-addon input-group-append border-left">
			                  <span class="fa fa-calendar input-group-text"></span>
			                </span>
			              </div>
			            </div>
			          </div>
			          <input type="hidden" name="user_id" value="<?php echo esc_attr( get_current_user_id() ); ?>" />
			          <input type="hidden" name="status" value="pending" />
			          <button type="button" id="SaveLeavesBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
			        </form>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- Modal Ends -->

			<!-- Edit Modal starts -->
			<div class="modal fade" id="EditLeaves" tabindex="-1" role="dialog" aria-labelledby="EditLeaves" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="EditLeaves"><?php esc_html_e( 'Submit your leave request', 'clockinator-lite' ); ?></h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <form class="forms-sample" method="post" id="EditLeavesForm">
			          <div class="form-group row">
			            <label for="subject" class="col-sm-3 col-form-label"><?php esc_html_e( 'Subject', 'clockinator-lite' ); ?></label>
			            <div class="col-sm-9">
			              <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject for your leave">
			            </div>
			          </div>
			          <div class="form-group row">
			            <label for="reason" class="col-sm-3 col-form-label"><?php esc_html_e( 'Reason', 'clockinator-lite' ); ?></label>
			            <div class="col-sm-9">
			              <textarea class="form-control" name="reason" id="reason" placeholder=""></textarea>
			            </div>
			          </div>
			          <div class="form-group row">
			            <label for="from" class="col-sm-3 col-form-label"><?php esc_html_e( 'From', 'clockinator-lite' ); ?></label>
			            <div class="col-sm-9">
			              <div class="input-group date datepicker">
			                <input type="text" class="form-control" name="from" id="from" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'clockinator-lite' ); ?>">
			                <span class="input-group-addon input-group-append border-left">
			                  <span class="fa fa-calendar input-group-text"></span>
			                </span>
			              </div>
			            </div>
			          </div>
			          <div class="form-group row">
			            <label for="to" class="col-sm-3 col-form-label"><?php esc_html_e( 'To', 'clockinator-lite' ); ?></label>
			            <div class="col-sm-9">
			              <div class="input-group date datepicker">
			                <input type="text" class="form-control" name="to" id="to" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'clockinator-lite' ); ?>">
			                <span class="input-group-addon input-group-append border-left">
			                  <span class="fa fa-calendar input-group-text"></span>
			                </span>
			              </div>
			            </div>
			          </div>
			          <input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( get_current_user_id() ); ?>">
			          <input type="hidden" name="status" id="status" value="">
			          <input type="hidden" name="id" id="id" value="">
			          <button type="button" id="EditLeaveBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
			        </form>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- Modal Ends -->
        </div>
		<?php
		}

		return ob_get_clean();
	}

	/* Display all holidays */
	public static function btclite_all_holidays( $attr ) {
		ob_start();
		$user_id     = get_current_user_id();
		$user_status = BTCLite_Helper::btclite_check_user_availability();
		if ( $user_status == true ) {
		?>
		<div class="btcl-container">
			<h4 class="card-title"><?php esc_html_e( 'Holidays', 'clockinator-lite' ); ?></h4>
			<div class="row">
			  	<div class="col-lg-12 grid-margin stretch-card">
				  	<div class="card no-shadow">
				    	<div class="card-body">
				      		<div class="mt-4">
				        		<div class="accordion accordion-solid-header" id="holidays-5" role="tablist">
				          			<?php
			                            $all_holidays = BTCLite_Helper::btclite_get_holidays();
			                            foreach ( $all_holidays as $key => $holiday ) {
			                            	if ( $holiday->status == 'active' && ( BTCLite_Helper::btclite_check_year_for_holidays( $holiday->start ) == true || BTCLite_Helper::btclite_check_year_for_holidays( $holiday->end ) == true ) ) {
			                        ?>
				          			<div class="card">
							            <div class="card-header" role="tab" id="holi-heading-<?php echo esc_attr( $key ); ?>">
							              <h6 class="mb-0">
							                <a data-toggle="collapse" href="#holiday-<?php echo esc_attr( $key ); ?>" aria-expanded="false" aria-controls="holiday-<?php echo esc_attr( $key ); ?>" class="collapsed">
							                  <strong><?php echo esc_html_e( ( $key+1 ).'. ', 'clockinator-lite' ); ?></strong><?php esc_html_e( $holiday->name, 'clockinator-lite' ); ?>
							                </a>
							              </h6>
							            </div>
							            <div id="holiday-<?php echo esc_attr( $key ); ?>" class="collapse" role="tabpanel" aria-labelledby="holi-heading-<?php echo esc_attr( $key ); ?>" data-parent="#holidays-5" style="">
							              <div class="card-body">
							                <div class="row">
							                  <div class="col-12">
							                    <?php echo BTCLite_Helper::btclite_front_holiday_html( $holiday->id ); ?>                          
							                  </div>
							                </div>
							              </div>
							            </div>
				          			</div>
				          			<?php } } ?>
				        		</div>
				      		</div>
				    	</div>
				  	</div>
				</div>
			</div>
        </div>
		<?php
		}

		return ob_get_clean();
	}

	/* Upcoming holidays */
	public static function btclite_upcoming_holidays( $attr ) {
		ob_start();
		$user_id     = get_current_user_id();
		$user_status = BTCLite_Helper::btclite_check_user_availability();
		if ( $user_status == true ) {
			$btcl_strings      = get_option( 'btcl_string_translation' );
			$upcoming_holidays = isset( $btcl_strings['upcoming_holidays'] ) ? sanitize_text_field( $btcl_strings['upcoming_holidays'] ) : esc_html__( 'Up coming Holidays' );
		?>
		<div class="btcl-container">
			<div class="card">
		    	<div class="card-body">
		      		<h5 class="card-title"><?php echo esc_html( $upcoming_holidays ); ?></h5>
		      		<div class="mt-4">
		        		<div class="accordion accordion-solid-header" id="upcoming_holidays-5" role="tablist">
		          			<?php echo BTCLite_Helper::btclite_get_upcoming_hoidays(); ?>
		        		</div>
		      		</div>
		    	</div>
		  	</div>
          </div>
		<?php
		}
		return ob_get_clean();
	}

	/* Upcoming holidays */
	public static function btclite_upcoming_events( $attr ) {
		ob_start();
		$user_id     = get_current_user_id();
		$user_status = BTCLite_Helper::btclite_check_user_availability();
		if ( $user_status == true ) {
			$btcl_strings    = get_option( 'btcl_string_translation' );
			$upcoming_events = isset( $btcl_strings['upcoming_events'] ) ? sanitize_text_field( $btcl_strings['upcoming_events'] ) : esc_html__( 'Up coming Events' );
		?>
		<div class="btcl-container">
			<div class="card">
		    	<div class="card-body">
		      		<h5 class="card-title"><?php echo esc_html( $upcoming_events ); ?></h5>
		      		<div class="mt-4">
		        		<div class="accordion accordion-solid-header" id="up-coming-events-5" role="tablist">
		        			<?php echo BTCLite_Helper::btclite_get_upcoming_events(); ?>
		        		</div>
		      		</div>
		    	</div>
		  	</div>
          </div>
		<?php
		}
		return ob_get_clean();
	}

	public static function btclite_shortcode_enqueue_assets() {

		/* Enqueue styles */
		wp_enqueue_style( 'bootstrap', BTCLite_PLUGIN_URL . 'assets/css/bootstrap.min.css' );
		wp_enqueue_style( 'toastr', BTCLite_PLUGIN_URL . 'assets/css/toastr.min.css');
		wp_enqueue_style( 'fontawesome', BTCLite_PLUGIN_URL . 'assets/css/fontawesome/css/all.min.css' );
		wp_enqueue_style( 'dataTables', BTCLite_PLUGIN_URL . 'assets/css/dataTables.bootstrap4.min.css' );
		wp_enqueue_style( 'datetimepicker', BTCLite_PLUGIN_URL . 'assets/css/bootstrap-datetimepicker.min.css' );
		wp_enqueue_style( 'btcl-front-style', BTCLite_PLUGIN_URL . 'public/css/clock-front-style.css' );
        
		/* Enqueue scripts */
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'moment-2.24.0', BTCLite_PLUGIN_URL . 'assets/js/moment.min.js', array( 'jquery' ), true, true );
		wp_enqueue_script( 'bootstrap', BTCLite_PLUGIN_URL . 'assets/js/bootstrap.min.js', array( 'jquery' ), true, true );
		wp_enqueue_script( 'toastr-js', BTCLite_PLUGIN_URL . 'assets/js/toastr.min.js', array( 'jquery' ), true, true );
		wp_enqueue_script( 'jquery.dataTables', BTCLite_PLUGIN_URL . 'assets/js/jquery.dataTables.min.js', array( 'jquery' ), true, true );
		wp_enqueue_script( 'bootstrap-datetimepicker', BTCLite_PLUGIN_URL . 'assets/js/bootstrap-datetimepicker.min.js', array( 'jquery' ), true, true );
		wp_enqueue_script( 'chart-min', BTCLite_PLUGIN_URL . 'assets/js/chart.min.js', array( 'jquery' ), true, true );
        
        /* Staff dash board ajax js */
		wp_enqueue_script( 'btcl-frontend-script', BTCLite_PLUGIN_URL . 'public/js/clock-front-script.js', array( 'jquery' ), true, true );
		wp_localize_script( 'btcl-frontend-script', 'ajax_frontend', 
			array(
				'ajax_url'       => admin_url( 'admin-ajax.php' ),
				'frontend_nonce' => wp_create_nonce( 'front_ajax_nonce' ),
			)
		);
		wp_enqueue_script( 'btcl-front-inline-script', BTCLite_PLUGIN_URL . 'public/js/clock-inline-script.js', array( 'jquery', 'chart-min' ), true, true );
	}
}