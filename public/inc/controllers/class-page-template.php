<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );

/**
 * Add page templates.
 */
class BTCLite_CustomPageTemplates {
	
	public static function btclite_add_page_template_to_dropdown( $templates ) {
		$templates['dashboard-template.php'] = esc_html__( 'Employer Dashboard', 'clockinator-lite' );
   		return $templates;
	}

	public static function btclite_catch_plugin_template( $template ) {
		if ( is_page_template( 'dashboard-template.php' ) ) {
			$template = BTCLite_PLUGIN_DIR_PATH . '/public/inc/templates/dashboard-template.php';
		}
	    return $template;
	}

	public static function btclite_setup_clockify_dashboard() {

	    $ClockifyDashboard = get_option( 'clockify_dashboard' );

	    if ( ! $ClockifyDashboard ) {

	        //post status and options
	        $post = array(
	              'comment_status' => 'closed',
	              'ping_status'    =>  'closed' ,
	              'post_author'    => 1,
	              'post_date'      => date('Y-m-d H:i:s'),
	              'post_name'      => 'Clockify Dashboard',
	              'post_status'    => 'publish' ,
	              'post_title'     => 'Clockify Dashboard',
	              'post_type'      => 'page',
	        ); 

	        //insert page and save the id
	        $NewValue = wp_insert_post( $post, false );
	        if ( $NewValue && ! is_wp_error( $NewValue ) ){
	            update_post_meta( $NewValue, '_wp_page_template', 'dashboard-template.php' );           
	        }

	        //save the id in the database
	        update_option( 'clockify_dashboard', $NewValue );
	    }
	}
}