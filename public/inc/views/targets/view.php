<h4 class="card-title"><?php echo esc_html( 'Your Assigneed Targets' ); ?></h4>
<div class="row inner-row">
	<div class="col-12">
  	<div class="table-responsive">
    		<table id="requests-listing" class="table table-striped">
              <thead>
                <tr>
                  <th><?php esc_html_e( 'S No. #', 'clockinator-lite' ); ?></th>
                  <th><?php esc_html_e( 'Target', 'clockinator-lite' ); ?></th>
                  <th><?php esc_html_e( 'Employee', 'clockinator-lite' ); ?></th>
                  <th><?php esc_html_e( 'Time Period', 'clockinator-lite' ); ?></th>
                  <th><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></th>
                  <th><?php esc_html_e( 'Progress', 'clockinator-lite' ); ?></th>
                </tr>
              </thead>
              <tbody>
            	  <?php
                  $user_id     = get_current_user_id();
                  $all_targets = BTCLite_Helper::btclite_get_targets();
                  $all_targets = array_reverse( $all_targets );
                  $s_no        = 1;
                  if ( ! empty ( $all_targets ) ) {
                    foreach ( $all_targets as $key => $target ) {
                      $user = BTCLite_Helper::btclite_get_employees_details( $target->user_id );
                      if ( $user_id == $user->user_id ) {
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
                  <td>
                    <a href="#" class="fetch-target-details" data-type="target" data-url="<?php echo esc_attr( esc_url( BTCLite_Helper::btclite_get_current_url() ) ); ?>" data-id="<?php echo esc_attr( $target->id ); ?>">
                      <?php echo esc_html( $target->title ); ?>
                    </a>
                  </td>
                  <td><?php echo esc_html( BTCLite_Helper::btclite_member_details( $target->user_id, 'name' ) ); ?></td>
                  <td>
                    <span class="label label-light-info label-inline label-lg">
                      <?php echo esc_html( BTCLite_Helper::btclite_get_formated_date( $target->fromm ).' to '.BTCLite_Helper::btclite_get_formated_date( $target->too ) ); ?>
                    </span>
                  </td>
                  <td>
                    <span class="label <?php echo esc_attr( $s_class ); ?> label-inline label-lg">
                      <?php echo esc_html( $target->status ); ?>
                    </span>
                  </td>
                  <td>
                    <span class="label label-light-info label-inline label-lg">
                      <?php echo esc_html( BTCLite_Helper::btclite_get_target_percentage( $target->id ) ); ?>%
                    </span>
                  </td>
                </tr>
                <?php $s_no++; } } } ?>
              </tbody>
          </table>
      </div>
  </div>
</div>