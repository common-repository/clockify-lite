<?php
defined( 'ABSPATH' ) or wp_die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );

/**
 *  Action calls for Target panel
 */
class BTCLite_TargetActions {
	public static function btclite_add_targets() {
		if ( ! wp_verify_nonce( $_REQUEST['btcl_save_targets_nounce'], 'btcl_save_targets' ) ) {
			die();
		}

		$user_id     = isset( $_POST['user_id'] ) ? sanitize_text_field( $_POST['user_id'] ) : '';
		$title       = isset( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
		$fromm       = isset( $_POST['fromm'] ) ? sanitize_text_field( $_POST['fromm'] ) : '';
		$too         = isset( $_POST['too'] ) ? sanitize_text_field( $_POST['too'] ) : '';
		$description = isset( $_POST['description'] ) ? sanitize_text_field( $_POST['description'] ) : '';
		$target      = isset( $_POST['target'] ) ? sanitize_text_field( $_POST['target'] ) : '';
		$status      = isset( $_POST['status'] ) ? sanitize_text_field( $_POST['status'] ) : '';

		/* validations */
		$message = '';
		if ( empty ( $title ) ) {
			$message = esc_html__( 'Please enter target title.', 'clockinator-lite' );
		}
		if ( empty ( $fromm ) ) {
			$message = esc_html__( 'Please select target start date.', 'clockinator-lite' );
		}
		if ( empty ( $too ) ) {
			$message = esc_html__( 'Please select target end date.', 'clockinator-lite' );
		}
		if ( empty ( $user_id ) ) {
			$message = esc_html__( 'Please select employee.', 'clockinator-lite' );
		}
		if ( empty ( $target ) ) {
			$message = esc_html__( 'Please enter target value.', 'clockinator-lite' );
		}

		if ( empty( $message ) ) {

			$data = array(
				'user_id'     => $user_id,
				'title'       => $title,
				'fromm'       => $fromm,
				'too'         => $too,
				'description' => $description,
				'target'      => $target,
				'status'      => $status,
			);
			$table_name = 'btcl_targets';
			$query      = BTCLite_Helper::btclite_insert_intoDB( $table_name, $data );
			if ( $query == true ) {
				$link = admin_url( 'admin.php?page=clockify-lite-target' );
				wp_send_json_success( array( 'message' => esc_html__( 'Target created successfully', 'clockinator-lite' ), 'url' => $link ) );
			} else {
				wp_send_json_error( array( 'message' => esc_html__( 'Target not created', 'clockinator-lite' ) ) );
			}
		}
		wp_send_json_error( array( 'message' => $message ) );
	}

	public static function btclite_edit_targets() {
		if ( ! wp_verify_nonce( $_REQUEST['btcl_edit_targets_nounce'], 'btcl_edit_targets' ) ) {
			die();
		}

		$user_id     = isset( $_POST['user_id'] ) ? sanitize_text_field( $_POST['user_id'] ) : '';
		$title       = isset( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
		$fromm       = isset( $_POST['fromm'] ) ? sanitize_text_field( $_POST['fromm'] ) : '';
		$too         = isset( $_POST['too'] ) ? sanitize_text_field( $_POST['too'] ) : '';
		$description = isset( $_POST['description'] ) ? sanitize_text_field( $_POST['description'] ) : '';
		$target      = isset( $_POST['target'] ) ? sanitize_text_field( $_POST['target'] ) : '';
		$status      = isset( $_POST['status'] ) ? sanitize_text_field( $_POST['status'] ) : '';
		$id          = isset( $_POST['id'] ) ? sanitize_text_field( $_POST['id'] ) : '';

		/* validations */
		$message = '';
		if ( empty ( $title ) ) {
			$message = esc_html__( 'Please enter target title.', 'clockinator-lite' );
		}
		if ( empty ( $fromm ) ) {
			$message = esc_html__( 'Please select target start date.', 'clockinator-lite' );
		}
		if ( empty ( $too ) ) {
			$message = esc_html__( 'Please select target end date.', 'clockinator-lite' );
		}
		if ( empty ( $user_id ) ) {
			$message = esc_html__( 'Please select employee.', 'clockinator-lite' );
		}
		if ( empty ( $target ) ) {
			$message = esc_html__( 'Please enter target value.', 'clockinator-lite' );
		}

		if ( empty( $message ) ) {

			$data = array(
				'user_id'     => $user_id,
				'title'       => $title,
				'fromm'       => $fromm,
				'too'         => $too,
				'description' => $description,
				'target'      => $target,
				'status'      => $status,
			);
			$where = array(
				'id' => $id
			);
			$table_name = 'btcl_targets';
			$query      = BTCLite_Helper::btclite_update_intoDB( $table_name, $data, $where );
			if ( $query == true ) {
				$link = admin_url( 'admin.php?page=clockify-lite-target' );
				wp_send_json_success( array( 'message' => esc_html__( 'Target edited successfully', 'clockinator-lite' ), 'url' => '' ) );
			} else {
				wp_send_json_error( array( 'message' => esc_html__( 'Target not edited', 'clockinator-lite' ) ) );
			}
		}
		wp_send_json_error( array( 'message' => $message ) );
	}

	/* Delete Task details */
	public static function btclite_delete_task_details() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['table'] ) && ! empty ( $_POST['id'] ) ) {
			$table = sanitize_text_field( $_POST['table'] );
			$id    = sanitize_text_field( $_POST['id'] );
			$pid   = sanitize_text_field( $_POST['pid'] );
			$data  = array( 'id' => $id );
			$query = BTCLite_Helper::btclite_delete_intoDB( $table, $data );

			if ( $query == true ) {
				$message = esc_html__( 'Data deleted successfully.', 'clockinator-lite' );
				$status  = 'success';
			} else {
				$message = esc_html__( 'Data not deleted successfully.', 'clockinator-lite' );
				$status  = 'error';
				$url     = '';
			}
		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockinator-lite' );
			$status  = 'error';
			$url     = '';
		}
		$return = array(
			'status'  => $status,
			'message' => $message,
			'url'     => $url
		);
		wp_send_json( $return );
		wp_die();
	}

	public static function btclite_add_target_records() {
		if ( ! wp_verify_nonce( $_REQUEST['btcl_add_trecords_nounce'], 'btcl_add_trecords' ) ) {
			die();
		}

		$date   = isset( $_POST['date'] ) ? sanitize_text_field( $_POST['date'] ) : '';
		$target = isset( $_POST['target'] ) ? sanitize_text_field( $_POST['target'] ) : '';
		$id     = isset( $_POST['id'] ) ? sanitize_text_field( $_POST['id'] ) : '';

		/* validations */
		$message = '';
		if ( empty ( $date ) ) {
			$message = esc_html__( 'Please select date for record.', 'clockinator-lite' );
		}
		if ( empty ( $target ) ) {
			$message = esc_html__( 'Please enter target record value.', 'clockinator-lite' );
		}

		if ( empty( $message ) ) {

			$targetd   = BTCLite_Helper::btclite_target_info( $id );
			$feedback  = $targetd->feedback;

			if ( empty ( $feedback ) ) {
				$feedback = array();
			} else {
				$feedback = unserialize( $targetd->feedback );
			}
			
			$feed_data = array(
				'date'   => $date,
				'target' => $target,
			);
			array_push( $feedback, $feed_data );
			
			$data = array(
				'feedback' => serialize( $feedback ),
			);
			$where = array(
				'id' => $id
			);
			$table_name = 'btcl_targets';
			$query      = BTCLite_Helper::btclite_update_intoDB( $table_name, $data, $where );
			if ( $query == true ) {
				$link = admin_url( 'admin.php?page=clockify-lite-target' );
				$url = add_query_arg( 
                    	array( 
                    		'action'  => 'view', 
                    		'row_id'  => $id 
                    	), 
                    	$link 
                );
				wp_send_json_success( array( 'message' => esc_html__( 'Record added successfully', 'clockinator-lite' ), 'url' => $url ) );
			} else {
				wp_send_json_error( array( 'message' => esc_html__( 'Record not added', 'clockinator-lite' ) ) );
			}
		}
		wp_send_json_error( array( 'message' => $message ) );
	}
}