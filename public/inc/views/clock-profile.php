<?php
global $wpdb;
$table_name     = esc_sql( $wpdb->base_prefix . "btcl_employees" );
$user_id        = get_current_user_id();
$employer_data  = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE user_id = %d", $user_id ) );
$employer_extra = unserialize( BTCLite_Helper::btclite_verify_value( $employer_data->extra ) );
$employer_bank  = unserialize( BTCLite_Helper::btclite_verify_value( $employer_data->bank ) );
$shift_id       = $employer_data->shift_id;
$department_id  = $employer_data->department_id;

$btcl_shifts    = esc_sql( $wpdb->base_prefix . "btcl_departments" );
$shifts_data    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_shifts WHERE id = %d", $department_id ) );
$department_id  = $shifts_data->name;

$btcl_strings   = get_option( 'btcl_string_translation' );
$your_profile   = isset( $btcl_strings['your_profile'] ) ? sanitize_text_field( $btcl_strings['your_profile'] ) : esc_html__( 'Your profile' );

?>
<h4 class="card-title"><?php echo esc_html( $your_profile ); ?></h4>
<div class="profile-wrapper">
	<form class="forms-sample" method="post" id="ProfileForm" autocomplete="off">
        <input value="<?php echo esc_attr( $user_id ); ?>" name="user_id" type="hidden">
        <input value="<?php echo esc_attr( $employer_data->id ); ?>" name="row_id" type="hidden">
		<div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="username" class="col-sm-4 col-form-label"><?php esc_html_e( 'Username', 'clockinator-lite' ); ?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="username" id="username" disabled="disabled" readonly="readonly" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_data->user_login ) ); ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="first_name" class="col-sm-4 col-form-label"><?php esc_html_e( 'First name', 'clockinator-lite' ); ?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_data->first_name ) ); ?>">
                    </div>
                </div>
            </div>
        </div>
		<div class="row">
        	<div class="col-md-6">
	          	<div class="form-group row">
		            <label for="last_name" class="col-sm-4 col-form-label"><?php esc_html_e( 'Last name', 'clockinator-lite' ); ?></label>
		            <div class="col-sm-8">
			            <input type="text" class="form-control" name="last_name" id="last_name"  value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_data->last_name ) ); ?>">
		            </div>
		        </div>
		    </div>
		    <div class="col-md-6">
	          	<div class="form-group row">
		            <label for="email" class="col-sm-4 col-form-label"><?php esc_html_e( 'Email', 'clockinator-lite' ); ?></label>
		            <div class="col-sm-8">
			            <input type="email" class="form-control" name="email" id="email" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_data->user_email ) ); ?>" placeholder="<?php esc_html_e( 'Your email', 'clockinator-lite' ); ?>" disabled="disabled" readonly="readonly">
		            </div>
		        </div>
		    </div>
      	</div>
      	<div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="dob" class="col-sm-4 col-form-label"><?php esc_html_e( 'Date of Birth', 'clockinator-lite' ); ?></label>
                    <div class="col-sm-8">
                        <div class="input-group date datepicker">
                            <input type="text" class="form-control" name="dob" id="dob" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_extra['dob'] ) ); ?>">
                            <span class="input-group-addon input-group-append border-left">
                                <span class="fa fa-calendar input-group-text"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="gender" class="col-sm-4 col-form-label"><?php esc_html_e( 'Gender', 'clockinator-lite' ); ?></label>
                    <div class="col-sm-4">
                        <div class="form-check">
                            <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="gender" id="gender1" value="male" checked="">
                            <?php esc_html_e( 'Male', 'clockinator-lite' ); ?>
                            <i class="input-helper"></i></label>
                        </div>
                    </div>
                    <div class="col-sm-4">
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
		            <label for="deprtment" class="col-sm-4 col-form-label"><?php esc_html_e( 'Department', 'clockinator-lite' ); ?></label>
		            <div class="col-sm-8">
			            <input type="text" class="form-control" name="deprtment" id="deprtment" disabled="disabled" readonly="readonly" value="<?php echo esc_html( $department_id ); ?>">
		            </div>
		        </div>
		    </div>
		    <div class="col-md-6">
	          	<div class="form-group row">
		            <label for="designation" class="col-sm-4 col-form-label"><?php esc_html_e( 'Designation', 'clockinator-lite' ); ?></label>
		            <div class="col-sm-8">
			            <input type="text" class="form-control" name="designation" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_data->designation ) ); ?>" id="designation" disabled="disabled" readonly="readonly">
		            </div>
		        </div>
		    </div>
      	</div>
      	<div class="row">
        	<div class="col-md-6">
	          	<div class="form-group row">
		            <label for="date_if_join" class="col-sm-4 col-form-label"><?php esc_html_e( 'Company date of joining', 'clockinator-lite' ); ?></label>
		            <div class="col-sm-8">
			            <input type="text" class="form-control" name="date_if_join" id="date_if_join" disabled="disabled" readonly="readonly" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_extra['doj'] ) ); ?>">
		            </div>
		        </div>
		    </div>
		    <div class="col-md-6">
	          	<div class="form-group row">
		            <label for="phone" class="col-sm-4 col-form-label"><?php esc_html_e( 'Phone', 'clockinator-lite' ); ?></label>
		            <div class="col-sm-8">
			            <input type="number" class="form-control" name="phone" id="phone" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_extra['phone'] ) ); ?>">
		            </div>
		        </div>
		    </div>
      	</div>
      	<div class="row">
        	<div class="col-md-6">
	          	<div class="form-group row">
		            <label for="facebook_id" class="col-sm-4 col-form-label"><?php esc_html_e( 'Facebook ID', 'clockinator-lite' ); ?></label>
		            <div class="col-sm-8">
			            <input type="text" class="form-control" name="facebook_id" id="facebook_id" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_extra['facebook_id'] ) ); ?>">
		            </div>
		        </div>
		    </div>
		    <div class="col-md-6">
	          	<div class="form-group row">
		            <label for="skype_id" class="col-sm-4 col-form-label"><?php esc_html_e( 'Skype ID', 'clockinator-lite' ); ?></label>
		            <div class="col-sm-8">
			            <input type="text" class="form-control" name="skype_id" id="skype_id" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_extra['skype_id'] ) ); ?>">
		            </div>
		        </div>
		    </div>
      	</div>
      	<div class="row">
        	<div class="col-md-12">
	          	<div class="form-group row">
		            <label for="address" class="col-sm-4 col-form-label"><?php esc_html_e( 'Address', 'clockinator-lite' ); ?></label>
		            <div class="col-sm-8">
                       	<textarea class="form-control" rows="4" name="address" id="address">
                       		<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_extra['address'] ) ); ?>
                       	</textarea>
                    </div>
		        </div>
		    </div>
		</div>
		<h4 class="form-sub-heading"><?php esc_html_e( 'Bank Account Details', 'clockinator-lite' ); ?></h4>
		<div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="Holder_name" class="col-sm-4 col-form-label"><?php esc_html_e( 'Account holder name*', 'clockinator-lite' ); ?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="Holder_name" id="Holder_name" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_bank['holder_name'] ) ); ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="Bank_name" class="col-sm-4 col-form-label"><?php esc_html_e( 'Bank Name*', 'clockinator-lite' ); ?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="Bank_name" id="Bank_name" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_bank['bank_name'] ) ); ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="Account_no" class="col-sm-4 col-form-label"><?php esc_html_e( 'Account Number*', 'clockinator-lite' ); ?></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="Account_no" id="Account_no" placeholder="200xxxxxxxxxxx45" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_bank['account_no'] ) ); ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="ifsc_code" class="col-sm-4 col-form-label"><?php esc_html_e( 'Bank Identifier Code/IFSC Code*', 'clockinator-lite' ); ?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" placeholder="CHISN586YDH8" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_bank['ifsc_code'] ) ); ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="branch_location" class="col-sm-4 col-form-label"><?php esc_html_e( 'Branch Location*', 'clockinator-lite' ); ?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="branch_location" id="branch_location" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_bank['branch_loc'] ) ); ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="tax_payer_id" class="col-sm-4 col-form-label"><?php esc_html_e( 'Tax Payer Id', 'clockinator-lite' ); ?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="tax_payer_id" id="tax_payer_id" value="<?php echo esc_attr( BTCLite_Helper::btclite_verify_value( $employer_bank['tax_id'] ) ); ?>">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" id="SaveProfilrBtn" class="btn btn-primary mr-2"><?php esc_html_e( 'Save', 'clockinator-lite' ); ?></button>
	</form>
</div>