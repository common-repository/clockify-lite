<?php
	$months            = BTCLite_Helper::btclite_month_filter();
	$btcl_strings      = get_option( 'btcl_string_translation' );
	$attendance_report = isset( $btcl_strings['attendance_report'] ) ? sanitize_text_field( $btcl_strings['attendance_report'] ) : esc_html__( 'Attendance Report' );
?>
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
           	<div class="col-md-2 tab-view-btn">
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
	</div>
</div>