<?php 
/***
 * @Author 	: Dijo David
 * @Company	: ITFlux
 * @Desc	: Save the Email to Database.
 * @Website	: www.itflux.com
 */
	include_once( './../../../wp-config.php' );
	include_once('./../../../wp-load.php');
	include_once('./../../../wp-includes/wp-db.php');

	global $wpdb;
	
	$email 	= $_POST['email'];
	$time	= date('Y-m-d H:i:s');
	$ip		= $_SERVER [ 'REMOTE_ADDR' ] ; //get IP address of the visitor
	
	$table 	= "wp_contacts";
	$data	= array (
				'email' 	=> $email,
				'time'		=> $time,
				'ip'		=> $ip	
			);
	
	$wpdb->insert( $table, $data); //Insert Values
	$contact_id = $wpdb->insert_id; //Get ID of the last inserted row
	$data['contactId'] = $contact_id;
	echo json_encode($data); //Pass the id to the JS
	
?>