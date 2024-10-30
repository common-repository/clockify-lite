<?php
defined('ABSPATH') or wp_die();
require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/helpers/clock-helper.php' );
?>
<div class="container-scroller">
  <?php require_once BTCLite_PLUGIN_DIR_PATH . '/admin/inc/views/nav/nav.php';  ?>

  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-12 grid-margin">
            <div class="card">
              <div class="card-body">
                <ul class="nav nav-tabs settings-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#general-tab" role="tab"><?php esc_html_e( 'General Settings', 'clockinator-lite' ); ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" target="_blank" href="https://beastthemes.com/plugins/clockify-pro/" role="tab"><?php esc_html_e( 'Email Templates', 'clockinator-lite' ); ?><span><?php esc_html_e( 'Pro', 'clockinator-lite' ); ?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" target="_blank" href="https://beastthemes.com/plugins/clockify-pro/" role="tab"><?php esc_html_e( 'SMS Templates', 'clockinator-lite' ); ?><span><?php esc_html_e( 'Pro', 'clockinator-lite' ); ?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" target="_blank" href="https://beastthemes.com/plugins/clockify-pro/" role="tab"><?php esc_html_e( 'Notification Settings', 'clockinator-lite' ); ?><span><?php esc_html_e( 'Pro', 'clockinator-lite' ); ?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#string-tab" role="tab"><?php esc_html_e( 'String Translation', 'clockinator-lite' ); ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-danger" data-toggle="tab" href="#support-tab" role="tab"><?php esc_html_e( 'Shortcodes & Support', 'clockinator-lite' ); ?></a>
                  </li>
                </ul><!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="general-tab" role="tabpanel">
                    <?php require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/settings/clock-general-settings.php' ); ?>
                  </div>
                  <div class="tab-pane" id="string-tab" role="tabpanel">
                    <?php require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/settings/clock-string-translation.php' ); ?>
                  </div>
                  <div class="tab-pane" id="support-tab" role="tabpanel">
                    <?php require_once( BTCLite_PLUGIN_DIR_PATH . 'admin/inc/settings/clock-support.php' ); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>