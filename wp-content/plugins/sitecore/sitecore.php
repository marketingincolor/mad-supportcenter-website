<?php
/**
 * Plugin Name: Sitecore - Plugin for current site
 * Plugin URI: http://marketingincolor.com
 * Description: Site specific code changes for current site
 * Version: 1.0
 * Author: Marketing In Color
 * Author URI: http://marketingincolor.com
 * License: A "Slug" license name e.g. GPL2
 */

/*  Copyright 2014 Marketing In Color (email : developer@marketingincolor.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Add additional view of data from Simple Login Log compared against User list
add_action( 'admin_menu', 'never_logged_menu' );
function never_logged_menu() {
	add_submenu_page( 'users.php', 'Show Users', 'Never Logged In', 'list_users', 'nonlogs', 'show_never_logged');
}

function show_never_logged() {
	if ( !current_user_can( 'list_users' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	global $wpdb;
	$unloggeds = $wpdb->get_results(
		"
		SELECT *
		FROM wp_users
		WHERE id NOT IN (SELECT uid FROM wp_simple_login_log)
		ORDER BY user_registered DESC
		"
	);
	
	echo '<div class="wrap">';
	echo '<p>Note: The data displayed in the table below requires the "Simple Login Log" plugin to be active on the site. Without it, there will be no Users presented in this listing.</p>';
	echo '<p>There are currently '.count($unloggeds).' Users listed below who have NEVER logged into the system.</p>';
	echo '</div>';
	
	echo '<div class="wrap">';
	echo '<table class="wp-list-table widefat fixed users">';
	echo '<thead><tr><th>User Name</th><th>Registration Date</th><th>Email</th>';
	foreach ($unloggeds as $unlogged )
	{
	echo '<tr><td><a href="./user-edit.php?user_id='.$unlogged->ID.'">'.$unlogged->display_name.'</a></td><td>'.$unlogged->user_registered.'</td><td><a href="mailto:'.$unlogged->user_email.'">'.$unlogged->user_email.'</a></td></tr>' ;
	}
	echo '</table>';
	echo '</div>';
		
	echo '<div class="wrap">';
	echo '<p>This is a "Sitecore" custom WP plugin developed by MIC solely for client use.</p>';
	echo '</div>';
}

// Add additional data element to Sitecore via Custom Metadata Manager Plugin - data specific to site

add_action( 'admin_menu', 'sc_init_custom_fields' );
function sc_init_custom_fields() {
    if( function_exists( 'x_add_metadata_field' ) && function_exists( 'x_add_metadata_group' ) ) {
		x_add_metadata_group ( 'sitecore_data', 'user', array(
			'label' => 'Additional Info'
		) );
        x_add_metadata_field( 'sc_company','user', array( 
			'group' => 'sitecore_data',
			'description' => 'Your company name', 
			'label' => 'Company', 
			'display_column' => true 
		) );
    }
}

// Add additional search terms to Sitecore via User Info Display Page
add_filter( 'user_search_columns', 'filter_function_name', 10, 3 );
function filter_function_name( $search_columns, $search, $this ) {
	$search_columns = array('user_url', 'user_nicename', 'user_email');
	return $search_columns;
} 
// Additional Search features to include meta data
//Searching Meta Data in Admin
add_action('pre_user_query','sc_pre_user_search');
function sc_pre_user_search($user_search) {
    global $wpdb;
    if (!isset($_GET['s'])) return;
    //Enter Your Meta Fields To Query
    $search_array = array('sc_company', 'first_name', 'last_name');
    $user_search->query_from .= " INNER JOIN {$wpdb->usermeta} ON {$wpdb->users}.ID={$wpdb->usermeta}.user_id AND (";
    for($i=0;$i<count($search_array);$i++) {
        if ($i > 0) $user_search->query_from .= " OR ";
            $user_search->query_from .= "{$wpdb->usermeta}.meta_key='" . $search_array[$i] . "'";
        }
    $user_search->query_from .= ")";        
    $custom_where = $wpdb->prepare("{$wpdb->usermeta}.meta_value LIKE '%s'", "%" . $_GET['s'] . "%");
    $user_search->query_where = str_replace('WHERE 1=1 AND (', "WHERE 1=1 AND ({$custom_where} OR ",$user_search->query_where);    
}

// Add User Registration Date to Users Page via Sitecore
add_filter ( 'manage_users_columns', 'sc_add_user_custom_column' );
add_filter ( 'manage_users_custom_column', 'sc_view_custom_column', 11, 3 );
function sc_add_user_custom_column ( $column ) {
	$column['registered'] = 'Registered';
	return $column;
}
function sc_view_custom_column ($column, $column_name, $id) {
	$user_info = get_userdata( $id );
	if ($column_name == 'registered')
		$column = $user_info->user_registered;
	return $column;
}

// Create new Removed Role
add_role('removed', 'Removed', array(
    'read' => true
));

// Prohibit Removed Users from Logging in via Sitecore
function sc_redirect_users_by_role( $user_login, $user ) {
	$logging_user = get_userdata( $user->ID );
	$role_name = $user->roles[0];
	if ( $role_name == 'removed' ) {
		wp_logout();
		wp_redirect( home_url() ); exit;
	} 
}
add_action( 'wp_login', 'sc_redirect_users_by_role', 12, 2 );