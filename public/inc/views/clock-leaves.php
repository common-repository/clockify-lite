<?php
$btcl_strings   = get_option( 'btcl_string_translation' );
$leave_requests = isset( $btcl_strings['leave_requests'] ) ? sanitize_text_field( $btcl_strings['leave_requests'] ) : esc_html__( 'Leave requests' );
$user_id = get_current_user_id();
?>
<h4 class="card-title"><?php echo esc_html( $leave_requests ); ?></h4>
<button type="button" class="btn btn-primary top-add-btn" data-toggle="modal" data-target="#AddLeaves"><?php esc_html_e( 'Add Request', 'clockinator-lite' ); ?></button>
<div class="row inner-row">
  	<div class="col-12">
    	<div class="table-responsive">
      		<table id="requests-listing" class="table table-striped">
                <thead>
                  <tr>
                    <th><?php esc_html_e( 'No.', 'clockinator-lite' ); ?></th>
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
                      if ( $leave->user_id == $user_id ) {
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
            	<?php if ( $leave->status != 'approved' ) { ?>
                    <button class="btn btn-outline-primary edit-leave-details" data-id="<?php echo esc_attr( $leave->id ); ?>" data-table="<?php echo esc_attr( 'btcl_leaves' ); ?>">
                      <?php esc_html_e( 'View', 'clockinator-lite' ); ?>
                    </button>
            	<?php } ?>
                <button class="btn btn-outline-danger delete-leave-details" data-id="<?php echo esc_attr( $leave->id ); ?>" data-table="<?php echo esc_attr( 'btcl_leaves' ); ?>">
                  <?php esc_html_e( 'Delete', 'clockinator-lite' ); ?>
                </button>
            </td>
  				</tr>
  				<?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal starts -->
<div class="modal fade" id="AddLeaves" tabindex="-1" role="dialog" aria-labelledby="AddLeaves" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddLeaves"><?php esc_html_e( 'Submit your leave request', 'clockinator-lite' ); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" method="post" id="LeavesForm">
          <div class="form-group row">
            <label for="subjectt" class="col-sm-3 col-form-label"><?php esc_html_e( 'Subject', 'clockinator-lite' ); ?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="subjectt" id="subjectt" placeholder="Subject for your leave">
            </div>
          </div>
          <div class="form-group row">
            <label for="reasonn" class="col-sm-3 col-form-label"><?php esc_html_e( 'Reason', 'clockinator-lite' ); ?></label>
            <div class="col-sm-9">
              <textarea class="form-control" name="reasonn" id="reasonn" placeholder=""></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="fromm" class="col-sm-3 col-form-label"><?php esc_html_e( 'From', 'clockinator-lite' ); ?></label>
            <div class="col-sm-9">
              <div class="input-group date datepicker">
                <input type="text" class="form-control" name="fromm" id="fromm" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'clockinator-lite' ); ?>">
                <span class="input-group-addon input-group-append border-left">
                  <span class="fa fa-calendar input-group-text"></span>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="too" class="col-sm-3 col-form-label"><?php esc_html_e( 'To', 'clockinator-lite' ); ?></label>
            <div class="col-sm-9">
              <div class="input-group date datepicker">
                <input type="text" class="form-control" name="too" id="too" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'clockinator-lite' ); ?>">
                <span class="input-group-addon input-group-append border-left">
                  <span class="fa fa-calendar input-group-text"></span>
                </span>
              </div>
            </div>
          </div>
          <input type="hidden" name="user_id" value="<?php echo esc_attr( get_current_user_id() ); ?>" />
          <input type="hidden" name="status" value="pending" />
          <button type="button" id="SaveLeavesBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Ends -->

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
          <input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( get_current_user_id() ); ?>">
          <input type="hidden" name="status" id="status" value="">
          <input type="hidden" name="id" id="id" value="">
          <button type="button" id="EditLeaveBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Submit', 'clockinator-lite' ); ?></button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Ends -->