<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );
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
                <h4 class="card-title"><?php esc_html_e( 'Holidays', 'clockinator-lite' ); ?></h4>
                <button type="button" class="btn btn-primary top-add-btn" data-toggle="modal" data-target="#AddHolidays"><?php esc_html_e( 'Add New', 'clockinator-lite' ); ?></button>
                <!-- Modal starts -->
                <div class="modal fade" id="AddHolidays" tabindex="-1" role="dialog" aria-labelledby="AddHolidays" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="AddHolidays"><?php esc_html_e( 'Add New Holiday', 'clockinator-lite' ); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" method="post" id="HolidayForm">
                          <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Title', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="name" id="name" placeholder="Holiday title">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label"><?php esc_html_e( 'Description', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <textarea class="form-control" name="description" id="description" placeholder=""></textarea>
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
                          <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label"><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <select class="form-control form-control-sm custom-select-height" name="status" id="status">
                                <option value="active"><?php esc_html_e( 'Active', 'clockinator-lite' ); ?></option>
                                <option value="inactive"><?php esc_html_e( 'Inactive', 'clockinator-lite' ); ?></option>
                              </select>
                            </div>
                          </div>
                          <button type="button" id="SaveHolidayBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal Ends -->

                <!-- Edit Modal starts -->
                <div class="modal fade" id="EditHolidays" tabindex="-1" role="dialog" aria-labelledby="EditHolidays" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="EditHolidays"><?php esc_html_e( 'Edit Holiday', 'clockinator-lite' ); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" method="post" id="EditHolidayForm">
                          <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Title', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="name" id="name" placeholder="Holiday title">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label"><?php esc_html_e( 'Description', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <textarea class="form-control" name="description" id="description" placeholder=""></textarea>
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
                          <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label"><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <select class="form-control form-control-sm custom-select-height" name="status" id="status">
                                <option value="active"><?php esc_html_e( 'Active', 'clockinator-lite' ); ?></option>
                                <option value="inactive"><?php esc_html_e( 'Inactive', 'clockinator-lite' ); ?></option>
                              </select>
                            </div>
                          </div>
                          <input type="hidden" name="id" id="id" value="">
                          <button type="button" id="EditHolidayBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal Ends -->
              </br>
              </br>
              </br>
              </br>
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="department-listing" class="table">
                        <thead>
                          <tr>
                              <th><?php esc_html_e( 'S No.', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'Name', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'Date(s)', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'Days', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></th>
                              <th><?php esc_html_e( 'Action', 'clockinator-lite' ); ?></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $all_holidays = BTCLite_Helper::btclite_get_holidays();
                            foreach ( $all_holidays as $key => $holiday ) {
                          ?>
                          <tr>
                              <td><?php echo esc_html( $key+1 ); ?></td>
                              <td><?php esc_html_e( $holiday->name, 'clockinator-lite' ); ?></td>
                              <td><?php echo esc_html( BTCLite_Helper::btclite_get_formated_date( $holiday->start ).' to '.BTCLite_Helper::btclite_get_formated_date( $holiday->end ) ); ?></td>
                              <td><?php echo esc_html( $holiday->days ); ?></td>
                              <td>
                                <?php if ( $holiday->status == 'active' ) {
                                  $class = 'badge-success';
                                } else {
                                  $class = 'badge-danger';
                                } ?>
                                <label class="badge <?php echo esc_attr( $class ); ?> text-white"><?php esc_html_e( $holiday->status, 'clockinator-lite' ); ?></label>
                              </td>
                              <td>
                                <button class="btn btn-outline-primary edit-holiday-details" data-id="<?php echo esc_attr( $holiday->id ); ?>" data-table="<?php echo esc_attr( 'btcl_holidays' ); ?>">
                                  <?php esc_html_e( 'View', 'clockinator-lite' ); ?>
                                </button>
                                <button class="btn btn-outline-danger delete-holiday-details" data-id="<?php echo esc_attr( $holiday->id ); ?>" data-table="<?php echo esc_attr( 'btcl_holidays' ); ?>">
                                  <?php esc_html_e( 'Delete', 'clockinator-lite' ); ?>
                                </button>
                              </td>
                          </tr>
                          <?php } ?>
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