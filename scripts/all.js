function MM_swapImgRestore() { //v3.0
	var i, x, a = document.MM_sr;
	for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++) x.src = x.oSrc;
}

function MM_preloadImages() { //v3.0
	var d = document;
	if (d.images) {
		if (!d.MM_p) d.MM_p = new Array();
		var i, j = d.MM_p.length,
			a = MM_preloadImages.arguments;
		for (i = 0; i < a.length; i++)
			if (a[i].indexOf("#") != 0) {
				d.MM_p[j] = new Image;
				d.MM_p[j++].src = a[i];
			}
	}
}

function MM_findObj(n, d) { //v4.01
	var p, i, x;
	if (!d) d = document;
	if ((p = n.indexOf("?")) > 0 && parent.frames.length) {
		d = parent.frames[n.substring(p + 1)].document;
		n = n.substring(0, p);
	}
	if (!(x = d[n]) && d.all) x = d.all[n];
	for (i = 0; !x && i < d.forms.length; i++) x = d.forms[i][n];
	for (i = 0; !x && d.layers && i < d.layers.length; i++) x = MM_findObj(n, d.layers[i].document);
	if (!x && d.getElementById) x = d.getElementById(n);
	return x;
}

function MM_swapImage() { //v3.0
	var i, j = 0,
		x, a = MM_swapImage.arguments;
	document.MM_sr = new Array;
	for (i = 0; i < (a.length - 2); i += 3)
		if ((x = MM_findObj(a[i])) != null) {
			document.MM_sr[j++] = x;
			if (!x.oSrc) x.oSrc = x.src;
			x.src = a[i + 2];
		}
}

function scrollTop(className) {
	$(className).click(function() {
		$('html, body').animate({
			"scrollTop": "0px"
		}, 500);
	});
}
$(function() {
	/*$('.popupBox-close').css('display', 'block');
	$(".popupBox-close").hide();
	$('#popupBox').css('display', 'block');
	$("#popupBox").hide();*/
	
	scrollTop('.scroll_top50');
	scrollTop('.scroll_top90');
	scrollTop('#scrollTop');
	scrollTop('.footer_gotop');

	var inputEl = $('#search'),
		defVal = inputEl.val();
	inputEl.bind({
		focus: function() {
			var _this = $(this);
			if (_this.val() == defVal) {
				_this.val('');
			}
		},
		blur: function() {
			var _this = $(this);
			if (_this.val() == '') {
				_this.val(defVal);
			}
		}
	});

	$('div.mobile-switch').click(function() {
		$('.mobile-list').css('display', 'block');
		$('.mobile-list').animate({
			"left": "0px",
			"opacity": "1"
		}, 700);
	});
	$('.mobileClose').click(function() {
		$('.mobile-list').animate({
			"left": "-100%",
			"opacity": "0"
		}, 700, function() {
			$(this).css('display', 'none');
		});
	});
	/*var date = new Date();
	$('div.fbslide').find('div.closebtn').click(function() {
		$('div.fbslide').fadeOut();
		date.setTime( date.getTime() + ( 12 * 60 * 60 * 1000) );
		$.cookie( '1cm_fbslide', 'yes', { expires : date } );
	});*/

	/*$(window).scroll(function() {
		// console.log($(document).scrollTop());
		// console.log($(window).height());
		// console.log($(document).height());
		// console.log($(document.body).outerHeight() * 0.95);
		if( !$.cookie('1cm_fbslide') )
		{
			if ($(document).scrollTop() > $(document).height() * 0.6) {
				$('div.fbslide').stop().animate({
					//"top": "0px",
					"bottom": "0px", 
					"opacity": "1"
				}, 500);
			}else{
				$('div.fbslide').stop().animate({
					"bottom": "-250px", 
					"opacity": "0.3"
				}, 500);
			}
		}
	});*/
	
});

function popupDiv(div_id)
{
	var date = new Date();
	if( !$.cookie('1cm_mask') && jQuery(window).width() <= 767)
	{
		date.setTime( date.getTime() + (60 * 60 * 1000) );
		
		console.log(date);
		
		$.cookie( '1cm_mask', 'yes', { expires : date } );
		$('.popupBox-close').css('display', 'block');
		$('#popupBox').css('display', 'block');
		var div_obj = $("#"+ div_id);
		$(".popupBox-close").show();
		$("#mask").show();
		$(div_obj).removeClass('hidden-mobile');
		$(div_obj).fadeIn();
	}
}

function hideDiv(div_id)
{
	$(".popupBox-close").hide();
	$("#mask").hide();
	$("#" + div_id).fadeOut();
}

$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return "";
    }
    else{
       return results[1] || 0;
    }
}


