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
	
	$name 		= $_POST['name'];
	$company	= $_POST['company'];
	$phone 		= $_POST['phone'];
	$country	= $_POST['country'];
	$contact_id = $_POST['contact_id'];
	
	$table 	= 'wp_contacts';
	$data	= array(
				'name'		=> $name,
				'company'	=> $company,
				'phone'		=> $phone,
				'country'	=> $country,
			);
	$where	= array(
				'id'	=> $contact_id
			);
	
	$wpdb->flush();
	
	$wpdb->update( $table, $data, $where ); //Update the Contact

?>