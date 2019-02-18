// Import JS
import '../lib/smoothState';
import '../lib/bootstrap.bundle';
import '../lib/bootstrap.jasny';
import '../lib/modernizr';
import '../lib/retina';
import '../lib/flowtype';
import '../lib/isotope.pkgd';
import '../lib/smooth-scroll.polyfills';

// Import CSS
import '../../css/lib/bootstrap.min.css';
import '../../css/lib/bootstrap-grid.min.css';
import '../../css/lib/bootstrap-reboot.min.css';
import '../../css/lib/bootstrap.jasny.min.css';
import '../../css/lib/fontawesome.all.min.css';
import '../../css/lib/animate.min.css';
import '../../css/dist/style.css';
'use strict';

(function ($, window, document) {

	// Global Vars
	var menu = $('#header-container');
	var origOffsetY = menu.offset().top;
	
	// Sticky Header
	function stickyHeader() {
		function scroll() {
			if ($('.jumbotron').length > 0) {
				if ($(window).scrollTop() <= origOffsetY) {
					$('#header-container').removeClass('sticky');
					$('.jumbotron').removeClass('menu-padding');
				} else {
					$('#header-container').addClass('sticky');
					$('.jumbotron').addClass('menu-padding');
				}
			} else {
				if ($(window).scrollTop() <= origOffsetY) {
					$('#header-container').removeClass('sticky');
					$('#content').removeClass('menu-padding');
				} else {
					$('#header-container').addClass('sticky');
					$('#content').addClass('menu-padding');
				}
			}
		}
		document.onscroll = scroll;
	}
	stickyHeader();
	
	// Transition Navbar
	function navbarTrans() {
		$(document).on('scroll',function(){
			if($(document).scrollTop() > 220){
				$('#trans-menu').removeClass('large').addClass('small');
				$('.trans-logo').removeClass('active').addClass('hidden');
				$('.regular-logo').removeClass('hidden').addClass('active');
			} 
			else{
				$('#trans-menu').removeClass('small').addClass('large');
				$('.trans-logo').removeClass('hidden').addClass('active');
				$('.regular-logo').removeClass('active').addClass('hidden');
			}
		});
	}
	navbarTrans();

	// Navbar Dropdown
	function navbarDropdown() {
		function is_touch_device() {
			return 'ontouchstart' in window /* Works on most browsers */ || navigator.maxTouchPoints; /* Works on IE10/11 and Surface */
		}
		if(!is_touch_device() && $('.navbar-toggle:hidden')){
			$('.dropdown-menu', this).css('margin-top',0);
			$('.dropdown').hover(function(){ 
				$('.dropdown-toggle#dropdown-main', this).trigger('click');
				// Uncomment below to make the parent item clickable.
				$('.dropdown-toggle#dropdown-main', this).toggleClass('disabled'); 
			});			
		}
		if(is_touch_device()) {
			$('<a href="#" data-toggle="dropdown" id="dropdown-arrow" aria-haspopup="true" class="dropdown-toggle visible-xs"><i class="glyphicon glyphicon-chevron-down"></i></a>').insertAfter('.dropdown-toggle#dropdown-main');
			$('.dropdown-toggle#dropdown-main', this).toggleClass('disabled');
		}
	}
	navbarDropdown();

	// Flowtype
	function flowtypeJS() {
		$('body').flowtype({
			minimum   : 320,
			maximum   : 2560,
			minFont   : 14,
			maxFont   : 72,
			fontRatio : 81
		});
	}
	flowtypeJS();

	// Height to Viewport
	function setHeight() {
		var windowHeight = $(window).innerHeight();
		var headerHeight = $('#header-container').innerHeight();
		$('.jumbotron').css('min-height', windowHeight - headerHeight);
		$('.jumbotron .slider').css('min-height', windowHeight - headerHeight);
	}
	setHeight();
	// Window Resize			
	$(window).resize(function() {
		setHeight();
	});
			
	// To Top Button
	function toTop() {
		var offset = 0;
		$(window).scroll(function() {
			if (jQuery(this).scrollTop() > offset) {
				jQuery('.totop').addClass('fadeIn').removeClass('fadeOut');
			} else {
				jQuery('.totop').addClass('fadeOut').removeClass('fadeIn');
			}
		});
	}
	toTop();

	// Adding Backlist Classes
	function addBlacklistClass() {
		$('a').each(function() {
			if (window.location.href.indexOf('/wp-admin') !== -1 ||
			window.location.href.indexOf('/wp-login.php') !== -1 ||
			window.location.href.indexOf('/shop') !== -1) {
				$(this).addClass('nosmoothstate');
			}
		});
	}
	addBlacklistClass();

	// Adding Comments Section Hash
	function addBlacklistHash() {
		var $hash = $( window.location.hash );
		if ($hash.length !== 0) {
			var offsetTop = $hash.offset().top;
			$('body, html').animate({
					scrollTop: ( offsetTop - 60 ),
				},{
					duration: 280
			});
		}
	}
	
	// Facebook API
	function FacebookAPI() {
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) { return; }
			js = d.createElement(s); js.id = id;
			js.src = '//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8';
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	}
	FacebookAPI();
	
	// Twitter API
	function twitterAPI() {
		!function(d,s,id){
			var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
			if(!d.getElementById(id)){
				js=d.createElement(s); js.id=id;
				js.src=p+'://platform.twitter.com/widgets.js';
				fjs.parentNode.insertBefore(js,fjs);
			}
		}(document,'script','twitter-wjs');
	}
	twitterAPI();
	
	// Detect External Links
	function externalLinkage() {
		$('a').click(function() {
			var href = $(this).attr('href');
			if ((href.match(/^https?\:/i)) && (!href.match(document.domain))) {
				var extLink = href.replace(/^https?\:\/\//i, '');
				return extLink;
			}
		});
	}
	externalLinkage();

	// Smooth Scroll
	var scroll = new SmoothScroll('a[href*="#"]', {
		// Selectors
		ignore: '[data-scroll-ignore],[data-toggle]',
		header: '[data-scroll-header]',
		topOnEmptyHash: true,
		// Speed & Easing
		speed: 750,
		clip: true,
		easing: 'easeInOutCubic',
		// History
		updateURL: false,
		popstate: true,
	});

	// SmoothState
	$('#smoothstate-container').smoothState({
		blacklist: '.nosmoothstate, .fancybox',
		onBefore: function($anchor, $container) {
			/* Insert Event Here */
		},
		onStart: {
			duration: 350,
			render: function ($container) {
				/* Insert Event Here */
			}
		},
		onProgress: {
			duration: 350,
			render: function ($container) {
				/* Insert Event Here */
			}
		},
		onReady: {
			duration: 350,
			render: function ($container, $newContent) {
				$container.html($newContent);
				/* Insert Event Here */
			}
		},
		onAfter: function($container, $newContent) {
			addBlacklistClass();
			addBlacklistHash();
		}
	});
						
})(jQuery, window, document);