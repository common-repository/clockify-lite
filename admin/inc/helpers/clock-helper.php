<?php
defined( 'ABSPATH' ) or die();

/**
 *  Helper class
 */
class BTCLite_Helper{

	public static function btclite_sanitize_array( $input ) {
		// Initialize the new array that will hold the sanitize values		
		$new_input = array();

		// Loop through the input and sanitize each of the values		
		foreach ( $input as $key => $val ) {
			$new_input[ $val['name'] ] = sanitize_text_field( $val['value'] );	
		}
	
		return $new_input;
	}
	
	public static function btclite_value_check( $value ) {
		if ( ! empty ( $value ) ) {
			return $value;
		}
	}

	public static function btclite_insert_intoDB( $table_name, $data ) {
		global $wpdb;
		$table        = $wpdb->base_prefix .''.$table_name;
		$result_check = $wpdb->insert( $table, $data );
		if ( $result_check ) {
			return true;
		} else {
			return false;
		}
	}

	public static function btclite_update_intoDB( $table_name, $data, $where ) {
		global $wpdb;
		$table        = $wpdb->base_prefix .''.$table_name;
		$result_check = $wpdb->update( $table, $data, $where );
		if ( $result_check ) {
			return true;
		} else {
			return false;
		}
	}

	public static function btclite_delete_intoDB( $table_name, $data ) {
		global $wpdb;
		$table        = $wpdb->base_prefix .''.$table_name;
		$result_check = $wpdb->delete( $table, $data );
		if ( $result_check ) {
			return true;
		} else {
			return false;
		}
	}

	public static function btclite_get_users_list() {
		global $wpdb;
		$user_table = esc_sql( $wpdb->base_prefix . "users" );
		$users_data = $wpdb->get_results( "SELECT * FROM $user_table" );
		return $users_data;
	}

	public static function btclite_get_departments() {
		global $wpdb;
		$department_table = esc_sql( $wpdb->base_prefix . "btcl_departments" );
		$department_data  = $wpdb->get_results( "SELECT * FROM $department_table" );
		return $department_data;
	}

	public static function btclite_get_shifts() {
		global $wpdb;
		$btcl_shifts = $wpdb->base_prefix . "btcl_shifts";
		$shifts_data = $wpdb->get_results( "SELECT * FROM $btcl_shifts" );
		return $shifts_data;
	}

	public static function btclite_get_leaves() {
		global $wpdb;
		$btcl_leaves = esc_sql( $wpdb->base_prefix . "btcl_leaves" );
		$leaves_data = $wpdb->get_results( "SELECT * FROM $btcl_leaves" );
		return $leaves_data;
	}

	public static function btclite_get_employees() {
		global $wpdb;
		$btcl_employees = esc_sql( $wpdb->base_prefix . "btcl_employees" );
		$employees_data = $wpdb->get_results( "SELECT * FROM $btcl_employees" );
		return $employees_data;
	}

	public static function btclite_get_shift_members( $shift_id ) {
		$all_employers = self::btclite_get_employees();
		$count         = 0;
		foreach ( $all_employers as $key => $employee ) {
			if ( $employee->shift_id == $shift_id ) {
				$count++;
			}
		}
		return $count;
	}

	public static function btclite_get_employees_pic( $user_id ) {
		global $wpdb;
		$btcl_employees = esc_sql( $wpdb->base_prefix . "btcl_employees" );
		$mylink         = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_employees WHERE user_id = %d", $user_id ) );
		if( isset($mylink->picture)) {
			$avtar_url      = $mylink->picture;
			if ( empty ( $avtar_url ) ) {
				$avtar_url = get_avatar_url( $user_id );
			}
			return $avtar_url;
		} else {
			return false;
		}
		
	}

	public static function btclite_get_row_reports( $user_id, $date ) {
		global $wpdb;
		$btcl_reportss = esc_sql( $wpdb->base_prefix . "btcl_reports" );
		$mylink        = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_reportss WHERE user_id = %d AND date = %d", $user_id, $date ) );
		return $mylink;
	}

	public static function btclite_get_holidays() {
		global $wpdb;
		$btcl_holidays = esc_sql( $wpdb->base_prefix . "btcl_holidays" );
		$holiday_data  = $wpdb->get_results( "SELECT * FROM $btcl_holidays" );
		return $holiday_data;
	}

	public static function btclite_get_events() {
		global $wpdb;
		$btcl_events  = esc_sql( $wpdb->base_prefix . "btcl_events" );
		$events_data  = $wpdb->get_results( "SELECT * FROM $btcl_events" );
		return $events_data;
	}

	public static function btclite_get_date_format() {
		$savesetting = get_option( 'btcl_settings' );

		if ( ! empty ( $savesetting ) ) {
			$date_format  = $savesetting['date_format'];

			if ( ! empty ( $date_format ) ) {
				return $date_format;
			} else {
				return 'F j Y';
			}
		} else {
			return 'F j Y';
		}
	}

	public static function btclite_get_formated_date( $date ) {
		return date( self::btclite_get_date_format(), strtotime( $date ) );
	}

	public static function btclite_get_time_format() {
		$savesetting = get_option( 'btcl_settings' );

		if ( ! empty ( $savesetting ) ) {

			$time_format  = $savesetting['time_format'];
			if ( ! empty ( $time_format ) ) {
				return $time_format;
			} else {
				return 'g:i A';
			}
		} else {
			return 'g:i A';
		}
	}

	public static function btclite_get_currency_position() {
		$savesetting = get_option( 'btcl_settings' );

		if ( ! empty ( $savesetting ) ) {
			$cur_position = $savesetting['cur_position'];
			if ( ! empty ( $cur_position ) ) {
				return $cur_position;
			} else {
				return 'Right';
			}
		} else {
			return 'Right';
		}
	}

	public static function btclite_get_currency_position_html( $string ) {
		$position       = self::btclite_get_currency_position();
		$savesetting    = get_option( 'btcl_settings' );
		$currency_symbl = $savesetting['cur_symbol'];

		if ( $position == 'Right' ) {
			$value = $string.' '.$currency_symbl;
		} else {
			$value = $currency_symbl.' '.$string;
		}
		return $value;
	}

	public static function btclite_month_filter() {
		$months       = array();
		$current_mnth = date("F Y");
		array_push( $months, $current_mnth );
		for ( $i=1; $i < 13; $i++ ) {
			$current_mnth = date( "F Y", strtotime( "-$i month" )  );
			array_push( $months, $current_mnth );
		}
		return $months;
	}

	public static function btclite_get_setting_timezone() {
		$savesetting = get_option( 'btcl_settings' );

		if ( ! empty ( $savesetting ) ) {
			$time_zone = $savesetting['timezone'];

			if ( ! empty ( $time_zone ) ) {
				return $time_zone;
			} else {
				return 'Asia/Kolkata';
			}
		} else {
			return 'Asia/Kolkata';
		}
	}

	public static function btclite_get_formated_time( $time ) {
		return date( self::btclite_get_time_format(), strtotime( $time ) );
	}

	public static function btclite_total_working_time( $times ) {
		$sum = strtotime('00:00:00');
		$totaltime = 0;
		  
		foreach( $times as $element ) {
		      
		    // Converting the time into seconds
		    $timeinsec = strtotime($element) - $sum;
		      
		    // Sum the time with previous value
		    $totaltime = $totaltime + $timeinsec;
		}
		  
		// Totaltime is the summation of all
		// time in seconds
		  
		// Hours is obtained by dividing
		// totaltime with 3600
		$h = intval($totaltime / 3600);
		  
		$totaltime = $totaltime - ($h * 3600);
		  
		// Minutes is obtained by dividing
		// remaining total time with 60
		$m = intval($totaltime / 60);
		  
		// Remaining value is seconds
		$s = $totaltime - ($m * 60);
		  
		// Printing the result
		return ( "$h:$m" );
	}

