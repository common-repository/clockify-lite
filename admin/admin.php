<?php
defined( 'ABSPATH' ) or die();

require_once( 'inc/controllers/clock-menu-panel.php' );
require_once( 'inc/controllers/clock-install-tables.php' );
require_once( 'inc/actions/clock-department-actions.php' );
require_once( 'inc/actions/clock-employees-actions.php' );
require_once( 'inc/actions/clock-holidays-actions.php' );
require_once( 'inc/actions/clock-requests-actions.php' );
require_once( 'inc/actions/clock-events-actions.php' );
require_once( 'inc/actions/clock-reports-actions.php' );
require_once( 'inc/actions/clock-settings-actions.php' );
require_once( 'inc/actions/clock-strings-actions.php' );
require_once( 'inc/actions/clock-shift-actions.php' );
require_once( 'inc/actions/clock-target-actions.php' );
require_once( 'clock-admin-notice.php' );

/* Action for creating menu pages */
add_action( 'admin_menu', array( 'BTCLite_AdminMenu', 'btclite_create_menu' ) );

/* Action for creating data tables */
add_action( 'init', array( 'BTCLite_InstallTables', 'btclite_initiate_tables' ) );

/* Action for save settings */
add_action( 'wp_ajax_btcl-settings', array( 'BTCLite_SaveSettings', 'btclite_save_settings' ) );

/* Action to save strings settings */
add_action( 'wp_ajax_btcl-strings-options', array( 'BTCLite_SaveTranslateStrings', 'btclite_save_settings' ) );

/**-------------------------------------------------------------Shifts-------------------------------------------------------------**/

/* Add Shifts */
add_action( 'wp_ajax_nopriv_btcl_save_shifts', array( 'BTCLite_ShiftPanelAction', 'btclite_add_shifts' ) );
add_action( 'wp_ajax_btcl_save_shifts', array( 'BTCLite_ShiftPanelAction', 'btclite_add_shifts' ) );

/* Edit Shifts */
add_action( 'wp_ajax_nopriv_btcl_edit_shifts', array( 'BTCLite_ShiftPanelAction', 'btclite_edit_shifts' ) );
add_action( 'wp_ajax_btcl_edit_shifts', array( 'BTCLite_ShiftPanelAction', 'btclite_edit_shifts' ) );

/* Delete Shifts */
add_action( 'wp_ajax_nopriv_btcl_delete_shifts', array( 'BTCLite_ShiftPanelAction', 'btclite_delete_shifts' ) );
add_action( 'wp_ajax_btcl_delete_shifts', array( 'BTCLite_ShiftPanelAction', 'btclite_delete_shifts' ) );

/* Update Shifts */
add_action( 'wp_ajax_nopriv_btcl_update_shifts', array( 'BTCLite_ShiftPanelAction', 'btclite_update_shifts' ) );
add_action( 'wp_ajax_btcl_update_shifts', array( 'BTCLite_ShiftPanelAction', 'btclite_update_shifts' ) );

/**-------------------------------------------------------------Departments-------------------------------------------------------------**/

/* Add Departments */
add_action( 'wp_ajax_nopriv_btcl_save_departments', array( 'BTCLite_DepartmentPanelAction', 'btclite_add_departments' ) );
add_action( 'wp_ajax_btcl_save_departments', array( 'BTCLite_DepartmentPanelAction', 'btclite_add_departments' ) );

/* Edit Departments */
add_action( 'wp_ajax_nopriv_btcl_edit_departments', array( 'BTCLite_DepartmentPanelAction', 'btclite_edit_departments' ) );
add_action( 'wp_ajax_btcl_edit_departments', array( 'BTCLite_DepartmentPanelAction', 'btclite_edit_departments' ) );

/* Delete Departments */
add_action( 'wp_ajax_nopriv_btcl_delete_departments', array( 'BTCLite_DepartmentPanelAction', 'btclite_delete_departments' ) );
add_action( 'wp_ajax_btcl_delete_departments', array( 'BTCLite_DepartmentPanelAction', 'btclite_delete_departments' ) );

/* Update Departments */
add_action( 'wp_ajax_nopriv_btcl_update_departments', array( 'BTCLite_DepartmentPanelAction', 'btclite_update_departments' ) );
add_action( 'wp_ajax_btcl_update_departments', array( 'BTCLite_DepartmentPanelAction', 'btclite_update_departments' ) );

