/***
 * @Author 	: Dijo David
 * @Company	: ITFlux
 * @Desc	: JS for the contact form widget.
 * @Website	: www.itflux.com
 */

var $j= jQuery.noConflict();

if(!DTRACKER){
	var DTRACKER = {};
}

DTRACKER.Version = 1.5;


/**
 * DTracker Modal Window
 */
DTRACKER.ModalWindow = {
	loactionHash: '',
	open : 	function(scrollToTop,docid,docTitle) {
			$j('#doc_id').val(docid);
			$j('#dwnld_title').html('Download '+docTitle);
			
			var modalWindowHeight = $j('body').height()+'px'; 
			var modalWindowWidth  = ($j('body').width()-100)+'px';
			$j('#modalWindow').css('height',modalWindowHeight);
			$j('#modalWindow').css('width',modalWindowWidth);
			DTRACKER.ModalWindow.loactionHash = window.location.hash;
			window.location.hash = '';
			$j('#modalWindow').show();
					if(scrollToTop){
						scroll(0,0);
					}
					$j(document).keyup(function(e){
						if(e.which == 27){
							DTRACKER.ModalWindow.close();
						}
					});
	},
	close : function() {
		$j('#modalWindow').hide();
		window.location.hash = DTRACKER.ModalWindow.loactionHash;
		DTRACKER.ModalWindow.loactionHash = '';
		//DTRACKER.ModalWindow.restoreSpinner();
		location.reload();
	},
	hideSpinner : function() {
		$j('#spinner').hide();
	},
	fixSize : function() {
		var modalWindowHeight = $('body').height()+'px'; 
		var modalWindowWidth  = ($('body').width()-100)+'px';
		$j('#modalWindow').css('height',modalWindowHeight);
		$j('#modalWindow').css('width',modalWindowWidth);
	},
	setContent : function(data)	{
		$j('#throbber').fadeOut(); 
		$j('#modalWindow').html(data);
	},
	restoreSpinner : function() {
		var BASEURL 	= $j('#base_url').val();
		$j('#modalWindow').html("<div id='spinner'>Please wait... <br /><img src='"+BASEURL+"images/spinner.gif' title='Loading' alt='...'/></div>");
	},
	showThrobber : function() {
		var position = $("#modalWindow .modal_content").offset();
		var width = $("#modalWindow .modal_content").width();
		var height = $("#modalWindow .modal_content").height();
		$j('#throbber').css({ top:position.top+height/2-25, left: position.left+width/2-25}).fadeIn();
	},
	reloadWindow : function() {
		$j('#modalWindow').html("<div id='spinner'>Please wait while reloading page... <br /><img src='"+BASE_URL+"images/spinner.gif' title='Loading' alt='...'/></div>");
		window.location.reload();
	}
};


/**
 * DTracker Validation and Information Collecting 
 * 
 */

