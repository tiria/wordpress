/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
* Copyright by WebMan - www.webmandesign.eu
*
* Theme scripts
*
* CONTENT:
* - 1) No spam jQuery extension
* - 2) Default actions
* - 3) Menu effects
* - 4) Video slider cover image
* - 5) Prettyphoto
* - 6) Apply email spam protection
* - 7) Create tabs
* - 8) Create accordions
* - 9) Create toggles
* - 10) YouTube embed fix
* - 11) Search form
* - 12) Slideshow shortcode
* - 13) Isotope filter
* - 14) Testimonials and statuses
* - 15) Responsive menu
* - 16) Masonry gallery
* - 17) Call to action
*****************************************************
*/

var autoAccordionDuration=(typeof autoAccordionDuration == 'undefined') ? 5000 : autoAccordionDuration;

/*
*****************************************************
*      1) NO SPAM JQUERY EXTENSION
*****************************************************
*/
jQuery.fn.nospam=function(settings){
	return this.each(function(){
		var e     = null,
			$this = jQuery(this);

		// 'normal'
		if(jQuery(this).is('a[data-address]')){
			e=$this.data('address').split('').reverse().join('').replace('[at]', '@').replace(/\//g, '.');
		}
		else{
			e=$this.text().split('').reverse().join('').replace('[at]', '@').replace(/\//g, '.');
		}
		
		if(e){
			if($this.is('a[data-address]')){
				$this.attr('href', 'mailto:'+e);
				$this.text(e);
			}
			else{
				$this.text(e);
			}
		}
	});
};

jQuery(function(){

/*
*****************************************************
*      2) DEFAULT ACTIONS
*****************************************************
*/
	jQuery('.no-js').removeClass('no-js');
	
	//to the top of page
	jQuery('.top-of-page, a[href="#top"]').click(function(){
		jQuery('html, body').animate({scrollTop:0},400);
		return false;
	});

/*
*****************************************************
*      3) MENU EFFECTS
*****************************************************
*/
	jQuery('.nav-main li, .top-bar li').hover(function(){
		jQuery(this).find('> ul').stop(true, true).fadeIn();
	},function(){
		jQuery(this).find('> ul').stop(true, true).fadeOut();
	});

/*
*****************************************************
*      4) VIDEO SLIDER COVER IMAGE
*****************************************************
*/
	var $videoSliderWCover=jQuery('#video-slider.has-cover');
	$videoSliderWCover.find('.video-container').hide();
	$videoSliderWCover.prev('.video-cover').click(function(){
		var $this   = jQuery(this),
			$parent = $this.closest('.slider').height($this.height()),
			srcAtt  = $videoSliderWCover.find('.video-container iframe').attr('src');
		$this.fadeOut(400, function(){
			$parent.find('.video-slider .video-container').fadeIn(250, function(){
				$parent.animate({height:jQuery(this).find('iframe').height()}, 250, function(){
					jQuery(this).height('auto');
				});
			});
		});
		if(-1==srcAtt.indexOf('?')) srcAtt+='?autoplay=1';
		else srcAtt+='&amp;autoplay=1';
		$videoSliderWCover.find('.video-container iframe').attr('src', srcAtt);
	});

/*
*****************************************************
*      5) PRETTYPHOTO
*****************************************************
*/
	if(jQuery().prettyPhoto){
		var thumbnails = 'a[href$=".bmp"],a[href$=".gif"],a[href$=".jpg"],a[href$=".jpeg"],a[href$=".png"],a[href$=".BMP"],a[href$=".GIF"],a[href$=".JPG"],a[href$=".JPEG"],a[href$=".PNG"]',
		    zoomObjects = jQuery(thumbnails+', .lightbox, a.modal, a[data-modal], a[rel^="prettyPhoto"]');

		if(1<zoomObjects.length) zoomObjects.attr('rel', 'prettyPhoto[pp_gal]');

		//Reset REL attribute for projects
		jQuery('a[data-rel]').each(function(){
			var $this=jQuery(this);
			$this.attr('rel', $this.data('rel'));
		});

		zoomObjects.prettyPhoto({
			show_title         : false,
			theme              : 'pp_default', /* pp_default (only this one is styled) / light_rounded / dark_rounded / light_square / dark_square / facebook */
			slideshow          : 6000,
			deeplinking        : true,
			overlay_gallery    : false,
			social_tools       : false
		});
	} // /prettyPhoto

/*
*****************************************************
*      6) APPLY EMAIL SPAM PROTECTION
*****************************************************
*/
	jQuery('a.email-nospam').nospam();

/*
*****************************************************
*      7) CREATE TABS
*****************************************************
*/
	if(jQuery('div.tabs-wrapper').length){
		(function(){
			var tabObject=jQuery('div.tabs-wrapper > ul');
			i=0;
			tabObject.each(function(item){
				var out         = '';
					tabsWrapper = jQuery(this),
					tabsCount   = tabsWrapper.children('li').length;

				tabsWrapper.find('.tab-heading').each(function(subitem){
					i++;
					var tabItem      = jQuery(this),
						tabItemId    = tabItem.closest('li').attr('id', 'tab-item-'+i),
						tabItemTitle = tabItem.html(),
						tabLast      = (tabsCount === i) ? ' last' : '';
					tabItem.addClass('hide');
					if(tabItem.closest('div.tabs-wrapper').hasClass('fullwidth')) out+='<li class="column col-1'+tabsCount+tabLast+' no-margin"><a href="#tab-item-'+i+' ">'+tabItemTitle+'</a></li>';
					else out+='<li><a href="#tab-item-'+i+'">'+tabItemTitle+'</a></li>';
				});
				tabsWrapper.before('<ul class="tabs clearfix">'+out+'</ul>');
			});
		})();

		var tabsWrapper        = jQuery('.tabs '),
			tabsContentWrapper = jQuery('.tabs + ul');

		tabsWrapper.find('li:first-child').addClass('active'); //make first tab active
		tabsContentWrapper.children().hide();
		tabsContentWrapper.find('li:first-child').show();

		tabsWrapper.find('a').click(function(e){
			e.preventDefault();
			var $this     = jQuery(this),
				targetTab = $this.attr('href').replace(/.*#(.*)/, "#$1"); //replace is for IE7

			$this.parent().addClass('active').siblings('li').removeClass('active');
			jQuery('li' + targetTab).fadeIn().siblings('li').hide();
		});

		//tour
		if(jQuery('div.tabs-wrapper.vertical.tour').length){
			jQuery('<div class="tour-nav"><span class="prev" data-index="-1"></span><span class="next" data-index="1"></span></div>').prependTo('.tabs-wrapper.tour ul.tabs + ul > li');

			var step02 = jQuery('.tabs-wrapper.tour ul.tabs li.active').next('li').html();
			jQuery('.tour-nav .next').html(step02);
			jQuery('.tour-nav .next a').prepend('<i class="icon-hand-right"></i> ');

			//change when tab clicked
			jQuery('.tabs-wrapper.tour ul.tabs a').click(function(){
				var $parentWrap   = jQuery(this).closest('.tabs-wrapper'),
					tourTabActive = $parentWrap.find('ul.tabs li.active'),
					prevTourTab   = tourTabActive.prev('li'),
					nextTourTab   = tourTabActive.next('li');

				if(prevTourTab.length){
					$parentWrap.find('.tour-nav .prev').html(prevTourTab.html()).attr('data-index', prevTourTab.index());
					$parentWrap.find('.tour-nav .prev a').append(' <i class="icon-hand-left"></i>');
				}
				else{
					$parentWrap.find('.tour-nav .prev').html('');
				}

				if(nextTourTab.length){
					$parentWrap.find('.tour-nav .next').html(nextTourTab.html()).attr('data-index', nextTourTab.index());
					$parentWrap.find('.tour-nav .next a').prepend('<i class="icon-hand-right"></i> ');
				}
				else{
					$parentWrap.find('.tour-nav .next').html('');
				}
			});

			//change when tour nav clicked
			jQuery('.tour-nav span').click(function(e){
				e.preventDefault();
				var $this       = jQuery(this),
					$parentWrap = $this.closest('.tabs-wrapper'),
					targetIndex = $this.data('index'),
					prevTourTab = $parentWrap.find('ul.tabs li').eq(targetIndex).prev('li'),
					nextTourTab = $parentWrap.find('ul.tabs li').eq(targetIndex).next('li');
					targetTab   = $this.find('a').attr('href');

				$parentWrap.find('ul.tabs li').eq(targetIndex).addClass('active').siblings('li').removeClass('active');
				$parentWrap.find('li' + targetTab).fadeIn().siblings('li').hide();

				if(prevTourTab.length){
					$parentWrap.find('.tour-nav .prev').html(prevTourTab.html()).attr('data-index', prevTourTab.index());
					$parentWrap.find('.tour-nav .prev a').append(' <i class="icon-hand-left"></i>');
				}
				else{
					$parentWrap.find('.tour-nav .prev').html('');
				}

				if(nextTourTab.length){
					$parentWrap.find('.tour-nav .next').html(nextTourTab.html()).attr('data-index', nextTourTab.index());
					$parentWrap.find('.tour-nav .next a').prepend('<i class="icon-hand-right"></i> ');
				}
				else{
					$parentWrap.find('.tour-nav .next').html('');
				}

			});
		} // /if tour tabs
	} // /if tabs

/*
*****************************************************
*      8) CREATE ACCORDIONS
*****************************************************
*/
	if (jQuery('div.accordion-wrapper').length){
		(function(){
			var accordionObject = jQuery('div.accordion-wrapper > ul > li');
			accordionObject.each(function(item){
				jQuery(this).find('.accordion-heading').siblings().wrapAll('<div class="accordion-content" />');
			});
		})();

		jQuery('.accordion-content').slideUp();
		jQuery('div.accordion-wrapper > ul > li:first-child .accordion-content').slideDown().parent().addClass('active');
		jQuery('.accordion-heading').click(function(){
			var $this = jQuery(this);
			$this.next('.accordion-content').slideDown().parent().addClass('active').siblings('li').removeClass('active');
			$this.closest('.accordion-wrapper').find('li:not(.active) > .accordion-content').slideUp();
		});

		//Automatic accordion
		var hoveringElements = jQuery('div.accordion-wrapper.auto > ul'),
			notHovering      = true;
		hoveringElements.hover(function(){
			notHovering = false;
		}, function(){
			notHovering = true;
		});

		function autoAccordionFn(){
			if(notHovering === true){
				var $this         = jQuery('div.accordion-wrapper.auto > ul'),
					count         = $this.children().length,
					currentActive = $this.find('li.active'),
					currentIndex  = currentActive.index() + 1,
					nextIndex     = (currentIndex + 1) % count;
				$this.find('li').eq(nextIndex - 1).find('.accordion-heading').trigger('click');
			}
		} // /autoAccordionFn
		var autoAccordion = setInterval(autoAccordionFn, autoAccordionDuration);
	} // /if accordion

/*
*****************************************************
*      9) CREATE TOGGLES
*****************************************************
*/
	if (jQuery('div.toggle-wrapper').length){
		(function(){
			var toggleObject = jQuery('div.toggle-wrapper');
			toggleObject.each(function(item){
				jQuery(this).find('.toggle-heading').siblings().wrapAll('<div class="toggle-content" />');
			});
		})();
		jQuery('div.toggle-wrapper').not('.active').find('div.toggle-content').slideUp();
		jQuery('.toggle-heading').click(function(){
			var $this = jQuery(this);
			if($this.hasClass('animation-fade')) $this.next('div.toggle-content').toggle().css({opacity:0}).animate({opacity:1}, 800).parent().toggleClass('active');
			else $this.next('div.toggle-content').slideToggle().parent().toggleClass('active');
		});
	} // /if toggle

/*
*****************************************************
*      10) YOUTUBE EMBED FIX
*****************************************************
*/
	jQuery('iframe[src*="youtube.com"]').each(function(item){
		var srcAtt=jQuery(this).attr('src');
		if(-1 == srcAtt.indexOf('?'))
			srcAtt+='?wmode=transparent';
		else
			srcAtt+='&amp;wmode=transparent';
		jQuery(this).attr('src', srcAtt);
	});

/*
*****************************************************
*      11) SEARCH FORM
*****************************************************
*/
	jQuery('.breadcrumbs.animated-form .form-search').width(120);
	jQuery('.breadcrumbs.animated-form input[type="text"]')
		.focus(function(){
			jQuery(this).closest('.form-search').width(200);
		})
		.blur(function(){
			jQuery(this).closest('.form-search').stop().animate({width:120}, 250);
		})
		.hover(function(){
			jQuery(this).closest('.form-search').stop().animate({width:200}, 250);
		}, function(){
			var $this = jQuery(this);
			if(!$this.is(':focus')) $this.closest('.form-search').stop().animate({width:120}, 250);
		});

	var $searchForm  = jQuery('.ie .form-search input[type="text"]'),
	    $placeholder = $searchForm.attr('placeholder');
	function setSearchPlaceholder(){
		if('' == $searchForm.val()) $searchForm.val($placeholder);
		else if($placeholder == $searchForm.val()) $searchForm.val('');
	}; // /setSearchPlaceholder

	setSearchPlaceholder();
	$searchForm.change(function(){
		setSearchPlaceholder();
	});
	$searchForm.focus(function(){
		setSearchPlaceholder();
	});

/*
*****************************************************
*      12) SLIDESHOW SHORTCODE
*****************************************************
*/
	if (jQuery().flexslider){
		var $containerF = jQuery('.slideshow.flexslider'),
		    slideSpeed  = $containerF.data('time');
		if(jQuery('html').hasClass('ie')){
			$containerF.flexslider({
				animation      : "slide",
				easing         : "swing",
				direction      : "horizontal",
				slideshowSpeed : slideSpeed,
				smoothHeight   : true,
				animationSpeed : 400,
				pauseOnAction  : true,
				pauseOnHover   : true,
				useCSS         : true,
				touch          : true,
				video          : false,
				controlNav     : true,
				directionNav   : true,
				keyboard       : true,
				pausePlay      : false
			});
		}
		else{
			$containerF.imagesLoaded(function(){
				$containerF.flexslider({
					animation      : "slide",
					easing         : "swing",
					direction      : "horizontal",
					slideshowSpeed : slideSpeed,
					smoothHeight   : true,
					animationSpeed : 400,
					pauseOnAction  : true,
					pauseOnHover   : true,
					useCSS         : true,
					touch          : true,
					video          : false,
					controlNav     : true,
					directionNav   : true,
					keyboard       : true,
					pausePlay      : false
				});
			});
		}
	} // /flexslider

/*
*****************************************************
*      13) ISOTOPE FILTER
*****************************************************
*/
	if(jQuery().isotope){
		var $filteredContent  = jQuery('.filter-this'),
		    isotopeLayoutMode = $filteredContent.data('layout-mode');
		if($filteredContent.hasClass('wrap-projects')){
			var itemWidth = $filteredContent.find('article:first-child').outerWidth();
			$filteredContent.width('101%').find('article').width(itemWidth);
		}
		function runIsotope(){
			$filteredContent.isotope({
				layoutMode : isotopeLayoutMode
			});
			//filter items when filter link is clicked
			jQuery('.wrap-filter a').click(function(e){
				e.preventDefault();
				var $this = jQuery(this),
					selector = $this.data('filter');
				$this.closest('.filterable-content').find('.filter-this').isotope({ filter: selector });
				$this.addClass('active').parent('li').siblings('li').find('a').removeClass('active');
			});
			jQuery('.filter-this .toggle-wrapper').click(function(){
				jQuery('.filter-this').isotope('layout');
			});
		}; // /runIsotope
		if(jQuery('html').hasClass('ie')){
			runIsotope();
		}
		else{
			$filteredContent.imagesLoaded(function(){
				runIsotope();
			});
		}
	} // /isotope

/*
*****************************************************
*      14) TESTIMONIALS AND STATUSES
*****************************************************
*/
	if (jQuery().quovolver){
		if (jQuery('.wrap-testimonials-shortcode[data-time]').length){
			(function(){
				var testimonialsObject = jQuery('.wrap-testimonials-shortcode[data-time]');
				testimonialsObject.each(function(item){
					var $this = jQuery(this),
						speed = $this.data('time') + 400;
					$this.find('blockquote').quovolver(400, speed);
				});
			})();
		} // /if testminonials
		
		if (jQuery('.wrap-status-shortcode[data-time]').length){
			(function(){
				var statusObject = jQuery('.wrap-status-shortcode[data-time]');
				statusObject.each(function(item){
					var $this = jQuery(this),
						speed = $this.data('time');
					if(speed) $this.find('.status-post').quovolver(400, speed + 400);
				});
			})();
		} // /if statuses
	} // /quovolver

/*
*****************************************************
*      15) RESPONSIVE MENU
*****************************************************
*/
	if(jQuery('#nav-main .menu').length){
		jQuery('<select />',{
			'id' : 'nav-mobile'
		}).appendTo('#nav-main');
		jQuery('<option />',{
			'selected' : 'selected',
			'value'    : '',
			'text'     : wmLocalization.mobileMenu
		}).appendTo('#nav-mobile');
		(function(){
			var menuItems  = jQuery('#nav-main ul li'),
			    appendLast = '';
			menuItems.each(function(item){
				var $this   = jQuery(this),
				    $link   = $this.find('> a'),
				    parents = $this.data('depth'),
				    url     = $link.attr('href'),
				    text    = $link.find('> span').text(),
				    dashes  = '';
				if(url && text){
					for(var i=parents-1; i>=0; i--){
						dashes += '- ';
					}
					if($this.hasClass('alignright')) appendLast += '<option value="' + url + '">' + dashes + text + '</option>';
					else{
						jQuery('<option />',{
							'value' : url,
							'text'  : dashes+' '+text
						}).appendTo('#nav-mobile');
					}
				}
			});
			jQuery('#nav-mobile').append(appendLast).change(function(){
				window.location = jQuery(this).val();
			});
		})();
	} // /if main navigation menu

/*
*****************************************************
*      16) MASONRY GALLERY
*****************************************************
*/
	if (jQuery().masonry){
		var $containerM = jQuery('.gallery.masonry-container'),
		    itemWidthM  = $containerM.find('figure:first-child').outerWidth() - 2;
		$containerM.width('105%').find('figure').width(itemWidthM);
		if(jQuery('html').hasClass('ie')){
			$containerM.masonry({
				itemSelector : 'figure'
			});
		}
		else{
			$containerM.imagesLoaded(function(){
				$containerM.masonry({
					itemSelector : 'figure'
				});
			});
		}
	} // /masonry

/*
*****************************************************
*      17) CALL TO ACTION
*****************************************************
*/
	if(jQuery('div.call-to-action').length){
		(function(){
			var ctaObject = jQuery('div.call-to-action');
			ctaObject.css({paddingRight:0});
			ctaObject.each(function(item){
				var $this          = jQuery(this),
					ctaBtnWidth    = $this.find('.btn').outerWidth() + 60, //30px margin left and right
					ctaTitle       = $this.find('.call-to-action-title'),
					ctaTitleWidth  = ctaTitle.outerWidth() + 30, //30px margin right
					ctaTitleMargin = 0;
				$this.find('.cta-text').css({paddingRight:ctaBtnWidth});
				if($this.hasClass('has-title')){
					$this.css({paddingLeft:ctaTitleWidth});
					ctaTitleMargin = (ctaTitle.outerHeight()-ctaTitle.find('h2').outerHeight())/2;
					ctaTitle.find('h2').css({marginTop:ctaTitleMargin+'px'});
				}
			});
		})();
	} // /if call to action
});