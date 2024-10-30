<?php
defined( 'ABSPATH' ) or wp_die();
global $wpdb;
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );
$row_id     = sanitize_text_field( $_GET['row_id'] );
$target     = BTCLite_Helper::btclite_target_info( $row_id );
$labels     = '';
$t_data     = '';

if ( isset( $target->feedback ) && ! empty( $target->feedback ) ) {
	$feedback = unserialize( $target->feedback );
	foreach ( $feedback as $fkey => $fvalue ) {
		$labels .= "'".$fvalue['date']."', ";
		$t_data .= $fvalue['target'].", ";
	}
} else {
	$feedback = '';
}

$emp_id     = $target->user_id;
$table_name = $wpdb->base_prefix . "btcl_employees";
$employe    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE user_id = %d", $emp_id ) );
if ( $target->status == 'Initiated' ) {
	$s_class = 'label-light-primary';
} else {
	$s_class = 'label-light-success';
}
?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
      	<div class="content-wrapper">
      		<div class="row">
		        <div class="col-12 grid-margin">
		            <div class="card">
		              	<div class="card-body">
		              		<h4 class="card-title"><?php esc_html_e( 'Target details', 'clockinator-lite' ); ?></h4>
		              		</br>
		              		</br>
		              		<div class="d-flex">
								<!--begin: Info-->
								<div class="flex-grow-1">
									<div class="subtask-inner-details">  
		                                <strong><?php esc_html_e( 'Target:', 'clockinator-lite' ); ?></strong>
		                                <span id="ms_deadline_72-1">
		                                    <span class="label label-light-info label-inline font-weight-bolder label-lg mr-2"><?php echo esc_html( $target->title ); ?></span>
		                                </span> |
		                                <strong><?php esc_html_e( 'Employee:', 'clockinator-lite' ); ?></strong>
		                                <span id="ms_deadline_72-1">
		                                    <span class="label label-light-primary label-inline font-weight-bolder label-lg mr-2"><?php echo esc_html( $employe->name ); ?></span>
		                                </span> |
		                                <strong><?php esc_html_e( 'Time period:', 'clockinator-lite' ); ?></strong>
		                                <span id="ms_deadline_72-1">
		                                    <span class="label label-light-primary label-inline font-weight-bolder label-lg mr-2">
		                                    	<?php echo esc_html( BTCLite_Helper::btclite_get_formated_date( $target->fromm ).' to '.BTCLite_Helper::btclite_get_formated_date( $target->too ) ); ?>
		                                    </span>
		                                </span> |
		                                <strong><?php esc_html_e( 'Status:', 'clockinator-lite' ); ?></strong>
		                                <span id="ms_deadline_72-1">
		                                    <span class="label <?php echo esc_attr( $s_class ); ?> label-inline font-weight-bolder label-lg mr-2">
		                                    	<?php echo esc_html( $target->status ); ?>
		                                    </span>
		                                </span>
		                            </div>
								</div>
							</div>
		              	</div>
		            </div>
		        </div>
	        </div>
	        <div class="row">
	        	<div class="col-4 grid-margin">
	        		<div class="card bg-default">
					    <div class="card-body">
					    	<h4 class="card-title"><?php esc_html_e( 'Target progress status', 'clockinator-lite' ); ?></h4>
					    	</br></br></br>
					    	<div class="svg-item">
							  <svg width="100%" height="100%" viewBox="0 0 40 40" class="donut">
							    <circle class="donut-hole" cx="20" cy="20" r="15.91549430918954" fill="#fff"></circle>
							    <circle class="donut-ring" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="3.5"></circle>
							    <circle class="donut-segment donut-segment-2" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="3.5" stroke-dasharray="<?php echo esc_html( BTCLite_Helper::btclite_get_target_percentage( $row_id ) ); ?> <?php echo esc_attr( ( 100 - BTCLite_Helper::btclite_get_target_percentage( $row_id ) ) ); ?>" stroke-dashoffset="25"></circle>
							    <g class="donut-text donut-text-1">

							      <text y="50%" transform="translate(0, 2)">
							        <tspan x="50%" text-anchor="middle" class="donut-percent"><?php echo esc_html( BTCLite_Helper::btclite_get_target_percentage( $row_id ) ); ?>%</tspan>   
							      </text>
							      <text y="60%" transform="translate(0, 2)">
							        <tspan x="50%" text-anchor="middle" class="donut-data">
							        	<?php 
							        		echo esc_html( ( 100 - BTCLite_Helper::btclite_get_target_percentage( $row_id ) ).'% Remaning' );
							        	?>
							        </tspan>   
							      </text>
							    </g>
							  </svg>
							</div>
					    </div>
					</div>
	        	</div>
	        	<div class="col-8 grid-margin">
	        		<div class="card bg-default">
					    <div class="card-body">
					    	<h4 class="card-title"><?php esc_html_e( 'Insert target records', 'clockinator-lite' ); ?></h4>
		              		</br></br></br></br></br></br>
		              		<form class="form fv-plugins-bootstrap fv-plugins-framework" id="AddTargetRecordsForm" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
                                <?php $nonce = wp_create_nonce( 'btcl_add_trecords' ); ?>
                                <input type="hidden" name="btcl_add_trecords_nounce" value="<?php echo esc_attr( $nonce ); ?>">
                                <input type="hidden" name="action" value="btcl_add_trecords">
                                <div class="row">
                                	<div class="col-12">
                                    	<div class="form-group row fv-plugins-icon-container">
	                                    	<label class="col-xl-2 col-lg-2 col-form-label"><?php esc_html_e( 'Select Date', 'clockinator-lite' ); ?></label>
	                                    	<div class="col-lg-9 col-xl-9">
	                                    		<div class="input-group date datepicker">
									                <input type="text" class="form-control" name="date" id="date" placeholder="<?php esc_html_e( 'MM-DD-YYYY', 'clockinator-lite' ); ?>">
									                <span class="input-group-addon input-group-append border-left">
									                  <span class="fa fa-calendar input-group-text"></span>
									                </span>
								              	</div>
	                                    	</div>
	                                    </div>
                                    </div>
                                    <div class="col-12">
                                		<div class="form-group row fv-plugins-icon-container">
                                			<label class="col-xl-2 col-lg-2 col-form-label"><?php esc_html_e( 'Reached Target Value', 'clockinator-lite' ); ?></label>
                                			<div class="col-lg-9 col-xl-9">
                                                <input class="form-control form-control-solid form-control-lg" name="target" type="number" placeholder="<?php esc_attr_e( 'Enter just target value Like:- 20', 'clockinator-lite' ); ?>">
                                            </div>
                                		</div>
                                	</div>
                                	<input type="hidden" name="id" value="<?php echo esc_attr( $row_id ); ?>">
                                	<div class="row">
	                                	<div class="col-12">
	                                		<button type="submit" id="AddTargetRecordsBtn" class="btn btn-primary mr-2">
	                                			<?php esc_html_e( 'Submit', 'clockinator-lite' ); ?>
	                                		</button>
	                                	</div>
	                                </div>
                                </div>
                            </form>
					    </div>
					</div>
	        	</div>
	        	<div class="col-12 grid-margin">
	        		<div class="card bg-default">
					    <div class="card-body">
					    	<h4 class="card-title"><?php esc_html_e( 'Target records graph', 'clockinator-lite' ); ?></h4>
					    	</br></br>
					        <div class="chart">
					            <!-- Chart wrapper -->
					            <canvas id="myChart" width="400" height="150"></canvas>
					            <?php
					            	$inline_js = "  var ctx     = document.getElementById('myChart');
													var myChart = new Chart(ctx, {
													    type: 'line',
													    data: {
													        labels: [".$labels."],
													        datasets: [{
													            label: '# of Target Achived',
													            data: [".$t_data."],
													            backgroundColor: [
													                'rgba(255, 99, 132, 0.2)',
													                'rgba(54, 162, 235, 0.2)',
													                'rgba(255, 206, 86, 0.2)',
													                'rgba(75, 192, 192, 0.2)',
													                'rgba(153, 102, 255, 0.2)',
													                'rgba(255, 159, 64, 0.2)'
													            ],
													            borderColor: [
													                'rgba(255, 99, 132, 1)',
													                'rgba(54, 162, 235, 1)',
													                'rgba(255, 206, 86, 1)',
													                'rgba(75, 192, 192, 1)',
													                'rgba(153, 102, 255, 1)',
													                'rgba(255, 159, 64, 1)'
													            ],
													            borderWidth: 1
													        }]
													    },
													    options: {
													        scales: {
													            y: {
													                beginAtZero: true
													            }
													        }
													    }
													});";
									wp_add_inline_script( 'btcl-inline-script', $inline_js );
					            ?>
					        </div>
					    </div>
					</div>
	        	</div>
	        </div>
	    </div>
	</div>
</div>