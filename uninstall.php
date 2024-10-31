<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option('sphca_option');
delete_option('sphca_On_Homepage');
delete_option('sphca_On_Posts');
delete_option('sphca_On_Pages');
delete_option('sphca_On_Archives');
delete_option('sphca_On_Search');
 
// for site options in Multisite
delete_site_option('sphca_option');
delete_site_option('sphca_On_Homepage');
delete_site_option('sphca_On_Posts');
delete_site_option('sphca_On_Pages');
delete_site_option('sphca_On_Archives');
delete_site_option('sphca_On_Search');

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}scroll_popup_html_content_ads");