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
                <h4 class="card-title"><?php esc_html_e( 'Employees', 'clockinator-lite' ); ?></h4>
                <button type="button" class="btn btn-primary top-add-btn" data-toggle="modal" data-target="#AddEployee"><?php esc_html_e( 'Add New', 'clockinator-lite' ); ?></button>

                <!-- Modal starts -->
                <div class="modal fade" id="AddEployee" tabindex="-1" role="dialog" aria-labelledby="AddEployee" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="AddEployee"><?php esc_html_e( 'Add New Employee', 'clockinator-lite' ); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" method="post" id="EmployeesForm" autocomplete="off">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="entry" class="col-sm-3 col-form-label"><?php esc_html_e( 'Entry', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <select class="form-control form-control-sm custom-select-height" name="entry" id="entry">
                                    <option value="new"><?php esc_html_e( 'Create new user', 'clockinator-lite' ); ?></option>
                                    <option value="exist"><?php esc_html_e( 'Existing user', 'clockinator-lite' ); ?></option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 default-diable" id="default-employees">
                              <div class="form-group row">
                                <label for="user_id" class="col-sm-3 col-form-label"><?php esc_html_e( 'Employee', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <select class="form-control form-control-sm custom-select-height" name="user_id" id="user_id">
                                    <option value=""><?php esc_html_e( 'Choose user...', 'clockinator-lite' ); ?></option>
                                    <?php $users_list = BTCLite_Helper::btclite_get_users_list();
                                      if ( ! empty( $users_list ) )  { foreach ( $users_list as $key => $users ) {
                                    ?>
                                    <option value="<?php echo esc_attr( $users->ID ); ?>"><?php echo esc_html( $users->display_name ); ?></option>
                                    <?php } } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Staff Name', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="name" id="name" placeholder="<?php esc_html_e( 'Name', 'clockinator-lite' ); ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label"><?php esc_html_e( 'Email Address', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <div class="input-group">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="<?php esc_html_e( 'Email', 'clockinator-lite' ); ?>">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">@</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="dob" class="col-sm-3 col-form-label"><?php esc_html_e( 'Date of Birth', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <div class="input-group date datepicker">
                                    <input type="text" class="form-control" name="dob" id="dob">
                                    <span class="input-group-addon input-group-append border-left">
                                      <span class="fa fa-calendar input-group-text"></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="gender" class="col-sm-3 col-form-label"><?php esc_html_e( 'Gender', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-4">
                                  <div class="form-check">
                                    <label class="form-check-label">
                                      <input type="radio" class="form-check-input" name="gender" id="gender1" value="male" checked="">
                                      <?php esc_html_e( 'Male', 'clockinator-lite' ); ?>
                                    <i class="input-helper"></i></label>
                                  </div>
                                </div>
                                <div class="col-sm-5">
                                  <div class="form-check">
                                    <label class="form-check-label">
                                      <input type="radio" class="form-check-input" name="gender" id="gender2" value="female">
                                      <?php esc_html_e( 'Female', 'clockinator-lite' ); ?>
                                    <i class="input-helper"></i></label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="department" class="col-sm-3 col-form-label"><?php esc_html_e( 'Department', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <select class="form-control form-control-sm custom-select-height" name="department">
                                  <?php $department_list = BTCLite_Helper::btclite_get_departments();
                                      if ( ! empty( $department_list ) )  { foreach ( $department_list as $key => $department ) {
                                    ?>
                                    <option value="<?php echo esc_attr( $department->id ); ?>"><?php echo esc_html( $department->name ); ?></option>
                                  <?php } } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="designation" class="col-sm-3 col-form-label"><?php esc_html_e( 'Designation', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="email" class="form-control" name="designation" id="designation">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="shift" class="col-sm-3 col-form-label"><?php esc_html_e( 'Shift', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <select class="form-control form-control-lg form-control-solid custom-select-height selectpicker" data-live-search="true" name="shift" id="shift">
                                      <?php $shift_list = BTCLite_Helper::btclite_get_shifts();
                                        if ( ! empty( $shift_list ) )  { foreach ( $shift_list as $key => $shift ) {
                                      ?>
                                      <option value="<?php echo esc_attr( $shift->id ); ?>"><?php echo esc_html( $shift->name ).' ('.esc_html( $shift->start ).' to '.esc_html( $shift->end ).' )'; ?></option>
                                      <?php } } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label style="padding: 0;padding-top: 20px;padding-left: 13px;" for="salary" class="col-sm-3 col-form-label"><?php esc_html_e( 'Salary', 'clockinator-lite' ); ?><span class="pro-content"><?php esc_html_e( 'Pro', 'clockinator-lite' ); ?></span></label>
                                <div class="col-sm-9">
                                  <input type="number" class="form-control" name="salary" id="salary" disabled="disabled">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="date_of_join" class="col-sm-3 col-form-label"><?php esc_html_e( 'Company date of joining', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <div class="input-group date datepicker">
                                    <input type="text" class="form-control" name="date_of_join" id="date_of_join" placeholder="<?php esc_html_e( 'Enter joining date', 'clockinator-lite' ); ?>">
                                    <span class="input-group-addon input-group-append border-left">
                                      <span class="fa fa-calendar input-group-text"></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="phone" class="col-sm-3 col-form-label"><?php esc_html_e( 'Phone', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="number" class="form-control" name="phone" id="phone" placeholder="<?php esc_html_e( 'Enter phone no with country code', 'clockinator-lite' ); ?>">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="facebook_id" class="col-sm-3 col-form-label"><?php esc_html_e( 'Facebook ID', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="facebook_id" id="facebook_id">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="skype_id" class="col-sm-3 col-form-label"><?php esc_html_e( 'Skype ID', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="skype_id" id="skype_id">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="profile_pic" class="col-sm-3 col-form-label"><?php esc_html_e( 'Upload profile photo', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-8">
                              <div class="input-group">
                                <input type="text" class="form-control" name="profile_pic" id="profile_pic">
                                <span class="input-group-addon input-group-append border-left">
                                  <span class="fa fa-user-circle input-group-text"></span>
                                </span>
                              </div>
                            </div>
                            <button type="button" class="btn btn-success btn-sm add-image-btn"><?php esc_html_e( 'Upload', 'clockinator-lite' ); ?></button>
                          </div>
                          <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label"><?php esc_html_e( 'Address', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <textarea class="form-control" rows="4" name="address" id="address"></textarea>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="role" class="col-sm-3 col-form-label"><?php esc_html_e( 'Role', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <select class="form-control form-control-sm custom-select-height" name="role" id="role">
                                    <option value="hr_manager"><?php esc_html_e( 'HR Manager', 'clockinator-lite' ); ?></option>
                                    <option value="employee"><?php esc_html_e( 'Employee', 'clockinator-lite' ); ?></option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="status" class="col-sm-3 col-form-label"><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <select class="form-control form-control-sm custom-select-height" name="status" id="status">
                                    <option value="active"><?php esc_html_e( 'Active', 'clockinator-lite' ); ?></option>
                                    <option value="inactive"><?php esc_html_e( 'Inactive', 'clockinator-lite' ); ?></option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <h4 class="form-sub-heading"><?php esc_html_e( 'Bank Account Details', 'clockinator-lite' ); ?></h4>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="Holder_name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Account holder name*', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="Holder_name" id="Holder_name">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="Bank_name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Bank Name*', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="Bank_name" id="Bank_name">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="Account_no" class="col-sm-3 col-form-label"><?php esc_html_e( 'Account Number*', 'clockinator-lite' ); ?></label>
                               <div class="col-sm-9">
                                  <input type="number" class="form-control" name="Account_no" id="Account_no" placeholder="200xxxxxxxxxxx45">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="ifsc_code" class="col-sm-3 col-form-label"><?php esc_html_e( 'Bank Identifier Code/IFSC Code*', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" placeholder="CHISN586YDH8">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="branch_location" class="col-sm-3 col-form-label"><?php esc_html_e( 'Branch Location*', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="branch_location" id="branch_location">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="tax_payer_id" class="col-sm-3 col-form-label"><?php esc_html_e( 'Tax Payer Id', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="tax_payer_id" id="tax_payer_id">
                                </div>
                              </div>
                            </div>
                          </div>
                          <h4 class="form-sub-heading"><?php esc_html_e( 'Login Details', 'clockinator-lite' ); ?></h4>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label"><?php esc_html_e( 'Username*', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="username" id="username" required>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="user_paswd" class="col-sm-3 col-form-label"><?php esc_html_e( 'Password*', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="user_paswd" id="user_paswd" required>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="repeat_paswd" class="col-sm-3 col-form-label"><?php esc_html_e( 'Repeat password*', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="repeat_paswd" id="repeat_paswd" required>
                                </div>
                              </div>
                            </div>
                          </div>
                          <button type="button" id="SaveEmployeeBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal Ends -->

                <!-- Edit Modal starts -->
                <div class="modal fade" id="EditEployee" tabindex="-1" role="dialog" aria-labelledby="EditEployee" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="EditEployee"><?php esc_html_e( 'Add New Employee', 'clockinator-lite' ); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" method="post" id="EditEmployeesForm" autocomplete="off">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Staff Name', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="name" id="name" placeholder="<?php esc_html_e( 'Name', 'clockinator-lite' ); ?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label"><?php esc_html_e( 'Email Address', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <div class="input-group">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="<?php esc_html_e( 'Email', 'clockinator-lite' ); ?>" disabled="disabled" readonly="readonly">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">@</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="dob" class="col-sm-3 col-form-label"><?php esc_html_e( 'Date of Birth', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <div class="input-group date datepicker">
                                    <input type="text" class="form-control" name="dob" id="dob">
                                    <span class="input-group-addon input-group-append border-left">
                                      <span class="fa fa-calendar input-group-text"></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="edit_gender" class="col-sm-3 col-form-label"><?php esc_html_e( 'Gender', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-4">
                                  <div class="form-check">
                                    <label class="form-check-label">
                                      <input type="radio" class="form-check-input" name="edit_gender" id="gender1" value="male" checked="">
                                      <?php esc_html_e( 'Male', 'clockinator-lite' ); ?>
                                    <i class="input-helper"></i></label>
                                  </div>
                                </div>
                                <div class="col-sm-5">
                                  <div class="form-check">
                                    <label class="form-check-label">
                                      <input type="radio" class="form-check-input" name="edit_gender" id="gender2" value="female">
                                      <?php esc_html_e( 'Female', 'clockinator-lite' ); ?>
                                    <i class="input-helper"></i></label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="department" class="col-sm-3 col-form-label"><?php esc_html_e( 'Department', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <select class="form-control form-control-sm custom-select-height" name="department">
                                  <?php $department_list = BTCLite_Helper::btclite_get_departments();
                                      if ( ! empty( $department_list ) )  { foreach ( $department_list as $key => $department ) {
                                    ?>
                                    <option value="<?php echo esc_attr( $department->id ); ?>"><?php echo esc_html( $department->name ); ?></option>
                                    <?php } } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="designation" class="col-sm-3 col-form-label"><?php esc_html_e( 'Designation', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="email" class="form-control" name="designation" id="designation">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="shift" class="col-sm-3 col-form-label"><?php esc_html_e( 'Shift', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <select class="form-control form-control-lg form-control-solid custom-select-height selectpicker" data-live-search="true" name="shift" id="shift">
                                      <?php $shift_list = BTCLite_Helper::btclite_get_shifts();
                                        if ( ! empty( $shift_list ) )  { foreach ( $shift_list as $key => $shift ) {
                                      ?>
                                      <option value="<?php echo esc_attr( $shift->id ); ?>"><?php echo esc_html( $shift->name ).' ('.esc_html( $shift->start ).' to '.esc_html( $shift->end ).' )'; ?></option>
                                      <?php } } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label style="padding: 0;padding-top: 20px;padding-left: 13px;" for="salary" class="col-sm-3 col-form-label"><?php esc_html_e( 'Salary', 'clockinator-lite' ); ?><span class="pro-content"><?php esc_html_e( 'Pro', 'clockinator-lite' ); ?></span></label>
                                <div class="col-sm-9">
                                  <input type="number" class="form-control" name="salary" id="salary" disabled="disabled">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="date_of_join" class="col-sm-3 col-form-label"><?php esc_html_e( 'Company date of joining', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <div class="input-group date datepicker">
                                    <input type="text" class="form-control" name="date_of_join" id="date_of_join" placeholder="<?php esc_html_e( 'Enter joining date', 'clockinator-lite' ); ?>">
                                    <span class="input-group-addon input-group-append border-left">
                                      <span class="fa fa-calendar input-group-text"></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="phone" class="col-sm-3 col-form-label"><?php esc_html_e( 'Phone', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="number" class="form-control" name="phone" id="phone" placeholder="<?php esc_html_e( 'Enter phone no with country code', 'clockinator-lite' ); ?>">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="facebook_id" class="col-sm-3 col-form-label"><?php esc_html_e( 'Facebook ID', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="facebook_id" id="facebook_id">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="skype_id" class="col-sm-3 col-form-label"><?php esc_html_e( 'Skype ID', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="skype_id" id="skype_id">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="profile_pic" class="col-sm-3 col-form-label"><?php esc_html_e( 'Upload profile photo', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-8">
                              <div class="input-group">
                                <input type="text" class="form-control" name="profile_pic" id="profile_pic">
                                <span class="input-group-addon input-group-append border-left">
                                  <span class="fa fa-user-circle input-group-text"></span>
                                </span>
                              </div>
                            </div>
                            <button type="button" class="btn btn-success btn-sm edit-image-btn"><?php esc_html_e( 'Upload', 'clockinator-lite' ); ?></button>
                          </div>
                          <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label"><?php esc_html_e( 'Address', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <textarea class="form-control" rows="4" name="address" id="address"></textarea>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="role" class="col-sm-3 col-form-label"><?php esc_html_e( 'Role', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <select class="form-control form-control-sm custom-select-height" name="role" id="role">
                                    <option value="hr_manager"><?php esc_html_e( 'HR Manager', 'clockinator-lite' ); ?></option>
                                    <option value="employee"><?php esc_html_e( 'Employee', 'clockinator-lite' ); ?></option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="status" class="col-sm-3 col-form-label"><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <select class="form-control form-control-sm custom-select-height" name="status" id="status">
                                    <option value="active"><?php esc_html_e( 'Active', 'clockinator-lite' ); ?></option>
                                    <option value="inactive"><?php esc_html_e( 'Inactive', 'clockinator-lite' ); ?></option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <h4 class="form-sub-heading"><?php esc_html_e( 'Bank Account Details', 'clockinator-lite' ); ?></h4>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="Holder_name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Account holder name*', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="Holder_name" id="Holder_name">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="Bank_name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Bank Name*', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="Bank_name" id="Bank_name">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="Account_no" class="col-sm-3 col-form-label"><?php esc_html_e( 'Account Number*', 'clockinator-lite' ); ?></label>
                               <div class="col-sm-9">
                                  <input type="number" class="form-control" name="Account_no" id="Account_no" placeholder="200xxxxxxxxxxx45">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="ifsc_code" class="col-sm-3 col-form-label"><?php esc_html_e( 'Bank Identifier Code/IFSC Code*', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" placeholder="CHISN586YDH8">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="branch_location" class="col-sm-3 col-form-label"><?php esc_html_e( 'Branch Location*', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="branch_location" id="branch_location">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="tax_payer_id" class="col-sm-3 col-form-label"><?php esc_html_e( 'Tax Payer Id', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="tax_payer_id" id="tax_payer_id">
                                </div>
                              </div>
                            </div>
                          </div>
                          <h4 class="form-sub-heading"><?php esc_html_e( 'Login Details', 'clockinator-lite' ); ?></h4>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label"><?php esc_html_e( 'Username*', 'clockinator-lite' ); ?></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="username" id="username" required disabled="disabled" readonly="readonly">
                                </div>
                              </div>
                            </div>
                          </div>
                          <input type="hidden" name="id" id="id" value="">
                          <button type="button" id="EditEmployeeBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Edit Modal Ends -->

              </div>
            </div>
          </div>
        </div>

        <div class="row employe-grid-view">
          <?php $all_employees = BTCLite_Helper::btclite_get_employees();
            foreach ( $all_employees as $key => $users ) {
              $status = BTCLite_Helper::btclite_check_staff_realtime_status( $users->user_id );
              if ( $status == true ) {
                $class1 = 'bg-success';
                $class  = 'label-light-success';
                $title  = esc_html__( 'Online', 'clockify' );
              } else {
                $class1 = 'bg-warning';
                $class  = 'label-light-warning';
                $title  = esc_html__( 'Offline', 'clockify' );
              }
          ?>
          <div class="col-3 grid-margin">
            <div class="card card-custom gutter-b">
              <!--begin::Body-->
              <div class="card-body pt-15">
                <!--begin::User-->
                <div class="text-center mb-8">
                  <div class="symbol symbol-60 symbol-circle symbol-xl-90">
                    <?php if ( ! empty ( $users->picture ) ) { ?>
                    <img alt="profile-pic" class="rounded-circle profile-widget-picture symbol-label" src="<?php echo esc_attr( esc_url( BTCLite_Helper::btclite_get_employees_pic( $users->user_id ) ) ); ?>">
                    <?php } else { ?>
                    <div class="symbol employee symbol-35 symbol-light-success flex-shrink-0 mr-3">
                      <span class="symbol-label font-weight-bolder font-size-lg text-uppercase staff-initials">
                        <?php echo BTCLite_Helper::btclite_get_initials( $users->first_name, $users->last_name ); ?>
                      </span>
                    </div>
                    <?php } ?>
                    <i class="symbol-badge symbol-badge-bottom <?php echo esc_attr( $class1 ); ?>"></i>
                  </div>
                  <h4 class="font-weight-bolder my-2"><?php echo esc_html( $users->name ); ?></h4>
                  <div class="text-muted mb-2"><?php echo esc_html( $users->designation ); ?></div>
                  <?php
                    $employer_extra = unserialize( BTCLite_Helper::btclite_verify_value( $users->extra ) );
                  ?>
                  <span class="label <?php echo esc_attr( $class ); ?> label-inline label-lg"><?php echo esc_html( $title ); ?></span>
                </div>
                <!--end::User-->
                <!--begin::Contact-->
                <div class="mb-10 text-center user-profile-icons">
                  <?php if ( ! empty ( $employer_extra['facebook_id'] ) ) { ?>
                  <a href="https://www.facebook.com/profile.php?id=<?php echo esc_attr( $employer_extra['facebook_id'] ); ?>" class="btn btn-icon btn-circle btn-light-facebook mr-2" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                  </a>
                  <?php } if ( ! empty ( $employer_extra['skype_id'] ) ) { ?>
                  <a href="https://join.skype.com/invite/<?php echo esc_attr( $employer_extra['skype_id'] ); ?>" class="btn btn-icon btn-circle btn-light-twitter mr-2" target="_blank">
                    <i class="fab fa-skype"></i>
                  </a>
                  <?php } if ( ! empty ( $users->user_email ) ) { ?>
                  <a href="mailto:<?php echo esc_attr( $users->user_email ); ?>" class="btn btn-icon btn-circle btn-light-google" target="_blank">
                    <i class="far fa-envelope"></i>
                  </a>
                  <?php } ?>
                </div>
                <!--end::Contact-->
                <p class="action-buttons">
                  <button class="btn btn-outline-notice edit-employee-details" data-id="<?php echo esc_attr( $users->id ); ?>" data-table="<?php echo esc_attr( 'btcl_employees' ); ?>">
                    <?php esc_html_e( 'View', 'clockinator-lite' ); ?>
                  </button>
                  <button class="btn btn-outline-notice delete-employee-details" data-id="<?php echo esc_attr( $users->id ); ?>" data-table="<?php echo esc_attr( 'btcl_employees' ); ?>">
                    <?php esc_html_e( 'Delete', 'clockinator-lite' ); ?>
                  </button>
                </p>
              </div>
              <!--end::Body-->
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>