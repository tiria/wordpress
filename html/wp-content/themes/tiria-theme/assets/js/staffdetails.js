/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
* Copyright by WebMan - www.webmandesign.eu
*
* Posts Slideshow
*****************************************************
*/
jQuery(document).ready(function(){
	jQuery('.modal-link').click(function(){
		id='#modal-'+jQuery(this).attr('data-bio');
		jQuery(id).slideDown();
	});
	jQuery('.close-modal').click(function(){
		jQuery(this).closest('.modal').slideUp();
	});
});