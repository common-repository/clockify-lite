<?php
defined( 'ABSPATH' ) or die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );
$action = '';
if ( isset( $_GET['action'] ) ) {
  $action = sanitize_text_field( $_GET['action'] );
}
?>
<div class="container-scroller">
  <?php require_once BTCLite_PLUGIN_DIR_PATH . '/admin/inc/views/nav/nav.php';

    if ( $action == 'add' ) {
      require_once BTCLite_PLUGIN_DIR_PATH . '/admin/inc/views/target/add.php';
    } elseif ( $action == 'edit' ) {
      require_once BTCLite_PLUGIN_DIR_PATH . '/admin/inc/views/target/edit.php';
    } elseif ( $action == 'view' ) {
      require_once BTCLite_PLUGIN_DIR_PATH . '/admin/inc/views/target/target.php';
    } else {
      require_once BTCLite_PLUGIN_DIR_PATH . '/admin/inc/views/target/view.php';
    }
  ?>
</div>