<?php
defined( 'ABSPATH' ) or wp_die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );

/**
 *  Action calls for shift panel
 */
class BTCLite_ShiftPanelAction {
	
	public static function btclite_add_shifts() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['data'] ) ) {

			$values = isset( $_POST['data'] ) ? (array) $_POST['data'] : array();
			$name   = $values[0]['value'];
			$start  = $values[1]['value'];
			$end    = $values[2]['value'];
			$late   = $values[3]['value'];
			$status = $values[4]['value'];

			$data = array(
				'name'   => $name,
				'start'  => $start,
				'end'    => $end,
				'late'   => $late,
				'status' => $status,
			);

			$table_name = 'btcl_shifts';

			$query = BTCLite_Helper::btclite_insert_intoDB( $table_name, $data );
			if ( $query == true ) {
				$message = esc_html__( 'Data Insert Successfully.', 'clockinator-lite' );
				$status  = 'success';
			} else {
				$message = esc_html__( 'Data Not Insert Successfully.', 'clockinator-lite' );
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

	public static function btclite_edit_shifts() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['id'] ) && ! empty ( $_POST['table'] ) ) {
			global $wpdb;
			$id         = sanitize_text_field( $_POST['id'] );
			$table      = sanitize_text_field( $_POST['table'] );
			$table_name = $wpdb->base_prefix . "" .$table;
			$data       = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $id ) );
			$status     = 'success';
			$message    = esc_html__( 'Data fetched!.', 'clockinator-lite' );
			$inputs     = array(
				'#shift_name',
				'#shift_start',
				'#shift_end',
				'#late_time',
				'#status',
				'#id'
			);
			$values     = array(
				$data->name,
				$data->start,
				$data->end,
				$data->late,
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

	public static function btclite_update_shifts() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['data'] ) ) {
			$values = isset( $_POST['data'] ) ? (array) $_POST['data'] : array();
			$name   = $values[0]['value'];
			$start  = $values[1]['value'];
			$end    = $values[2]['value'];
			$late   = $values[3]['value'];
			$status = $values[4]['value'];
			$id     = $values[5]['value'];
			$data   = array(
				'name'   => $name,
				'start'  => $start,
				'end'    => $end,
				'late'   => $late,
				'status' => $status,
			);
			$where  = array(
				'id' => $id
			);
			$table_name = 'btcl_shifts';
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

	public static function btclite_delete_shifts() {
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