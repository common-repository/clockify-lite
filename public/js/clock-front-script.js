jQuery(document).ready(function() {
	'use strict';

	jQuery('#user_login').attr('placeholder', 'Email or Username');
	jQuery('#user_pass').attr('placeholder', 'Password');

	/* functions */
	var get_timepicker = function( selector ){
		if ( jQuery( selector ).length ) {
			jQuery( selector ).datetimepicker({
			    format: "LT",
			    icons: {
			      	up: "fa fa-chevron-up",
			      	down: "fa fa-chevron-down"
			    }
			});
		}
	}
	var get_datepicker = function( selector ){
		if ( jQuery( selector ).length ) {
		    jQuery( selector ).datetimepicker({
			    useCurrent: true,
			    format: "L",
			    showTodayButton: false,
			    icons: {
			      next: "fa fa-chevron-right",
			      previous: "fa fa-chevron-left",
			      today: 'todayText',
			    }
			});
		}
	}
	var get_datatable_script = function( selector ) {
		jQuery( selector ).DataTable();
	}
	var SaveFormDetails = function( selector, action, form, modalID, refresh = null, todo = null, reset = null ) {
		jQuery(document).on( "click", selector, function(e) {
			e.preventDefault();
			var nounce = ajax_frontend.frontend_nonce;
			jQuery.ajax({
				url: ajax_frontend.ajax_url,
				type: "POST",
				data: {
					action: action,
					nounce: nounce,
					data: jQuery( form ).serializeArray()
				},
				success: function(response) {
					if (response) {
						if ( response.status == "error" ) {
							toastr.error( response.message );
						} else {
							toastr.success( response.message );
							if ( modalID.length != 0 ) {
								jQuery( modalID ).modal( "hide" );
							}
							if ( todo == 'generate' ) {
								var table = jQuery('#reports-listing').DataTable({
		                            'responsive': true,
		                            'destroy': true,
		                            'order': [],
		                            'data': response.reports
		                        });

		                        // Find indexes of rows which have `Yes` in the second column
		                        var indexes1 = table.rows().eq(0).filter(function (rowIdx) {
		                            return table.cell(rowIdx, 1).data() === 'Sunday' ? true : false;
		                        });
		                        
		                        // Add a class to those rows using an index selector
		                        table.rows(indexes1)
		                            .nodes()
		                            .to$()
		                            .addClass('sunday_report');
		                        
		                        // Find indexes of rows which have `Yes` in the second column
		                        var indexes2 = table.rows().eq(0).filter(function (rowIdx) {
		                            return table.cell(rowIdx, 4).data() === '<label class="badge badge-danger text-white">Absent</label>' ? true : false;
		                        });
		                        
		                        // Add a class to those rows using an index selector
		                        table.rows(indexes2)
		                            .nodes()
		                            .to$()
		                            .addClass('absent_report');
		                        
		                        // Find indexes of rows which have `Yes` in the second column
		                        var indexes3 = table.rows().eq(0).filter(function (rowIdx) {
		                            return table.cell(rowIdx, 4).data() === '<label class="badge badge-warning text-white">Holiday</label>' ? true : false;
		                        });
		                        
		                        // Add a class to those rows using an index selector
		                        table.rows(indexes3)
		                            .nodes()
		                            .to$()
		                            .addClass('holiday_report');

								jQuery('div#reports-listing_wrapper').show();
								jQuery('.salary-status-div').show();
								jQuery('.salary-form-div').empty();
								jQuery('.salary-form-div').append(response.time);
							}
							if ( todo == 'work' ) {
								jQuery('#report_btn').hide();
							}
							if ( reset == true ) {
								jQuery( form )[0].reset();
							}
							if ( refresh == true ) {
								location.reload();
							}
						}
					}
				}
			});
		});
	}
	var EditFormDetails = function( selector, action, form, modalID, type = null ) {
		jQuery(document).on( "click", selector, function(e) {
			e.preventDefault();
			var nounce = ajax_frontend.frontend_nonce;

			if ( type == 'default' ) {
				var id     = jQuery( this ).attr('data-id');
				var table  = jQuery( this ).attr('data-table');
				jQuery.ajax({
					url: ajax_frontend.ajax_url,
					type: "POST",
					data: {
						action: action,
						nounce: nounce,
						id:id,
						table:table
					},
					success: function(response) {
						if (response) {
							if ( response.status == "error" ) {
								toastr.error( response.message );
							} else {
								toastr.success( response.message );
								jQuery( modalID ).modal( "show" );
								for ( var i = 0, l = response.inputs.length; i < l; i++ ) {
									jQuery( form ).find( response.inputs[i] ).val( response.values[i] );
								}
							}
						}
					}
				});
			} else {
				var id      = jQuery( this ).attr('data-id');
				var table   = jQuery( this ).attr('data-table');
				var user_id = jQuery( this ).attr('data-user');
				var date    = jQuery( this ).attr('data-date');
				jQuery.ajax({
					url: ajax_frontend.ajax_url,
					type: "POST",
					data: {
						action: action,
						nounce: nounce,
						id:id,
						date:date,
						table:table,
						user_id:user_id
					},
					success: function(response) {
						if (response) {
							if ( response.status == "error" ) {
								toastr.error( response.message );
							} else {
								toastr.success( response.message );
								jQuery( modalID ).modal( "show" ); console.log(response);
								jQuery('#EditReportsForm').empty();
								jQuery('#EditReportsForm').append( response.html );
							}
						}
					}
				});
			}
			
		});
	}
	var UpdateFormDetails = function( selector, action, form, modalID, refresh = null ) {
		jQuery(document).on( "click", selector, function(e) {
			e.preventDefault();
			var nounce = ajax_frontend.frontend_nonce;
			jQuery.ajax({
				url: ajax_frontend.ajax_url,
				type: "POST",
				data: {
					action: action,
					nounce: nounce,
					data: jQuery( form ).serializeArray()
				},
				success: function(response) {
					if (response) {
						if ( response.status == "error" ) {
							toastr.error( response.message );
						} else {
							toastr.success( response.message );
							jQuery( modalID ).modal( "hide" );
							jQuery( form )[0].reset();
							if ( refresh == true ) {
								location.reload();
							}
						}
					}
				}
			});
		});
	}
	var DeleteFormDetails = function( selector, action, refresh = null ) {
		jQuery(document).on( "click", selector, function(e) {
			e.preventDefault();
			var nounce = ajax_frontend.frontend_nonce;
			var id     = jQuery( this ).attr('data-id');
			var table  = jQuery( this ).attr('data-table');
			jQuery.ajax({
				url: ajax_frontend.ajax_url,
				type: "POST",
				data: {
					action: action,
					nounce: nounce,
					id:id,
					table:table
				},
				success: function(response) {
					if (response) {
						if ( response.status == "error" ) {
							toastr.error( response.message );
						} else {
							toastr.success( response.message );
							if ( refresh == true ) {
								location.reload();
							}
						}
					}
				}
			});
		});
	}
	var ClockActions = function( selector, action, refresh = null, type = null ) {
		jQuery(document).on( "click", selector, function(e) {
			e.preventDefault();
			var nounce = ajax_frontend.frontend_nonce;
			var user_id = jQuery( this ).attr('data-value');

			if ( type == 'extra' ) {
				var row_id = jQuery(this).attr('data-row');
				jQuery.ajax({
					url: ajax_frontend.ajax_url,
					type: "POST",
					data: {
						action: action,
						nounce: nounce,
						row_id: row_id,
						user_id: user_id
					},
					success: function (response) {
						if (response) {
							if (response.status == "error") {
								toastr.error(response.message);
							} else {
								toastr.success(response.message);
								if (refresh == true) {
									location.reload();
								}
							}
						}
					}
				});
			} else {
				jQuery.ajax({
					url: ajax_frontend.ajax_url,
					type: "POST",
					data: {
						action: action,
						nounce: nounce,
						user_id: user_id
					},
					success: function (response) {
						if (response) {
							if (response.status == "error") {
								toastr.error(response.message);
							} else {
								toastr.success(response.message);
								if (refresh == true) {
									location.reload();
								}
							}
						}
					}
				});
			}
			
		});
	}

	/* Scripts for clock action buttons */
	var clockin = new ClockActions( '#clock_in_btn', 'btcl_clock_in', true, '' );
	var clockin = new ClockActions( '#clock_out_btn', 'btcl_clock_out', true, 'extra' );
	var clockin = new ClockActions( '#break_in_btn', 'btcl_break_in', true, 'extra' );
	var clockin = new ClockActions( '#break_out_btn', 'btcl_break_out', true, 'extra' );

	/* Scripts to save form details */
	var saveformdetails = new SaveFormDetails( '#SaveLeavesBtn', 'btcl_save_leaves', '#LeavesForm', '#AddLeaves', true, '', true );
	var saveformdetails = new SaveFormDetails( '#SaveWorkReportBtn', 'btcl_submit_report', '#WorkReportForm', '#AddWorkReport', false, 'work', true );
	var saveformdetails = new SaveFormDetails( '#GenerateReportsBtn', 'btcl_generate_staff_reports', '#staff-reports-form', '', false, 'generate', false );
	var saveformdetails = new SaveFormDetails( '#SaveProfilrBtn', 'btcl_save_profile', '#ProfileForm', '', false, '', false );

	/* Scripts to edit form details */
	var editformdetails = new EditFormDetails( '.edit-leave-details', 'btcl_edit_leaves', '#EditLeavesForm', '#EditLeaves', 'default' );
	var editformdetails = new EditFormDetails( '.edit-report_data-details', 'btcl_edit_staff_reports', '#EditReportsForm', '#EditReports', 'view' );

	/* Scripts to update form details */
	var updateformdetails = new UpdateFormDetails( '#EditLeaveBtn', 'btcl_update_leaves', '#EditLeavesForm', '#EditLeaves', true );

	/* Scripts to delete form details */
	var deleteformdetails = new DeleteFormDetails( '.delete-leave-details', 'btcl_delete_leaves', true );

	/* Scripts for datatables */
	var datatable = new get_datatable_script( '#requests-listing' );

	/* Date picker */
	var datepicker = new get_datepicker( "#LeavesForm #fromm" );
	var datepicker = new get_datepicker( '#LeavesForm #too' );
	var datepicker = new get_datepicker( "#EditLeavesForm #from" );
	var datepicker = new get_datepicker( '#EditLeavesForm #to' );


	jQuery(document).on( "click", '.fetch-target-details', function(e) {
		e.preventDefault();
		var id     = jQuery( this ).attr( 'data-id' );
		var type   = jQuery( this ).attr( 'data-type' );
		var url    = jQuery( this ).attr( 'data-url' );
		var nounce = ajax_frontend.frontend_nonce;
		jQuery.ajax({
			url: ajax_frontend.ajax_url,
			type: "POST",
			data: {
				action: 'btcl_fetch_target_details',
				nounce: nounce,
				id: id,
				type: type,
			},
			success: function(response) {
				if (response) {
					if ( response.status == "error" ) {
						toastr.error( response.message );
					} else {
						toastr.success( response.message );
						window.location.replace( response.url );				
					}
				}
			}
		});
	});

	// ------------------------------------------------------- //
    // Clock
    // ------------------------------------------------------ //
	setInterval( function() {
		var hours = new Date().getHours();
		jQuery(".hours").html(( hours < 10 ? "0" : "" ) + hours);
	}, 1000);
	setInterval( function() {
		var minutes = new Date().getMinutes();
		jQuery(".min").html(( minutes < 10 ? "0" : "" ) + minutes);
	},1000);
	setInterval( function() {
		var seconds = new Date().getSeconds();
		jQuery(".sec").html(( seconds < 10 ? "0" : "" ) + seconds);
	},1000);

	/* Script to submit session work report */
	jQuery(document).on( "click", '#report_btn', function(e) {
		e.preventDefault();
		jQuery('#AddWorkReport').modal( "show" );
		var row_id  = jQuery( this ).attr('data-row');
		var user_id = jQuery( this ).attr('data-value');
		jQuery('#AddWorkReport #row_id').val( row_id );
		jQuery('#AddWorkReport #user_id').val( user_id );
	});
});