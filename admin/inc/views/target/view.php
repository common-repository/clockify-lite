<?php
defined( 'ABSPATH' ) or wp_die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );
$link = admin_url( 'admin.php?page=clockify-lite-target' );
?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
	<div class="main-panel">
  		<div class="content-wrapper">
    		<div class="row">
      			<div class="col-12 grid-margin">
        			<div class="card">
          				<div class="card-body">
            				<h4 class="card-title"><?php esc_html_e( 'Targets', 'clockinator-lite' ); ?></h4>
            				<a href="<?php echo esc_url( add_query_arg( 'action', 'add', $link ) ); ?>" class="btn btn-primary top-add-btn">
			              		<?php esc_html_e( 'Add New', 'clockify' ); ?>
			              	</a>
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
					                        <th><?php esc_html_e( 'Target', 'clockinator-lite' ); ?></th>
					                        <th><?php esc_html_e( 'Employee', 'clockinator-lite' ); ?></th>
					                        <th><?php esc_html_e( 'Time Period', 'clockinator-lite' ); ?></th>
					                        <th><?php esc_html_e( 'Target Value', 'clockinator-lite' ); ?></th>
					                        <th><?php esc_html_e( 'Reached Value', 'clockinator-lite' ); ?></th>
					                        <th><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></th>
					                        <th><?php esc_html_e( 'Actions', 'clockinator-lite' ); ?></th>
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
			                    				} else {
			                    					$s_class = 'label-light-success';
			                    				}
			                    			?>
			                    			<tr>
			                    				<td><?php echo esc_html( $s_no ); ?></td>
			                    				<td>
			                    					<a href="<?php echo esc_url( 
				                                    add_query_arg( 
					                                    array(
					                                    'action' => 'view',
					                                    'row_id' => $target->id,
					                                    ), $link ) ); ?>">
					                                    <?php echo esc_html( $target->title ); ?>
					                                </a>
				                                </td>
			                    				<td><?php echo esc_html( BTCLite_Helper::btclite_member_details( $target->user_id, 'name' ) ); ?></td>
			                    				<td>
			                    					<span class="label label-light-info label-inline label-lg">
						                              <?php echo esc_html( BTCLite_Helper::btclite_get_formated_date( $target->fromm ).' to '.BTCLite_Helper::btclite_get_formated_date( $target->too ) ); ?>
						                            </span>
			                    				</td>
			                    				<td><?php echo esc_html( $target->target ); ?></td>
			                    				<td><?php echo esc_html( BTCLite_Helper::btclite_get_target_reached_value( $target->id ) ); ?></td>
			                    				<td>
			                    					<span class="label <?php echo esc_attr( $s_class ); ?> label-inline label-lg">
			                    						<?php echo esc_html( $target->status ); ?>
			                    					</span>
			                    				</td>
			                    				<td>
			                    					<a class="btn btn-outline-primary edit-location-payslip" href="<?php echo esc_url( 
					                                    add_query_arg( 
					                                    array(
					                                    'action' => 'edit',
					                                    'row_id' => $target->id,
					                                    ), $link ) ); ?>"><i class="fas fa-pencil-alt"></i>
					                                </a>
					                                <button class="btn btn-outline-danger delete-entities" data-id="<?php echo esc_attr( $target->id ); ?>" data-table="btcl_targets">
					                                  <i class="far fa-trash-alt"></i>
					                                </button>
			                    				</td>
			                    			</tr>
			                    			<?php $s_no++; }
			                    		}
			                    	?>
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