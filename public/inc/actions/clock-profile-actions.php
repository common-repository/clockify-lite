<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );

/**
 * Action calls to save profile
 */
class BTCLite_SaveProfileAction{
	
	public static function btclite_edit_save_profile() {
		check_ajax_referer( 'front_ajax_nonce', 'nounce' );

        if ( ! empty ( $_POST['data'] ) ) {
            
			global $wpdb;
			$values  = isset( $_POST['data'] ) ? (array) BTCLite_Helper::btclite_sanitize_array( $_POST['data'] ) : array();
			$table_name     = esc_sql( $wpdb->base_prefix . "btcl_employees" );
			$user_id        = $values['user_id'];
			$row_id         = $values['row_id'];
			$employer_data  = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE user_id = %d", $user_id ) );
			$employer_extra = unserialize( BTCLite_Helper::btclite_verify_value( $employer_data->extra ) );

			$extra = array(
				'address'     => $values['address'],
				'skype_id'    => $values['skype_id'],
				'facebook_id' => $values['facebook_id'],
				'phone' 	  => $values['phone'],
				'dob'         => $values['dob'],
				'doj'         => $employer_extra['doj'],
				'gender'      => $values['gender'],
			);
			$bank = array(
				'holder_name' => $values['Holder_name'],
				'bank_name'   => $values['Bank_name'],
				'account_no'  => $values['Account_no'],
				'ifsc_code'   => $values['ifsc_code'],
				'branch_loc'  => $values['branch_location'],
				'tax_id'      => $values['tax_payer_id'],
			);
			$data = array(
				'user_id'       => $user_id,
				'name'          => $values['first_name'].' '.$values['last_name'],
				'first_name'    => $values['first_name'],
				'last_name'     => $values['last_name'],
				'extra'         => serialize( $extra ),
				'bank'          => serialize( $bank ),
			);

			$where = array(
				'id' => $row_id
			);
			$table_name = 'btcl_employees';
			$query      = BTCLite_Helper::btclite_update_intoDB( $table_name, $data, $where );

			if ( $query == true ) {
				$message = esc_html__( 'Data updated successfully.', 'clockinator-lite' );
				$status  = 'success';
			} else {
				$message = esc_html__( 'Data not updated successfully.', 'clockinator-lite' );
				$status  = 'error';
			}

        } else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
		}
		$return = array(
			'status'  => $status,
			'message' => $message
		);
		wp_send_json( $return );
		wp_die();
    }
}