/**-------------------------------------------------------------Employees-------------------------------------------------------------**/

/* Fetch Employees */
add_action( 'wp_ajax_nopriv_btcl_fetch_employees', array( 'BTCLite_EmployeePanelAction', 'btclite_fetch_user_data' ) );
add_action( 'wp_ajax_btcl_fetch_employees', array( 'BTCLite_EmployeePanelAction', 'btclite_fetch_user_data' ) );

/* Add Employees */
add_action( 'wp_ajax_nopriv_btcl_save_employees', array( 'BTCLite_EmployeePanelAction', 'btclite_add_employees' ) );
add_action( 'wp_ajax_btcl_save_employees', array( 'BTCLite_EmployeePanelAction', 'btclite_add_employees' ) );

/* Edit Employees */
add_action( 'wp_ajax_nopriv_btcl_edit_employees', array( 'BTCLite_EmployeePanelAction', 'btclite_edit_employees' ) );
add_action( 'wp_ajax_btcl_edit_employees', array( 'BTCLite_EmployeePanelAction', 'btclite_edit_employees' ) );

/* Update Employees */
add_action( 'wp_ajax_nopriv_btcl_update_employees', array( 'BTCLite_EmployeePanelAction', 'btclite_update_employees' ) );
add_action( 'wp_ajax_btcl_update_employees', array( 'BTCLite_EmployeePanelAction', 'btclite_update_employees' ) );

/* Delete Employees */
add_action( 'wp_ajax_nopriv_btcl_delete_employees', array( 'BTCLite_EmployeePanelAction', 'btclite_delete_employees' ) );
add_action( 'wp_ajax_btcl_delete_employees', array( 'BTCLite_EmployeePanelAction', 'btclite_delete_employees' ) );

/**-------------------------------------------------------------Holidays-------------------------------------------------------------**/

/* Add Holiday */
add_action( 'wp_ajax_nopriv_btcl_save_holidays', array( 'BTCLite_HolidayPanelAction', 'btclite_add_holidays' ) );
add_action( 'wp_ajax_btcl_save_holidays', array( 'BTCLite_HolidayPanelAction', 'btclite_add_holidays' ) );

/* Edit Departments */
add_action( 'wp_ajax_nopriv_btcl_edit_holidays', array( 'BTCLite_HolidayPanelAction', 'btclite_edit_holidays' ) );
add_action( 'wp_ajax_btcl_edit_holidays', array( 'BTCLite_HolidayPanelAction', 'btclite_edit_holidays' ) );

/* Delete Departments */
add_action( 'wp_ajax_nopriv_btcl_delete_holidays', array( 'BTCLite_HolidayPanelAction', 'btclite_delete_holidays' ) );
add_action( 'wp_ajax_btcl_delete_holidays', array( 'BTCLite_HolidayPanelAction', 'btclite_delete_holidays' ) );

/* Update Departments */
add_action( 'wp_ajax_nopriv_btcl_update_holidays', array( 'BTCLite_HolidayPanelAction', 'btclite_update_holidays' ) );
add_action( 'wp_ajax_btcl_update_holidays', array( 'BTCLite_HolidayPanelAction', 'btclite_update_holidays' ) );

/**-------------------------------------------------------------Requests-------------------------------------------------------------**/

/* Add Holiday */
add_action( 'wp_ajax_nopriv_btcl_edit_requests', array( 'BTCLite_RequestPanelAction', 'btclite_edit_requests' ) );
add_action( 'wp_ajax_btcl_edit_requests', array( 'BTCLite_RequestPanelAction', 'btclite_edit_requests' ) );

/* Edit Departments */
add_action( 'wp_ajax_nopriv_btcl_update_requests', array( 'BTCLite_RequestPanelAction', 'btclite_update_requests' ) );
add_action( 'wp_ajax_btcl_update_requests', array( 'BTCLite_RequestPanelAction', 'btclite_update_requests' ) );

/**-------------------------------------------------------------Events-------------------------------------------------------------**/

/* Add Events */
add_action( 'wp_ajax_nopriv_btcl_save_events', array( 'BTCLite_EventsPanelAction', 'btclite_save_events' ) );
add_action( 'wp_ajax_btcl_save_events', array( 'BTCLite_EventsPanelAction', 'btclite_save_events' ) );

