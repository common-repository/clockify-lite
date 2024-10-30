<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );
$user_id   = get_current_user_id();
$user_name = BTCLite_Helper::btclite_get_current_user_data( $user_id, 'first_name' );

if ( empty ( $user_name ) ) {
  $user_name = BTCLite_Helper::btclite_get_current_user_data( $user_id, 'display_name' );
}

$savesetting = get_option( 'btcl_settings' );
$avtar_check = isset( $savesetting['employee_avatar'] ) ? sanitize_text_field( $savesetting['employee_avatar'] ) : 'yes';
$user_pic    = BTCLite_Helper::btclite_get_employees_pic( $user_id );

?>
<div class="container-scroller">
  <?php require_once BTCLite_PLUGIN_DIR_PATH . '/admin/inc/views/nav/nav.php';  ?>

  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="dash-item btcl-column btcl-column-1">
                  <?php if ( ! empty ( BTCLite_Helper::btclite_get_employees_pic( $user_id ) ) ) { ?>
                  <div class="btcl-user-img">
                    <img class="profile_img" src="<?php echo esc_attr( esc_url( BTCLite_Helper::btclite_get_employees_pic( $user_id ) ) ); ?>" alt="Viollet D'Amore">
                  </div>
                  <?php } else { ?>
                    <div class="symbol employee symbol-35 symbol-light-info flex-shrink-0 mr-3">
                      <span class="symbol-label font-weight-bolder font-size-lg text-uppercase staff-initials-admin">
                        <?php echo BTCLite_Helper::btclite_get_initials( $user_name, BTCLite_Helper::btclite_member_details( $user_id, 'lastname' ) ); ?>
                      </span>
                    </div>
                  <?php } ?>
                  <div class="welcome-wrap">
                    <h1 class="btcl-hello">
                      <?php echo esc_html__( 'Hello, ', 'clockinator-lite' ).''.esc_html( $user_name ); ?>
                    </h1>
                    <span><?php esc_html_e( 'Welcome Back', 'clockinator-lite' ); ?></span>
                    <div class="img-account-hello"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 grid-margin stretch-card">
            <div class="card bg-gradient-primary text-white text-center card-shadow-primary">
              <div class="card-body">
                <h6 class="font-weight-normal"><?php esc_html_e( 'Employees', 'clockinator-lite' ); ?></h6>
                <h2 class="mb-0"><?php echo esc_html( BTCLite_Helper::btclite_get_total_employers() ); ?></h2>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 grid-margin stretch-card">
            <div class="card bg-gradient-danger text-white text-center card-shadow-danger">
              <div class="card-body">
                <h6 class="font-weight-normal"><?php esc_html_e( 'Leave Requests', 'clockinator-lite' ); ?></h6>
                <h2 class="mb-0"><?php echo esc_html( BTCLite_Helper::btclite_get_total_leaves() ); ?></h2>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 grid-margin stretch-card">
            <div class="card bg-gradient-warning text-white text-center card-shadow-warning">
              <div class="card-body">
                <h6 class="font-weight-normal"><?php esc_html_e( 'Departments', 'clockinator-lite' ); ?></h6>
                <h2 class="mb-0"><?php echo esc_html( BTCLite_Helper::btclite_get_total_departments() ); ?></h2>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 grid-margin stretch-card">
            <div class="card bg-gradient-info text-white text-center card-shadow-info">
              <div class="card-body">
                <h6 class="font-weight-normal"><?php esc_html_e( 'Shifts', 'clockinator-lite' ); ?></h6>
                <h2 class="mb-0"><?php echo esc_html( BTCLite_Helper::btclite_get_total_shifts() ); ?></h2>
              </div>
            </div>
          </div>
        </div>
        <div class="row grid-margin">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><?php esc_html_e( 'Employee\'s target leaderboard', 'clockinator-lite' ); ?></h4>
                  <div class="table-responsive mt-2">
                    <table id="live-status-listing" class="table mt-3 border-top">
                      <thead>
                        <tr>
                          <th><?php esc_html_e( 'No.', 'clockinator-lite' ); ?></th>
                          <th><?php esc_html_e( 'Employee', 'clockinator-lite' ); ?></th>
                          <th><?php esc_html_e( 'Target', 'clockinator-lite' ); ?></th>
                          <th><?php esc_html_e( 'Progress', 'clockinator-lite' ); ?></th>
                          <th><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                            $all_targets = BTCLite_Helper::btclite_get_targets();
                            $all_targets = array_reverse( $all_targets );
                            $s_no        = 1;
                            if ( ! empty ( $all_targets ) ) {
                              foreach ( $all_targets as $key => $target ) {
                                $user = BTCLite_Helper::btclite_get_employees_details( $target->user_id );
                                  if ( $target->status == 'Initiated' ) {
                                    $s_class = 'label-light-primary';
                                  } elseif ( $target->status == 'Processing' ) {
                                    $s_class = 'label-light-warning';
                                  } else {
                                    $s_class = 'label-light-success';
                                  }

                                  ?>
                                  <tr>
                                    <td><?php echo esc_html( $s_no ); ?></td>
                                    <td><?php echo esc_html( BTCLite_Helper::btclite_member_details( $target->user_id, 'name' ) ); ?></td>
                                    <td>
                                      <a href="<?php echo esc_url( 
                                              add_query_arg( 
                                              array(
                                              'action' => 'view',
                                              'row_id' => $target->id,
                                              ), admin_url( 'admin.php?page=clockify-lite-target' ) ) ); ?>">
                                          <?php echo esc_html( $target->title ); ?>
                                      </a>
                                    </td>
                                    <td>
                                      <span class="label label-light-info label-inline label-lg">
                                        <?php echo esc_html( BTCLite_Helper::btclite_get_target_percentage( $target->id ) ); ?>%
                                      </span>
                                    </td>
                                    <td>
                                      <span class="label <?php echo esc_attr( $s_class ); ?> label-inline label-lg">
                                        <?php echo esc_html( $target->status ); ?>
                                      </span>
                                    </td>
                                  </tr>
                                  <?php $s_no++; 
                              }
                            }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="row grid-margin">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title"><?php esc_html_e( 'Employee\'s status', 'clockinator-lite' ); ?></h4>
                <div class="table-responsive mt-2">
                  <table id="live-status-listing" class="table mt-3 border-top">
                    <thead>
                      <tr>
                        <th><?php esc_html_e( 'No.', 'clockinator-lite' ); ?></th>
                        <th><?php esc_html_e( 'Name', 'clockinator-lite' ); ?></th>
                        <th><?php esc_html_e( 'Date', 'clockinator-lite' ); ?></th>
                        <th><?php esc_html_e( 'Day', 'clockinator-lite' ); ?></th>
                        <th><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $all_staffs = BTCLite_Helper::btclite_get_employees();
                        foreach ( $all_staffs as $key => $staff ) {
                          if ( $staff->status == 'active' ) {
                      ?>
                      <tr>
                        <td><?php echo esc_html( $key+1 ) ?></td>
                        <td><?php echo esc_html( $staff->name ); ?></td>
                        <td><?php echo esc_html( BTCLite_Helper::btclite_get_formated_date( date( 'Y-m-d' ) ) ); ?></td>
                        <td><?php echo esc_html( date( 'l', strtotime( date( 'Y-m-d' ) ) ) ); ?></td>
                        <?php 
                          $status = BTCLite_Helper::btclite_check_staff_realtime_status( $staff->user_id );
                          if ( $status == true ) {
                            $class = 'label-light-success';
                            $title = esc_html__( 'Online', 'clockinator-lite' );
                          } else {
                            $class = 'label-light-danger';
                            $title = esc_html__( 'Offline', 'clockinator-lite' );
                          }
                        ?>
                        <td><span class="label <?php echo esc_attr( $class ); ?> label-inline label-lg"><?php echo esc_html( $title ); ?></div></td>
                      </tr>
                      <?php } } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>
