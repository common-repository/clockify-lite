<?php
defined('ABSPATH') or wp_die();

$timezone_list     = BTCLite_Helper::btclite_timezone_list();
$btcl_settings     = get_option( 'btcl_settings' );
$company_name      = isset( $btcl_settings['company_name'] ) ? sanitize_text_field( $btcl_settings['company_name'] ) : '';
$TimeZone          = isset( $btcl_settings['timezone'] ) ? sanitize_text_field( $btcl_settings['timezone'] ) : 'Asia/Kolkata';
$date_format       = isset( $btcl_settings['date_format'] ) ? sanitize_text_field( $btcl_settings['date_format'] ) : 'F j Y';
$time_format       = isset( $btcl_settings['time_format'] ) ? sanitize_text_field( $btcl_settings['time_format'] ) : 'g:i A';
$halfday_start     = isset( $btcl_settings['halfday_start'] ) ? sanitize_text_field( $btcl_settings['halfday_start'] ) : '';
$halfday_end       = isset( $btcl_settings['halfday_end'] ) ? sanitize_text_field( $btcl_settings['halfday_end'] ) : '';
$cur_symbol        = isset( $btcl_settings['cur_symbol'] ) ? sanitize_text_field( $btcl_settings['cur_symbol'] ) : '₹';
$cur_position      = isset( $btcl_settings['cur_position'] ) ? sanitize_text_field( $btcl_settings['cur_position'] ) : 'Right';
$monday_status     = isset( $btcl_settings['monday_status'] ) ? sanitize_text_field( $btcl_settings['monday_status'] ) : 'working';
$tuesday_status    = isset( $btcl_settings['tuesday_status'] ) ? sanitize_text_field( $btcl_settings['tuesday_status'] ) : 'working';
$wednesday_status  = isset( $btcl_settings['wednesday_status'] ) ? sanitize_text_field( $btcl_settings['wednesday_status'] ) : 'working';
$thursday_status   = isset( $btcl_settings['thursday_status'] ) ? sanitize_text_field( $btcl_settings['thursday_status'] ) : 'working';
$friday_status     = isset( $btcl_settings['friday_status'] ) ? sanitize_text_field( $btcl_settings['friday_status'] ) : 'working';
$saturday_status   = isset( $btcl_settings['saturday_status'] ) ? sanitize_text_field( $btcl_settings['saturday_status'] ) : 'working';
$sunday_status     = isset( $btcl_settings['sunday_status'] ) ? sanitize_text_field( $btcl_settings['sunday_status'] ) : 'off';
$salary_method     = isset( $btcl_settings['salary_method'] ) ? sanitize_text_field( $btcl_settings['salary_method'] ) : 'monthly';
$employee_avatar   = isset( $btcl_settings['employee_avatar'] ) ? sanitize_text_field( $btcl_settings['employee_avatar'] ) : 'yes';