/* Edit Events */
add_action( 'wp_ajax_nopriv_btcl_edit_events', array( 'BTCLite_EventsPanelAction', 'btclite_edit_events' ) );
add_action( 'wp_ajax_btcl_edit_events', array( 'BTCLite_EventsPanelAction', 'btclite_edit_events' ) );

/* Edit Events */
add_action( 'wp_ajax_nopriv_btcl_update_events', array( 'BTCLite_EventsPanelAction', 'btclite_update_events' ) );
add_action( 'wp_ajax_btcl_update_events', array( 'BTCLite_EventsPanelAction', 'btclite_update_events' ) );

/* Edit Events */
add_action( 'wp_ajax_nopriv_btcl_delete_events', array( 'BTCLite_EventsPanelAction', 'btclite_delete_events' ) );
add_action( 'wp_ajax_btcl_delete_events', array( 'BTCLite_EventsPanelAction', 'btclite_delete_events' ) );

/**-------------------------------------------------------------Reports-------------------------------------------------------------**/

/* Generate Reports */
add_action( 'wp_ajax_nopriv_btcl_generate_staff_report', array( 'BTCLite_RepertGenerateAction', 'btclite_generate_staff_report' ) );
add_action( 'wp_ajax_btcl_generate_staff_report', array( 'BTCLite_RepertGenerateAction', 'btclite_generate_staff_report' ) );

/* Edit Reports */
add_action( 'wp_ajax_nopriv_btcl_edit_reports', array( 'BTCLite_RepertGenerateAction', 'btclite_edit_staff_report' ) );
add_action( 'wp_ajax_btcl_edit_reports', array( 'BTCLite_RepertGenerateAction', 'btclite_edit_staff_report' ) );

/* Fetch clock Reports */
add_action( 'wp_ajax_nopriv_btcl_fetch_clock_reports', array( 'BTCLite_RepertGenerateAction', 'btclite_fetch_clock_details' ) );
add_action( 'wp_ajax_btcl_fetch_clock_reports', array( 'BTCLite_RepertGenerateAction', 'btclite_fetch_clock_details' ) );

/* Update Reports */
add_action( 'wp_ajax_nopriv_btcl_update_fetch_reports', array( 'BTCLite_RepertGenerateAction', 'bbtclite_update_reports' ) );
add_action( 'wp_ajax_btcl_update_fetch_reports', array( 'BTCLite_RepertGenerateAction', 'btclite_update_reports' ) );

/**-------------------------------------------------------------Delete Entriess-------------------------------------------------------------**/

/* Generate Reports */
add_action( 'wp_ajax_nopriv_btcl_delete_all_entries', array( 'BTCLite_RequestPanelAction', 'btclite_delete_entries' ) );
add_action( 'wp_ajax_btcl_delete_all_entries', array( 'BTCLite_RequestPanelAction', 'btclite_delete_entries' ) );

/**-------------------------------------------------------------Target Actions-------------------------------------------------------------**/

/* Add targets */
add_action( 'wp_ajax_nopriv_btcl_save_targets', array( 'BTCLite_TargetActions', 'btclite_add_targets' ) );
add_action( 'wp_ajax_btcl_save_targets', array( 'BTCLite_TargetActions', 'btclite_add_targets' ) );

/* Edit targets */
add_action( 'wp_ajax_nopriv_btcl_edit_targets', array( 'BTCLite_TargetActions', 'btclite_edit_targets' ) );
add_action( 'wp_ajax_btcl_edit_targets', array( 'BTCLite_TargetActions', 'btclite_edit_targets' ) );

// /* Add target records */
add_action( 'wp_ajax_nopriv_btcl_add_trecords', array( 'BTCLite_TargetActions', 'btclite_add_target_records' ) );
add_action( 'wp_ajax_btcl_add_trecords', array( 'BTCLite_TargetActions', 'btclite_add_target_records' ) );

/* Delete Project Entites  */
add_action( 'wp_ajax_nopriv_btcl_delete_details', array( 'BTCLite_TargetActions', 'btclite_delete_task_details' ) );
add_action( 'wp_ajax_btcl_delete_details', array( 'BTCLite_TargetActions', 'btclite_delete_task_details' ) );