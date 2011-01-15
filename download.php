<?php
/***
 * @Author 	: Dijo David
 * @Company	: ITFlux
 * @Desc	: Save the Contact to Database.
 * @Website	: www.itflux.com
 */
	include_once( './../../../wp-config.php' );
	include_once('./../../../wp-load.php');
	include_once('./../../../wp-includes/wp-db.php');
	
	global $wpdb;
	
	$doc_id 	= $_GET['id'];
	$file = $wpdb->get_results( "SELECT * FROM wp_posts WHERE ID = $doc_id " );
	$doc_uri 	= $file[0]->guid;
	$doc_name 	= $file[0]->post_title.".pdf";
	$base_url 	= get_bloginfo('url');
	
	$file_path = str_replace($base_url,"",$doc_uri);
	$file_path = ABSPATH.$file_path;
	
	if(file_exists($file_path))
	{
		header("Content-Disposition:attachment; filename=$doc_name");
		header("Content-Type:application/pdf");
		header("Content-Length: ".filesize($file_path));
		echo  file_get_contents($file_path);
	} 
	else
	{
		header("HTTP/1.0 404 Not Found");
	}
