<?php
	/*
	Plugin Name: DTracker
	Plugin URI: http://www.itflux.com
	Description: This plugin tracks the information of the visitor who had tried to download the whitepaper.
	Author: Dijo David
	Version: 1.5
	Author URI: http://twitter.com/dijodavid
	*/

	define('BASE_URL', get_bloginfo('url'));

	function dtracker_activate(){
		global $wpdb;
		$table_name = $wpdb->prefix . "contacts";

   		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		
			$query ="CREATE TABLE " . $table_name . " (
			  		id int(10) NOT NULL AUTO_INCREMENT,
			  	 	email varchar(100) collate utf8_unicode_ci NOT NULL,
				  	name varchar(50) collate utf8_unicode_ci NOT NULL,
		 		 	company varchar(50) collate utf8_unicode_ci NOT NULL,
		 	 		phone varchar(50) collate utf8_unicode_ci NOT NULL,
			 	 	country varchar(50) collate utf8_unicode_ci NOT NULL,
				  	time datetime NOT NULL,
				  	ip varchar(300) collate utf8_unicode_ci NOT NULL,
			 	 	PRIMARY KEY (`id`)
			);";
			require_once( ABSPATH .'/wp-admin/includes/upgrade.php');
			dbDelta($query);
		}
	}
	register_activation_hook( __FILE__, 'dtracker_activate' );
	
	
	function dtracker_options(){
		include("contacts_import.php");
	}
	
	
	function download_admin_cp(){
		add_options_page('Contact Lists', 'DTracker', 'manage_options', '1', 'dtracker_options');
	}
	add_action('admin_menu','download_admin_cp');
	
	
	function get_whitepapers(){ // Get the whitepaper list
		include("whitepapers.php");
	}
	add_shortcode('whitepapers','get_whitepapers'); //Adding Shortcode
	add_filter('widget_text', 'do_shortcode'); // Enable Shortcodes for Text Widgets
	
	
	function plugin_init(){
		wp_register_script('dtrackerScript', WP_PLUGIN_URL.'/dtracker/js/dtracker_widget.js');
		wp_register_style('dtrackerStyle', WP_PLUGIN_URL.'/dtracker/styles/dtracker.css');
		wp_enqueue_script('jquery');
		wp_enqueue_script('dtrackerScript');
		wp_enqueue_style('dtrackerStyle');
	}
	add_action('init','plugin_init');
	
