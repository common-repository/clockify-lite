<?php
defined( 'ABSPATH' ) or die();

/**
 *  Create Datatables for Clockify
 */
class BTCLite_InstallTables {
	
	public static function btclite_include_upgrade_file() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	}

	public static function btclite_initiate_tables() {
		self::btclite_initiate_option_names();
		self::btclite_include_upgrade_file();
		self::btclite_initiate_notices_table();
		self::btclite_initiate_events_table();
		self::btclite_initiate_leaves_table();
		self::btclite_initiate_holidays_table();
		self::btclite_initiate_departments_table();
		self::btclite_initiate_shifts_table();
		self::btclite_initiate_employees_table();
		self::btclite_initiate_requests_table();
		self::btclite_initiate_reports_table();
		self::btclite_initiate_targets_table();
		self::btclite_initiate_templates();
	}

	public static function btclite_initiate_option_names() {
		add_option( 'btcl_settings' );
		add_option( 'btcl_email_templates' );
		add_option( 'btcl_sms_templates' );
		add_option( 'btcl_email_settings' );
		add_option( 'btcl_string_translation' );
	}

	public static function btclite_table_exists( $table_name ) {
	   global $wpdb;
	   $table = $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" );
	   return $table;
	}

	public static function btclite_table_column_exists( $table_name, $column_name ) {
	   global $wpdb;
	   $column = $wpdb->get_results( $wpdb->prepare(
	       "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ",
	       DB_NAME, $table_name, $column_name
	   ) );
	   if ( ! empty( $column ) ) {
	       return true;
	   }
	   return false;
	}

	protected static function btclite_get_wp_charset_collate() {

		global $wpdb;
		$charset_collate = '';

		if ( ! empty ( $wpdb->charset ) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";

		if ( ! empty ( $wpdb->collate ) )
			$charset_collate .= " COLLATE $wpdb->collate";

		return $charset_collate;
	}

	public static function btclite_initiate_notices_table() {
		global $wpdb;
		$charset_collate = self::btclite_get_wp_charset_collate();

		$table_name  = esc_sql( $wpdb->base_prefix . "btcl_notices" );
		$table_check = self::btclite_table_exists( $table_name );
		if ( empty ( $table_check ) ) {
			$wpdb->query(
				"CREATE TABLE IF NOT EXISTS `$table_name` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `description` varchar(255) NOT NULL,
				  `status` varchar(255) NOT NULL,
				 PRIMARY KEY (`id`)
				)$charset_collate;"
			);
		}
	}

	public static function btclite_initiate_events_table() {
		global $wpdb;
		$charset_collate = self::btclite_get_wp_charset_collate();

		$table_name  = esc_sql( $wpdb->base_prefix . "btcl_events" );
		$table_check = self::btclite_table_exists( $table_name );
		if ( empty ( $table_check ) ) {
			$wpdb->query(
				"CREATE TABLE IF NOT EXISTS `$table_name` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `event_date` varchar(255) NOT NULL,
				  `description` varchar(255) NOT NULL,
				  `status` varchar(255) NOT NULL,
				 PRIMARY KEY (`id`)
				)$charset_collate;"
			);
		}
	}

	public static function btclite_initiate_leaves_table() {
		global $wpdb;
		$charset_collate = self::btclite_get_wp_charset_collate();

		$table_name  = esc_sql( $wpdb->base_prefix . "btcl_leaves" );
		$table_check = self::btclite_table_exists( $table_name );
		if ( empty ( $table_check ) ) {
			$wpdb->query(
				"CREATE TABLE IF NOT EXISTS `$table_name` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `description` varchar(255) NOT NULL,
				  `date` varchar(255) NOT NULL,
				  `start` varchar(255) NOT NULL,
				  `end` varchar(255) NOT NULL,
				  `user_id` varchar(255) NOT NULL,
				  `user_name` varchar(255) NOT NULL,
				  `days` varchar(255) NOT NULL,
				  `status` varchar(255) NOT NULL,
				 PRIMARY KEY (`id`)
				)$charset_collate;"
			);
		}
	}

	public static function btclite_initiate_holidays_table() {
		global $wpdb;
		$charset_collate = self::btclite_get_wp_charset_collate();

		$table_name  = esc_sql( $wpdb->base_prefix . "btcl_holidays" );
		$table_check = self::btclite_table_exists( $table_name );
		if ( empty ( $table_check ) ) {
			$wpdb->query(
				"CREATE TABLE IF NOT EXISTS `$table_name` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `description` varchar(255) NOT NULL,
				  `start` varchar(255) NOT NULL,
				  `end` varchar(255) NOT NULL,
				  `days` varchar(255) NOT NULL,
				  `status` varchar(255) NOT NULL,
				 PRIMARY KEY (`id`)
				)$charset_collate;"
			);
		}
	}

	public static function btclite_initiate_departments_table() {
		global $wpdb;
		$charset_collate = self::btclite_get_wp_charset_collate();

		$table_name  = esc_sql( $wpdb->base_prefix . "btcl_departments" );
		$table_check = self::btclite_table_exists( $table_name );
		if ( empty ( $table_check ) ) {
			$wpdb->query(
				"CREATE TABLE IF NOT EXISTS `$table_name` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `color` varchar(255) NOT NULL,
				  `status` varchar(255) NOT NULL,
				 PRIMARY KEY (`id`)
				)$charset_collate;"
			);
		}
	}

	public static function btclite_initiate_shifts_table() {
		global $wpdb;
		$charset_collate = self::btclite_get_wp_charset_collate();

		$table_name  = esc_sql( $wpdb->base_prefix . "btcl_shifts" );
		$table_check = self::btclite_table_exists( $table_name );
		if ( empty ( $table_check ) ) {
			$wpdb->query(
				"CREATE TABLE IF NOT EXISTS `$table_name` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `start` varchar(255) NOT NULL,
				  `end` varchar(255) NOT NULL,
				  `late` varchar(255) NOT NULL,
				  `status` varchar(255) NOT NULL,
				 PRIMARY KEY (`id`)
				)$charset_collate;"
			);
		}
	}

	public static function btclite_initiate_employees_table() {
		global $wpdb;
		$charset_collate = self::btclite_get_wp_charset_collate();

		$table_name  = esc_sql( $wpdb->base_prefix . "btcl_employees" );
		$table_check = self::btclite_table_exists( $table_name );
		if ( empty ( $table_check ) ) {
			$wpdb->query(
				"CREATE TABLE IF NOT EXISTS `$table_name` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `user_id` varchar(255) NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `first_name` varchar(255) NOT NULL,
				  `last_name` varchar(255) NOT NULL,
				  `user_login` varchar(255) NOT NULL,
				  `user_nicename` varchar(255) NOT NULL,
				  `user_email` varchar(255) NOT NULL,
				  `display_name` varchar(255) NOT NULL,
				  `shift_id` varchar(255) NOT NULL,
				  `department_id` varchar(255) NOT NULL,
				  `designation` varchar(255) NOT NULL,
				  `salary` varchar(255) NOT NULL,
				  `role` varchar(255) NOT NULL,
				  `picture` varchar(255) NOT NULL,
				  `leaves` longtext NOT NULL,
				  `extra` longtext NOT NULL,
				  `bank` longtext NOT NULL,
				  `status` varchar(255) NOT NULL,
				 PRIMARY KEY (`id`)
				)$charset_collate;"
			);
		}
	}

	public static function btclite_initiate_requests_table() {
		global $wpdb;
		$charset_collate = self::btclite_get_wp_charset_collate();

		$table_name  = esc_sql( $wpdb->base_prefix . "btcl_requests" );
		$table_check = self::btclite_table_exists( $table_name );
		if ( empty ( $table_check ) ) {
			$wpdb->query(
				"CREATE TABLE IF NOT EXISTS `$table_name` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `user_id` varchar(255) NOT NULL,
				  `subject` varchar(255) NOT NULL,
				  `first_name` varchar(255) NOT NULL,
				  `last_name` varchar(255) NOT NULL,
				  `user_name` varchar(255) NOT NULL,
				  `user_email` varchar(255) NOT NULL,
				  `start` varchar(255) NOT NULL,
				  `end` varchar(255) NOT NULL,
				  `days` varchar(255) NOT NULL,
				  `reason` varchar(255) NOT NULL,
				  `status` varchar(255) NOT NULL,
				 PRIMARY KEY (`id`)
				)$charset_collate;"
			);
		}
	}

	public static function btclite_initiate_reports_table() {
		global $wpdb;
		$charset_collate = self::btclite_get_wp_charset_collate();

		$table_name  = esc_sql( $wpdb->base_prefix . "btcl_reports" );
		$table_check = self::btclite_table_exists( $table_name );
		if ( empty ( $table_check ) ) {
			$wpdb->query(
				"CREATE TABLE IF NOT EXISTS `$table_name` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `user_id` varchar(255) NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `email` varchar(255) NOT NULL,
				  `office_in` varchar(255) NOT NULL,
				  `office_out` varchar(255) NOT NULL,
				  `late` varchar(255) NOT NULL,
				  `late_reason` varchar(255) NOT NULL,
				  `report` longtext NOT NULL,
				  `breaks` longtext NOT NULL,
				  `working_hours` varchar(255) NOT NULL,
				  `login_date` varchar(255) NOT NULL,
				  `user_ip` varchar(255) NOT NULL,
				  `shift_id` varchar(255) NOT NULL,
				  `shift_name` varchar(255) NOT NULL,
				  `location` varchar(255) NOT NULL,
				  `date_in` varchar(255) NOT NULL,
				  `date_out` varchar(255) NOT NULL,
				 PRIMARY KEY (`id`)
				)$charset_collate;"
			);
		} else {
			$datein_check = self::btclite_table_column_exists( $table_name, 'date_in' );
			if ( $datein_check == false ) {
				$date_in = "ALTER TABLE $table_name ADD date_in varchar(255) NOT NULL";
	       		$wpdb->query( $date_in );
			}

			$date_out_check = self::btclite_table_column_exists( $table_name, 'date_out' );
			if ( $date_out_check == false ) {
				$date_out = "ALTER TABLE $table_name ADD date_out varchar(255) NOT NULL";
	       		$wpdb->query( $date_out );
			}
		}
	}

	public static function btclite_initiate_targets_table() {
		global $wpdb;
		$charset_collate = self::btclite_get_wp_charset_collate();

		$table_name  = esc_sql( $wpdb->base_prefix . "btcl_targets" );
		$table_check = self::btclite_table_exists( $table_name );
		if ( empty ( $table_check ) ) {
			$wpdb->query(
				"CREATE TABLE IF NOT EXISTS `$table_name` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `user_id` varchar(255) NOT NULL,
                  `title` varchar(255) NOT NULL,
                  `fromm` varchar(255) NOT NULL,
                  `too` varchar(255) NOT NULL,
                  `description` varchar(255) NOT NULL,
                  `target` varchar(255) NOT NULL,
                  `feedback` longtext NOT NULL,
                  `status` varchar(255) NOT NULL,
				 PRIMARY KEY (`id`)
				)$charset_collate;"
			);
		}
	}

	public static function btclite_initiate_templates() {

		$btcl_email_templates = get_option( 'btcl_email_templates' );
		$btcl_sms_templates   = get_option( 'btcl_sms_templates' );

		//Employee welcome
        $welcome = [
            'subject' => 'Welcome {full_name} to {company_name}',
            'heading' => 'Welcome Onboard {first_name}!',
			'body'    => 'Dear {full_name},
			<br>
			Welcome aboard as a <strong>{job_title}</strong> in our team at <strong>{company_name}</strong>! I am pleased to have you working with us. You were selected for employment due to the attributes that you displayed that appear to match the qualities I look for in an employee.
			<br>
			I’m looking forward to seeing you grow and develop into an outstanding employee that exhibits a high level of care, concern, and compassion for others. I hope that you will find your work to be rewarding, challenging, and meaningful.
			<br>
			Please take your time and review our yearly goals so that you can know what is expected and make a positive contribution. Again, I look forward to seeing you grow as a professional while enhancing the lives of the clients entrusted in your care.
			<br>
			Sincerely,
			<br>
			Manager Name
			<br>
			CEO, Company Name
			<br>',
			'tags'   => 'You may use these template tags inside subject, heading, body and those will be replaced by original values: {full_name}, {last_name}, {first_name}, {job_title}, {company_name}.'
		];

		//New Leave Request
        $new_leave_request = [
            'subject' => 'New leave request received from {employee_name}',
            'heading' => 'New Leave Request',
            'body'    => 'Hello,
			<br>
			A new leave request has been received from {employee_name}.
			<br>
			<strong>Date:</strong> {date_from} to {date_to}
			<br>
			<strong>Days:</strong> {no_days}
			<br>
			<strong>Reason:</strong> {reason}
			<br>
			<br>
			Please approve/reject this leave application.
			<br>
			Thanks.',
			'tags'   => 'You may use these template tags inside subject, heading, body and those will be replaced by original values: {employee_name}, {date_from},{date_to}, {no_days}, {reason}.'
		];

		//Approved Leave Request
		$approved_request = [
			'subject' => 'Your leave request has been approved',
			'heading' => 'Leave Request Approved',
			'body'    => 'Hello {employee_name},
			<br>
			Your leave request for <strong>{no_days} days</strong> from {date_from} to {date_to} has been approved.
			<br>
			Regards
			<br>
			Manager Name
			<br>
			Company',
			'tags'   => 'You may use these template tags inside subject, heading, body and those will be replaced by original values: {employee_name}, {date_from},{date_to}, {no_days}, {reason}.'
		];

		//Rejected Leave Request
		$reject_request = [
			'subject' => 'Your leave request has been rejected',
			'heading' => 'Leave Request Rejected',
			'body'    => 'Hello {employee_name},
			<br>
			Your leave request for <strong>{no_days} days</strong> from {date_from} to {date_to} has been rejected.
			<br>
			Regards
			<br>
			Manager Name
			<br>
			Company',
			'tags'   => 'You may use these template tags inside subject, heading, body and those will be replaced by original values: {employee_name}, {date_from},{date_to}, {no_days}.'
		];

		//New Notice Created
        $new_notice_request = [
            'subject' => 'New Notice has been created ( {site_name} )',
            'heading' => 'You have new notice from {site_name}',
            'body'    => 'Hello <strong>{employee_name}</strong>,
			<br>
			{notice_text}.
			<br>
			Thankyou.
			<br><br>
			Regards
			<br>
			Manager Name
			<br>
			Company',
			'tags'   => 'You may use these template tags inside subject, heading, body and those will be replaced by original values: {site_name}, {employee_name}, {notice_text}.'
		];

		// New Employee Introduction Email
		$new_contact_assigned = [
			'subject' => 'New Employee Introduction Email',
			'heading' => 'New Employee joining Announcement',
			'body'    => 'Dear Staffs,
			<br>
			I\'m happy to let you know that {employee_name} has accepted our job offer and joined the team as a quality {employee_designation}.
			<br>
			You can contact him/her by {employee_email}.
			<br>
			I appreciate you joining me in providing a warm welcome for {employee_name} with excitement.
			<br>
			Regards
			<br>
			Name of Department Manager/Boss
			<br>
			Company',
			'tags'   => 'You may use these template tags inside subject, heading, body and those will be replaced by original values: {employee_name}, {employee_email},{employee_designation}.'
		];

		$data = array(
			'welcome_mail'     => $welcome,
			'leave_mail'       => $new_leave_request,
			'approved_mail'    => $approved_request,
			'reject_mail'      => $reject_request,
			'new_notice_mail'  => $new_notice_request,
			'new_contact_mail' => $new_contact_assigned
		);
		if ( empty ( $btcl_email_templates ) ) {
			update_option( 'btcl_email_templates', $data );
		}
		
		//New Leave Request
        $sms_new_leave_request = [
            'body'    => 'Hello,
			A new leave request has been received from {employee_name}.
			Date: {date_from} to {date_to}
			Days: {no_days}
			Reason: {reason}

			Please approve/reject this leave application.

			Thanks.',
			'tags'   => 'You may use these template tags inside body and those will be replaced by original values: {employee_name}, {date_from},{date_to}, {no_days}, {reason}.'
		];

		//Approved Leave Request
		$sms_approved_request = [
			'body'    => 'Hello {employee_name},
			Your leave request for {no_days} days from {date_from} to {date_to} has been approved.
			Regards
			Manager Name
			Company',
			'tags'   => 'You may use these template tags inside body and those will be replaced by original values: {employee_name}, {date_from},{date_to}, {no_days}, {reason}.'
		];

		//Rejected Leave Request
		$sms_reject_request = [
			'body'    => 'Hello {employee_name},
			Your leave request for <strong>{no_days} days</strong> from {date_from} to {date_to} has been rejected.
			Regards
			Manager Name
			Company',
			'tags'   => 'You may use these template tags inside body and those will be replaced by original values: {employee_name}, {date_from},{date_to}, {no_days}.'
		];

		//New Notice Created
        $sms_new_notice_request = [
			'body' => 'Hello <strong>{employee_name}</strong>,
			{notice_text}.
			Thankyou.
			Regards
			Manager Name
			Company',
			'tags'   => 'You may use these template tags inside subject, heading, body and those will be replaced by original values: {site_name}, {employee_name}, {notice_text}.'
		];

		$sms_data = array(
			'leave_sms'       => $sms_new_leave_request,
			'approved_sms'    => $sms_approved_request,
			'reject_sms'      => $sms_reject_request,
			'new_notice_sms'  => $sms_new_notice_request,
		);
		if ( empty ( $btcl_sms_templates ) ) {
			update_option( 'btcl_sms_templates', $sms_data );
		}
	}

}