$(window).load(function() {
	
	var $cart = $('#slidebar_adv'),
		$TopBanner = $('.content_blockAdv').eq(0),
		$Recommand = $('.recommend_block'),
		$goTopBtn = $('#slidebar_goTop'),
		$TopBannerWidth = $TopBanner.width() + 2,
		dis,
		/*$header = $('#header'),
		$headerBG = $('#header_background'),
		$headerC = $('#header .headerC'),
		$headerL = $('#header .headerL'),
		$headerR = $('#header .headerR'),
		$header_mb_switch = $('#header .mobile-switch'),
		$header_mb_fb = $('#header .mobile-fb'),
		$header_mb_insta = $('#header .mobile-insta'),*/
		/*_topTopBanner = $TopBanner.offset().top - 30,
		_topRecommand = $Recommand.offset().top,*/
		_topFootBanner = 1000,
		L_height = $('.content_sectionL').height(),
		R_height = $('.content_sectionR').height();
	//console.log(_top);
	$(window).resize(function() {
		$TopBannerWidth = $TopBanner.width() + 2;
	});
	
	var $win = $(window).scroll(function() {
		dis = $('#ysm').height() - 600;
		//dis = $('content_blockFB').height();
		console.log('dis :'+dis );
		if(L_height > R_height){
			/*if ($win.scrollTop() >= _topTopBanner) {
				if ($TopBanner.css('position') != 'fixed') {
					$TopBanner.css({
						position: 'fixed',
						top: '35px',
						width: $TopBannerWidth +'px',
						height: '2000px'
					});
				}
			} 
			if ($win.scrollTop() >= (_topRecommand-50) || $win.scrollTop() < _topTopBanner) {
				$TopBanner.css({
					position: 'static',
					top: 'auto',
					width: '100%',
					height: 'auto'
				});SSS
			}*/
			if ($win.scrollTop() >= (_topFootBanner + dis -10) * 100000) {
				if ($cart.css('position') != 'fixed') {
					$cart.css({
						position: 'fixed',
						top: '35px',
					});
				}
			} else {
				$cart.css({
					position: 'static',
					top: 'auto'
				});
			}
		}
		/*if($win.scrollTop() > $( document ).height() / 2 && jQuery(window).width() <= 767)
		{
			popupDiv("popupBox");
		}*/
		if($win.scrollTop() > 80)
		{
			/*if ($header.css('position') != 'fixed') {
				if( jQuery(window).width() > 767 && jQuery(window).width() <= 1120 )
				{
					$header.css({
						position: 'fixed',
						width: '780px',
						height: '45px',
					});
				}
				else if( jQuery(window).width() > 1120 )
				{
					$header.css({
						position: 'fixed',
						width: '1103px',
						height: '45px',			
					});
					//$header.css("margin-left", "2px");
				}
				else
				{
					$header.css({
						position: 'fixed',
						height: '45px',
					});
					$header_mb_switch.css({
						height: '20px'
					});
					$header_mb_fb.css({
						top: '15%'
					});
					$header_mb_insta.css({
						top: '15%'
					});
					$header_mb_switch.css("background-size", "80% 80%");
				}
				$headerC.css({
					height:'45px'
				});
				$headerBG.css({
					height: '45px',
				});
				$headerL.css("margin-top", "2px");
				$headerR.css("padding-top", "6px");
			}*/
			$goTopBtn.show();
		}
		else
		{
			/*if( jQuery(window).width() <= 767 )
			{
				$header.removeAttr("style");
				$header.css({
					width: '100%',
					height:'90px',
					margin:'0',
				});
				$header.css("box-shadow", "2px 2px 10px #888888");
				$header_mb_switch.css({
					height: '41px'
				});
				$header_mb_fb.css({
					top: '33%'
				});
				$header_mb_insta.css({
					top: '33%'
				});
				$header_mb_switch.css("background-size", "100% 100%");
			}
			else
			{
				$header.css({
					width: '100%',
					position: 'relative',
					height: '90px',
				});
			}
			$headerC.css({
				height:'90px'
			});
			$headerBG.css({
				height: '90px',
			});
			$headerL.css("margin-top", "25px");
			$headerR.css("padding-top","30px");*/
			$goTopBtn.hide();
		}
	});
});

/*$(document).ready(function() {
	if( $('nav#menu2').length )
	{
		$('nav#menu2').mmenu({
			footer: {
			   add: true,
			   content: "&copy; 2015"
			},
			searchfield: true
		 });
	}
});*/

	<!--  Google Analytics  1cm.life tracker -->
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52847947-2', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');



	<!--  Google Analytics  onecentimetre.com tracker -->	
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-52847947-1']);
  _gaq.push(['_setDomainName', 'onecentimetre.com']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
	