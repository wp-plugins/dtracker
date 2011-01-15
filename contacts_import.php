<?php
/***
 * @Author 	: Dijo David
 * @Company	: ITFlux
 * @Desc	: Contact list in Admin Panel.
 * @Website	: www.itflux.com
 */

	global $wpdb;
	$contacts 	= $wpdb->get_results( "SELECT * FROM wp_contacts ORDER BY time DESC" );
	$base_url	= WP_PLUGIN_URL;
?>	

<div class='wrap'>
	<table class="widefat">
		<thead>
			<tr>
				<th>SL No.</th>
				<th>Name</th>
				<th>Email</th>
				<th>Company</th>
				<th>Phone</th>
				<th>Country</th>
				<th>Time</th>
				<th>IP Address</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tfoot>
		    <tr>
		 	   <th>SL No.</th>
				<th>Name</th>
				<th>Email</th>
				<th>Company</th>
				<th>Phone</th>
				<th>Country</th>
				<th>Time</th>
				<th>IP Address</th>
				<th>Actions</th>
		    </tr>
		</tfoot>
<?php
	if($contacts){
	$i=1; 
	foreach($contacts as $contact){
		$id			= $contact->id;
		$name		= $contact->name;
		$email		= $contact->email;
		$company	= $contact->company;
		$phone		= $contact->phone;
		$country	= $contact->country;
		$time		= $contact->time;
		$ip			= $contact->ip; 
?>		
		<tbody>
		   <tr>
		   	 <td><?php echo $i;?></td>
		     <td><?php echo $name;?></td>
		     <td><a href="mailto:<?php echo $email;?>"><?php echo $email;?></a></td>
		     <td><?php echo $company;?></td>
		     <td><?php echo $phone;?></td>
		     <td><?php echo $country;?></td>
		     <td><?php echo $time;?></td>
		     <td><?php echo $ip;?></td>
		     <td><a id="delContactBtn" class="button-primary" href="javascript:;" onclick="DTRACKER.Actions.remove(<?php echo $id.",'".$base_url."'";?>)">Delete</a></td>
<?php 
	$i++;
	}
} else {
	echo "<td align='center' colspan=9 >No Contacts Available</td>";
}
?>		
		   </tr>
		</tbody>
	</table>
</div>