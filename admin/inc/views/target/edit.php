<?php
defined('ABSPATH') or wp_die();
$row_id = sanitize_text_field( $_GET['row_id'] );
$target = BTCLite_Helper::btclite_target_info( $row_id );
?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  	<div class="main-panel">
    	<div class="content-wrapper">
      		<div class="row">
        		<div class="col-12 grid-margin">
          			<div class="card">
			            <div class="card-body">
			            	<h5 class="text-dark font-weight-bold mb-10"><?php esc_html_e( 'Edit Target Details:', 'clockinator-lite' ); ?></h5>
			            	<br>
			            	<br>
			            	<form class="form fv-plugins-bootstrap fv-plugins-framework" id="EditTargetsForm" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
                                <?php $nonce = wp_create_nonce( 'btcl_edit_targets' ); ?>
                                <input type="hidden" name="btcl_edit_targets_nounce" value="<?php echo esc_attr( $nonce ); ?>">
                                <input type="hidden" name="action" value="btcl_edit_targets">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-2 col-lg-2 col-form-label"><?php esc_html_e( 'Title', 'clockinator-lite' ); ?></label>
                                            <div class="col-lg-9 col-xl-9">
                                                <input class="form-control form-control-solid form-control-lg" name="title" type="title" placeholder="<?php esc_attr_e( 'Enter title', 'clockinator-lite' ); ?>" value="<?php echo esc_attr( BTCLite_Helper::btclite_value_check( $target->title ) ); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                    	<div class="form-group row fv-plugins-icon-container">
	                                    	<label class="col-xl-2 col-lg-2 col-form-label"><?php esc_html_e( 'Start', 'clockinator-lite' ); ?></label>
	                                    	<div class="col-lg-9 col-xl-9">
	                                    		<div class="input-group date datepicker">
									                <input type="text" class="form-control" name="fromm" id="fromm" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'clockinator-lite' ); ?>" value="<?php echo esc_attr( BTCLite_Helper::btclite_value_check( $target->fromm ) ); ?>">
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
                                            <label class="col-xl-2 col-lg-2 col-form-label"><?php esc_html_e( 'Description', 'clockinator-lite' ); ?></label>
                                            <div class="col-lg-9 col-xl-9">
                                                <textarea class="form-control form-control-solid form-control-lg" rows="5" name="description">
                                                	<?php echo esc_html( BTCLite_Helper::btclite_value_check( $target->description ) ); ?>
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                    	<div class="form-group row fv-plugins-icon-container">
	                                    	<label class="col-xl-2 col-lg-2 col-form-label"><?php esc_html_e( 'End', 'clockinator-lite' ); ?></label>
	                                    	<div class="col-lg-9 col-xl-9">
	                                    		<div class="input-group date datepicker">
									                <input type="text" class="form-control" name="too" id="too" placeholder="<?php esc_html_e( 'YYYY-MM-DD', 'clockinator-lite' ); ?>" value="<?php echo esc_attr( BTCLite_Helper::btclite_value_check( $target->too ) ); ?>">
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
                                			<label class="col-xl-2 col-lg-2 col-form-label"><?php esc_html_e( 'Employee', 'clockinator-lite' ); ?></label>
                                			<div class="col-lg-9 col-xl-9">
                                				<?php $clients_list = BTCLite_Helper::btclite_get_employees(); ?>
                                                <select class="form-control form-control-lg form-control-solid selectpicker" data-live-search="true" name="user_id">
                                                    <option value=""><?php esc_html_e( 'Select Employee...', 'clockinator-lite' ); ?></option>
                                                    <?php if ( ! empty( $clients_list ) )  { 
                                                        foreach ( $clients_list as $key => $client ) {
                                                    ?>
                                                       <option value="<?php echo esc_attr( $client->user_id ); ?>" <?php selected( $target->user_id, $client->user_id ) ?>>
                                                           <?php echo esc_html( $client->name ); ?>
                                                       </option>
                                                    <?php } } ?>
                                                </select>
                                			</div>
                                		</div>
                                	</div>
                                	<div class="col-6">
                                		<div class="form-group row fv-plugins-icon-container">
                                			<label class="col-xl-2 col-lg-2 col-form-label"><?php esc_html_e( 'Target', 'clockinator-lite' ); ?></label>
                                			<div class="col-lg-9 col-xl-9">
                                                <input class="form-control form-control-solid form-control-lg" name="target" type="target" placeholder="<?php esc_attr_e( 'Enter just target value Like:- 2000', 'clockinator-lite' ); ?>" value="<?php echo esc_attr( BTCLite_Helper::btclite_value_check( $target->target ) ); ?>">
                                            </div>
                                		</div>
                                	</div>
                                	<div class="col-6">
                                		<div class="form-group row fv-plugins-icon-container">
                                			<label class="col-xl-2 col-lg-2 col-form-label"><?php esc_html_e( 'Status', 'clockinator-lite' ); ?></label>
                                			<div class="col-lg-9 col-xl-9">
                                                <select class="form-control form-control-lg form-control-solid" name="status">
                                                	<option value="Initiated" <?php selected( $target->status, 'Initiated' ) ?>><?php esc_html_e( 'Initiated', 'clockinator-lite' ); ?></option>
                                                	<option value="Completed" <?php selected( $target->status, 'Completed' ) ?>><?php esc_html_e( 'Completed', 'clockinator-lite' ); ?></option>
                                                </select>
                                            </div>
                                		</div>
                                	</div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo esc_attr( $row_id ); ?>">
                                <div class="row">
                                	<div class="col-12">
                                		<button type="submit" id="EditTargetsBtn" class="btn btn-primary mr-2">
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