<?php
defined( 'ABSPATH' ) or die();

class BTCLLiteLanguage {
	public static function btclite_load_translation() {
		load_plugin_textdomain( 'clockinator-lite', false, basename( BTCLite_PLUGIN_DIR_PATH ) . '/lang' );
	}
}