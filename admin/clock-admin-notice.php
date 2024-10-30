<?php
defined( 'ABSPATH' ) or die();

function btclite_admin_notice__success() {
    ?>
    <div class="btcl-notice notice notice-success is-dismissible">
		<div class="btcl-notice__content">
			<h3><?php esc_html_e( 'Upgrade to Clockinator Pro now & Get upto 50% discount!, Get Pro in just $30 for Lifetime Updates & Premium Support.', 'clockinator-lite' ); ?></h3>
			<p><?php esc_html_e( 'You will get advance features & option to track your employees working activites, Attandence Reports, Leaves, Holidays, Working Hours, Shifts, Departments, Salary calculation, Payroll, Payslip, Projects, Tasks and many more.!', 'clockinator-lite' ); ?></p>
			<div class="btcl-notice__actions">
				<a target="_blank" href="https://beastthemes.com/plugins/clockify-pro/" class="btcl-button btcl-button btcl-button--cta button-primary"><span><?php esc_html_e( 'View More', 'clockify' ); ?></span></a>
				<a target="_blank" href="https://demo.beastthemes.com/clockify-pro-wordpress-plugin/" class="btcl-button btcl-button btcl-button--cta button-primary"><span><?php esc_html_e( 'View Demo', 'clockify' ); ?></span></a>
				<a target="_blank" href="https://beastthemes.com/account/signup/clockify-pro-plugin" class="btcl-button btcl-button btcl-button--cta button-primary"><span><?php esc_html_e( 'Upgrade Now', 'clockify' ); ?></span></a>
			</div>
		</div>
    </div>
    <?php
}
add_action( 'admin_notices', 'btclite_admin_notice__success' );

function btclite_admin_notice_assets() {
	wp_register_style( 'btclite_admin_css', BTCLite_PLUGIN_URL . 'admin/css/clock-admin-notice.css' );
    wp_enqueue_style( 'btclite_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'btclite_admin_notice_assets' );