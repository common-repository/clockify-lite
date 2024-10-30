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
                <h4 class="card-title"><?php esc_html_e( 'Leave Requests', 'clockinator-lite' ); ?></h4>
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
                          <input type="hidden" name="user_id" id="user_id" value="">
                          <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label"><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <select class="form-control form-control-sm custom-select-height" name="status" id="status">
                                <option value="pending"><?php esc_html_e( 'Pending', 'clockinator-lite' ); ?></option>
                                <option value="approved"><?php esc_html_e( 'Approved', 'clockinator-lite' ); ?></option>
                                <option value="cancelled"><?php esc_html_e( 'Cancelled', 'clockinator-lite' ); ?></option>
                              </select>
                            </div>
                          </div>
                          <input type="hidden" name="id" id="id" value="">
                          <button type="button" id="EditLeaveBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
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
                            <th><?php esc_html_e( 'S No. #', 'clockinator-lite' ); ?></th>
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
                        ?>
                          <tr>
                            <td><?php echo esc_html( $key+1 ); ?></td>
                            <td><?php esc_html_e( $leave->name, 'clockinator-lite' ); ?></td>
                            <td><?php echo esc_html( BTCLite_Helper::btclite_get_formated_date( $leave->start ).' to '.BTCLite_Helper::btclite_get_formated_date( $leave->end ) ); ?></td>
                            <td><?php esc_html_e( $leave->description, 'clockinator-lite' ); ?></td>
                            <td>
                                <?php if ( $leave->status == 'approved' ) {
                                    $class = 'badge-success';
                                } elseif ( $leave->status == 'cancelled' ) {
                                    $class = 'badge-danger';
                                } else {
                                  $class = 'badge-warning';
                                } ?>
                                <label class="badge <?php echo esc_attr( $class ); ?> text-white"><?php esc_html_e( $leave->status, 'clockinator-lite' ); ?></label>
                            </td>
                            <td>
                                <button class="btn btn-outline-primary edit-leave-details" data-id="<?php echo esc_attr( $leave->id ); ?>" data-table="<?php echo esc_attr( 'btcl_leaves' ); ?>">
                                  <?php esc_html_e( 'View', 'clockinator-lite' ); ?>
                                </button>
                                <button class="btn btn-outline-danger delete-entries" data-id="<?php echo esc_attr( $leave->id ); ?>" data-table="<?php echo esc_attr( 'btcl_leaves' ); ?>">
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