$arr = array(
    2066 => array(
        'images_id' => 2066,
        'title' => 'title one',
    ),
    2063 => array(
        'images_id' => 2063,
        'title' => 'title two',
    ),
    2022 => array(
        'images_id' => 2022,
        'title' => 'title three',
    ),
);
?>
<form class="form-sample" id="btcl-save-settings-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
  <?php $nonce = wp_create_nonce('btcl_save_settings'); ?>
  <input type="hidden" name="btcl_setting_options" value="<?php echo esc_attr( $nonce ); ?>">
  <input type="hidden" name="action" value="btcl-settings">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Company Name:', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <input type="text" class="form-control" name="company_name" id="company_name" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $company_name ) ); ?>" />
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'TimeZone:', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <select class="form-control" id="timezone" name="timezone">
            <option value=""><?php esc_html_e( 'Select timezone', 'clockinator-lite'); ?></option>
            <?php foreach ( $timezone_list as $timezone ) { ?>
              <option value="<?php echo esc_attr( $timezone ); ?>" <?php selected( $TimeZone, $timezone ); ?>><?php echo esc_html( $timezone ); ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Date format:', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <select class="form-control" id="date_format" name="date_format">
            <option value="F j Y" <?php selected( $date_format, 'F j Y' ); ?>><?php echo esc_html( date('F j Y' ) . ' ( F j Y ) ' ); ?></option>
            <option value="Y-m-d" <?php selected( $date_format, 'Y-m-d' ); ?>><?php echo esc_html( date('Y-m-d' ) . ' ( YYYY-MM-DD )' ); ?></option>
            <option value="m/d/Y" <?php selected( $date_format, 'm/d/Y' ); ?>><?php echo esc_html( date('m/d/Y' ) . ' ( MM/DD/YYYY )' ); ?></option>
            <option value="d-m-Y" <?php selected( $date_format, 'd-m-Y' ); ?>><?php echo esc_html( date('d-m-Y' ) . ' ( DD-MM-YYYY )' ); ?></option>
            <option value="m-d-Y" <?php selected( $date_format, 'm-d-Y' ); ?>><?php echo esc_html( date('m-d-Y' ) . ' ( MM-DD-YYYY )' ); ?></option>
            <option value="jS F Y" <?php selected( $date_format, 'jS F Y' ); ?>><?php echo esc_html( date('jS F Y' ) . ' ( d M YYYY )' ); ?></option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Time format:', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <select class="form-control" id="time_format" name="time_format">
            <option value="g:i a" <?php selected( $time_format, 'g:i a' ); ?>><?php echo esc_html( date( 'g:i a' ) . ' (  g:i a  )' ); ?></option>
            <option value="g:i A" <?php selected( $time_format, 'g:i A' ); ?>><?php echo esc_html( date( 'g:i A' ) . ' (  g:i A  )' ); ?></option>
            <option value="H:i" <?php selected( $time_format, 'H:i' ); ?>><?php echo esc_html( date( 'H:i' ) . ' (  H:i  )' ); ?></option>
            <option value="H:i:s" <?php selected( $time_format, 'H:i:s' ); ?>><?php echo esc_html( date( 'H:i:s' ) . ' (  H:i:s  )' ); ?></option>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Halfday Start Time', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <div class="input-group time">
            <input class="form-control" id="halfday_start" name="halfday_start" placeholder="HH:MM AM/PM" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $halfday_start ) ); ?>" />
            <span class="input-group-append input-group-addon">
              <span class="input-group-text"><i class="fa fa-clock"></i></span>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Halfday End Time', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <div class="input-group time">
            <input class="form-control" id="halfday_end" name="halfday_end" placeholder="HH:MM AM/PM" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $halfday_end ) ); ?>" />
            <span class="input-group-append input-group-addon">
              <span class="input-group-text"><i class="fa fa-clock"></i></span>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Currency Symbol', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <input type="text" class="form-control" placeholder="$" id="currency_symbol" name="currency_symbol" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $cur_symbol ) ); ?>">
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Currency Position', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <select class="form-control" id="currency_position" name="currency_position">
            <option value="Right" <?php selected( $cur_position, 'Right' ); ?>><?php esc_html_e( 'Right', 'clockinator-lite' ); ?></option>
            <option value="Left" <?php selected( $cur_position, 'Left' ); ?>><?php esc_html_e( 'Left', 'clockinator-lite' ); ?></option>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Show Employee Avatar:', 'clockinator-lite' ); ?></label>
        <div class="col-sm-4">
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="employee_avatar" value="yes" <?php checked( $employee_avatar, 'yes' ); ?>>
              <i class="input-helper"></i>
              <?php esc_html_e( 'Yes', 'clockinator-lite' ); ?>
            </label>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="employee_avatar" value="no" <?php checked( $employee_avatar, 'no' ); ?>>
              <i class="input-helper"></i>
              <?php esc_html_e( 'No', 'clockinator-lite' ); ?>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <h4 class="card-title sub-heading-title"><?php esc_html_e( 'Week days status', 'clockinator-lite' ); ?></h4>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Monday', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <select class="form-control" name="monday_status">
            <option value="working" <?php selected( $monday_status, 'working' ); ?>><?php esc_html_e( 'Working', 'clockinator-lite' ); ?></option>
            <option value="halfday" <?php selected( $monday_status, 'halfday' ); ?>><?php esc_html_e( 'Halfday', 'clockinator-lite' ); ?></option>
            <option value="off" <?php selected( $monday_status, 'off' ); ?>><?php esc_html_e( 'Off', 'clockinator-lite' ); ?></option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Tuesday', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <select class="form-control" name="tuesday_status">
            <option value="working" <?php selected( $tuesday_status, 'working' ); ?>><?php esc_html_e( 'Working', 'clockinator-lite' ); ?></option>
            <option value="halfday" <?php selected( $tuesday_status, 'halfday' ); ?>><?php esc_html_e( 'Halfday', 'clockinator-lite' ); ?></option>
            <option value="off" <?php selected( $tuesday_status, 'off' ); ?>><?php esc_html_e( 'Off', 'clockinator-lite' ); ?></option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Wednesday', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <select class="form-control" name="wednesday_status">
            <option value="working" <?php selected( $wednesday_status, 'working' ); ?>><?php esc_html_e( 'Working', 'clockinator-lite' ); ?></option>
            <option value="halfday" <?php selected( $wednesday_status, 'halfday' ); ?>><?php esc_html_e( 'Halfday', 'clockinator-lite' ); ?></option>
            <option value="off" <?php selected( $wednesday_status, 'off' ); ?>><?php esc_html_e( 'Off', 'clockinator-lite' ); ?></option>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Thursday', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <select class="form-control" name="thursday_status">
            <option value="working" <?php selected( $thursday_status, 'working' ); ?>><?php esc_html_e( 'Working', 'clockinator-lite' ); ?></option>
            <option value="halfday" <?php selected( $thursday_status, 'halfday' ); ?>><?php esc_html_e( 'Halfday', 'clockinator-lite' ); ?></option>
            <option value="off" <?php selected( $thursday_status, 'off' ); ?>><?php esc_html_e( 'Off', 'clockinator-lite' ); ?></option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Friday', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <select class="form-control" name="friday_status">
            <option value="working" <?php selected( $friday_status, 'working' ); ?>><?php esc_html_e( 'Working', 'clockinator-lite' ); ?></option>
            <option value="halfday" <?php selected( $friday_status, 'halfday' ); ?>><?php esc_html_e( 'Halfday', 'clockinator-lite' ); ?></option>
            <option value="off" <?php selected( $friday_status, 'off' ); ?>><?php esc_html_e( 'Off', 'clockinator-lite' ); ?></option>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Saturday', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <select class="form-control" name="saturday_status">
            <option value="working" <?php selected( $saturday_status, 'working' ); ?>><?php esc_html_e( 'Working', 'clockinator-lite' ); ?></option>
            <option value="halfday" <?php selected( $saturday_status, 'halfday' ); ?>><?php esc_html_e( 'Halfday', 'clockinator-lite' ); ?></option>
            <option value="off" <?php selected( $saturday_status, 'off' ); ?>><?php esc_html_e( 'Off', 'clockinator-lite' ); ?></option>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label"><?php esc_html_e( 'Sunday', 'clockinator-lite' ); ?></label>
        <div class="col-sm-8">
          <select class="form-control" name="sunday_status">
            <option value="working" <?php selected( $sunday_status, 'working' ); ?>><?php esc_html_e( 'Working', 'clockinator-lite' ); ?></option>
            <option value="halfday" <?php selected( $sunday_status, 'halfday' ); ?>><?php esc_html_e( 'Halfday', 'clockinator-lite' ); ?></option>
            <option value="off" <?php selected( $sunday_status, 'off' ); ?>><?php esc_html_e( 'Off', 'clockinator-lite' ); ?></option>
          </select>
        </div>
      </div>
    </div>
  </div>
  <button type="submit" class="btn btn-primary bg-gradient-primary btcl-gradient-btn mr-2" id="btcl-save-settings"><?php esc_html_e( 'Save', 'clockinator-lite' ); ?></button>
</form>