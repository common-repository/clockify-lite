<?php
defined('ABSPATH') or wp_die();
$btcl_strings      = get_option( 'btcl_string_translation' );
$clock_in          = isset( $btcl_strings['clock_in'] ) ? sanitize_text_field( $btcl_strings['clock_in'] ) : esc_html__( 'Clock In' );
$clock_out         = isset( $btcl_strings['clock_out'] ) ? sanitize_text_field( $btcl_strings['clock_out'] ) : esc_html__( 'Clock Out' );
$break_in          = isset( $btcl_strings['break_in'] ) ? sanitize_text_field( $btcl_strings['break_in'] ) : esc_html__( 'Break In' );
$break_out         = isset( $btcl_strings['break_out'] ) ? sanitize_text_field( $btcl_strings['break_out'] ) : esc_html__( 'Break Out' );
$session_report    = isset( $btcl_strings['session_report'] ) ? sanitize_text_field( $btcl_strings['session_report'] ) : esc_html__( 'Submit Session Report' );
$upcoming_holidays = isset( $btcl_strings['upcoming_holidays'] ) ? sanitize_text_field( $btcl_strings['upcoming_holidays'] ) : esc_html__( 'Up coming Holidays' );
$upcoming_events   = isset( $btcl_strings['upcoming_events'] ) ? sanitize_text_field( $btcl_strings['upcoming_events'] ) : esc_html__( 'Up coming Events' );
$attendance_report = isset( $btcl_strings['attendance_report'] ) ? sanitize_text_field( $btcl_strings['attendance_report'] ) : esc_html__( 'Attendance Report' );
$leave_requests    = isset( $btcl_strings['leave_requests'] ) ? sanitize_text_field( $btcl_strings['leave_requests'] ) : esc_html__( 'Leave requests' );
$your_profile      = isset( $btcl_strings['your_profile'] ) ? sanitize_text_field( $btcl_strings['your_profile'] ) : esc_html__( 'Your profile' );
?>
<h4 class="card-title sub-heading-title"><?php esc_html_e( 'Strings', 'clockinator-lite' ); ?></h4>
<form class="form-sample" id="btcl-strings-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
    <?php $nonce = wp_create_nonce('btcl_save_template_options'); ?>
    <input type="hidden" name="btcl_strings_options" value="<?php echo esc_attr( $nonce ); ?>">
    <input type="hidden" name="action" value="btcl-strings-options">
    <div class="row">
    	<div class="col-lg-12 col-md-12">
    		<div class="form-group row">
                <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Clock In', 'clockinator-lite' ); ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="clock_in" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $clock_in ) ); ?>">
                </div>
            </div>
    	</div>
    	<div class="col-lg-12 col-md-12">
    		<div class="form-group row">
                <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Clock Out', 'clockinator-lite' ); ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="clock_out" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $clock_out ) ); ?>">
                </div>
            </div>
    	</div>
    	<div class="col-lg-12 col-md-12">
    		<div class="form-group row">
                <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Break In', 'clockinator-lite' ); ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="break_in" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $break_in ) ); ?>">
                </div>
            </div>
    	</div>
    	<div class="col-lg-12 col-md-12">
    		<div class="form-group row">
                <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Break Out', 'clockinator-lite' ); ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="break_out" name="break_out" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $break_out ) ); ?>">
                </div>
            </div>
    	</div>
        <div class="col-lg-12 col-md-12">
    		<div class="form-group row">
                <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Submit Session Report', 'clockinator-lite' ); ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="session_report" name="session_report" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $session_report ) ); ?>">
                </div>
            </div>
    	</div>
    	<div class="col-lg-12 col-md-12">
    		<div class="form-group row">
                <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Up-coming Holidays', 'clockinator-lite' ); ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="upcoming_holidays" name="upcoming_holidays" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $upcoming_holidays ) ); ?>">
                </div>
            </div>
    	</div>
    	<div class="col-lg-12 col-md-12">
    		<div class="form-group row">
                <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Up-coming Events', 'clockinator-lite' ); ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="upcoming_events" name="upcoming_events" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $upcoming_events ) ); ?>">
                </div>
            </div>
    	</div>
    	<div class="col-lg-12 col-md-12">
    		<div class="form-group row">
                <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Attendance Report', 'clockinator-lite' ); ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="attendance_report" name="attendance_report" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $attendance_report ) ); ?>">
                </div>
            </div>
    	</div>
    	<div class="col-lg-12 col-md-12">
    		<div class="form-group row">
                <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Leave requests', 'clockinator-lite' ); ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="leave_requests" name="leave_requests" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $leave_requests ) ); ?>">
                </div>
            </div>
    	</div>
    	<div class="col-lg-12 col-md-12">
    		<div class="form-group row">
                <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Your profile', 'clockinator-lite' ); ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="your_profile" name="your_profile" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $your_profile ) ); ?>">
                </div>
            </div>
    	</div>
    </div>
    <button type="submit" class="btn btn-primary bg-gradient-primary btcl-gradient-btn mr-2" id="btcl-save-strings"><?php esc_html_e( 'Save', 'clockinator-lite' ); ?></button>
</form>