	public static function btclite_sum_time( $array ) {
        $i = 0;
        $m = 0;
        $h = 0;
        foreach ($array as $time) {
            sscanf($time, '%d:%d:%d', $hour, $min,$sec);
            $i += ($hour * 60 + $min)*60+$sec;
        }
        if ($h = floor($i / 3600)) {
            $i %= 3600;
            if ($m = floor($i / 60)) {
                $i %= 60;
            }
        }
        return sprintf('%02d:%02d:%02d', $h, $m,$i);
    }

    public static function btclite_sum_total_time( $times ) {
	    $minutes = 0; //declare minutes either it gives Notice: Undefined variable
	    // loop throught all the times
	    foreach ($times as $time) {
	        list($hour, $minute) = explode(':', $time);
	        $minutes += $hour * 60;
	        $minutes += $minute;
	    }

	    $hours = floor($minutes / 60);
	    $minutes -= $hours * 60;

	    // returns the time already formatted
	    return sprintf('%02d:%02d', $hours, $minutes);
	}

	public static function btclite_sum_of_time_group_array( $array ) {
		$seconds = 0;
		foreach ($array as $time) {
			list ($hr, $min, $sec) = explode(':',$time);
			$time = 0;
			$time = (((int)$hr) * 60 * 60) + (((int)$min) * 60) + ((int)$sec);
			$seconds = $seconds + $time;
		}

		$hours   = floor($seconds / 3600);
		$minutes = floor(($seconds / 60) % 60);
		$seconds = $seconds % 60;
		
		$hours   = sprintf( "%02d", $hours );
		$minutes = sprintf( "%02d", $minutes );
		$seconds = sprintf( "%02d", $seconds );

		return "$hours:$minutes:$seconds";
	}

    public static function btclite_get_work_time_difference( $start, $din, $end, $dout ) {

		date_default_timezone_set( self::btclite_get_setting_timezone() );

		// Declare and define two dates
		$date1 = strtotime( $din." ".$start );
		$date2 = strtotime( $dout." ".$end );

		$start_date = new DateTime( $din." ".$start, new DateTimeZone( self::btclite_get_setting_timezone() ));
		$end_date   = new DateTime( $dout." ".$end, new DateTimeZone( self::btclite_get_setting_timezone() ));
		$interval   = $start_date->diff($end_date);
		$hours      = $interval->format('%H'); 
		$minutes    = $interval->format('%I');
		$seconds    = $interval->format('%S');
		return $hours.':'.$minutes.':'.$seconds;
	}
	
	public static function btclite_get_time_difference( $start, $end ) {
		$dteStart = new DateTime( $start );
		$dteEnd   = new DateTime( $end );
		$dteDiff  = $dteStart->diff( $dteEnd );
		$interval = $dteDiff->format( "%H:%I:%S" );
		return $interval;
	}

	public static function btclite_get_total_employers() {
		global $wpdb;
	    $table_name  = $wpdb->base_prefix  . 'btcl_employees';
	    $count_query = "select count(*) from $table_name";
	    $num         = $wpdb->get_var( $count_query );
	    return $num;
	}

	public static function btclite_get_total_departments() {
		global $wpdb;
	    $table_name  = $wpdb->base_prefix  . 'btcl_departments';
	    $count_query = "select count(*) from $table_name";
	    $num         = $wpdb->get_var( $count_query );
	    return $num;
	}

	public static function btclite_get_total_shifts() {
		global $wpdb;
	    $table_name  = $wpdb->base_prefix  . 'btcl_shifts';
	    $count_query = "select count(*) from $table_name";
	    $num         = $wpdb->get_var( $count_query );
	    return $num;
	}

	public static function btclite_get_employees_details( $user_id ) {
		global $wpdb;
		$table = $wpdb->base_prefix . "btcl_employees";
		$data  = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE user_id = %d", $user_id ) );
		return $data;
	}

	public static function btclite_get_total_leaves() {
		global $wpdb;
		$btcl_leaves = esc_sql( $wpdb->base_prefix . "btcl_leaves" );
		$leaves_data = $wpdb->get_results( "SELECT * FROM $btcl_leaves" );
		$leaves      = 0;

		foreach ( $leaves_data as $key => $leave ) {
			if ( $leave->status == 'pending' ) {
				$leaves++;
			}
		}
		return $leaves;
	}

	public static function btclite_get_targets() {
		global $wpdb;
		$btcl_employees = $wpdb->base_prefix . "btcl_targets";
		$employees_data = $wpdb->get_results( "SELECT * FROM $btcl_employees" );
		return $employees_data;
	}

	public static function btclite_timezone_list() {
		//Timezone array
		$timezones = DateTimeZone::listAbbreviations(); 
		$tzlist    = DateTimeZone::listIdentifiers();
		$cities1   = array();
		$cities2   = array();
		$cities3   = array();
		foreach( $timezones as $key => $zones ) {
		    foreach( $zones as $id => $zone ) {  
		        array_push( $cities1, $zone["timezone_id"] ); 
		    }
		}
		foreach( timezone_abbreviations_list() as $abbr => $timezone ) {
		    foreach( $timezone as $val ) {
		        if ( isset( $val['timezone_id'] ) ) { 
		            array_push( $cities2, $val['timezone_id'] );
		        }
		    }
		}
		foreach( $tzlist as  $timezone ) {
		    if ( isset( $timezone ) ) {
		        array_push( $cities3, $timezone );
		    }
		} 
		$ALL_timezone    = array_merge( $cities1, $cities2, $cities3 );
		$result_timezone = array_unique( $ALL_timezone ); 
		sort( $result_timezone );

		return $result_timezone;
	}

	public static function btclite_check_user_availability() {
		$status       = 0;
		$user_id      = get_current_user_id();
		$all_eployers = self::btclite_get_employees();

		foreach ( $all_eployers as $key => $employer ) {
			if ( $employer->user_id == $user_id && $employer->status == 'active' ) {
				$status++;
			}
		}

		if ( $status != 0 ) {
			return true;
		} else {
			return false;
		}
	}

	public static function btclite_get_current_url() {
		if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' )   
	         $url = "https://";   
	    else  
	         $url = "http://";   
	    $url.= $_SERVER['HTTP_HOST'];     
	    $url.= $_SERVER['REQUEST_URI'];
	    return $url;
	}

	public static function btclite_get_current_user_data( $id, $value ) {
		$user          = get_userdata( $id );
		$first_name    = $user->first_name;
		$last_name     = $user->last_name;
		$user_login    = $user->user_login;
		$user_nicename = $user->user_nicename;
		$user_email    = $user->user_email;
		$display_name  = $user->display_name;

		if ( ! empty ( $value ) && $value == 'first_name' ) {
			return $user->first_name;
		} elseif( ! empty ( $value ) && $value == 'last_name' ) {
			return $user->last_name;
		} elseif( ! empty ( $value ) && $value == 'user_login' ) {
			return $user->user_login;	 	
		} elseif( ! empty ( $value ) && $value == 'user_nicename' ) {
			return $user->user_nicename;		
		} elseif( ! empty ( $value ) && $value == 'user_email' ) {
			return $user->user_email;			
		} elseif( ! empty ( $value ) && $value == 'display_name' ) {
			return $user->display_name;			
		} elseif( ! empty ( $value ) && $value == 'fullname' ) {
			return $user->first_name.' '.$user->last_name;
		}
	}

