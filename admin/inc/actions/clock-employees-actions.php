<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );

/**
 *  Action calls for Employee panel
 */
class BTCLite_EmployeePanelAction {
	
	public static function btclite_fetch_user_data() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['user_id'] ) ) {

			$user_id    = sanitize_text_field( $_POST['user_id'] );
			$author_obj = get_user_by( 'id', $user_id );

		  	$return = array(
				'status'       => 'success',
				'message'      => esc_html__( 'Data fetched!.', 'clockinator-lite' ),
				'username'     => $author_obj->user_login,
			  	'first_name'   => $author_obj->first_name,
			  	'last_name'    => $author_obj->last_name,
			  	'user_email'   => $author_obj->user_email,
			);
			wp_send_json( $return );

		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
			$return  = array(
				'status'  => $status,
				'message' => $message
			);
			wp_send_json( $return );
		}
		wp_die();
	}

	public static function btclite_add_employees() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['data'] ) ) {

			$values          = isset( $_POST['data'] ) ? (array) BTCLite_Helper::btclite_sanitize_array( $_POST['data'] ) : array();
			$entry           = isset( $values['entry'] ) ? sanitize_text_field( $values['entry'] ) : '';
			$user_id         = isset( $values['user_id'] ) ? sanitize_text_field( $values['user_id'] ) : '';
			$user_name       = isset( $values['username'] ) ? sanitize_text_field( $values['username'] ) : '';
			$first_name      = isset( $values['firstname'] ) ? sanitize_text_field( $values['firstname'] ) : '';
			$last_name       = isset( $values['lastname'] ) ? sanitize_text_field( $values['lastname'] ) : '';
			$user_email      = isset( $values['email'] ) ? sanitize_text_field( $values['email'] ) : '';
			$dob             = isset( $values['dob'] ) ? sanitize_text_field( $values['dob'] ) : '';
			$gender          = isset( $values['gender'] ) ? sanitize_text_field( $values['gender'] ) : '';
			$department      = isset( $values['department'] ) ? sanitize_text_field( $values['department'] ) : '';
			$designation     = isset( $values['designation'] ) ? sanitize_text_field( $values['designation'] ) : '';
			$salary          = isset( $values['salary'] ) ? sanitize_text_field( $values['salary'] ) : '';
			$date_of_join    = isset( $values['date_of_join'] ) ? sanitize_text_field( $values['date_of_join'] ) : '';
			$phone           = isset( $values['phone'] ) ? sanitize_text_field( $values['phone'] ) : '';
			$facebook_id     = isset( $values['facebook_id'] ) ? sanitize_text_field( $values['facebook_id'] ) : '';
			$skype_id        = isset( $values['skype_id'] ) ? sanitize_text_field( $values['skype_id'] ) : '';
			$profile_pic     = isset( $values['profile_pic'] ) ? sanitize_text_field( $values['profile_pic'] ) : '';
			$address         = isset( $values['address'] ) ? sanitize_text_field( $values['address'] ) : '';
			$role            = isset( $values['role'] ) ? sanitize_text_field( $values['role'] ) : '';
			$user_status     = isset( $values['status'] ) ? sanitize_text_field( $values['status'] ) : '';
			$location        = isset( $values['location'] ) ? sanitize_text_field( $values['location'] ) : '';
			$Holder_name     = isset( $values['Holder_name'] ) ? sanitize_text_field( $values['Holder_name'] ) : '';
			$Bank_name       = isset( $values['Bank_name'] ) ? sanitize_text_field( $values['Bank_name'] ) : '';
			$Account_no      = isset( $values['Account_no'] ) ? sanitize_text_field( $values['Account_no'] ) : '';
			$ifsc_code       = isset( $values['ifsc_code'] ) ? sanitize_text_field( $values['ifsc_code'] ) : '';
			$branch_location = isset( $values['branch_location'] ) ? sanitize_text_field( $values['branch_location'] ) : '';
			$tax_payer_id    = isset( $values['tax_payer_id'] ) ? sanitize_text_field( $values['tax_payer_id'] ) : '';
			$shift           = isset( $values['shift'] ) ? sanitize_text_field( $values['shift'] ) : '';
			$user_paswd      = isset( $values['user_paswd'] ) ? sanitize_text_field( $values['user_paswd'] ) : '';
			$repeat_paswd    = isset( $values['repeat_paswd'] ) ? sanitize_text_field( $values['repeat_paswd'] ) : '';
			$status          = '';
			
			if ( $entry == 'new' ) {

				if ( empty ( $user_paswd ) ) {
					$message = esc_html__( 'Please set password.', 'clockinator-lite' );
					$status  = 'error';
				}

				if ( empty ( $repeat_paswd ) ) {
					$message = esc_html__( 'Please enter same password in Repeat password field.', 'clockinator-lite' );
					$status  = 'error';
				}

				if ( ! empty ( $user_paswd ) && empty ( ! $repeat_paswd ) ) {
					if ( $user_paswd != $repeat_paswd ) {
						$message = esc_html__( 'Password didn\'t match, Please enter same password into repeat password field.', 'clockinator-lite' );
						$status  = 'error';
					}
				}

				$user_email = $values['email'];
				$user_id    = username_exists( $user_name );
 	
 				if ( isset( $status ) && $status != 'error' ) {
 					if ( ! $user_id && false == email_exists( $user_email ) ) {
					    $random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
					    $userdata        = array(
						    'user_pass'    => $user_paswd,
						    'user_login'   => $user_name,
						    'user_email'   => $user_email,
						    'display_name' => $values['name'],
						);
						$user_id         = wp_insert_user( $userdata ) ;
	 
						// On success.
						if ( ! is_wp_error( $user_id ) ) {
						    $message     = esc_html__( 'User created successfully.', 'clockinator-lite' );
						    $status      = 'success';
							$subject     = esc_html__( 'New Account Login Details', 'clockinator-lite' );
							$headers     = array( 'Content-Type: text/html; charset=UTF-8' );
							$messagee    = '<h3>'.esc_html__( 'Your account new created on', 'clockinator-lite' ). ' '. get_bloginfo() .'</h3><p>
											'.esc_html__( 'Username:- ', 'clockinator-lite' ). ' '.$user_name.' </p><p> '
											.esc_html__( 'Password:- ', 'clockinator-lite' ). ' '.$user_paswd. '</p>';
							$enquerysend = wp_mail( $user_email, $subject, wp_kses_post( $messagee ), $headers );
						}

					} else {
					    $message = esc_html__( 'User already exists. Please enter different email.', 'clockinator-lite' );
					    $status  = 'error';
					}
 				}

				$author_obj   = get_user_by( 'id', $user_id );
				$username     = $author_obj->user_login;
			  	$first_name   = $author_obj->first_name;
			  	$last_name    = $author_obj->last_name;
			  	$user_email   = $author_obj->user_email;
			  	$user_nice    = $author_obj->user_nicename;
			  	$display_name = $author_obj->display_name;

			} elseif ( $values['entry'] == 'exist' ) {
				$user_id      = $values['user_id'];
				$author_obj   = get_user_by( 'id', $user_id );
				$username     = $author_obj->user_login;
			  	$first_name   = $author_obj->first_name;
			  	$last_name    = $author_obj->last_name;
			  	$user_email   = $author_obj->user_email;
			  	$user_nice    = $author_obj->user_nicename;
			  	$display_name = $author_obj->display_name;
			  	$status       = 'success';
			}

			if ( isset( $status ) && ! empty( $status ) && $status == 'success' ) {
				$extra = array(
					'address'     => $values['address'],
					'skype_id'    => $values['skype_id'],
					'facebook_id' => $values['facebook_id'],
					'phone' 	  => $values['phone'],
					'dob'         => $values['dob'],
					'doj'         => $values['date_of_join'],
					'gender'      => $values['grnder'],
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
					'name'          => $values['name'],
					'first_name'    => $first_name,
					'last_name'     => $last_name,
					'user_login'    => $username,
					'user_nicename' => $user_nice,
					'user_email'    => $user_email,
					'display_name'  => $display_name,
					'shift_id'      => $shift,
					'department_id' => $values['department'],
					'designation'   => $values['designation'],
					'salary'        => '',
					'leaves'        => '',
					'role'          => $values['role'],
					'picture'       => $values['profile_pic'],
					'extra'         => serialize( $extra ),
					'bank'          => serialize( $bank ),
					'status'        => $values['status'],
				);

				if ( ! empty ( $values['name'] ) ) {
					$name = $values['name'];
				} else {
					$name = $first_name. ' ' .$last_name;
				}

				$table_name = 'btcl_employees';
				$query      = BTCLite_Helper::btclite_insert_intoDB( $table_name, $data );
				if ( $query == true ) {
					$message = esc_html__( 'Data Insert Successfully.', 'clockinator-lite' );
					$status  = 'success';
				} else {
					$message = esc_html__( 'Data Not Insert Successfully.', 'clockinator-lite' );
					$status  = 'error';
				}
			} else {
				$status  = 'error';
				$return = array(
					'status'  => $status,
					'message' => $message
				);
				wp_send_json( $return );
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

	public static function btclite_edit_employees() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['id'] ) && ! empty ( $_POST['table'] ) ) {
			global $wpdb;
			$id         = sanitize_text_field( $_POST['id'] );
			$table      = sanitize_text_field( $_POST['table'] );
			$table_name = esc_sql( $wpdb->base_prefix . "" .$table );
			$data       = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $id ) );
			$status     = 'success';
			$message    = esc_html__( 'Data fetched!.', 'clockinator-lite' );
			$extra      = unserialize( BTCLite_Helper::btclite_verify_value( $data->extra ) );
			$bank       = unserialize( BTCLite_Helper::btclite_verify_value( $data->bank ) );
			$inputs     = array(
				'#name',
				'#email',
				'#dob',
				'gender',
				'#department',
				'#designation',
				'#shift',
				'#date_of_join',
				'#phone',
				'#facebook_id',
				'#skype_id',
				'#profile_pic',
				'#address',
				'#role',
				'#status',
				'#Holder_name',
				'#Bank_name',
				'#Account_no',
				'#ifsc_code',
				'#branch_location',
				'#tax_payer_id',
				'#username',
				'#id',
			);
			$values     = array(
				$data->name,
				$data->user_email,
				$extra['dob'],
				$extra['gender'],
				$data->department_id,
				$data->designation,
				$data->shift_id,
				$extra['doj'],
				$extra['phone'],
				$extra['facebook_id'],
				$extra['skype_id'],
				$data->picture,
				$extra['address'],
				$data->role,
				$data->status,
				$bank['holder_name'],
				$bank['bank_name'],
				$bank['account_no'],
				$bank['ifsc_code'],
				$bank['branch_loc'],
				$bank['tax_id'],
				$data->user_login,
				$data->id,
			);

		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
			$inputs  = '';
			$values  = '';
		}
		$return = array(
			'status'  => $status,
			'message' => $message,
			'inputs'  => $inputs,
			'values'  => $values,
		);
		wp_send_json( $return );
		wp_die();
	}

	public static function btclite_update_employees() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['data'] ) ) {
			$values  = isset( $_POST['data'] ) ? (array) BTCLite_Helper::btclite_sanitize_array( $_POST['data'] ) : array();
			$extra  = array(
				'address'     => $values['address'],
				'skype_id'    => $values['skype_id'],
				'facebook_id' => $values['facebook_id'],
				'phone' 	  => $values['phone'],
				'dob'         => $values['dob'],
				'doj'         => $values['date_of_join'],
				'gender'      => $values['gender'],
			);
			$bank  = array(
				'holder_name' => $values['Holder_name'],
				'bank_name'   => $values['Bank_name'],
				'account_no'  => $values['Account_no'],
				'ifsc_code'   => $values['ifsc_code'],
				'branch_loc'  => $values['branch_location'],
				'tax_id'      => $values['tax_payer_id'],
			);
			$data  = array(
				'name'          => $values['name'],
				'shift_id'      => $values['shift'],
				'department_id' => $values['department'],
				'designation'   => $values['designation'],
				'salary'        => '',
				'leaves'        => '',
				'role'          => $values['role'],
				'picture'       => $values['profile_pic'],
				'extra'         => serialize( $extra ),
				'bank'          => serialize( $bank ),
				'status'        => $values['status'],
			);

			$id    = $values['id'];
			$where = array(
				'id' => $id
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

	public static function btclite_delete_employees() {
		if ( ! empty ( $_POST['id'] ) && ! empty ( $_POST['table'] ) ) {
			global $wpdb;
			$id         = sanitize_text_field( $_POST['id'] );
			$table      = sanitize_text_field( $_POST['table'] );
			$data       = array( 'id' => $id );
			$query      = BTCLite_Helper::btclite_delete_intoDB( $table, $data );

			if ( $query == true ) {
				$message = esc_html__( 'Data deleted successfully.', 'clockinator-lite' );
				$status  = 'success';
			} else {
				$message = esc_html__( 'Data not deleted successfully.', 'clockinator-lite' );
				$status  = 'error';
			}
		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
		}
		$return = array(
			'status'  => $status,
			'message' => $message,
		);
		wp_send_json( $return );
		wp_die();
	}
}