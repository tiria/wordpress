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
window.currentps=0;
jQuery(document).ready(function(){
	jQuery('.posts-slideshow-mask').css('height',jQuery('.posts-slideshow-row').height()+'px');
	var limit = 0;
	jQuery('.posts-slideshow-row').each(function(){
		jQuery(this).css('left',(parseInt(jQuery(this).attr('data-row'))*10)+'%');
		limit++;
	});
	jQuery('.posts-slideshow .navigation-left').click(function(){
		slideRight(limit-1);
	});
	jQuery('.posts-slideshow .navigation-right').click(function(){
		slideLeft(limit-1);
	});
	if(jQuery('.posts-slideshow').attr('data-timer')!='none'){
		var timer=(parseInt(jQuery('.posts-slideshow').attr('data-timer'))>1000) ? parseInt(jQuery('.posts-slideshow').attr('data-timer')) : 10000;
		var t=setInterval(function(){
			slideLeft(limit-1);
		},timer);
		jQuery('.posts-slideshow').mouseout(function(){
			t = setInterval(function(){
				slideLeft(limit-1);
			},timer)
		});
		jQuery('.posts-slideshow').mouseover(function(){
		  clearInterval(t);
		});
	}
});
function slideRight(limit){
	if(currentps==0){
		window.currentps=limit;
		jQuery('.posts-slideshow-container').animate({'left':'-'+(limit*100)+'%'});
	}
	else{
		window.currentps--;
		jQuery('.posts-slideshow-container').animate({'left':'+'+(currentps*100)+'%'});
	}
}
function slideLeft(limit){
	if(currentps==limit){
		window.currentps=0;
		jQuery('.posts-slideshow-container').animate({'left':'0%'});
	}
	else{
		window.currentps++;
		jQuery('.posts-slideshow-container').animate({'left':'-'+(currentps*100)+'%'});
	}
}