	public static function btclite_member_details( $id, $value ) {
		global $wpdb;
		$table  = $wpdb->base_prefix . "btcl_employees";
		$data   = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE user_id = %s", $id ) );

		if ( empty ( $data ) ) {
			$user          = get_userdata( $id );
			$first_name    = ! empty ( $user->first_name ) ? $user->first_name : '';
			$last_name     = ! empty ( $user->last_name ) ? $user->last_name : '';
			$user_login    = ! empty ( $user->user_login ) ? $user->user_login : '';
			$user_nicename = ! empty ( $user->user_nicename ) ? $user->user_nicename : '';
			$user_email    = ! empty ( $user->user_email ) ? $user->user_email : '';
			$display_name  = ! empty ( $user->display_name ) ? $user->display_name : '';

			if ( ! empty ( $value ) && $value == 'firstname' ) {
				return $first_name;
			} elseif( ! empty ( $value ) && $value == 'lastname' ) {
				return $last_name;
			} elseif( ! empty ( $value ) && $value == 'email' ) {
				return $user_email;			
			} elseif( ! empty ( $value ) && $value == 'name' ) {
				return $first_name.' '.$last_name;
			}
		} else {
			if ( $value == 'name' ) {
				return $data->name;
			} elseif ( $value == 'firstname' ) {
				return $data->first_name;
			} elseif ( $value == 'lastname' ) {
				return $data->last_name;
			} elseif ( $value == 'email' ) {
				return $data->email;
			}
		}
	}

	public static function btclite_target_info( $id ) {
		global $wpdb;
		$table  = $wpdb->base_prefix . "btcl_targets";
		$data   = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE id = %s", $id ) );
		return $data;
	}

	public static function btclite_get_percentage( $total, $number ) {
	  if ( $total > 0 ) {
	   return round( ( ( $number / $total ) * 100 ),0);
	  } else {
	    return 0;
	  }
	}

	public static function btclite_get_target_reached_value( $id ) {
		$target = self::btclite_target_info( $id );
		$t_data = 0;
		if ( isset( $target->feedback ) && ! empty( $target->feedback ) ) {
			$feedback = unserialize( $target->feedback );
			foreach ( $feedback as $fkey => $fvalue ) {
				$t_data = $t_data + $fvalue['target'];
			}
		}
		return $t_data;
	}

	public static function btclite_get_target_percentage( $id ) {
		$target = self::btclite_target_info( $id );

		if ( isset( $target->feedback ) && ! empty( $target->feedback ) ) {
			$feedback = unserialize( $target->feedback );

			$t_data = 0;
			foreach ( $feedback as $fkey => $fvalue ) {
				$t_data = $t_data + $fvalue['target'];
			}
			$total = $target->target;
			$total = (int) filter_var($total, FILTER_SANITIZE_NUMBER_INT);  

			if ( $total > $t_data ) {
				$percentage = self::btclite_get_percentage( $total, $t_data );
			} else {
				$percentage = 100;
			}

		} else {
			$percentage = 0;
		}

		return $percentage;
	}

	public static function btclite_verify_value( $value ) {
		if ( isset ( $value ) && ! empty ( $value ) ) {
			return $value;
		}
	}

	public static function btclite_get_notice_class() {
		$colors = array( 'bg-gradient-primary', 'bg-gradient-danger', 'bg-gradient-warning', 'bg-gradient-info', 'bg-gradient-green' );
		shuffle( $colors );
		return $colors[0];
	}

	public static function btclite_front_holiday_html( $id ) {
		global $wpdb;
		$btcl_holidays = esc_sql( $wpdb->base_prefix . "btcl_holidays" );
		$holiday       = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_holidays WHERE id = %d", $id ) );
		$descr         = $holiday->description;
		$start         = $holiday->start;
		$end           = $holiday->end;
		$days          = $holiday->days;
		$html          = '';

		if ( $days == '1' ) {
			$html = esc_html__( 'One day leave on ', 'clockinator-lite' ) . '' . self::btclite_get_formated_date( $start );
		} else {
			$html = esc_html__( $days, 'clockinator-lite' ). ''. esc_html__( ' days leave from ', 'clockinator-lite' ) .''. self::btclite_get_formated_date( $start ) .''. esc_html__( ' to ', 'clockinator-lite' ) . '' . self::btclite_get_formated_date( $end );
		}

		return wp_kses_post( $html );
	}

	public static function btclite_check_year_for_holidays( $date ) {
        $first       = new \DateTime( date( "Y" )."-01-01" );
        $first       = $first->format( "Y-m-d" );
        $plusOneYear = date( "Y" )+1;
        $last        = new \DateTime( $plusOneYear."-12-31" );          
        $last        = $last->format( "Y-m-d" );          
        $all_dates   = self::btclite_get_date_range( $first, $last );
        $date        = date( "Y-m-d", strtotime( $date ) );
        
        if ( in_array( $date, $all_dates ) ) {
        	return true;
        } else {
        	return false;
        }
	}

	public static function btclite_check_mnth_for_holidays( $date ) {
        $first       = new \DateTime( date( "Y-m" )."-01" );
        $first       = $first->format( "Y-m-d" );
        $last        = new \DateTime( date( "Y-m-t" ) );          
        $last        = $last->format( "Y-m-d" );          
        $all_dates   = self::btclite_get_date_range( $first, $last );
        $date        = date( "Y-m-d", strtotime( $date ) );
        
        if ( in_array( $date, $all_dates ) ) {
        	return true;
        } else {
        	return false;
        }
	}

	public static function btclite_get_date_range( $first, $last ) {
		$arr  = array();
		$now  = strtotime( $first );
		$last = strtotime( $last );
		$arr  = array();

		while( $now <= $last ) {
		  array_push( $arr, date( "Y-m-d", $now ) );
		  $now = strtotime( '+1 day', $now );
		}
		return $arr;
	}

