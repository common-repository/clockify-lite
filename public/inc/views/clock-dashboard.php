<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );

$btcl_settings     = get_option( 'btcl_settings' );
$avtar_check       = isset( $btcl_settings['employee_avatar'] ) ? sanitize_text_field( $btcl_settings['employee_avatar'] ) : 'yes';
$btcl_strings      = get_option( 'btcl_string_translation' );
$upcoming_holidays = isset( $btcl_strings['upcoming_holidays'] ) ? sanitize_text_field( $btcl_strings['upcoming_holidays'] ) : esc_html__( 'Up coming Holidays' );
$upcoming_events   = isset( $btcl_strings['upcoming_events'] ) ? sanitize_text_field( $btcl_strings['upcoming_events'] ) : esc_html__( 'Up coming Events' );

/* Fetching Location Post(Shortcode) Id */
extract( shortcode_atts( array( ), $attr ) );

$user_id     = get_current_user_id();
$user_status = BTCLite_Helper::btclite_check_user_availability();
if ( $user_status == true ) {

	$action = '';
	if ( isset( $_GET['action'] ) ) {
	    $action = sanitize_text_field( $_GET['action'] );
	}
?>
<main>
	<?php if (!wp_is_mobile()) { ?>
	<div class="container btcl-container">
	<?php } else { ?>
	<div class="container-fluid btcl-container">
	<?php } ?>
		<div class="row">
			<div class="col-sm-3 profile-left">
				<div class="left-inner-wrapp">
	    			<div class="btcl-user-area btcl-clearfix">
						<?php if ( $avtar_check == 'yes' ) { ?>
						<div class="btcl-user-img">
							<img class="profile_img" src="<?php echo esc_attr( esc_url( BTCLite_Helper::btclite_get_employees_pic( $user_id ) ) ); ?>" alt="Viollet D'Amore">
						</div>
						<?php } ?>
						<div class="btcl-user-name-area">
							<h5 class="btcl-user">
								<?php echo esc_html( BTCLite_Helper::btclite_get_current_user_data( $user_id, 'first_name' ).' '.BTCLite_Helper::btclite_get_current_user_data( $user_id, 'last_name' ) ); ?>
							</h5>
						</div>
					</div>
					<div class="list-group">
						<a href="#dashboard" class="list-group-item list-group-item-action <?php if ( empty ( $action ) ) { echo esc_attr( 'active' ); } ?>" data-toggle="list">
							<i class="fa fa-home"></i><?php esc_html_e( 'Dashboard', 'clockinator-lite' ); ?>
						</a>
						<a href="#targets" class="list-group-item list-group-item-action <?php if ( ! empty ( $action ) && ( $action == 'tar_view' ) ) { echo esc_attr( 'active' ); } ?>" data-toggle="list"><i class="fas fa-tags"></i><?php esc_html_e( 'Targets', 'clockinator-lite' ); ?></a>
						<a href="#leaves" class="list-group-item list-group-item-action " data-toggle="list"><i class="fas fa-briefcase-medical"></i><?php esc_html_e( 'Leaves', 'clockinator-lite' ); ?></a>
						<a href="#holidays" class="list-group-item list-group-item-action " data-toggle="list"><i class="fas fa-snowman"></i><?php esc_html_e( 'Holidays', 'clockinator-lite' ); ?></a>
						<a href="#reports" class="list-group-item list-group-item-action " data-toggle="list"><i class="fas fa-chart-pie"></i><?php esc_html_e( 'Reports', 'clockinator-lite' ); ?></a>
						<a href="#profile" class="list-group-item list-group-item-action " data-toggle="list"><i class="fas fa-user-alt"></i><?php esc_html_e( 'Profile', 'clockinator-lite' ); ?></a>
						<a href="<?php echo wp_logout_url( get_permalink() ); ?>" class="list-group-item list-group-item-action"><i class="fas fa-sign-out-alt"></i><?php esc_html_e( 'Logout', 'clockinator-lite' ); ?></a>
					</div><!-- /list-group -->
				</div>
			</div><!-- /col -->
			<div class="col-sm-9 btcl-right-side-content">
				<div class="tab-content">
					<div id="dashboard" class="tab-pane fade show <?php if ( empty ( $action ) ) { echo esc_attr( 'active show' ); } ?>">
						<div class="dash-item btcl-column btcl-column-1">
							<div class="welcome-wrap">
								<h1 class="btcl-hello">
									<?php echo esc_html__( 'Hello, ', 'clockify-lite' ).''.esc_html( BTCLite_Helper::btclite_get_current_user_data( $user_id, 'first_name' ) ); ?>
								</h1>
								<span><?php esc_html_e( 'Welcome Back', 'clockify-lite' ); ?></span>
								<div class="img-account-hello"></div>
							</div>
						</div>
						<div class="row highlight-cards">
	          	<div class="col-md-6 col-lg-4 grid-margin stretch-card">
		            <div class="card bg-gradient-success card-holder text-center card-shadow-danger">
		              	<div class="card-body">
		                	<h6 class="font-weight-normal text-white"><?php esc_html_e( 'Last day working hours', 'clockify-lite' ); ?></h6>
		                	<h2 class="mb-0 text-white">
												<?php echo esc_html( BTCLite_Helper::btclite_last_day_working_hours() ); ?>
											</h2>
		              	</div>
		            </div>
	          	</div>
	          	<div class="col-md-6 col-lg-4 grid-margin stretch-card">
		            <div class="card bg-gradient-info card-holder text-center card-shadow-info">
		              	<div class="card-body">
		                	<h6 class="font-weight-normal text-white"><?php esc_html_e( 'Total Attendance', 'clockify-lite' ); ?></h6>
		                	<h2 class="mb-0 text-white">
											<?php
												$user_id        = get_current_user_id();
												$total_presents = BTCLite_Helper::btclite_total_absents( $user_id, '1' );;
												$total_presents = sizeof( $total_presents['attend'] );
												echo esc_html( $total_presents );
											?>
											</h2>
		              	</div>
		            </div>
	          	</div>
	          	<div class="col-md-6 col-lg-4 grid-margin stretch-card">
		            <div class="card bg-gradient-danger card-holder text-center card-shadow-danger">
		              	<div class="card-body">
		                	<h6 class="font-weight-normal text-white"><?php esc_html_e( 'Total Absents', 'clockify-lite' ); ?></h6>
		                	<h2 class="mb-0 text-white">
											<?php
												$user_id        = get_current_user_id();
												$total_absents  = BTCLite_Helper::btclite_total_absents( $user_id, '1' );
												$total_absents  = sizeof( $total_absents['dates1'] );
												echo esc_html( $total_absents );
											?>
											</h2>
		              	</div>
		            </div>
	          	</div>
				    </div>
		        <hr>
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
		        <hr>
		        <div class="detail-panel extra-data-panel">
					  	<div class="content-wrapper">
					    	<div class="row">
					      		<div class="col-lg-6 grid-margin stretch-card dashboard-holiday-box">
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
								<div class="col-lg-6 grid-margin stretch-card dashboard-event-box">
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
					    	</div>
					  	</div>
						</div>
						<div class="detail-panel extra-data-panel">
					  	<div class="content-wrapper">
					    	<div class="row">
								<?php $birthday_data = BTCLite_Helper::btclite_get_birthday_name();
									if ( ! empty ( $birthday_data ) ) {
										$names = implode( ", ", $birthday_data );
								?>
								<div class="col-lg-6 grid-margin stretch-card dashboard-forth-box birthday-alert-box">
							  	<div class="card">
							    	<div class="card-body">
										<h3 class="card-title text-white">Today is <br> <?php echo esc_html( $names ).'\'s'; ?> <br> Birthday</h3>
							    	</div>
							  	</div>
								</div>
								<?php } ?>
					    	</div>
					  	</div>
						</div>
						<hr>
					</div><!-- /tab-pane -->
					<div id="targets" class="tab-pane fade <?php if ( ! empty ( $action ) && ( $action == 'tar_view' ) ) { echo esc_attr( 'active show' ); } ?>">
						<?php require_once( BTCLite_PLUGIN_DIR_PATH . 'public/inc/views/clock-targets.php' ) ?>
					</div><!-- /tab-pane -->
					<div id="reports" class="tab-pane fade">
						<?php require_once( BTCLite_PLUGIN_DIR_PATH . 'public/inc/views/clock-reports.php' ) ?>
					</div><!-- /tab-pane -->
					<div id="leaves" class="tab-pane fade">
						<?php require_once( BTCLite_PLUGIN_DIR_PATH . 'public/inc/views/clock-leaves.php' ) ?>
					</div><!-- /tab-pane -->
					<div id="holidays" class="tab-pane fade">
						<?php require_once( BTCLite_PLUGIN_DIR_PATH . 'public/inc/views/clock-holiday.php' ) ?>
					</div><!-- /tab-pane -->
					<div id="profile" class="tab-pane fade">
						<?php require_once( BTCLite_PLUGIN_DIR_PATH . 'public/inc/views/clock-profile.php' ) ?>
					</div><!-- /tab-pane -->
				</div><!-- /tab-content -->
			</div><!-- /col -->
		</div><!-- /row -->

		<!-- Modal starts -->
    <div class="modal fade" id="AddWorkReport" tabindex="-1" role="dialog" aria-labelledby="AddWorkReport" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="AddWorkReport"><?php esc_html_e( 'Submit Your Session Work Report', 'clockify-lite' ); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="forms-sample" method="post" id="WorkReportForm">
              <div class="form-group row">
                <div class="col-sm-12">
                	<textarea class="form-control" name="work_report" rows="8" id="work_report" placeholder="<?php esc_html_e( 'Report content goes here......', 'clockify-lite' ); ?>" required></textarea>
                </div>
              </div>
              <input type="hidden" name="row_id" id="row_id" value="">
              <input type="hidden" name="user_id" id="user_id" value="">
              <button type="button" id="SaveWorkReportBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockify-lite' ); ?></button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Ends -->

	</div><!-- /container -->
</main>
<?php } else {
	if ( ! is_user_logged_in() ) {
	?>
		<div class="container-space container btcl-form-container">
			<div class="row justify-content-center">
				<div class="col-md-4">
					<h4><?php esc_html_e( 'You need to login first.', 'clockinator-lite' ); ?></h4>
					<!-- form card login -->
          <div class="card card-outline-secondary">
            <div class="card-header">
              <h3 class="mb-0">Login</h3>
            </div>
            <div class="card-body">
							<?php
								$form_args = array(
									'echo'           => true,
									'redirect'       => get_permalink( get_the_ID() ),
									'remember'       => true,
									'value_remember' => true,
									'label_username' => '',
									'label_password' => '',
								);
								wp_login_form( $form_args );
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="container-space container btcl-error-container"> 
			<div class="row">
				<h4 class="text-center"><?php esc_html_e( 'You are not registored in Clockify system. So you can not access this page.', 'clockinator-lite' ); ?></h4>
			</div>
		</div>
		<?php
	}
}