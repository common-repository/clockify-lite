<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );

/**
 *  Action calls for Department panel
 */
class BTCLite_DepartmentPanelAction {
	
	public static function btclite_add_departments() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['data'] ) ) {
			$values  = isset( $_POST['data'] ) ? (array) BTCLite_Helper::btclite_sanitize_array( $_POST['data'] ) : array();
			$name     = $values['name'];
			$color    = $values['color'];
			$status   = $values['status'];
			$data     = array(
				'name'   => $name,
				'color'  => $color,
				'status' => $status,
			);
			$table_name = 'btcl_departments';
			$query      = BTCLite_Helper::btclite_insert_intoDB( $table_name, $data );

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

	public static function btclite_edit_departments() {
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
				'#name',
				'#color',
				'#id',
				'#status'
			);
			$values     = array(
				$data->name,
				$data->color,
				$data->id,
				$data->status
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

	public static function btclite_update_departments() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['data'] ) ) {
			$values  = isset( $_POST['data'] ) ? (array) BTCLite_Helper::btclite_sanitize_array( $_POST['data'] ) : array();
			$name     = $values['name'];
			$color    = $values['color'];
			$status   = $values['status'];
			$col_id   = $values['id'];
			$data     = array(
				'name'   => $name,
				'color'  => $color,
				'status' => $status
			);
			$where    = array(
				'id' => $col_id
			);
			$table_name = 'btcl_departments';
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

	public static function btclite_delete_departments() {
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