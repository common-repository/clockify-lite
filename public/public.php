<?php
defined( 'ABSPATH' ) or die();

require_once( 'clock-language.php' );
require_once( 'clock-shortcode.php' );
require_once( 'inc/controllers/class-page-template.php' );
require_once( 'inc/actions/clock-leaves-actions.php' );
require_once( 'inc/actions/clock-btn-actions.php' );
require_once( 'inc/actions/clock-reports-actions.php' );
require_once( 'inc/actions/clock-profile-actions.php' );

/* Load text domain */
add_action( 'plugins_loaded', array( 'BTCLLiteLanguage', 'btclite_load_translation' ) );

/* Enqueue Assets for shortcodes */
add_action( 'wp_enqueue_scripts', array( 'BTCLShortcodes', 'btclite_shortcode_enqueue_assets' ) );

/* Login Form Shortcode files */
add_shortcode( 'btcl-dashboard', array( 'BTCLShortcodes', 'btclite_front_dashboard' ) );

/* Employee dashbord Shortcodes */
add_shortcode( 'btcl-last-day-wotking-hours', array( 'BTCLShortcodes', 'btclite_last_day_working_hours' ) );
add_shortcode( 'btcl-total-attendance', array( 'BTCLShortcodes', 'btclite_total_attendance' ) );
add_shortcode( 'btcl-total-absents', array( 'BTCLShortcodes', 'btclite_total_absents' ) );
add_shortcode( 'btcl-clockin-buttons', array( 'BTCLShortcodes', 'btclite_clockin_buttons' ) );
add_shortcode( 'btcl-attendance-reports', array( 'BTCLShortcodes', 'btclite_attendance_reports' ) );
add_shortcode( 'btcl-leave-requests', array( 'BTCLShortcodes', 'btclite_leave_requests' ) );
add_shortcode( 'btcl-holiday-list', array( 'BTCLShortcodes', 'btclite_all_holidays' ) );
add_shortcode( 'btcl-upcoming-holidays', array( 'BTCLShortcodes', 'btclite_upcoming_holidays' ) );
add_shortcode( 'btcl-upcoming-events', array( 'BTCLShortcodes', 'btclite_upcoming_events' ) );

/* Add page templates. */
add_filter( 'theme_page_templates', array( 'BTCLite_CustomPageTemplates', 'btclite_add_page_template_to_dropdown' ) );
add_filter( 'page_template', array( 'BTCLite_CustomPageTemplates', 'btclite_catch_plugin_template' ) );

/**-------------------------------------------------------------Leaves-------------------------------------------------------------**/

/* Add Leaves */
add_action( 'wp_ajax_nopriv_btcl_save_leaves', array( 'BTCLite_LeavesPanelAction', 'btclite_add_leaves' ) );
add_action( 'wp_ajax_btcl_save_leaves', array( 'BTCLite_LeavesPanelAction', 'btclite_add_leaves' ) );

/* Edit Leaves */
add_action( 'wp_ajax_nopriv_btcl_edit_leaves', array( 'BTCLite_LeavesPanelAction', 'btclite_edit_leaves' ) );
add_action( 'wp_ajax_btcl_edit_leaves', array( 'BTCLite_LeavesPanelAction', 'btclite_edit_leaves' ) );

/* Delete Leaves */
add_action( 'wp_ajax_nopriv_btcl_delete_leaves', array( 'BTCLite_LeavesPanelAction', 'btclite_delete_leaves' ) );
add_action( 'wp_ajax_btcl_delete_leaves', array( 'BTCLite_LeavesPanelAction', 'btclite_delete_leaves' ) );

/* Update Leaves */
add_action( 'wp_ajax_nopriv_btcl_update_leaves', array( 'BTCLite_LeavesPanelAction', 'btclite_update_leaves' ) );
add_action( 'wp_ajax_btcl_update_leaves', array( 'BTCLite_LeavesPanelAction', 'btclite_update_leaves' ) );

/**-------------------------------------------------------------Clock Actions-------------------------------------------------------------**/

/* Clock In */
add_action( 'wp_ajax_nopriv_btcl_clock_in', array( 'BTCLite_ClockAction', 'btclite_add_clock_in' ) );
add_action( 'wp_ajax_btcl_clock_in', array( 'BTCLite_ClockAction', 'btclite_add_clock_in' ) );

/* Clock Out */
add_action( 'wp_ajax_nopriv_btcl_clock_out', array( 'BTCLite_ClockAction', 'btclite_add_clock_out' ) );
add_action( 'wp_ajax_btcl_clock_out', array( 'BTCLite_ClockAction', 'btclite_add_clock_out' ) );

/* Break In */
add_action( 'wp_ajax_nopriv_btcl_break_in', array( 'BTCLite_ClockAction', 'btclite_add_break_in' ) );
add_action( 'wp_ajax_btcl_break_in', array( 'BTCLite_ClockAction', 'btclite_add_break_in' ) );

/* Break Out */
add_action( 'wp_ajax_nopriv_btcl_break_out', array( 'BTCLite_ClockAction', 'btclite_add_break_out' ) );
add_action( 'wp_ajax_btcl_break_out', array( 'BTCLite_ClockAction', 'btclite_add_break_out' ) );

/* Work report */
add_action( 'wp_ajax_nopriv_btcl_submit_report', array( 'BTCLite_ClockAction', 'btclite_submit_work_report' ) );
add_action( 'wp_ajax_btcl_submit_report', array( 'BTCLite_ClockAction', 'btclite_submit_work_report' ) );

/**-------------------------------------------------------------Report Actions-------------------------------------------------------------**/

/* Generate reports */
add_action( 'wp_ajax_nopriv_btcl_generate_staff_reports', array( 'BTCLite_RepertsGenerateAction', 'btclite_generate_staff_report' ) );
add_action( 'wp_ajax_btcl_generate_staff_reports', array( 'BTCLite_RepertsGenerateAction', 'btclite_generate_staff_report' ) );

/* View reports */
add_action( 'wp_ajax_nopriv_btcl_edit_staff_reports', array( 'BTCLite_RepertsGenerateAction', 'btclite_edit_staff_report' ) );
add_action( 'wp_ajax_btcl_edit_staff_reports', array( 'BTCLite_RepertsGenerateAction', 'btclite_edit_staff_report' ) );

/**-------------------------------------------------------------Profile Actions-------------------------------------------------------------**/

/* View reports */
add_action( 'wp_ajax_nopriv_btcl_save_profile', array( 'BTCLite_SaveProfileAction', 'btclite_edit_save_profile' ) );
add_action( 'wp_ajax_btcl_save_profile', array( 'BTCLite_SaveProfileAction', 'btclite_edit_save_profile' ) );


/**-------------------------------------------------------------Target Actions-------------------------------------------------------------**/

/* View targets */
add_action( 'wp_ajax_nopriv_btcl_fetch_target_details', array( 'BTCLite_RepertsGenerateAction', 'btclite_display_target' ) );
add_action( 'wp_ajax_btcl_fetch_target_details', array( 'BTCLite_RepertsGenerateAction', 'btclite_display_target' ) );