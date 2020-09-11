<?php
/*
Plugin Name: Update notification manager
Plugin URI: https://www.bramesposito.com
Description: Manage update notifications visibility
Version: 1.0
Author: Bram Esposito
Author URI: https://www.bramesposito.com
License: GPL-2.0+
Text Domain: update-manager
Domain Path: /languages
*/


if (is_admin()) {


  // Hide Core updates
  function hide_update_notice_to_all_but_admin_users() {
      if (!current_user_can('update_core')) {
          remove_action( 'admin_notices', 'update_nag', 3 );
      }
  }
  add_action( 'admin_head', 'hide_update_notice_to_all_but_admin_users', 1 );

  // Hide Plugin & Theme updates
  function remove_core_updates() {
      if (!current_user_can('update_core')) {
          global $wp_version;
          return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
      }
  }
  add_filter('pre_site_transient_update_core','remove_core_updates'); //hide updates for WordPress itself
  add_filter('pre_site_transient_update_plugins','remove_core_updates'); //hide updates for all plugins
  add_filter('pre_site_transient_update_themes','remove_core_updates'); //hide updates for all themes

  // Hide PHP notice
  function remove_php_nag() {
    if (!current_user_can('update_core')) {
      remove_meta_box( 'dashboard_php_nag', 'dashboard', 'normal' );
    }
  }
  add_action( 'wp_dashboard_setup', 'remove_php_nag' );
}
