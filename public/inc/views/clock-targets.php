<?php
defined( 'ABSPATH' ) or wp_die();
$action = '';
if ( isset( $_GET['action'] ) ) {
    $action = sanitize_text_field( $_GET['action'] );
}

if ( $action == 'tar_view' ) {
  require_once BTCLite_PLUGIN_DIR_PATH . '/public/inc/views/targets/target.php';
} else {
  require_once BTCLite_PLUGIN_DIR_PATH . '/public/inc/views/targets/view.php';
}
?>