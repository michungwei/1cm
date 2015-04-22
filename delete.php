<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="author" content="<?php echo $author; ?>" />
<meta name="copyright" content="<?php echo $copyright; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $web_name; ?></title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="scripts/jquery-1.9.1.js"></script>
	<script>

		function scrollTop(className){
			$(className).click(function() {
				$('html, body').animate({"scrollTop": "0px"}, 500);
			});
		}

		$(function(){

			scrollTop('.scroll_top50');
			scrollTop('.scroll_top90');

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

			$('div.fbslide').find('div.closebtn').click(function() {
				$('div.fbslide').fadeOut();
			});

			$(window).scroll(function() {
				if ($(document).scrollTop() + $(window).height() >= $(document.body).outerHeight() * 0.95) {
					$('div.fbslide').stop().animate({"top":"0px","opacity":"1"}, 400);
				}
			});


		});
		
	</script>
</head>
<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div id="wrapper">
		<div class="scroll_top50 hidden-mobile hidden-tablet"></div>
		<div class="scroll_top90 hidden-mobile hidden-tablet"></div>

		<header id="header">
			<nav class="headerL">
				<span><a href="about.php">ABOUT</a></span>
				<span><a href="news_type.php">NEWS</a></span>
			</nav>
			<div class="headerC">
				<p><a href="index.php"><img src="images/logo.png" alt=""></a></p>
			</div>
			<div class="headerR hidden-mobile">
				<div class="search">
					<input type="text" id="search" value="search">
					<p class="btn"><a href="#"><img src="images/search_btn.png" alt=""></a></p>
				</div>
				<span class="hidden-tablet"><a href="https://www.facebook.com/pages/1cm/761735067202346" target="_blank"><img src="images/icon_fb.png" alt=""></a></span>
				<span class="hidden-tablet"><a href="http://instagram.com/1___cm" target="_blank"><img src="images/icon_insta.png" alt=""></a></span>
			</div>
		</header>

		<section id="content">
			<div class="subtitle"><img src="images/subtitle.png" alt=""></div>
			<div class="subtitle-advtise">
				<div class="subtitle-advtiseL">
					<a href="#"><img src="images/advtiseL.jpg" alt=""></a>
				</div>
				<div class="subtitle-advtiseR hidden-mobile">
					<p class="title hidden-tablet">按下讚與我們一起探索知識的無窮！</p>
					<p class="title visible-tablet">按下讚探索知識的無窮！</p>
					<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
				</div>
			</div>
			<div class="banner">
				<div class="fblike hidden-mobile hidden-tablet">
					<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=40&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:43px; height:65px;" allowTransparency="true"></iframe>
					<div class="fb-share-button" data-href="https://www.facebook.com/pages/1cm/761735067202346" data-width="40" data-type="box_count"></div>
				</div>
				<img src="images/banner.png" alt="">
			</div>
			<div class="content_section">
				<div class="content_sectionL border_bottomNone">

					<!-- 內文 Start -->
					<div class="delete_block">
						<p class="icon"><img src="images/deleteimg.png" alt=""></p>
						<p class="btn_home"><a href="index.php"><img src="images/btn_home.png" alt=""></a></p>
					</div>
					<!-- 內文 End -->

				</div>

				<!-- Sidebar Start -->
				<aside class="content_sectionR hidden-mobile">
					<div class="content_blockAdv"><a href="#"><img src="images/content_blockAdv01.png" alt=""></a></div>
					<div class="content_blockAdv">
						<div class="thumbimg"><img src="images/content_blockAdv02-img.png" alt=""></div>
						<div class="title">維基百科新規定 付費編輯須公開維基百科新規定</div>
					</div>
					<div class="content_blockFB">
						<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; background: #f5f5f5;" allowTransparency="true"></iframe>
					</div>
				</aside>
				<!-- Sidebar End -->
				
				<div class="fb_block">
					<div class="fbshare_btn"><a href="#"><img src="images/fbshare_btn.png" alt=""></a></div>
					<div class="fbjoin_btn"><a href="#"><img src="images/fbjoin_btn.png" alt=""></a></div>
				</div>
				<div class="page_btn">
					<span class="prev"><a href="#"><img src="images/btn_prev.png" alt=""></a></span>
					<span class="next"><a href="#"><img src="images/btn_next.png" alt=""></a></span>
				</div>
				<div class="like_section hidden-mobile">
					<p><img src="images/like_block_title.png" alt=""></p>
					<div class="like_block">
						<p class="like_blockimg"><img src="images/like_blockimg.png" alt=""></p>
						<p>路透：廣達奪iWatch大單 下月量產10月上市 規格曝光，提前上市</p>
					</div>
					<div class="like_block">
						<p class="like_blockimg"><img src="images/like_blockimg.png" alt=""></p>
						<p>路透：廣達奪iWatch大單 下月量產10月上市 規格曝光，提前上市</p>
					</div>
					<div class="like_block border_rightNone">
						<p class="like_blockimg"><img src="images/like_blockimg.png" alt=""></p>
						<p>路透：廣達奪iWatch大單 下月量產10月上市 規格曝光，提前上市</p>
					</div>
				</div>
				<div class="like_section visible-mobile">
					<p><img src="images/like_block_title.png" alt=""></p>
					<div class="like_block">
						<p class="like_blockimg"><img src="images/like_blockimg.png" alt=""></p>
						<p>路透：廣達奪iWatch大單 下月量產10月上市 規格曝光，提前上市</p>
					</div>
					<div class="like_block border_rightNone">
						<p class="like_blockimg"><img src="images/like_blockimg.png" alt=""></p>
						<p>路透：廣達奪iWatch大單 下月量產10月上市 規格曝光，提前上市</p>
					</div>
				</div>

				<ul class="advertisement hidden-mobile">
					<li><a href="#"><img src="images/advertisement01.png" alt=""></a></li>
					<li><a href="#"><img src="images/advertisement02.png" alt=""></a></li>
				</ul>
				<div class="fbslide hidden-mobile" id="fbslide">
					<div class="closebtn"></div>
					<p class="title">歡迎加入我們，<br />一同探索簡單有趣的生活品味：）</p>
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%;" allowTransparency="true"></iframe>
				</div>
				<div class="mobile_advertisement visible-mobile">
					<?php
					   $input = array ("1", "2", "3");
					   $rand_keys = array_rand($input);
					   echo $adv[$rand_keys];
					?>
				</div>
				<div class="mobile_advertisement visible-mobile">
                    <?php
						foreach($rows_rnews as $row_rnews){
					?>
						<div class="content_blockAdv mt_15 mb_15">
	                        <a href="news_detail.php?nid=<?php echo $row_rnews["news_id"];?>">
							<div class="thumbimg"><img src="<?php echo $web_path_news,"s",$row_rnews["news_banner"];?>" alt=""></div>
							<div class="title"><?php echo tc_left($row_rnews["news_title"],23);?></div>
	                        </a>
						</div>
                    <?php
                    	}
					?>
				</div>
			</div>
			<div class="clear"></div>
		</section>

		<footer id="footer">
			<ul class="hidden-mobile">
				<li><img src="images/footer_logo.png" alt=""></li>
				<li>2014 1CM MEDIA. ALL RIGHT RESERVED</li>
				<li class="mailinfo"><a href="mailto:onecentimetremag@gmail.com">onecentimetremag@gmail.com</a></li>
			</ul>
			<div class="mobile_footer visible-mobile">
				<img src="images/footer_logo.png" alt="">
			</div>
		</footer>

	</div>
</body>
</html>