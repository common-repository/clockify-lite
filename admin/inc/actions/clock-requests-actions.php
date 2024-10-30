<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );

/**
 *  Action calls for Leaves panel
 */
class BTCLite_RequestPanelAction {
	
	public static function btclite_edit_requests() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['id'] ) && ! empty ( $_POST['table'] ) ) {
			global $wpdb;
			$id         = sanitize_text_field( $_POST['id'] );
			$table      = sanitize_text_field( $_POST['table'] );
			$table_name = esc_sql( $wpdb->base_prefix . "" .$table );
			$data       = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $id ) );
			$status     = 'success';
			$message    = esc_html__( 'Data fetched!.', 'clockinator-lite' );
			$inputs     = array(
				'#subject',
				'#reason',
				'#from',
				'#to',
				'#user_id',
				'#status',
				'#id',
			);
			$values     = array(
				$data->name,
				$data->description,
				$data->start,
				$data->end,
				$data->user_id,
				$data->status,
				$data->id
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

	public static function btclite_update_requests() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['data'] ) ) {
			$values  = isset( $_POST['data'] ) ? (array) BTCLite_Helper::btclite_sanitize_array( $_POST['data'] ) : array();
			$name    = $values['subject'];
			$descr   = $values['reason'];
			$start   = $values['from'];
			$end     = $values['to'];
			$user_id = $values['user_id'];
			$status  = $values['status'];
			$id      = $values['id'];

			$date1  = date_create( $start );
			$date2  = date_create( $end );
			$diff   = date_diff( $date1, $date2 );
			$leaves = $diff->format( "%a" );	
			$leaves = $leaves + 1;

			$data = array(
				'name'        => $name,
				'description' => $descr,
				'date'        => date( 'Y-m-d' ),
				'start'       => $start,
				'end'         => $end,
				'user_id'     => $user_id,
				'user_name'   => BTCLite_Helper::btclite_get_current_user_data( $user_id, 'fullname' ),
				'days'        => $leaves,
				'status'      => $status,
			);

			$where  = array(
				'id' => $id
			);
			$table_name = 'btcl_leaves';
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

	public static function btclite_delete_entries() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['table'] ) && ! empty ( $_POST['id'] ) ) {
			$table = sanitize_text_field( $_POST['table'] );
			$id    = sanitize_text_field( $_POST['id'] );
			$pid   = sanitize_text_field( $_POST['pid'] );
			$data  = array( 'id' => $id );
			$query = BTCLite_Helper::btclite_delete_intoDB( $table, $data );

			if ( $query == true ) {

				if ( $table == 'btcl_projects' ) {
					$tasks = BTCLite_Helper::btclite_project_tasks( $id );
					foreach ( $tasks as $tkey => $tvalue ) {
						$t_table = 'btcl_tasks';
						$query   = BTCLite_Helper::btclite_delete_intoDB( $t_table, array( 'id' => $tvalue->id ) );
						$query2  = BTCLite_Helper::btclite_delete_intoDB( 'btcl_comments', array( 'project_id' => $id, 'type' => 'btcl_tasks', 'type_id' => $tvalue->id ) );
					}
					$url = esc_url( admin_url( 'admin.php?page=clockify-lite-projects' ) );
				} elseif ( $table == 'btcl_tasks' ) {
					$query2 = BTCLite_Helper::btclite_delete_intoDB( 'btcl_comments', array( 'project_id' => $pid, 'type' => 'btcl_tasks', 'type_id' => $id ) );
					$url    = add_query_arg( array( 'action' => 'view', 'row_id' => $pid ), admin_url( 'admin.php?page=clockify-lite-projects' ) );
				} elseif ( $table == 'btcl_comments' ) {
					$url = '';
				}

				$message = esc_html__( 'Data deleted successfully.', 'clockify' );
				$status  = 'success';
			} else {
				$message = esc_html__( 'Data not deleted successfully.', 'clockify' );
				$status  = 'error';
				$url     = '';
			}
		} else {
			$message = esc_html__( 'Something went wrong!.', 'clockify' );
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
}