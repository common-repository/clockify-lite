<!-- partial:partials/_horizontal-navbar.html -->
<div class="horizontal-menu">
  <nav class="navbar top-navbar col-lg-12 col-12 p-0">
    <div class="nav-top flex-grow-1">
      <div class="container d-flex flex-row h-100 align-items-center">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="<?php echo admin_url( 'admin.php?page=clockify-lite-panel' ); ?>"><img src="<?php echo BTCLite_PLUGIN_URL; ?>assets/images/clockify-lite.png" alt="logo"/></a>
          <a class="navbar-brand brand-logo-mini" href="<?php echo admin_url( 'admin.php?page=clockify-lite-panel' ); ?>"><img src="<?php echo BTCLite_PLUGIN_URL; ?>assets/images/clockify-lite.png" alt="logo"/></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end flex-grow-1">
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-settings d-none d-lg-block">
              <a class="nav-link" href="<?php echo admin_url( 'admin.php?page=clockify-lite-settings' ); ?>">
                <i class="fas fa-cog"></i>
                <?php esc_html_e( 'Settings', 'clockinator-lite' ); ?>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <nav class="bottom-navbar">
    <div class="container">
      <ul class="nav page-navigation">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo admin_url( 'admin.php?page=clockify-lite-panel' ); ?>">
            <i class="fas fa-home menu-icon"></i>
            <span class="menu-title"><?php esc_html_e( 'Dashboard', 'clockinator-lite' ); ?></span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo admin_url( 'admin.php?page=clockify-lite-employee' ); ?>">
            <i class="fas fa-users menu-icon"></i>
            <span class="menu-title"><?php esc_html_e( 'Employees', 'clockinator-lite' ); ?></span>
          </a>
        </li>
        <li class="nav-item mega-menu">
          <a href="<?php echo admin_url( 'admin.php?page=clockify-lite-department' ); ?>" class="nav-link">
            <i class="fas fa-briefcase menu-icon"></i>
            <span class="menu-title"><?php esc_html_e( 'Departments', 'clockinator-lite' ); ?></span>
          </a>
        </li>
        <li class="nav-item mega-menu">
          <a href="<?php echo admin_url( 'admin.php?page=clockify-lite-shift' ); ?>" class="nav-link">
            <i class="fas fa-user-clock menu-icon"></i>
            <span class="menu-title"><?php esc_html_e( 'Shifts', 'clockinator-lite' ); ?></span>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo admin_url( 'admin.php?page=clockify-lite-events' ); ?>" class="nav-link">
            <i class="far fa-calendar-alt menu-icon"></i>
            <span class="menu-title"><?php esc_html_e( 'Events', 'clockinator-lite' ); ?></span>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo admin_url( 'admin.php?page=clockify-lite-holidays' ); ?>" class="nav-link">
            <i class="fas fa-snowman menu-icon"></i>
            <span class="menu-title"><?php esc_html_e( 'Holidays', 'clockinator-lite' ); ?></span>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo admin_url( 'admin.php?page=clockify-lite-leaves' ); ?>" class="nav-link">
            <i class="fas fa-briefcase-medical menu-icon"></i>
            <span class="menu-title"><?php esc_html_e( 'Leaves', 'clockinator-lite' ); ?></span>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo admin_url( 'admin.php?page=clockify-lite-target' ); ?>" class="nav-link">
            <i class="fas fa-star menu-icon"></i>
            <span class="menu-title"><?php esc_html_e( 'Targets', 'clockinator-lite' ); ?></span>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo admin_url( 'admin.php?page=clockify-lite-reports' ); ?>" class="nav-link">
            <i class="fas fa-chart-pie menu-icon"></i>
            <span class="menu-title"><?php esc_html_e( 'Reports', 'clockinator-lite' ); ?></span>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo admin_url( 'admin.php?page=clockify-lite-payslip' ); ?>" class="nav-link">
            <i class="fas fa-file-invoice-dollar menu-icon"></i>
            <span class="menu-title"><?php esc_html_e( 'Payslip', 'clockinator-lite' ); ?></span>
          </a>
        </li>
        <li class="nav-item">
          <a href="https://beastthemes.com/getting-started-with-the-clockify-lite-wordpress-premium-plugin/" class="nav-link">
            <i class="fas fa-book menu-icon"></i>
            <span class="menu-title"><?php esc_html_e( 'Documentation', 'clockinator-lite' ); ?></span></a>
        </li>
      </ul>
    </div>
  </nav>
</div>