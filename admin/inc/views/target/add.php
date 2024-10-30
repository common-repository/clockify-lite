<?php
defined( 'ABSPATH' ) or wp_die();
$user_id = '';
if ( isset( $_GET['user_id'] ) ) {
  $user_id = sanitize_text_field( $_GET['user_id'] );
}
?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  	<div class="main-panel">
    	<div class="content-wrapper">
      		<div class="row">
        		<div class="col-12 grid-margin">
          			<div class="card">
			            <div class="card-body">
			            	<h5 class="text-dark font-weight-bold mb-10"><?php esc_html_e( 'Target Details:', 'clockify' ); ?></h5>
			            	<br>
			            	<br>
			            	<form class="form fv-plugins-bootstrap fv-plugins-framework" id="AddTargetsForm" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
					          <?php $nonce = wp_create_nonce( 'btcl_save_targets' ); ?>
					          <input type="hidden" name="btcl_save_targets_nounce" value="<?php echo esc_attr( $nonce ); ?>">
					          <input type="hidden" name="action" value="btcl_save_targets">

					          <div class="row">
                      <div class="col-6">
                        <div class="form-group row fv-plugins-icon-container">
						              <label class="col-sm-3 col-form-label"><?php esc_html_e( 'Title', 'clockinator-lite' ); ?></label>
						              <div class="col-sm-9">
						                  <input class="form-control form-control-solid form-control-lg" name="title" type="title" placeholder="<?php esc_attr_e( 'Enter title', 'clockinator-lite' ); ?>">
						              </div>
						          	</div>
						          </div>
						          <div class="col-6">
							        	<div class="form-group row fv-plugins-icon-container">
							          	<label class="col-sm-3 col-form-label"><?php esc_html_e( 'Start', 'clockinator-lite' ); ?></label>
							          	<div class="col-sm-9">
							          		<div class="input-group date datepicker">
									            <input type="text" class="form-control" name="fromm" id="fromm" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'clockinator-lite' ); ?>">
									            <span class="input-group-addon input-group-append border-left">
									              <span class="fa fa-calendar input-group-text"></span>
									            </span>
									        	</div>
							          	</div>
							          </div>
							        </div>
							      </div>
							      <div class="row">
                      <div class="col-6">
							          <div class="form-group row fv-plugins-icon-container">
							              <label class="col-sm-3 col-form-label"><?php esc_html_e( 'Description', 'clockinator-lite' ); ?></label>
							              <div class="col-sm-9">
							                  <textarea class="form-control form-control-solid form-control-lg" rows="5" name="description"></textarea>
							              </div>
							          </div>
							        </div>
							        <div class="col-6">
							        	<div class="form-group row fv-plugins-icon-container">
							          	<label class="col-sm-3 col-form-label"><?php esc_html_e( 'End', 'clockinator-lite' ); ?></label>
							          	<div class="col-sm-9">
							          		<div class="input-group date datepicker">
									            <input type="text" class="form-control" name="too" id="too" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'clockinator-lite' ); ?>">
									            <span class="input-group-addon input-group-append border-left">
									              <span class="fa fa-calendar input-group-text"></span>
									            </span>
									        	</div>
							          	</div>
							          </div>
							        </div>
							      </div>
							      <div class="row">
                      <div class="col-6">
							      		<div class="form-group row fv-plugins-icon-container">
							      			<label class="col-sm-3 col-form-label"><?php esc_html_e( 'Employee', 'clockinator-lite' ); ?></label>
							      			<div class="col-sm-9">
							      				<?php $clients_list = BTCLite_Helper::btclite_get_employees(); ?>
							              <select class="form-control form-control-lg form-control-solid selectpicker" data-live-search="true" name="user_id">
							                  <option value=""><?php esc_html_e( 'Select Employee...', 'clockinator-lite' ); ?></option>
							                  <?php if ( ! empty( $clients_list ) )  { 
							                      foreach ( $clients_list as $key => $client ) {
							                  ?>
							                     <option value="<?php echo esc_attr( $client->user_id ); ?>" <?php selected( $user_id, $client->user_id ); ?>>
							                         <?php echo esc_html( $client->name ); ?>
							                     </option>
							                  <?php } } ?>
							              </select>
							      			</div>
							      		</div>
							      	</div>
							      	<div class="col-6">
							      		<div class="form-group row fv-plugins-icon-container">
							      			<label class="col-sm-3 col-form-label"><?php esc_html_e( 'Target', 'clockinator-lite' ); ?></label>
							      			<div class="col-sm-9">
							              <input class="form-control form-control-solid form-control-lg" name="target" type="target" placeholder="<?php esc_attr_e( 'Enter just target value Like:- 2000', 'clockinator-lite' ); ?>">
							            </div>
							      		</div>
							      	</div>
							      </div>
							      <div class="row">
                      <div class="col-6">
							      		<div class="form-group row fv-plugins-icon-container">
							      			<label class="col-sm-3 col-form-label"><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></label>
							      			<div class="col-sm-9">
							                <select class="form-control form-control-lg form-control-solid" name="status">
							                	<option value="Initiated"><?php esc_html_e( 'Initiated', 'clockinator-lite' ); ?></option>
							                	<option value="Completed"><?php esc_html_e( 'Completed', 'clockinator-lite' ); ?></option>
							                </select>
							            </div>
							      		</div>
							      	</div>
							      </div>
					          <div class="row">
					          	<div class="col-12">
					          		<button type="submit" id="AddTargetsBtn" class="btn btn-primary mr-2">
					          			<?php esc_html_e( 'Submit', 'clockinator-lite' ); ?>
					          		</button>
					          	</div>
					          </div>
					        </form>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</div>