	public static function btclite_get_all_dates_reports( $month ) {
		if ( $month == '1' ) {

			$first     = date( "Y-m-01" );
			$last      = date( "Y-m-t", strtotime( $first ) );            
			$all_dates = self::btclite_get_date_range( $first, $last );

		} elseif ( $month == '2' ) {

			$first     = date( "Y-m-01", strtotime( "-1 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );              
			$all_dates = self::btclite_get_date_range( $first, $last );

		}  elseif ( $month == '3' ) {

			$first     = date( "Y-m-01", strtotime( "-2 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );              
			$all_dates = self::btclite_get_date_range( $first, $last );

		}  elseif ( $month == '4' ) {

			$first     = date( "Y-m-01", strtotime( "-3 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );          
			$all_dates = self::btclite_get_date_range( $first, $last );

		}  elseif ( $month == '5' ) {

			$first     = date( "Y-m-01", strtotime( "-4 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );     
			$all_dates = self::btclite_get_date_range( $first, $last );

		}  elseif ( $month == '6' ) {

			$first     = date( "Y-m-01", strtotime( "-5 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );         
			$all_dates = self::btclite_get_date_range( $first, $last );

		}  elseif ( $month == '7' ) {
			$first     = date( "Y-m-01", strtotime( "-6 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );        
			$all_dates = self::btclite_get_date_range( $first, $last );

		}  elseif ( $month == '8' ) {

			$first     = date( "Y-m-01", strtotime( "-7 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );       
			$all_dates = self::btclite_get_date_range( $first, $last );

		}  elseif ( $month == '9' ) {

			$first     = date( "Y-m-01", strtotime( "-8 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );           
			$all_dates = self::btclite_get_date_range( $first, $last );

		}  elseif ( $month == '10' ) {

			$first     = date( "Y-m-01", strtotime( "-9 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );    
			$all_dates = self::btclite_get_date_range( $first, $last );

		}  elseif ( $month == '11' ) {

			$first     = date( "Y-m-01", strtotime( "-10 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );         
			$all_dates = self::btclite_get_date_range( $first, $last );

		}  elseif ( $month == '12' ) {

			$first     = date( "Y-m-01", strtotime( "-11 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );        
			$all_dates = self::btclite_get_date_range( $first, $last );

		}  elseif ( $month == '13' ) {

			$first     = date( "Y-m-01", strtotime( "-12 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );     
			$all_dates = self::btclite_get_date_range( $first, $last );

		} elseif ( $month == '14' ) {

			$first     = date( "Y-m-01", strtotime( "-3 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );
			$last      = date( "Y-m-d", strtotime( "+2 month", strtotime( $last ) ) );      
			$all_dates = self::btclite_get_date_range( $first, $last );

		} elseif( $month == "15" ) {

			$first    = date( "Y-m-01", strtotime( "-6 month" ) );
			$last     = date( "Y-m-t", strtotime( $first ) );
			$last     = date( "Y-m-d", strtotime( "+5 month", strtotime( $last ) ) );    
			$all_dates = self::btclite_get_date_range( $first, $last );

		} elseif( $month == "16" ) {

			$first     = date( "Y-m-01", strtotime( "-9 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );
			$last      = date( "Y-m-d", strtotime( "+8 month", strtotime( $last ) ) );     
			$all_dates = self::btclite_get_date_range( $first, $last );

		} elseif( $month == "17" ) {

			$first     = date( "Y-m-01", strtotime( "-12 month" ) );
			$last      = date( "Y-m-t", strtotime( $first ) );
			$last      = date( "Y-m-d", strtotime( "+11 month", strtotime( $last ) ) ); 
			$all_dates = self::btclite_get_date_range( $first, $last );

		}
		return $all_dates;
	}

	public static function btclite_get_offdays() {

		$btcl_settings = get_option( 'btcl_settings' );
		$offdays       = array();

		$monday_status     = isset( $btcl_settings['monday_status'] ) ? sanitize_text_field( $btcl_settings['monday_status'] ) : 'working';
		$tuesday_status    = isset( $btcl_settings['tuesday_status'] ) ? sanitize_text_field( $btcl_settings['tuesday_status'] ) : 'working';
		$wednesday_status  = isset( $btcl_settings['wednesday_status'] ) ? sanitize_text_field( $btcl_settings['wednesday_status'] ) : 'working';
		$thursday_status   = isset( $btcl_settings['thursday_status'] ) ? sanitize_text_field( $btcl_settings['thursday_status'] ) : 'working';
		$friday_status     = isset( $btcl_settings['friday_status'] ) ? sanitize_text_field( $btcl_settings['friday_status'] ) : 'working';
		$saturday_status   = isset( $btcl_settings['saturday_status'] ) ? sanitize_text_field( $btcl_settings['saturday_status'] ) : 'working';
		$sunday_status     = isset( $btcl_settings['sunday_status'] ) ? sanitize_text_field( $btcl_settings['sunday_status'] ) : 'off';

		if ( $monday_status == 'off' ) {
			array_push( $offdays, 'Monday' );
		}
		if ( $tuesday_status == 'off' ) {
			array_push( $offdays, 'Tuesday' );
		}
		if ( $wednesday_status == 'off' ) {
			array_push( $offdays, 'Wednesday' );
		}
		if ( $thursday_status == 'off' ) {
			array_push( $offdays, 'Thursday' );
		}
		if ( $friday_status == 'off' ) {
			array_push( $offdays, 'Friday' );
		}
		if ( $saturday_status == 'off' ) {
			array_push( $offdays, 'Saturday' );
		}
		if ( $sunday_status == 'off' ) {
			array_push( $offdays, 'Sunday' );
		}

		return $offdays;
	}

	public static function btclite_get_halfdays() {

		$save_settings = get_option( 'wprsmp_settings_data' );
		$halfdays      = array();

		$monday_status     = isset( $btcl_settings['monday_status'] ) ? sanitize_text_field( $btcl_settings['monday_status'] ) : 'working';
		$tuesday_status    = isset( $btcl_settings['tuesday_status'] ) ? sanitize_text_field( $btcl_settings['tuesday_status'] ) : 'working';
		$wednesday_status  = isset( $btcl_settings['wednesday_status'] ) ? sanitize_text_field( $btcl_settings['wednesday_status'] ) : 'working';
		$thursday_status   = isset( $btcl_settings['thursday_status'] ) ? sanitize_text_field( $btcl_settings['thursday_status'] ) : 'working';
		$friday_status     = isset( $btcl_settings['friday_status'] ) ? sanitize_text_field( $btcl_settings['friday_status'] ) : 'working';
		$saturday_status   = isset( $btcl_settings['saturday_status'] ) ? sanitize_text_field( $btcl_settings['saturday_status'] ) : 'working';
		$sunday_status     = isset( $btcl_settings['sunday_status'] ) ? sanitize_text_field( $btcl_settings['sunday_status'] ) : 'off';

		if ( $monday_status == 'off' ) {
			array_push( $halfdays, 'Monday' );
		}
		if ( $tuesday_status == 'off' ) {
			array_push( $halfdays, 'Tuesday' );
		}
		if ( $wednesday_status == 'off' ) {
			array_push( $halfdays, 'Wednesday' );
		}
		if ( $thursday_status == 'off' ) {
			array_push( $halfdays, 'Thursday' );
		}
		if ( $friday_status == 'off' ) {
			array_push( $halfdays, 'Friday' );
		}
		if ( $saturday_status == 'off' ) {
			array_push( $halfdays, 'Saturday' );
		}
		if ( $sunday_status == 'off' ) {
			array_push( $halfdays, 'Sunday' );
		}

		return $halfdays;

	}

	public static function btclite_total_absents( $user_id = null, $month ) {

		if ( empty ( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		global $wpdb;
		$btcl_reports  = esc_sql( $wpdb->base_prefix . "btcl_reports" );
		$all_holidays  = self::btclite_all_holidays();
		$present_days1 = array();
		$present_days2 = array();
		$present_days3 = array();
		$off_days      = self::btclite_get_offdays();
		$all_dates     = self::btclite_get_all_dates_reports( $month );
		$current_date  = date( 'Y-m-d' );

		foreach ( $all_dates as $key => $date ) {
			$report_data = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %d AND login_date = %s", $user_id, $date ) );
			if ( ! empty ( $report_data ) ) {
				array_push( $present_days1, $date );
			}
		}

		foreach ( $all_dates as $key => $date ) {
			if ( ! in_array( $date, $present_days1 ) ) {
				if ( ! in_array( $date, $all_holidays ) ) {
					if ( ! in_array( date( 'l', strtotime( $date ) ), $off_days ) ) {
						if ( $date < $current_date ) {
							array_push( $present_days2, $date  );
							array_push( $present_days3, date( self::btclite_get_date_format(), strtotime( $date ) ) );
						}
					}
				}
			}
		}

		$data  = array(
			'days'    => sizeof( $present_days2 ).' '.esc_html__( 'Days', 'clockinator-lite' ),
			'dates1'  => $present_days2,
			'dates2'  => $present_days3,
			'attend'  => $present_days1,
			'attend1' => sizeof( $present_days1 ),
		);

		return $data;
	}

	public static function btclite_total_attendance_count( $user_id = null, $month ) {
		if ( empty( $user_id ) ) {
			$user_id = get_current_user_id();
		}
		global $wpdb;
		$btcl_reports  = esc_sql( $wpdb->base_prefix . "btcl_reports" );
		$all_dates     = self::btclite_get_all_dates_reports( $month );
		$present_days1 = array();

		foreach ( $all_dates as $key => $date ) {
			$report_data = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %d AND login_date = %s", $user_id, $date ) );

			if ( ! empty ( $report_data ) ) {
				array_push( $present_days1, $date );
			}
		}
		return sizeof( $present_days1 );
	}

	// public static function btclite_get_clock_action_buttons( $user_id ) {
	// 	date_default_timezone_set( BTCLite_Helper::btclite_get_setting_timezone() );

	// 	global $wpdb;
	// 	$html         = '';
	// 	$status       = 0;
	// 	$b_status     = 0;
	// 	$date         = date( 'Y-m-d' );
	// 	$btcl_reports = esc_sql( $wpdb->base_prefix . "btcl_reports" );
	// 	$report_data  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %d AND login_date = %d", $user_id, $date ) );

	// 	$btcl_strings = get_option( 'btcl_string_translation' );
	// 	$clock_in     = isset( $btcl_strings['clock_in'] ) ? sanitize_text_field( $btcl_strings['clock_in'] ) : esc_html__( 'Clock In' );
	// 	$clock_out    = isset( $btcl_strings['clock_out'] ) ? sanitize_text_field( $btcl_strings['clock_out'] ) : esc_html__( 'Clock Out' );
	// 	$break_in     = isset( $btcl_strings['break_in'] ) ? sanitize_text_field( $btcl_strings['break_in'] ) : esc_html__( 'Break In' );
	// 	$break_out    = isset( $btcl_strings['break_out'] ) ? sanitize_text_field( $btcl_strings['break_out'] ) : esc_html__( 'Break Out' );
	// 	$report_btn   = isset( $btcl_strings['session_report'] ) ? sanitize_text_field( $btcl_strings['session_report'] ) : esc_html__( 'Submit Session Report' );


	// 	if ( ! empty ( $report_data ) ) { 

	// 		foreach ( $report_data as $key => $report ) {
	// 			if ( isset ( $report->office_in ) && ! empty ( $report->office_in ) ) {
	// 				if ( empty ( $report->office_out ) ) {
	// 					$html .= '<button id="clock_out_btn" data-value="'.esc_attr( $user_id ).'" type="button" class="btn btn-holder btn-time-out text-white top-add-btn">'.esc_html( $clock_out ).'</button>';
	// 					if ( empty ( $report->report ) ) {
	// 						$html .= '<button id="report_btn" data-value="'.esc_attr( $user_id ).'" data-row="'.esc_attr( $report->id ).'" type="button" class="btn btn-holder btn-time-in text-white top-add-btn">'.esc_html( $report_btn ).'</button>';
	// 					}
	// 					if ( empty( $report->breaks ) ) {
	// 						$html .= '<button id="break_in_btn" data-value="' . esc_attr( $user_id ) . '" data-row="' . esc_attr( $report->id ) . '" type="button" class="btn btn-holder btn-time-in text-white top-add-btn">' . esc_html( $break_in ) . '</button>';
	// 					} else {
	// 						$b_status    = 0;
	// 						$breaks_data = unserialize( $report->breaks );
	// 						foreach ( $breaks_data as $key => $b_value ) {
	// 							if ( ! empty ( $b_value['break_in'] ) && empty ( $b_value['break_out'] ) ) {
	// 								$html .= '<button id="break_out_btn" data-value="' . esc_attr( $user_id ) . '" data-row="' . esc_attr( $report->id ) . '" type="button" class="btn btn-holder btn-time-out text-white top-add-btn">' . esc_html( $break_out ) . '</button>';
	// 								$b_status++;
	// 							}
	// 						}
	// 						if ( $b_status == 0 ) {
	// 							$html .= '<button id="break_in_btn" data-value="' . esc_attr( $user_id ) . '" data-row="' . esc_attr( $report->id ) . '" type="button" class="btn btn-holder btn-time-in text-white top-add-btn">' . esc_html( $break_in ) . '</button>';
	// 						}
	// 					}
	// 					$status = 1;
	// 				}
	// 			}
	// 		}

	// 		if ( $status == 0 ) {
	// 			$html .= '<button id="clock_in_btn" data-value="'.esc_attr( $user_id ).'" type="button" class="btn btn-holder btn-time-in text-white top-add-btn">'.esc_html( $clock_in ).'</button>';
	// 		}

	// 	} else {
	// 		$html .= '<button id="clock_in_btn" data-value="'.esc_attr( $user_id ).'" type="button" class="btn btn-holder btn-time-in text-white top-add-btn">'.esc_html( $clock_in ).'</button>';
	// 	}

	// 	return wp_kses_post( $html );
	// }

// --------------------------- //
	public static function btclite_get_clock_action_buttons( $user_id ) {
		date_default_timezone_set( BTCLite_Helper::btclite_get_setting_timezone() );

		global $wpdb;
		$html          = '';
		$pstatus       = 0;
		$status        = 0;
		$b_status      = 0;
		$date          = date( 'Y-m-d' );
		$previous_date = date( 'Y-m-d', strtotime( $date . " - 1 day" ) );
		$btcl_reports  = $wpdb->base_prefix . "btcl_reports";
		$report_data   = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %s AND login_date = %s", $user_id, $previous_date ) );

		if ( ! empty ( $report_data ) ) {
			foreach ( $report_data as $key => $report ) {
				if ( isset ( $report->office_in ) && ! empty ( $report->office_in ) ) {
					if ( empty ( $report->office_out ) || $report->office_out == '00:00:00' ) {
						$pstatus++;
					}
				}
			}
		}

		if ( $pstatus == 0 ) {
			$report_data  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %s AND login_date = %s", $user_id, $date ) );
		}

		$btcl_strings = get_option( 'btcl_string_translation' );
		$clock_in     = isset( $btcl_strings['clock_in'] ) ? sanitize_text_field( $btcl_strings['clock_in'] ) : esc_html__( 'Clock In', 'clockinator' );
		$clock_out    = isset( $btcl_strings['clock_out'] ) ? sanitize_text_field( $btcl_strings['clock_out'] ) : esc_html__( 'Clock Out', 'clockinator' );
		$break_in     = isset( $btcl_strings['break_in'] ) ? sanitize_text_field( $btcl_strings['break_in'] ) : esc_html__( 'Break In', 'clockinator' );
		$break_out    = isset( $btcl_strings['break_out'] ) ? sanitize_text_field( $btcl_strings['break_out'] ) : esc_html__( 'Break Out', 'clockinator' );
		$report_btn   = isset( $btcl_strings['session_report'] ) ? sanitize_text_field( $btcl_strings['session_report'] ) : esc_html__( 'Submit Session Report', 'clockinator' );


		if ( ! empty ( $report_data ) ) { 

			foreach ( $report_data as $key => $report ) {
				if ( isset ( $report->office_in ) && ! empty ( $report->office_in ) ) {
					if ( empty ( $report->office_out ) || $report->office_out == '00:00:00' ) {
						$html .= '<button id="clock_out_btn" data-row="'.esc_attr( $report->id ).'" data-value="'.esc_attr( $user_id ).'" type="button" class="btn btn-holder btn-time-out text-white top-add-btn">'.esc_html( $clock_out ).'</button>';
						if ( empty ( $report->report ) ) {
							$html .= '<button id="report_btn" data-value="'.esc_attr( $user_id ).'" data-row="'.esc_attr( $report->id ).'" type="button" class="btn btn-holder btn-time-in text-white top-add-btn">'.esc_html( $report_btn ).'</button>';
						}
						if ( empty( $report->breaks ) ) {
							$html .= '<button id="break_in_btn" data-value="' . esc_attr( $user_id ) . '" data-row="' . esc_attr( $report->id ) . '" type="button" class="btn btn-holder btn-time-in text-white top-add-btn">' . esc_html( $break_in ) . '</button>';
						} else {
							$b_status    = 0;
							$breaks_data = unserialize( $report->breaks );
							foreach ( $breaks_data as $key => $b_value ) {
								if ( ! empty ( $b_value['break_in'] ) && empty ( $b_value['break_out'] ) ) {
									$html .= '<button id="break_out_btn" data-value="' . esc_attr( $user_id ) . '" data-row="' . esc_attr( $report->id ) . '" type="button" class="btn btn-holder btn-time-out text-white top-add-btn">' . esc_html( $break_out ) . '</button>';
									$b_status++;
								}
							}
							if ( $b_status == 0 ) {
								$html .= '<button id="break_in_btn" data-value="' . esc_attr( $user_id ) . '" data-row="' . esc_attr( $report->id ) . '" type="button" class="btn btn-holder btn-time-in text-white top-add-btn">' . esc_html( $break_in ) . '</button>';
							}
						}
						$status = 1;
					}
				}
			}

			if ( $status == 0 ) {
				$html .= '<button id="clock_in_btn" data-value="'.esc_attr( $user_id ).'" type="button" class="btn btn-holder btn-time-in text-white top-add-btn">'.esc_html( $clock_in ).'</button>';
			}

		} else {
			$html .= '<button id="clock_in_btn" data-value="'.esc_attr( $user_id ).'" type="button" class="btn btn-holder btn-time-in text-white top-add-btn">'.esc_html( $clock_in ).'</button>';
		}

		return wp_kses_post( $html );
	}

	public static function btclite_check_staff_realtime_status( $user_id ) {
		global $wpdb;
		$status       = 0;
		$return       = '';
		$date         = date( 'Y-m-d' );
		$btcl_reports = esc_sql( $wpdb->base_prefix . "btcl_reports" );
		$report_data  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %d AND login_date = %d", $user_id, $date ) );

		if ( ! empty ( $report_data ) ) {
			foreach ( $report_data as $key => $report ) {
				if ( isset ( $report->office_in ) && ! empty ( $report->office_in ) ) {
					if ( empty ( $report->office_out ) ) {
						$return = true;
						$status = 1;
					}
				}
			}
			if ( $status == 0 ) {
				$return = false;
			}
		} else {
			$return = false;
		}
		return $return;
	}

	public static function btclite_get_upcoming_hoidays() {
        $first        = date( "Y-m-d" );         
        $last         = date( "Y-m-t" );          
        $all_dates    = self::btclite_get_date_range( $first, $last );
		$all_holidays = self::btclite_get_holidays();
		$html         = '';
        foreach ( $all_holidays as $key => $holiday ) {
        	if ( $holiday->status == 'active' && ( in_array( $holiday->start, $all_dates ) ) ) {
        		$html .= '<div class="card">
				            <div class="card-header" role="tab" id="up_holi-heading-'.esc_attr( $key ).'">
				              <h6 class="mb-0">
				                <a data-toggle="collapse" href="#upcoming_holiday-'.esc_attr( $key ).'" aria-expanded="false" aria-controls="upcoming_holiday-'.esc_attr( $key ).'" class="collapsed">
				                  '.esc_html__( $holiday->name, 'clockinator-lite' ).'
				                </a>
				              </h6>
				            </div>
				            <div id="upcoming_holiday-'.esc_attr( $key ).'" class="collapse" role="tabpanel" aria-labelledby="up_holi-heading-'.esc_attr( $key ).'" data-parent="#upcoming_holidays-5" style="">
				              <div class="card-body">
				                <div class="row">
				                  <div class="col-12">
				                    '.self::btclite_front_holiday_html( $holiday->id ).'                         
				                  </div>
				                </div>
				              </div>
				            </div>
	          			</div>';
        	}

        }
        return wp_kses_post( $html );
	}

	public static function btclite_get_upcoming_events() {
        $first        = date( "Y-m-d" );
        $last         = date( "Y-m-t" );          
        $all_dates    = self::btclite_get_date_range( $first, $last );
		$all_events = self::btclite_get_events();
		$html         = '';
        foreach ( $all_events as $key => $event ) {        	
        	if ( $event->status == 'active' && ( in_array( $event->event_date, $all_dates ) ) ) {
        		$html .= '<div class="card">
				            <div class="card-header" role="tab" id="up_event-heading-'.esc_attr( $key ).'">
				              <h6 class="mb-0">
				                <a data-toggle="collapse" href="#upcoming_events-'.esc_attr( $key ).'" aria-expanded="false" aria-controls="upcoming_events-'.esc_attr( $key ).'" class="collapsed">
				                  '.esc_html__( $event->name, 'clockinator-lite' ).'
				                </a>
				              </h6>
				            </div>
				            <div id="upcoming_events-'.esc_attr( $key ).'" class="collapse" role="tabpanel" aria-labelledby="up_event-heading-'.esc_attr( $key ).'" data-parent="#up-coming-events-5" style="">
				              <div class="card-body">
				                <div class="row">
				                  <div class="col-12">
				                     <p>'.esc_html__( $event->description ).'</p>                    
				                  </div>
				                </div>
				              </div>
				            </div>
	          			</div>';
        	}

        }
        return wp_kses_post( $html );
	}

	public static function btclite_get_current_date_range() {
		$first       = new \DateTime(  date( "Y-m" )."-01" );                                                                
		$first       = $first->format( "Y-m-d" );
		$plusOneYear = date("Y")+1;
		$last        = new \DateTime( $plusOneYear."-12-31" );                                                                   
		$last        = $last->format( "Y-m-d" );
		$all_dates   = self::btclite_get_date_range( $first, $last );
		return $all_dates;
	}

	public static function btclite_all_holidays() {
		$all_holidays = self::btclite_get_holidays();
		$holiday_arr1 = array();
		$holiday_arr2 = array();

		$first       = new \DateTime(  date( "Y-" )."01-01" );                                                                
		$first       = $first->format( "Y-m-d" );
		$plusOneYear = date("Y")+1;
		$last        = new \DateTime( $plusOneYear."-12-31" );                                                                   
		$last        = $last->format( "Y-m-d" );
		$all_dates   = self::btclite_get_date_range( $first, $last );

		foreach ( $all_dates as $key => $date ) {
			if ( ! empty ( $all_holidays  ) ) {
				foreach ( $all_holidays as $holiday_key => $holiday ) {
					if ( $holiday->start == $date ) {
						$start_date = $holiday->start;
						$end_date   = $holiday->end;
						if ( $end_date == $start_date ) { 
						    array_push( $holiday_arr1, $start_date );
						} else {
							for ( $i=0; $i < $holiday->days ; $i++ ) {
								$start_date1 = date( 'Y-m-d', strtotime( $start_date . ' +'.$i.' day' ) );
								array_push( $holiday_arr2, $start_date1 );
							}
						}
					}
				}
			}
		}
		$all_holidays = array_merge( $holiday_arr1, $holiday_arr2 );
		return $all_holidays;
	}

	public static function btclite_get_total_working_time( $user_id, $month ) {

		/* Get employer data */
		global $wpdb;
		$btcl_employees = esc_sql( $wpdb->base_prefix . "btcl_employees" );
		$employer_data  = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $btcl_employees WHERE user_id = %d", $user_id ) );

		/* Get all holidays */
	    $all_dates      = self::btclite_get_all_dates_reports( $month );
	    $total_hours    = array();
		$totalb_hours   = array();
		$btcl_reports   = esc_sql( $wpdb->base_prefix . "btcl_reports" );

	    foreach ( $all_dates as $date_key => $date ) {
	    	/* Get reports */
			$report_data = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %d AND login_date = %s", $user_id, $date ) );
			if ( ! empty ( $report_data ) ) {
				foreach ( $report_data as $report_key => $report ) {
					$working_hours = ! empty( $report->working_hours ) ? self::btclite_total_working_time( array( $report->working_hours ) ) : '';
					array_push( $total_hours, $report->working_hours );

					$breaks_data = ! empty( $report->breaks ) ? unserialize( $report->breaks ) : '';
					if ( ! empty ( $breaks_data ) ) {
						foreach ( $breaks_data as $key => $breaks ) {
							$break_in  = ! empty( $breaks['break_in'] ) ? self::btclite_get_formated_time( $breaks['break_in'] ) : '';
							$break_out = ! empty( $breaks['break_out'] ) ? self::btclite_get_formated_time( $breaks['break_out'] ) : '';
							if ( ! empty( $break_in ) && ! empty( $break_out ) ) {
								$break_time = self::btclite_get_time_difference( $break_in, $break_out );
								array_push( $totalb_hours, $break_time );
							}
						}
					}
				}
			}
		}
		$total_hours  = self::btclite_total_working_time( $total_hours );
		$total_bhours = self::btclite_total_working_time( $totalb_hours );
		$actual_time  = $total_hours - $total_bhours;
		return $actual_time;
	}

	public static function btclite_get_today_single_working_hours( $row_id = null ) {
		$totalb_hours = array();
		$total_hours  = array();

		global $wpdb;
		$table  = $wpdb->base_prefix . "btcl_reports";
		$report = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE id = %d", $row_id ) );

		if ( !empty( $report ) ) {
			$office_in    = isset( $report->office_in ) ? $report->office_in : '';
			$office_out   = isset( $report->office_out ) ? $report->office_out : '';
			$current_time = date( 'H:i:s' );
			$current_date = date( 'Y-m-d' );

			if ( !empty($office_in) && !empty($office_out) ) {
				$totaltime = $report->working_hours;
			} elseif ( !empty($office_in) && ( empty( $office_out ) || $office_out == '00:00:00' ) ) {
				$datein    = isset( $report->date_in ) ? $report->date_in : '';
				$start     = date( "H:i:s", strtotime( $office_in ) );
				$end       = date( "H:i:s", strtotime( $current_time ) );
				$totaltime = self::btclite_get_work_time_difference( $start, $datein, $end, $current_date );
			}

			$breaks_data = unserialize( $report->breaks );
			if (isset($report->breaks) && !empty($breaks_data)){
				foreach ( $breaks_data as $b_key => $b_value ) {
					if ( ! empty ( $b_value['break_in'] ) && !empty ( $b_value['break_out'] ) ) {
						$break_time = self::btclite_get_time_difference( $b_value['break_in'], $b_value['break_out'] );
						array_push( $totalb_hours, $break_time );
					}
				}
			}
			
			if (!empty($totalb_hours)) {
				$totaltime = self::btclite_get_time_difference( $totaltime, self::btclite_sum_time( $totalb_hours ) );
			}
			return $totaltime;
		}
	}

	public static function btclite_last_day_working_hours() {

		/* Get reports */
		global $wpdb;
		$current_date  = date( 'Y-m-d' );
		$previous_date = date( 'Y-m-d', strtotime( $current_date . " - 1 day" ) );
		$user_id       = get_current_user_id();
		$btcl_reports  = $wpdb->base_prefix . "btcl_reports";
		$report_data   = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %d AND login_date = %s", $user_id, $previous_date ) );
		$total_hours   = array();
		$actual_time   = esc_html__( '00:00', 'clockinator' );

		if ( ! empty ( $report_data ) ) {
			foreach ( $report_data as $report_key => $report ) {
				$working_hours = self::btclite_get_today_single_working_hours( $report->id );
				if ( ! empty ( $working_hours ) ) {
					array_push( $total_hours, $working_hours );
				}
			}
			$actual_time = self::btclite_sum_of_time_group_array( $total_hours ). ' ' .esc_html__( 'Hours', 'clockinator' );
		}
		return $actual_time;
	}

	public static function btclite_get_birthday_name() {
		$employee_data = self::btclite_get_employees();
		$birthday_data = array();
		foreach ( $employee_data as $key => $employee ) {
			$extra = $employee->extra;
			$extra = unserialize( $extra );
			$dob   = $extra['dob'];
			$dob   = date( "m-d", strtotime( $dob ) );
			$date  = date( 'm-d' );

			if ( $dob == $date ) {
				array_push( $birthday_data, $employee->name );
			}
		}
		return $birthday_data;
	}

	public static function btclite_get_department_members( $department_id ) {
		$all_employers = self::btclite_get_employees();
		$count         = 0;
		foreach ( $all_employers as $key => $employee ) {
			if ( $employee->department_id == $department_id ) {
				$count++;
			}
		}
		return $count;
	}

	public static function btclite_get_user_location( $ip ) {

		$city = $regionName = $country = $continent = '';

		$request = wp_remote_get( 'http://ip-api.com/php/'.$ip.'?fields=status,message,continent,continentCode,country,countryCode,region,regionName,city,district,zip,lat,lon,timezone,isp,org,as,query' );

		if (!is_null($request)){
			$request = unserialize( $request['body'] );

			if ( ! empty ( $request['city'] ) ) {
				$city = $request['city'];
			} else {
				$city = '';
			}

			if ( ! empty ( $request['regionName'] ) ) {
				$regionName = $request['regionName'];
			} else {
				$regionName = '';
			}

			if ( ! empty ( $request['country'] ) ) {
				$country = $request['country'];
			} else {
				$country = '';
			}

			if ( ! empty ( $request['continent'] ) ) {
				$continent = $request['continent'];
			} else {
				$continent = '';
			}
		}

		return $city.', '.$regionName.', '.$country.', '.$continent;
	}

	public static function btclite_get_total_working_hour_byday( $user_id, $id ) {

		/* Get employer data */
		global $wpdb;
	    $total_hours  = array();
		$totalb_hours = array();
		$btcl_reports = $wpdb->base_prefix . "btcl_reports";

    	/* Get reports */
		$report_data = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $btcl_reports WHERE user_id = %d AND id = %s", $user_id, $id ) );
		if ( ! empty ( $report_data ) ) {
			foreach ( $report_data as $report_key => $report ) {
				$working_hours = ! empty( $report->working_hours ) ? self::btclite_total_working_time( array( $report->working_hours ) ) : '';
				array_push( $total_hours, $report->working_hours );
				$breaks_data = ! empty( $report->breaks ) ? unserialize( $report->breaks ) : '';
				if ( ! empty ( $breaks_data ) ) {
					foreach ( $breaks_data as $key => $breaks ) {
						$break_in  = ! empty( $breaks['break_in'] ) ? self::btclite_get_formated_time( $breaks['break_in'] ) : '';
						$break_out = ! empty( $breaks['break_out'] ) ? self::btclite_get_formated_time( $breaks['break_out'] ) : '';
						if ( ! empty( $break_in ) && ! empty( $break_out ) ) {
							$break_time = self::btclite_get_time_difference( $break_in, $break_out );
							array_push( $totalb_hours, $break_time );
						}
					}
				}
			}
		}
		
		$total_hours  = self::btclite_total_working_time( $total_hours );
		$total_bhours = self::btclite_total_working_time( $totalb_hours );
		$actual_time  = $total_hours - $total_bhours;
		return $actual_time;
	}

	public static function btclite_employee_login_status( $user_id = null, $office_in, $office_out, $user_location, $ip ) {

		if ( empty ( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		$btcl_email_settings = get_option( 'btcl_email_settings' );
		$email_enable        = isset( $btcl_email_settings['email_enable'] ) ? $btcl_email_settings['email_enable'] : '';
		$clockin_clockout    = isset( $btcl_email_settings['clockin_clockout'] ) ? $btcl_email_settings['clockin_clockout'] : '';

		$all_employers = self::btclite_get_employees();
		$login_sub     = esc_html__( 'Login Alert From Clockify', 'clockinator-lite' );
		$logout_sub    = esc_html__( 'Logout Alert From Clockify', 'clockinator-lite' );
		$mail_heading  = esc_html__( 'Employee Login/Logout Details', 'clockinator-lite' );
		$mail_logo     = isset( $btcl_email_settings['logo_image_mail'] ) ? $btcl_email_settings['logo_image_mail'] : '';

		$full_name = self::btclite_member_details( $user_id, $name );

		// Admin Mail Address
		$admin_email = get_option( 'admin_email' );
		$headers     = array( 'Content-Type: text/html; charset=UTF-8' );

		if ( ! empty ( $office_out ) ) {
			$subject = $logout_sub;
		} else {
			$subject = $login_sub;
		}

		$message = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody>';
		if ( ! empty ( $mail_logo ) ) {
			$message .= '<tr>
							<td bgcolor="#ffffff" align="center">
								<!--[if (gte mso 9)|(IE)]>
								<table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
								<tr>
								<td align="center" valign="top" width="500">
								<![endif]-->
								<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 670px;" class="wrapper">
									<tbody><tr>
										<td align="center" valign="top" style="padding: 15px 0;" class="logo">
											<a href="'.esc_attr( esc_url( home_url('/') ) ).'" target="_blank">
												<img alt="Logo" width="100" height="100" src="'.esc_attr( esc_url( $mail_logo ) ).'" width="60" height="60" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
											</a>
										</td>
									</tr>
								</tbody></table>
								<!--[if (gte mso 9)|(IE)]>
								</td>
								</tr>
								</table>
								<![endif]-->
							</td>
						</tr>';
		}
		$message .= '   <tr>
							<td bgcolor="#ffffff" align="center" style="padding: 15px;">
								<!--[if (gte mso 9)|(IE)]>
								<table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
								<tr>
								<td align="center" valign="top" width="500">
								<![endif]-->
								<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 670px;" class="responsive-table">
									<tbody>
									<tr>
										<td>
											<!-- COPY -->
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tbody>
												<tr>
													<td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; font-weight: 700;color: #FF9800; padding-top: 30px;" class="padding-copy">'.esc_html__( $mail_heading, 'clockinator-lite' ).'</td>
												</tr>
											</tbody>
											</table>
										</td>
									</tr>
								</tbody>
								</table>
								<!--[if (gte mso 9)|(IE)]>
								</td>
								</tr>
								</table>
								<![endif]-->
							</td>
						</tr>
						<tr>
						<td bgcolor="#ffffff" align="center" style="padding: 15px;" class="padding">
							<!--[if (gte mso 9)|(IE)]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
							<tr>
							<td align="center" valign="top" width="500">
							<![endif]-->
							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 670px;" class="responsive-table">
								<tbody>
									<tr>
										<td style="padding: 10px 0 0 0; border-top: 1px dashed #aaaaaa;">
											<!-- TWO COLUMNS -->
											<table cellspacing="0" cellpadding="0" border="0" width="100%">
												<tbody><tr>
													<td valign="top" class="mobile-wrapper">
														<!-- LEFT COLUMN -->
														<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
															<tbody><tr>
																<td style="padding: 0 0 10px 0;">
																	<table cellpadding="0" cellspacing="0" border="0" width="100%">
																		<tbody><tr>
																			<td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">Detail</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														<!-- RIGHT COLUMN -->
														<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
															<tbody><tr>
																<td style="padding: 0 0 10px 0;">
																	<table cellpadding="0" cellspacing="0" border="0" width="100%">
																		<tbody><tr>
																			<td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">Value</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
											</tbody></table>
										</td>
									</tr>
									<tr>
										<td style="padding: 10px 0 0 0; border-top: 1px dashed #aaaaaa;">
											<!-- TWO COLUMNS -->
											<table cellspacing="0" cellpadding="0" border="0" width="100%">
												<tbody>
												<tr>
													<td valign="top" class="mobile-wrapper">
														<!-- LEFT COLUMN -->
														<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
															<tbody><tr>
																<td style="padding: 0 0 10px 0;">
																	<table cellpadding="0" cellspacing="0" border="0" width="100%">
																		<tbody><tr>
																			<td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">'.esc_html__( 'Name', 'clockinator-lite' ).'</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														<!-- RIGHT COLUMN -->
														<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
															<tbody><tr>
																<td style="padding: 0 0 10px 0;">
																	<table cellpadding="0" cellspacing="0" border="0" width="100%">
																		<tbody><tr>
																			<td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">'.esc_html( $full_name ).'</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td valign="top" class="mobile-wrapper">
														<!-- LEFT COLUMN -->
														<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
															<tbody><tr>
																<td style="padding: 0 0 10px 0;">
																	<table cellpadding="0" cellspacing="0" border="0" width="100%">
																		<tbody><tr>
																			<td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">'.esc_html__( 'Date', 'clockinator-lite' ).'</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														<!-- RIGHT COLUMN -->
														<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
															<tbody><tr>
																<td style="padding: 0 0 10px 0;">
																	<table cellpadding="0" cellspacing="0" border="0" width="100%">
																		<tbody><tr>
																			<td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">'.esc_html( date( self::btclite_get_date_format(), strtotime( date( 'Y-m-d' ) ) ) ).'</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>
												<tr>
													<td valign="top" class="mobile-wrapper">
														<!-- LEFT COLUMN -->
														<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
															<tbody><tr>
																<td style="padding: 0 0 10px 0;">
																	<table cellpadding="0" cellspacing="0" border="0" width="100%">
																		<tbody><tr>
																			<td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">'.esc_html__( 'Office IN', 'clockinator-lite' ).'</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														<!-- RIGHT COLUMN -->
														<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
															<tbody><tr>
																<td style="padding: 0 0 10px 0;">
																	<table cellpadding="0" cellspacing="0" border="0" width="100%">
																		<tbody><tr>
																			<td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">'.esc_html( date( self::btclite_get_time_format(), strtotime( $office_in ) ) ).'</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>';
							if ( ! empty( $office_out ) ) {
								$message .= '   <tr>
													<td valign="top" class="mobile-wrapper">
														<!-- LEFT COLUMN -->
														<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
															<tbody><tr>
																<td style="padding: 0 0 10px 0;">
																	<table cellpadding="0" cellspacing="0" border="0" width="100%">
																		<tbody><tr>
																			<td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">'.esc_html__( 'Office OUT', 'clockinator-lite' ).'</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
														<!-- RIGHT COLUMN -->
														<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
															<tbody><tr>
																<td style="padding: 0 0 10px 0;">
																	<table cellpadding="0" cellspacing="0" border="0" width="100%">
																		<tbody><tr>
																			<td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">'.esc_html( date( self::btclite_get_time_format(), strtotime( $office_out ) ) ).'</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</td>
												</tr>';
							}
							
							$message .= ' <tr>
											<td valign="top" class="mobile-wrapper">
												<!-- LEFT COLUMN -->
												<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
													<tbody><tr>
														<td style="padding: 0 0 10px 0;">
															<table cellpadding="0" cellspacing="0" border="0" width="100%">
																<tbody><tr>
																	<td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">'.esc_html__( 'User IP', 'clockinator-lite' ).'</td>
																</tr>
															</tbody></table>
														</td>
													</tr>
												</tbody></table>
												<!-- RIGHT COLUMN -->
												<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
													<tbody>
														<tr>
														<td style="padding: 0 0 10px 0;">
															<table cellpadding="0" cellspacing="0" border="0" width="100%">
																<tbody>
																<tr>
																	<td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">'.esc_html( $ip ).'</td>
																</tr>
																</tbody>
															</table>
														</td>
														</tr>
													</tbody>
												</table>
											</td>
											</tr>
											<tr>
												<td valign="top" class="mobile-wrapper">
														<!-- LEFT COLUMN -->
														<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
															<tbody><tr>
																<td style="padding: 0 0 10px 0;">
																	<table cellpadding="0" cellspacing="0" border="0" width="100%">
																		<tbody><tr>
																			<td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">'.esc_html__( 'User Location', 'clockinator-lite' ).'</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody>
													</table>
													<!-- RIGHT COLUMN -->
													<table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
														<tbody>
														<tr>
															<td style="padding: 0 0 10px 0;">
																<table cellpadding="0" cellspacing="0" border="0" width="100%">
																	<tbody><tr>
																		<td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">'.esc_html( $user_location ).'</td>
																	</tr>
																</tbody></table>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
										</tbody>
										</table>
										</td>
									</tr>
								</tbody>
							</table>
							</td>
						</tr>
					</tbody>
				</table>';

		$enquerysend = wp_mail( $admin_email, $subject, $message, $headers );
	}

	public static function btclite_get_initials( $first, $last = null ) {

		$first = substr( $first, 0, 1 );
		$name  = $first;
		if ( ! empty ( $last ) ) {
			$last = substr( $last, 0, 1 );
			$name = $first.''.$last;
		}
		return $name;

	}
}