DTRACKER.Download = {
	setup : function(){
		$j('#button1').click(function() {
			DTRACKER.Download.saveEmail();	
			return false;
		});
		$j('#button2').click(function(){
			DTRACKER.Download.saveContact();	
			return false;
		});
	},
	saveEmail : function(){
		var BASEURL 	= $j('#base_url').val();
		var email 	 	= $j('#modalWindow').find('#email').val();
		var emailReg	=  /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		
		if (email == "" ) {
			$j('#email_error').html('Please Enter Your Email To Proceed');
		} else if (!emailReg.test(email)){
			$j('#email_error').html('Please Enter a Valid Email Address');
		} else {
			var position = $j('#button1').offset();
			$j('#button1_loading').css({ top: position.top -20, left: position.left +140 }).show();
			
			$j.ajax({
				type: 'POST',
				url	: BASEURL+'/dtracker/save_mail.php',
				dataType: 'json',
				data: {
					email : email
				},
				success: function(resultJSON){
					$j('#button1_loading').hide();
					$j('#step2').show();
					$j('#step1').hide();
					$j("#contact_id").val(resultJSON.contactId);
				}
			});
		}
	},
	saveContact : function(){
		var BASEURL 	= $j('#base_url').val();
		var name    	= $j('#user_name').val();
		var company 	= $j('#company').val();
		var phone   	= $j('#phone').val();
		var country 	= $j('#country').val();
		var contact_id  = $j('#contact_id').val();
		
		$j('.error').hide();
		
		var flag = true;
		if (name == "" ) {
			flag = false;
			$j('#name_error').show();
		} 
		if(company==""){
			flag = false;
			$j('#company_error').show();
		} 
		if(phone==""){
			flag = false;
			$j('#phone_error').show();
		}
		if(country==""){
			flag = false;
			$j('#country_error').show();
		}
		if(!flag) {
			return;
		}
		var position = $j('#button2').offset();
		$j('#button2_loading').css({ top: position.top -20, left: position.left +140 }).show();
		
		$j.ajax({
			type: 'POST',
			url	: BASEURL+'/dtracker/save_contact.php',
			data: {
				name 		: name,
				company		: company,
				phone		: phone,
				country		: country,
				contact_id	: contact_id
			},
			success: function(resultsHtml){
				$j('#button2_loading').hide();
				$j('#step3').show();
				$j('#step1').hide();
				$j('#step2').hide();
				
				var downloadUrl = $j('#downloadLink').attr('href');
				downloadUrl += '?id='+$j('#doc_id').val();
				$j('#downloadLink').attr('href',downloadUrl);
				$j('body').append("<iframe src='" + downloadUrl + "' style='display: none;' ></iframe>");
			}
		});
	}
};


/***
 * DTracker Download Slider
 * 
 */

DTRACKER.Slider = {
		slideCount : 0,
		slides : new Array(),
		init: function(){
			DTRACKER.Slider.slideCount = $j('.cmn_dwnld_wrapper').length;
			DTRACKER.Slider.slides     = $j('.cmn_dwnld_wrapper');
			$j('.cmn_dwnld_wrapper:first').addClass('show');
			DTRACKER.Slider.currentSlideIndex = 0;
			if(DTRACKER.Slider.slideCount < 2){
				$j('.slide_btn').hide();
			} 
		},
		getNextSlideIndex: function(){
			if(DTRACKER.Slider.currentSlideIndex+1 < DTRACKER.Slider.slideCount){
				return DTRACKER.Slider.currentSlideIndex+1;
			} else {
				return 0;
			}	
		},
		getPrevSlideIndex: function(){
			if(DTRACKER.Slider.currentSlideIndex-1 >= 0){
				return DTRACKER.Slider.currentSlideIndex-1;
			} else {
				return DTRACKER.Slider.slideCount-1;
			}	
		},
		nextSlide: function(){
			$j('.cmn_dwnld_wrapper').removeClass('show');
			var nextSlideIndex = DTRACKER.Slider.getNextSlideIndex();
			DTRACKER.Slider.currentSlideIndex = nextSlideIndex; 
			$j(DTRACKER.Slider.slides[nextSlideIndex]).addClass('show');
		},
		prevSlide: function(){
			$j('.cmn_dwnld_wrapper').removeClass('show');
			var prevSlideIndex = DTRACKER.Slider.getPrevSlideIndex();
			DTRACKER.Slider.currentSlideIndex = prevSlideIndex; 
			$j(DTRACKER.Slider.slides[prevSlideIndex]).addClass('show');
		}
}


/**
 * Admin Actions
 * 
 */

DTRACKER.Actions = {
		remove: function(contactId,baseUrl){
			$j.ajax({
				type: 'POST',
				url	: baseUrl+'/dtracker/delete.php',
				data: {
					contact_id : contactId
				},
				success: function(result){
					location.reload();
				}
			});
		}
};


jQuery(function ($) {
	DTRACKER.Download.setup(); //Setting download button
	DTRACKER.Slider.init();	//Setting the slider feature
});