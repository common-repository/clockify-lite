jQuery(document).ready(function() {
	"use strict";

	jQuery('#report-listing').hide();

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
	var UploadImage = function( selector, target ) {
		jQuery(document).on( 'click', selector, function (e) {
	        e.preventDefault();
	        jQuery('body').addClass('modal-open');
	        var button = this;
	        var image  = wp.media({
	            title: 'Upload Image',
	            multiple: false
	        }).open().on('select', function (e) {
	            var uploaded_image = image.state().get('selection').first();
	            var location_image = uploaded_image.toJSON().url;
	            jQuery( target ).val( location_image );
	            jQuery( 'body' ).addClass( 'modal-open' );
	        });
	    });
	}
	var SaveFormDetails = function( selector, action, form, modalID, refresh = null ) {
		jQuery(document).on( "click", selector, function(e) {
			e.preventDefault();
			var nounce = ajax_admin.btcl_nonce;
			jQuery.ajax({
				url: ajax_admin.ajax_url,
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
	var EditFormDetails = function( selector, action, form, modalID, type = null ) {
		jQuery(document).on( "click", selector, function(e) {
			e.preventDefault();
			var nounce = ajax_admin.btcl_nonce;

			if ( type == 'default' ) {
				var id     = jQuery( this ).attr('data-id');
				var table  = jQuery( this ).attr('data-table');
				jQuery.ajax({
					url: ajax_admin.ajax_url,
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

									if ( response.inputs[i] == 'gender' ) {
										jQuery(":radio[name='edit_gender'][value='"+response.values[i]+"']").attr('checked', 'checked');
									}
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
					url: ajax_admin.ajax_url,
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
			var nounce = ajax_admin.btcl_nonce;
			jQuery.ajax({
				url: ajax_admin.ajax_url,
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
			var nounce = ajax_admin.btcl_nonce;
			var id     = jQuery( this ).attr('data-id');
			var table  = jQuery( this ).attr('data-table');
			jQuery.ajax({
				url: ajax_admin.ajax_url,
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
	var DeleteEntities = function( selector, action, type = null ) {
		jQuery(document).on( 'click', selector, function (e) {
	        e.preventDefault();
	        var id     = jQuery( this ).attr( 'data-id' );
	        var nounce = ajax_admin.btcl_nonce;
	        var table, pid = '';

	        if ( type.length != undefined ) {
	        	table = jQuery( this ).attr( 'data-table' );
	        }

	        try {
	        	pid = jQuery( this ).attr( 'data-pid' );
	        } catch {

	        }

			jQuery.ajax({
				url: ajax_admin.ajax_url,
				type: "POST",
				data: {
					action: action,
					nounce: nounce,
					id: id,
					table: table,
					pid: pid
				},
				success: function(response) {
					if (response) {
						if ( response.status == "error" ) {
							toastr.error( response.message );
						} else {
							toastr.success( response.message );
							var redirect_url = response.url;
							if ( redirect_url != null && redirect_url.length != undefined ) {
								window.location.replace( response.url );
							} else {
								location.reload();
							}
						}
					}
				}
			});
	    });
	}
	var GenerateReports = function( selector, action, form, todo = null ) {
		jQuery(document).on( "click", selector, function(e) {
			e.preventDefault();
			var nounce = ajax_admin.btcl_nonce;
			jQuery.ajax({
				url: ajax_admin.ajax_url,
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
							if ( todo == 'generate' ) {
								jQuery('#report-listing').show();
								var table = jQuery('#report-listing').DataTable({
		                            'responsive': true,
		                            'destroy': true,
		                            'order': [],
		                            'data': response.reports
		                        });

		                        // Find indexes of rows which have `Yes` in the second column
		                        var indexes1 = table.rows().eq(0).filter(function (rowIdx) {
		                            return table.cell(rowIdx, 2).data() === 'Off day!' ? true : false;
		                        });
		                        
		                        // Add a class to those rows using an index selector
		                        table.rows(indexes1)
		                            .nodes()
		                            .to$()
		                            .addClass('sunday_report');
		                        
		                        // Find indexes of rows which have `Yes` in the second column
		                        var indexes2 = table.rows().eq(0).filter(function (rowIdx) {
		                            return table.cell(rowIdx, 6).data() === 'Absent' ? true : false;
		                        });
		                        
		                        // Add a class to those rows using an index selector
		                        table.rows(indexes2)
		                            .nodes()
		                            .to$()
		                            .addClass('absent_report');
		                        
		                        // Find indexes of rows which have `Yes` in the second column
		                        var indexes3 = table.rows().eq(0).filter(function (rowIdx) {
		                            return table.cell(rowIdx, 6).data() === '<label class="badge badge-warning text-white">Holiday</label>' ? true : false;
		                        });
		                        
		                        // Add a class to those rows using an index selector
		                        table.rows(indexes3)
		                            .nodes()
		                            .to$()
		                            .addClass('holiday_report');
							}
						}
					}
				}
			});
		});
	}
	var SaveSettings = function save( selector, form = null ) {
        jQuery(form).ajaxForm({
            success: function ( response ) {
                jQuery(selector).prop('disabled', false);
                if (response.success) {
                    jQuery('span.text-danger').remove();
                    jQuery(".is-valid").removeClass("is-valid");
                    jQuery(".is-invalid").removeClass("is-invalid");
                    toastr.success(response.data.message);
                } else {
                    jQuery('span.text-danger').remove();
                    if (response.data && jQuery.isPlainObject(response.data)) {
                        jQuery(form + ' :input').each(function () {
                            var input = this;
                            jQuery(input).removeClass('is-valid');
                            jQuery(input).removeClass('is-invalid');
                            if (response.data[input.name]) {
                                var errorSpan = '<span class="text-danger">' + response.data[input.name] + '</span>';
                                jQuery(input).addClass('is-invalid');
                                jQuery(errorSpan).insertAfter(input);
                            } else {
                                jQuery(input).addClass('is-valid');
                            }
                        });
                    } else {
                        var errorSpan = '<span class="text-danger">' + response.data + '<hr></span>';
                        jQuery(errorSpan).insertBefore(form);
                    }
                }
            },
            error: function (response) {
                jQuery(selector).prop('disabled', false);
                toastr.error(response.statusText);
            }
        });
    }

    var SaveProjects = function save( selector, form = null ) {
        jQuery(form).ajaxForm({
            success: function ( response ) {
                jQuery(selector).prop('disabled', false);
                if (response.success) {
                    jQuery('span.text-danger').remove();
                    jQuery(".is-valid").removeClass("is-valid");
                    jQuery(".is-invalid").removeClass("is-invalid");
                    toastr.success(response.data.message);
                    window.location.replace( response.data.url );
                } else {
                    jQuery('span.text-danger').remove();
                    if (response.data && jQuery.isPlainObject(response.data)) {
                        jQuery(form + ' :input').each(function () {
                            var input = this;
                            jQuery(input).removeClass('is-valid');
                            jQuery(input).removeClass('is-invalid');
                            if (response.data[input.name]) {
                                var errorSpan = '<span class="text-danger">' + response.data[input.name] + '</span>';
                                jQuery(input).addClass('is-invalid');
                                jQuery(errorSpan).insertAfter(input);
                            } else {
                                jQuery(input).addClass('is-valid');
                            }
                        });
                        toastr.error(response.data.message);
                    } else {
                        var errorSpan = '<span class="text-danger">' + response.data + '<hr></span>';
                        jQuery(errorSpan).insertBefore(form);
                        toastr.error(response.data.message);
                    }
                }
            },
            error: function (response) {
                jQuery(selector).prop('disabled', false);
                toastr.error(response.statusText);
            }
        });
    }

    var DeleteEntities = function( selector, action, type = null ) {
		jQuery(document).on( 'click', selector, function (e) {
	        e.preventDefault();
	        var id     = jQuery( this ).attr( 'data-id' );
	        var nounce = ajax_admin.btcl_nonce;
	        var table = '';

	        if ( type.length != undefined ) {
	        	table = jQuery( this ).attr( 'data-table' );
	        }

			jQuery.ajax({
				url: ajax_admin.ajax_url,
				type: "POST",
				data: {
					action: action,
					nounce: nounce,
					id: id,
					table: table
				},
				success: function(response) {
					if (response) {
						if ( response.status == "error" ) {
							toastr.error( response.message );
						} else {
							toastr.success( response.message );
							var redirect_url = response.url;
							if ( redirect_url != null && redirect_url.length != undefined ) {
								window.location.replace( response.url );
							} else {
								location.reload();
							}
						}
					}
				}
			});
	    });
	}

    /* Save settings */
    var savesettings = new SaveSettings( '#btcl-save-settings', '#btcl-save-settings-form' );
    var savesettings = new SaveSettings( '#btcl-save-sms-btn', '#btcl-template-form' );
    var savesettings = new SaveSettings( '#btcl-email-template-btn', '#btcl-email-template-form' );
    var savesettings = new SaveSettings( '#btcl-sms-template-btn', '#btcl-sms-template-form' );
	var savesettings = new SaveSettings( '#btcl-save-strings', '#btcl-strings-form' );

	/* time picker */
	var timepicker = new get_timepicker( "#btcl-save-settings-form #halfday_start" );
	var timepicker = new get_timepicker( "#btcl-save-settings-form #halfday_end" );
	var timepicker = new get_timepicker( "#btcl-save-settings-form #lunch_start" );
	var timepicker = new get_timepicker( "#btcl-save-settings-form #lunch_end" );
	var timepicker = new get_timepicker( "#ShiftForm #shift_start" );
	var timepicker = new get_timepicker( "#ShiftForm #shift_end" );
	var timepicker = new get_timepicker( "#ShiftForm #late_time" );
	var timepicker = new get_timepicker( "#EditShiftForm #shift_start" );
	var timepicker = new get_timepicker( "#EditShiftForm #shift_end" );
	var timepicker = new get_timepicker( "#EditShiftForm #late_time" );

	/* Date picker */
	var datepicker = new get_datepicker( "#EmployeesForm #dob" );
	var datepicker = new get_datepicker( '#EmployeesForm #date_of_join' );
	var datepicker = new get_datepicker( "#EditEmployeesForm #dob" );
	var datepicker = new get_datepicker( '#EditEmployeesForm #date_of_join' );
    var datepicker = new get_datepicker( '#HolidayForm #from' );
    var datepicker = new get_datepicker( '#HolidayForm #to' );
    var datepicker = new get_datepicker( '#EditHolidayForm #from' );
    var datepicker = new get_datepicker( '#EditHolidayForm #to' );
    var datepicker = new get_datepicker( '#EventsForm #event_date' );
    var datepicker = new get_datepicker( '#EditEventForm #event_date_e' );

    var datepicker = new get_datepicker( '#starting_date' );
    var datepicker = new get_datepicker( '#due_date' );
    var datepicker = new get_datepicker( '#dob' );
    var datepicker = new get_datepicker( '#fromm' );
    var datepicker = new get_datepicker( '#too' );
    var datepicker = new get_datepicker( '#advancefrom' );
    var datepicker = new get_datepicker( '#advanceto' );
    var datepicker = new get_datepicker( '#AddTargetRecordsForm #date' );

    /* Scripts to upload media file */
    var uploadimage = new UploadImage( '.add-image-btn', '#EmployeesForm #profile_pic' );
    var uploadimage = new UploadImage( '.edit-image-btn', '#EditEmployeesForm #profile_pic' );
	// var uploadimage = new UploadImage( '.upload-image-btn', '#btcl-template-form #logo_image_mail' );

	var saveProjects = new SaveProjects( '#AddTargetsBtn', '#AddTargetsForm' );
	var saveProjects = new SaveProjects( '#EditTargetsBtn', '#EditTargetsForm' );
	var saveProjects = new SaveProjects( '#AddTargetRecordsBtn', '#AddTargetRecordsForm' );

    /* Scripts to save form details */
    var saveformdetails = new SaveFormDetails( '#SaveShiftBtn', 'btcl_save_shifts', '#ShiftForm', '#AddNewShift', true );
	var saveformdetails = new SaveFormDetails( '#SaveDepartBtn', 'btcl_save_departments', '#DepartmentForm', '#AddDepartment', true );
	var saveformdetails = new SaveFormDetails( '#SaveEmployeeBtn', 'btcl_save_employees', '#EmployeesForm', '#AddEployee', true );
	var saveformdetails = new SaveFormDetails( '#SaveHolidayBtn', 'btcl_save_holidays', '#HolidayForm', '#AddHolidays', true );
	var saveformdetails = new SaveFormDetails( '#SaveEventBtn', 'btcl_save_events', '#EventsForm', '#AddEvents', true );

	/* Scripts to edit form details */
	var editformdetails = new EditFormDetails( '.edit-department-details', 'btcl_edit_departments', '#EditDepartmentForm', '#EditDepartment', 'default' );
	var editformdetails = new EditFormDetails( '.edit-shift-details', 'btcl_edit_shifts', '#EditShiftForm', '#EditNewShift', 'default' );
	var editformdetails = new EditFormDetails( '.edit-holiday-details', 'btcl_edit_holidays', '#EditHolidayForm', '#EditHolidays', 'default' );
	var editformdetails = new EditFormDetails( '.edit-leave-details', 'btcl_edit_requests', '#EditLeavesForm', '#EditLeaves', 'default' );
	var editformdetails = new EditFormDetails( '.edit-employee-details', 'btcl_edit_employees', '#EditEmployeesForm', '#EditEployee', 'default' );
	var editformdetails = new EditFormDetails( '.edit-event-details', 'btcl_edit_events', '#EditEventForm', '#EditEvents', 'default' );
	var editformdetails = new EditFormDetails( '.edit-report_data-details', 'btcl_edit_reports', '#EditReportsForm', '#EditReports', 'view' );
	var editformdetails = new EditFormDetails( '.update-report_data-details', 'btcl_fetch_clock_reports', '#FetchReportsForm', '#FetchReports', 'default' );

	/* Scripts to update form details */
	var updateformdetails = new UpdateFormDetails( '#EditDepartBtn', 'btcl_update_departments', '#EditDepartmentForm', '#EditDepartment', true );
	var updateformdetails = new UpdateFormDetails( '#EditShiftBtn', 'btcl_update_shifts', '#EditShiftForm', '#EditNewShift', true );
	var updateformdetails = new UpdateFormDetails( '#EditHolidayBtn', 'btcl_update_holidays', '#EditHolidayForm', '#EditHolidays', true );
	var updateformdetails = new UpdateFormDetails( '#EditLeaveBtn', 'btcl_update_requests', '#EditLeavesForm', '#EditLeaves', true );
	var updateformdetails = new UpdateFormDetails( '#EditEmployeeBtn', 'btcl_update_employees', '#EditEmployeesForm', '#EditEployee', true );
	var updateformdetails = new UpdateFormDetails( '#EditEventBtn', 'btcl_update_events', '#EditEventForm', '#EditEvents', true );
	var updateformdetails = new UpdateFormDetails( '#FetchReportsBtn', 'btcl_update_fetch_reports', '#FetchReportsForm', '#FetchReports', false );

	/* Scripts to delete form details */
	var deleteformdetails = new DeleteFormDetails( '.delete-department-details', 'btcl_delete_departments', true );
	var deleteformdetails = new DeleteFormDetails( '.delete-holiday-details', 'btcl_delete_holidays', true );
	var deleteformdetails = new DeleteFormDetails( '.delete-employee-details', 'btcl_delete_employees', true );
	var deleteformdetails = new DeleteFormDetails( '.delete-event-details', 'btcl_delete_events', true );
	var deleteformdetails = new DeleteFormDetails( '.delete-shift-details', 'btcl_delete_shifts', true );

	var deleteentires = new DeleteEntities( '.delete-entries', 'btcl_delete_all_entries', 'default' );

	/* Delete Project Entities */
    var deletestask   = new DeleteEntities( '.delete-entities', 'btcl_delete_details', 'task' );

	/* Scripts to generate reports */
	var generatestaffreports = new GenerateReports( '#GenerateReportsBtn', 'btcl_generate_staff_report', '#staff-reports-form', 'generate' );

	/* Scripts for datatables */
	var datatable = new get_datatable_script( '#department-listing' );
	var datatable = new get_datatable_script( '#live-status-listing' );

	/* Color picker */
    jQuery('.color-field').wpColorPicker();

	/* Additional scripts */
	jQuery(document).on( "change", '#EmployeesForm #entry', function(e) {
		e.preventDefault();
		var value = jQuery(this).val();
		if ( value == 'new' ){
			jQuery('#default-employees').hide();
		} else {
			jQuery('#default-employees').show();
		}
	});
	jQuery(document).on( "change", '#EmployeesForm #user_id', function(e) {
		e.preventDefault();
		var value  = jQuery(this).val();
		var nounce = ajax_admin.btcl_nonce;
		jQuery.ajax({
			url: ajax_admin.ajax_url,
			type: "POST",
			data: {
				action: 'btcl_fetch_employees',
				nounce: nounce,
				user_id: value
			},
			success: function(response) {
				if (response) {
					if ( response.status == "error" ) {
						toastr.error( response.message );
					} else {
						toastr.success( response.message );
						jQuery('#EmployeesForm #name').val( response.first_name+' '+response.last_name );
						jQuery('#EmployeesForm #email').val( response.user_email );
						jQuery('#EmployeesForm #username').val( response.username );
					}
				}
			}
		});
	});

});