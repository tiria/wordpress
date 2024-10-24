/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
* Copyright by WebMan - www.webmandesign.eu
*
* General scripts
*****************************************************
*/
jQuery(function($){
	// custom js

	/* menu responsive*/
	$('#mobile-open-menu').click(function(){
		if($('#nav-main .menu').hasClass('active')){
			// $('#nav-main .menu').removeClass('active').stop().slideUp();
			// $('#nav-main .menu').removeClass('active').css('display','none');
			// $('#mobile-close-menu').removeClass('active').css('display','none');
			$('.navigation-wrap').removeClass('active').css('opacity','0');
			$('.navigation-wrap').removeClass('active').css('width','0');
			$('#nav-main .menu').removeClass('active').css('opacity','0');
			// $('#nav-main .menu').removeClass('active').css('width','0');
			$('#mobile-close-menu').removeClass('active').css('display','none');
		}else{
			// $('#nav-main .menu').addClass('active').stop().slideDown();
			// $('#nav-main .menu').addClass('active').css('display','flex');
			// $('#mobile-close-menu').addClass('active').css('display','flex');
			$('.navigation-wrap').addClass('active').css('opacity','1');
			$('.navigation-wrap').addClass('active').css('width','100%');
			$('#nav-main .menu').addClass('active').css('opacity','1');
			// $('#nav-main .menu').addClass('active').css('width','100%');
			$('#mobile-close-menu').addClass('active').css('display','flex');
		}
	});
	$('#mobile-close-menu').click(function(){
		$('.navigation-wrap').removeClass('active').css('opacity','0');
		$('.navigation-wrap').removeClass('active').css('width','0');
		$('#nav-main .menu').removeClass('active').css('opacity','0');
		// $('#nav-main .menu').removeClass('active').css('width','0');
		$('#mobile-close-menu').removeClass('active').css('display','none');
	});

	$('body').on('click','.menu.active > li.menu-item-has-children',function(){
		if($(this).find('> ul.sub-menu').hasClass('active')){
			$(this).removeClass('active');
			$(this).find('> ul.sub-menu').removeClass('active').stop().slideUp();
		}else{
			$('.menu.active > li.menu-item-has-children').removeClass('active');
			$('.menu.active > li.menu-item-has-children > ul.sub-menu').removeClass('active').stop().slideUp();
			$(this).addClass('active');
			$(this).find('> ul.sub-menu').addClass('active').stop().slideDown();
		}
	});

});