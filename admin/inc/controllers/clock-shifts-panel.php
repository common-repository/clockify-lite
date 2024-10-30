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
                				<h4 class="card-title"><?php esc_html_e( 'Shifts', 'clockinator-lite' ); ?></h4>
                				<button type="button" class="btn btn-primary top-add-btn" data-toggle="modal" data-target="#AddNewShift"><?php esc_html_e( 'Add New', 'clockinator-lite' ); ?></button>

                				<!-- Modal starts -->
				                <div class="modal fade" id="AddNewShift" tabindex="-1" role="dialog" aria-labelledby="AddNewShift" aria-hidden="true">
				                  <div class="modal-dialog" role="document">
				                    <div class="modal-content">
				                      <div class="modal-header">
				                        <h5 class="modal-title" id="AddNewShift"><?php esc_html_e( 'Add New Shift', 'clockinator-lite' ); ?></h5>
				                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                          <span aria-hidden="true">&times;</span>
				                        </button>
				                      </div>
				                      <div class="modal-body">
				                        <form class="forms-sample" method="post" id="ShiftForm">
				                          <div class="form-group row">
				                            <label for="shift_name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Name', 'clockinator-lite' ); ?></label>
				                            <div class="col-sm-9">
				                              <input type="text" class="form-control" name="shift_name" id="shift_name" placeholder="<?php esc_html_e( 'Shift Name', 'clockinator-lite' ); ?>">
				                            </div>
				                          </div>
				                          <div class="form-group row">
				                            <label for="shift_start" class="col-sm-3 col-form-label"><?php esc_html_e( 'Start Time', 'clockinator-lite' ); ?></label>
				                            <div class="col-sm-9">
				                              <div class="input-group time">
				                                <input class="form-control" id="shift_start" name="shift_start" placeholder="<?php esc_html_e( 'HH:MM AM/PM', 'clockinator-lite' ); ?>"/>
				                                <span class="input-group-append input-group-addon">
				                                  <span class="input-group-text"><i class="fa fa-clock"></i></span>
				                                </span>
				                              </div>
				                            </div>
				                          </div>
				                          <div class="form-group row">
				                            <label for="shift_end" class="col-sm-3 col-form-label"><?php esc_html_e( 'End Time', 'clockinator-lite' ); ?></label>
				                            <div class="col-sm-9">
				                              <div class="input-group time">
				                                <input class="form-control" id="shift_end" name="shift_end" placeholder="<?php esc_html_e( 'HH:MM AM/PM', 'clockinator-lite' ); ?>"/>
				                                <span class="input-group-append input-group-addon">
				                                  <span class="input-group-text"><i class="fa fa-clock"></i></span>
				                                </span>
				                              </div>
				                            </div>
				                          </div>
				                          <div class="form-group row">
				                            <label for="late_time" class="col-sm-3 col-form-label"><?php esc_html_e( 'Late Time', 'clockinator-lite' ); ?></label>
				                            <div class="col-sm-9">
				                              <div class="input-group time">
				                                <input class="form-control" id="late_time" name="late_time" placeholder="<?php esc_html_e( 'HH:MM AM/PM', 'clockinator-lite' ); ?>"/>
				                                <span class="input-group-append input-group-addon">
				                                  <span class="input-group-text"><i class="fa fa-clock"></i></span>
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
				                          <button type="button" id="SaveShiftBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
				                        </form>
				                      </div>
				                    </div>
				                  </div>
				                </div>
				                <!-- Modal Ends -->

				                <!-- Edit Modal starts -->
				                <div class="modal fade" id="EditNewShift" tabindex="-1" role="dialog" aria-labelledby="EditNewShift" aria-hidden="true">
				                  <div class="modal-dialog" role="document">
				                    <div class="modal-content">
				                      <div class="modal-header">
				                        <h5 class="modal-title" id="EditNewShift"><?php esc_html_e( 'Edit Shift', 'clockinator-lite' ); ?></h5>
				                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                          <span aria-hidden="true">&times;</span>
				                        </button>
				                      </div>
				                      <div class="modal-body">
				                        <form class="forms-sample" method="post" id="EditShiftForm">
				                          <div class="form-group row">
				                            <label for="shift_name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Name', 'clockinator-lite' ); ?></label>
				                            <div class="col-sm-9">
				                              <input type="text" class="form-control" name="shift_name" id="shift_name" placeholder="<?php esc_html_e( 'Shift Name', 'clockinator-lite' ); ?>">
				                            </div>
				                          </div>
				                          <div class="form-group row">
				                            <label for="shift_start" class="col-sm-3 col-form-label"><?php esc_html_e( 'Start Time', 'clockinator-lite' ); ?></label>
				                            <div class="col-sm-9">
				                              <div class="input-group time">
				                                <input class="form-control" id="shift_start" name="shift_start" placeholder="<?php esc_html_e( 'HH:MM AM/PM', 'clockinator-lite' ); ?>"/>
				                                <span class="input-group-append input-group-addon">
				                                  <span class="input-group-text"><i class="fa fa-clock"></i></span>
				                                </span>
				                              </div>
				                            </div>
				                          </div>
				                          <div class="form-group row">
				                            <label for="shift_end" class="col-sm-3 col-form-label"><?php esc_html_e( 'End Time', 'clockinator-lite' ); ?></label>
				                            <div class="col-sm-9">
				                              <div class="input-group time">
				                                <input class="form-control" id="shift_end" name="shift_end" placeholder="<?php esc_html_e( 'HH:MM AM/PM', 'clockinator-lite' ); ?>"/>
				                                <span class="input-group-append input-group-addon">
				                                  <span class="input-group-text"><i class="fa fa-clock"></i></span>
				                                </span>
				                              </div>
				                            </div>
				                          </div>
				                          <div class="form-group row">
				                            <label for="late_time" class="col-sm-3 col-form-label"><?php esc_html_e( 'Late Time', 'clockinator-lite' ); ?></label>
				                            <div class="col-sm-9">
				                              <div class="input-group time">
				                                <input class="form-control" id="late_time" name="late_time" placeholder="<?php esc_html_e( 'HH:MM AM/PM', 'clockinator-lite' ); ?>"/>
				                                <span class="input-group-append input-group-addon">
				                                  <span class="input-group-text"><i class="fa fa-clock"></i></span>
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
				                          <button type="button" id="EditShiftBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
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
				                      <table id="shift-listing" class="table">
				                        <thead>
				                          <tr>
				                            <th><?php esc_html_e( 'S No. #', 'clockinator-lite' ); ?></th>
				                            <th><?php esc_html_e( 'Name', 'clockinator-lite' ); ?></th>
				                            <th><?php esc_html_e( 'Timing', 'clockinator-lite' ); ?></th>
				                            <th><?php esc_html_e( 'Late Time', 'clockinator-lite' ); ?></th>
				                            <th><?php esc_html_e( 'Members', 'clockinator-lite' ); ?></th>
				                            <th><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></th>
				                            <th><?php esc_html_e( 'Actions', 'clockinator-lite' ); ?></th>
				                          </tr>
				                        </thead>
				                        <tbody>
				                          <?php
				                            $all_shifts = BTCLite_Helper::btclite_get_shifts();
				                            foreach ( $all_shifts as $key => $shift ) {
				                          ?>
				                          <tr>
				                            <td><?php echo esc_html( $key+1 ); ?></td>
				                            <td><?php esc_html_e( $shift->name, 'clockinator-lite' ); ?></td>
				                            <td>
				                              <span class="label label-light-info label-inline label-lg">
				                                <?php echo BTCLite_Helper::btclite_get_formated_time( $shift->start ).' to '.BTCLite_Helper::btclite_get_formated_time( $shift->end ); ?>
				                              </span>
				                            </td>
				                            <td>
				                              <span class="label label-light-warning label-inline label-lg">
				                                <?php echo BTCLite_Helper::btclite_get_formated_time( $shift->late ); ?>
				                              </span>
				                            </td>
				                            <td>
				                              <span class="label label-light-primary label-inline label-lg">
				                                <?php echo esc_html( BTCLite_Helper::btclite_get_shift_members( $shift->id ) ); ?>
				                              </span>
				                            </td>
				                            <td>
				                              <?php 
				                                if ( $shift->status == 'active' ) {
				                                  $class = 'badge-success';
				                                } else {
				                                  $class = 'badge-danger';
				                                } 
				                              ?>
				                              <label class="badge <?php echo esc_attr( $class ); ?>"><?php esc_html_e( $shift->status, 'clockinator-lite' ); ?></label>
				                            </td>
				                            <td>
				                              <button class="btn btn-outline-primary edit-shift-details" data-id="<?php echo esc_attr( $shift->id ); ?>" data-table="<?php echo esc_attr( 'btcl_shifts' ); ?>">
				                                <?php esc_html_e( 'View', 'clockinator-lite' ); ?>
				                              </button>
				                              <button class="btn btn-outline-danger delete-shift-details" data-id="<?php echo esc_attr( $shift->id ); ?>" data-table="<?php echo esc_attr( 'btcl_shifts' ); ?>">
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