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
                <h4 class="card-title"><?php esc_html_e( 'Departments', 'clockinator-lite' ); ?></h4>
                <button type="button" class="btn btn-primary top-add-btn" data-toggle="modal" data-target="#AddDepartment"><?php esc_html_e( 'Add New', 'clockinator-lite' ); ?></button>
                <!-- Modal starts -->
                <div class="modal fade" id="AddDepartment" tabindex="-1" role="dialog" aria-labelledby="AddDepartment" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="AddDepartment"><?php esc_html_e( 'Add New Department', 'clockinator-lite' ); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" method="post" id="DepartmentForm">
                          <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Name', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="name" id="name" placeholder="Shift Name">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="color" class="col-sm-3 col-form-label"><?php esc_html_e( 'Color Code', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <input type="email" class="form-control color-field" name="color" id="color" placeholder="">
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
                          <button type="button" id="SaveDepartBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal Ends -->

                <!-- Edit Modal starts -->
                <div class="modal fade" id="EditDepartment" tabindex="-1" role="dialog" aria-labelledby="EditDepartment" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="EditDepartment"><?php esc_html_e( 'Edit Department', 'clockinator-lite' ); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" method="post" id="EditDepartmentForm">
                          <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Name', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="name" id="name" placeholder="Shift Name">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="color" class="col-sm-3 col-form-label"><?php esc_html_e( 'Color Code', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <input type="email" class="form-control color-field" name="color" id="color" placeholder="">
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
                          <button type="button" id="EditDepartBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Edit Modal Ends -->

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
                            <th><?php esc_html_e( 'Name', 'clockinator-lite' ); ?></th>
                            <th><?php esc_html_e( 'Members', 'clockinator-lite' ); ?></th>
                            <th><?php esc_html_e( 'Color', 'clockinator-lite' ); ?></th>
                            <th><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></th>
                            <th><?php esc_html_e( 'Actions', 'clockinator-lite' ); ?></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $all_departments = BTCLite_Helper::btclite_get_departments();
                            foreach ( $all_departments as $key => $department ) {
                          ?>
                          <tr>
                            <td><?php echo esc_html( $key+1 ); ?></td>
                            <td><?php esc_html_e( $department->name, 'clockinator-lite' ); ?></td>
                            <td><?php echo esc_html( BTCLite_Helper::btclite_get_department_members( $department->id ) ); ?></td>
                            <td>
                              <label class="badge" style="background-color:<?php echo esc_attr( $department->color ); ?>">
                                <?php echo esc_html( $department->color ); ?>
                              </label>
                            </td>
                            <td>
                              <?php 
                                if ( $department->status == 'active' ) {
                                  $class = 'badge-success';
                                } else {
                                  $class = 'badge-danger';
                                } 
                              ?>
                              <label class="badge <?php echo esc_attr( $class ); ?> text-white"><?php esc_html_e( $department->status, 'clockinator-lite' ); ?></label>
                            </td>
                            <td>
                              <button class="btn btn-outline-primary edit-department-details" data-id="<?php echo esc_attr( $department->id ); ?>" data-table="<?php echo esc_attr( 'btcl_departments' ); ?>">
                                <?php esc_html_e( 'View', 'clockinator-lite' ); ?>
                              </button>
                              <button class="btn btn-outline-danger delete-department-details" data-id="<?php echo esc_attr( $department->id ); ?>" data-table="<?php echo esc_attr( 'btcl_departments' ); ?>">
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