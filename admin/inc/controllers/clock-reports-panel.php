<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );
$months = BTCLite_Helper::btclite_month_filter();
?>
<div class="container-scroller">
  <?php require_once BTCLite_PLUGIN_DIR_PATH . '/admin/inc/views/nav/nav.php';  ?>

  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title"><?php esc_html_e( 'Reports', 'clockinator-lite' ); ?></h4>

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

                <div class="report-form-div">
                  <form id="staff-reports-form" method="post">
                    <div class="row">
                      <div class="col-md-4">
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
                      <div class="col-md-3">
                        <select class="form-control form-control-sm custom-select-height" name="status" id="status">
                          <option value="all"><?php esc_html_e( 'All days', 'clockinator-lite' ); ?></option>
                          <option value="absent"><?php esc_html_e( 'Only Absent Days', 'clockinator-lite' ); ?></option>
                          <option value="present"><?php esc_html_e( 'Only Attend days', 'clockinator-lite' ); ?></option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <select class="form-control form-control-sm custom-select-height" name="user_id" id="user_id">
                          <?php
                            $employer_list = BTCLite_Helper::btclite_get_employees();
                            foreach ( $employer_list as $key => $employer ) {
                          ?>
                          <option value="<?php echo esc_attr( $employer->user_id ); ?>"><?php echo esc_html( $employer->name );  ?></option>
                        <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <button type="button" id="GenerateReportsBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
                      </div>
                    </div>
                  </form>
                </div>
              </br>
              </br>
              </br>
              </br>
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="report-listing" class="table table-striped">
                        <thead>
                          <tr>
                              <th><?php esc_html_e( 'Date', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'Day', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'Clock In', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'Clock Out', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'Working Hours', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'IP Address', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'Location', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'Actions', 'clockinator-lite' ); ?></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Fetch clock in & clock out detail -->
<div class="modal fade" id="FetchReports" tabindex="-1" role="dialog" aria-labelledby="FetchReports" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="FetchReports"><?php esc_html_e( 'Clock in & Clock out details ( Default TimeZone is '.BTCLite_Helper::btclite_get_setting_timezone().' )', 'clockinator' ); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="post" id="FetchReportsForm">
          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Clock In', 'clockinator' ); ?></label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="edit_clock_in" id="edit_clock_in" placeholder="<?php esc_html_e( '10:00 AM', 'clockinator' ); ?>">
            </div>
            <div class="col-sm-4">
              <input type="date" class="form-control" name="edit_datein" id="edit_datein" placeholder="<?php esc_html_e( 'DD-MM-YYYY', 'clockinator' ); ?>">
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Clock Out', 'clockinator' ); ?></label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="edit_clock_out" id="edit_clock_out" placeholder="<?php esc_html_e( '07:00 PM', 'clockinator' ); ?>">
            </div>
            <div class="col-sm-4">
              <input type="date" class="form-control" name="edit_dateout" id="edit_dateout" placeholder="<?php esc_html_e( 'DD-MM-YYYY', 'clockinator' ); ?>">
            </div>
          </div>
          <input type="hidden" name="report_id" id="report_id">
          <button type="button" id="FetchReportsBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator' ); ?></button>
        </form>
      </div>
    </div>
  </div>
</div>