<h4 class="card-title"><?php esc_html_e( 'Holidays', 'clockinator-lite' ); ?></h4>
<div class="row">
  	<div class="col-lg-12 grid-margin stretch-card">
	  	<div class="card no-shadow">
	    	<div class="card-body">
	      		<div class="mt-4">
	        		<div class="accordion accordion-solid-header" id="holidays-5" role="tablist">
	          			<?php
                            $all_holidays = BTCLite_Helper::btclite_get_holidays();
                            foreach ( $all_holidays as $key => $holiday ) {
                            	if ( $holiday->status == 'active' && ( BTCLite_Helper::btclite_check_year_for_holidays( $holiday->start ) == true || BTCLite_Helper::btclite_check_year_for_holidays( $holiday->end ) == true ) ) {
                        ?>
	          			<div class="card">
				            <div class="card-header" role="tab" id="holi-heading-<?php echo esc_attr( $key ); ?>">
				              <h6 class="mb-0">
				                <a data-toggle="collapse" href="#holiday-<?php echo esc_attr( $key ); ?>" aria-expanded="false" aria-controls="holiday-<?php echo esc_attr( $key ); ?>" class="collapsed">
				                  <strong><?php echo esc_html_e( ( $key+1 ).'. ', 'clockinator-lite' ); ?></strong><?php esc_html_e( $holiday->name, 'clockinator-lite' ); ?>
				                </a>
				              </h6>
				            </div>
				            <div id="holiday-<?php echo esc_attr( $key ); ?>" class="collapse" role="tabpanel" aria-labelledby="holi-heading-<?php echo esc_attr( $key ); ?>" data-parent="#holidays-5" style="">
				              <div class="card-body">
				                <div class="row">
				                  <div class="col-12">
				                    <?php echo BTCLite_Helper::btclite_front_holiday_html( $holiday->id ); ?>                          
				                  </div>
				                </div>
				              </div>
				            </div>
	          			</div>
	          			<?php } } ?>
	        		</div>
	      		</div>
	    	</div>
	  	</div>
	</div>
</div>