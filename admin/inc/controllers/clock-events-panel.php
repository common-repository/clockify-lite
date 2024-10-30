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
                <h4 class="card-title"><?php esc_html_e( 'Events', 'clockinator-lite' ); ?></h4>
                <button type="button" class="btn btn-primary top-add-btn" data-toggle="modal" data-target="#AddEvents"><?php esc_html_e( 'Add New', 'clockinator-lite' ); ?></button>
                <!-- Modal starts -->
                <div class="modal fade" id="AddEvents" tabindex="-1" role="dialog" aria-labelledby="AddEvents" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="AddEvents"><?php esc_html_e( 'Add New Event', 'clockinator-lite' ); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" method="post" id="EventsForm">
                          <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Title', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="name" id="name" placeholder="<?php esc_html_e( 'Event title', 'clockinator-lite' ); ?>" required>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="event_date" class="col-sm-3 col-form-label"><?php esc_html_e( 'Event date', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <div class="input-group date datepicker">
                                <input type="text" class="form-control" name="event_date" id="event_date" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'clockinator-lite' ); ?>">
                                <span class="input-group-addon input-group-append border-left">
                                  <span class="fa fa-calendar input-group-text"></span>
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label"><?php esc_html_e( 'Description', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <textarea class="form-control" rows="4" name="description" id="description" placeholder="<?php esc_html_e( 'Event content', 'clockinator-lite' ); ?>" required></textarea>
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
                          <button type="button" id="SaveEventBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal Ends -->

                <!-- Edit Modal starts -->
                <div class="modal fade" id="EditEvents" tabindex="-1" role="dialog" aria-labelledby="EditEvents" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="EditEvents"><?php esc_html_e( 'Edit Notice', 'clockinator-lite' ); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form class="forms-sample" method="post" id="EditEventForm">
                          <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><?php esc_html_e( 'Title', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="name" id="name" placeholder="<?php esc_html_e( 'Notice title', 'clockinator-lite' ); ?>" required>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="event_date_e" class="col-sm-3 col-form-label"><?php esc_html_e( 'Event date', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <div class="input-group date datepicker">
                                <input type="text" class="form-control" name="event_date_e" id="event_date_e" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'clockinator-lite' ); ?>">
                                <span class="input-group-addon input-group-append border-left">
                                  <span class="fa fa-calendar input-group-text"></span>
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label"><?php esc_html_e( 'Description', 'clockinator-lite' ); ?></label>
                            <div class="col-sm-9">
                              <textarea class="form-control" rows="4" name="description" id="description" placeholder="<?php esc_html_e( 'Notice content', 'clockinator-lite' ); ?>" required></textarea>
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
                          <button type="button" id="EditEventBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
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
                <div class="row notice-profile-grid">
                  <?php $events_data = BTCLite_Helper::btclite_get_events();
                    foreach ( $events_data as $key => $event ) {
                  ?>
                  <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                    <div class="card <?php echo esc_attr( BTCLite_Helper::btclite_get_notice_class() ); ?> text-white text-center card-shadow-warning">
                      <div class="card-body">
                        <h3 class="mb-0"><?php echo esc_html( $event->name ); ?></h3>
                         <p class="event-description"><?php echo esc_html( $event->description ); ?></p>
                         <p class="action-buttons">
                           <button class="btn btn-outline-event edit-event-details" data-id="<?php echo esc_attr( $event->id ); ?>" data-table="<?php echo esc_attr( 'btcl_events' ); ?>">
                              <?php esc_html_e( 'View', 'clockinator-lite' ); ?>
                            </button>
                            <button class="btn btn-outline-event delete-event-details" data-id="<?php echo esc_attr( $event->id ); ?>" data-table="<?php echo esc_attr( 'btcl_events' ); ?>">
                              <?php esc_html_e( 'Delete', 'clockinator-lite' ); ?>
                            </button>
                         </p>
                      </div>
                    </div>
                  </div>
                   <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>