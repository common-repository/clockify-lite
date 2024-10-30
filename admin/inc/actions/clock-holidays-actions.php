<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );

/**
 *  Action calls for holidays panel
 */
class BTCLite_HolidayPanelAction {
	
	public static function btclite_add_holidays() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['data'] ) ) {

			$values = isset( $_POST['data'] ) ? (array) BTCLite_Helper::btclite_sanitize_array( $_POST['data'] ) : array();
			$name   = $values['name'];
			$desc   = $values['description'];
			$start  = $values['from'];
			$end    = $values['to'];
			$status = $values['status'];

			$date1  = date_create( $start );
			$date2  = date_create( $end );
			$diff   = date_diff( $date1, $date2 );
			$leaves = $diff->format( "%a" );	
			$leaves = $leaves + 1;

			$data = array(
				'name'        => $name,
				'description' => $desc,
				'start'       => date( "Y-m-d", strtotime( $start ) ),
				'end'         => date( "Y-m-d", strtotime( $end ) ),
				'days'        => $leaves,
				'status'      => $status,
			);

			$table_name = 'btcl_holidays';

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

	public static function btclite_edit_holidays() {
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
				'#description',
				'#from',
				'#to',
				'#id',
				'#status'
			);
			$values     = array(
				$data->name,
				$data->description,
				$data->start,
				$data->end,
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

	public static function btclite_update_holidays() {
		check_ajax_referer( 'btcl_ajax_nonce', 'nounce' );

		if ( ! empty ( $_POST['data'] ) ) {
			$values  = isset( $_POST['data'] ) ? (array) BTCLite_Helper::btclite_sanitize_array( $_POST['data'] ) : array();
			$name    = $values['name'];
			$desc    = $values['description'];
			$start   = $values['from'];
			$end     = $values['to'];
			$status  = $values['status'];
			$id      = $values['id'];
			$date1   = date_create( $start );
			$date2   = date_create( $end );
			$diff    = date_diff( $date1, $date2 );
			$leaves  = $diff->format( "%a" );	
			$leaves  = $leaves + 1;
			$data    = array(
				'name'        => $name,
				'description' => $desc,
				'start'       => date( "Y-m-d", strtotime( $start ) ),
				'end'         => date( "Y-m-d", strtotime( $end ) ),
				'days'        => $leaves,
				'status'      => $status
			);
			$where   = array(
				'id' => $id
			);
			$table_name = 'btcl_holidays';
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

	public static function btclite_delete_holidays() {
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