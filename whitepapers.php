<?php 
/***
 * @Author 	: Dijo David
 * @Company	: ITFlux
 * @Desc	: Download widget data.
 * @Website	: www.itflux.com
 */
?>

<div class="download_section">
<?php
	
	global $wpdb;
	$rows = $wpdb->get_results( "SELECT * FROM wp_posts WHERE post_mime_type= 'application/pdf' " );

	
	define('IMG_URL',WP_PLUGIN_URL.'/dtracker/img/');

	foreach($rows as $row){
		$doc_id		= $row->ID;
		$doc_name	= $row->post_excerpt;
		$doc_title 	= $row->post_title;
		$doc_desc	= $row->post_content;
		$doc_link	= $row->guid;
?>

	<div class="cmn_dwnld_wrapper">
		<a href="javascript:;" onclick="DTRACKER.ModalWindow.open(1,<?php echo $doc_id.",'".$doc_title."'";?>);" class="dwnld_btn">Download Whitepaper</a>
		<div class="clear"></div>
		
		<div class="wp_title"><?php echo $doc_title;?></div>
		<div class="clear"></div>
		
		<div class="wp_details">
			<div class="wp_desc"><?php echo $doc_desc;?></div>
			
			<div class="wp_thumb">
				<img alt="Whitepaper Thumb" src="<?php echo IMG_URL.'wp_thumb.png';?>" />
			</div>
		</div>
		<div class="clear"></div>
		
		<div class="slide_btn">
			<a onclick="DTRACKER.Slider.prevSlide();" href="javascript:;" class="prev nav_btn">Previous</a>
			<a onclick="DTRACKER.Slider.nextSlide();" href="javascript:;" class="next nav_btn">Next</a>
			<div class="clear"></div>
		</div>
	</div>
<?php	
	}
	include('modal.php');
?>
</div>