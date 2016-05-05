<?php
/*
Plugin Name: wp33423 hotfix
Description: This is a hotfix for the ticket #33423.
Version:     1.1
Author:      peterwilsoncc
Author URI:  http://peterwilson.cc/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


function wp33423_hotfix(){
  global $wp_version;
  /**
   * Disable this plugin from 4.3.1
   */
  if ( ( 1 !== version_compare( "4.3.1", $wp_version ) ) && current_user_can( 'activate_plugins' ) ) {
    deactivate_plugins( plugin_basename( __FILE__ ) );
  }
  
  /**
   * Prevent 4.3 from messing up the cron array and options table
   */
  remove_action( 'admin_init', '_wp_check_for_scheduled_split_terms' );

  /**
   * Clean the cron array after 4.3 messed it up
   */
  $cron_array = _get_cron_array();
  if ( isset( $cron_array['wp_batch_split_terms'] ) ) {
    unset( $cron_array['wp_batch_split_terms'] );
    _set_cron_array( $cron_array );
  }
  
  /**
   * In order to avoid the wp_batch_split_terms() job being accidentally removed,
   * check that it's still scheduled while we haven't finished splitting terms.
   */
  if ( ! get_option( 'finished_splitting_shared_terms' ) && ! wp_next_scheduled( 'wp_split_shared_term_batch' ) ) {
    wp_schedule_single_event( time() + MINUTE_IN_SECONDS, 'wp_split_shared_term_batch' );
  }
}

add_action( 'admin_init', 'wp33423_hotfix', 5 );