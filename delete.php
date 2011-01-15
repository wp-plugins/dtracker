<?php
/***
 * @Author 	: Dijo David
 * @Company	: ITFlux
 * @Desc	: Delete the Contact from Database.
 * @Website	: www.itflux.com
 */
	include_once( './../../../wp-config.php' );
	include_once('./../../../wp-load.php');
	include_once('./../../../wp-includes/wp-db.php');
	
	global $wpdb;
	
	$contact_id	= $_POST['contact_id']; //Contact ID to be deleted
	
	$query	= "DELETE FROM wp_contacts WHERE id = $contact_id";
	$wpdb->query($query); // Delete the contact
	
?>	