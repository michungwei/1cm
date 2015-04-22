<?php
include_once("_config.php");
include_once($inc_path."_getpage.php");

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();
//廣告
$sql_adv = "SELECT * 
		    FROM $table_adv
			WHERE $isshow_adv=1";

$rows_adv = $db -> fetch_all_array($sql_adv);

foreach($rows_adv as $row_adv){
  $adv[$row_adv["adv_id"]]=$row_adv["adv_link"];
}

//新聞列表
$sql = "SELECT * 
		FROM $table_news n,$table_newstype nt ,$table_admin a
	    WHERE n.newsType_id=nt.newsType_id AND a.admin_id=n.news_aut_id AND n.$news_upday<=NOW() AND n.$isshow_news = 1
		ORDER BY $news_upday DESC";

getSql($sql, 10, $query_str);
$rows_news = $db -> fetch_all_array($sql);

$i = 0;
foreach($rows_news as $rows_news){
  $rows_img[$i]=$rows_news["news_banner"];
  $rows_id[$i]=$rows_news["news_id"];
  $rows_title[$i]=$rows_news["news_title"];
  $i++;
}


$db -> close();
?>
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
	<link rel="stylesheet" href="css/bootstrap.css">
    <link rel="icon" href="<?php echo $web_icon?>" type="image/png" />
    <link rel="stylesheet" href="scripts/fancybox/jquery.fancybox.css">
	<script src="scripts/jquery-1.9.1.js"></script>
	<script src="scripts/jquery.infinitescroll.min.js"></script>
	<script src="scripts/jquery.cookie.js"></script>
	<script src="scripts/bootstrap.js"></script>
	<script src="scripts/all.js"></script>
    <script src="scripts/search.js"></script>
    <script src="scripts/fancybox/jquery.fancybox.js"></script>
    <script>
    	/*$(function(){
    		$('.fancybox').fancybox({
    			"autoWidth": "true",
    			"autoHeight": "true",
    			"openEffect": "elastic",
    			"closeEffect": "elastic",
    		});
    	});*/
    </script>
	<script>
		$(function(){
			$('#content_').infinitescroll({
				navSelector 	:	'#page-nav',
				nextSelector	:	'#page-nav a',
				itemSelector	:	'.content_sectionL',
				animate      	:   true,
				maxPage			:	<?php echo $page_count; ?>,
				path: function(index) {
					return "index.php?keyword="+$.urlParam("keyword")+"&page=" + index;
				},
	
				loading: {
					msgText : 'Loading...',    //加载时的提示语
					finishedMsg: '您已經閱讀完全部了喔！',
					finished: function() {
						var el = document.body; 
						$('#infscr-loading').hide();
						if (typeof FB !== "undefined") { FB.XFBML.parse(el); }
					}
				}

			});
		});
	</script>
	<script type="text/javascript">
    	var googletag = googletag || {};
    	googletag.cmd = googletag.cmd || [];
		(function() {
			var gads = document.createElement("script");
			gads.async = true;
			gads.type = "text/javascript";
			var useSSL = "https:" == document.location.protocol;
			gads.src = (useSSL ? "https:" : "http:") + "//www.googletagservices.com/tag/js/gpt.js";
			var node =document.getElementsByTagName("script")[0];
			node.parentNode.insertBefore(gads, node);
		})();
    </script>

	<script>
		googletag = window.googletag || {cmd:[]};
		googletag.cmd.push(function() {
			var mapping = googletag.sizeMapping().addSize([0, 0], [300, 250]).addSize([400, 0], [160, 600]).build();
			googletag.defineSlot('/7682122/1CM_all_160x600_RT', [[160, 600], [300, 250]], 'div-gpt-ad-1411546601925-0').defineSizeMapping(mapping).addService(googletag.pubads());
    	    googletag.enableServices();
		});
	</script>
	<script type="text/javascript" src="/ysm/1cm/sf_ysm.js" id="sf_script" slot="1cm_home"></script>
	<script type="text/javascript" src="/ysm/1cm/sf_ysm_hk.js" id="sf_hk_script"></script>
</head>
<body>
	<!-- scrollTop Start -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div id="idle_wrapper">
		
		<!-- <div class="scroll_top50 hidden-mobile hidden-tablet">
			<a href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image1','','images/scroll_topover.png')"><img src="images/scroll_top.png" height="80" width="80" name="image1" alt=""></a>
		</div>
		<div class="scroll_top90 hidden-mobile hidden-tablet">
			<a href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image2','','images/scroll_topover.png')"><img src="images/scroll_top.png" height="80" width="80" name="image2" alt=""></a>
		</div> -->
		
		<header id="idle_header">
			<!-- <nav class="headerL hidden-mobile">
				<span><a href="about.php">ABOUT</a></span>
				<span><a href="news_type.php">NEWS</a></span>
			</nav>
			<div class="headerC">
				<p><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagelogo','','images/logoover.png')"><img src="images/logo.png" alt="" name="imagelogo"></a></p>
			</div>
			<div class="headerR hidden-mobile">
				<div class="search">
					<input type="text" id="search" name="search" value="search">
					<p class="btn" id="search_btn" onClick="search()"><img src="images/search_btn.png" alt=""></p>
				</div>
				<span class="hidden-tablet"><a href="https://www.facebook.com/pages/1cm/761735067202346" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagefb','','images/icon_fbover.png')"><img src="images/icon_fb.png" alt="" name="imagefb"></a></span>
				<span class="hidden-tablet"><a href="http://instagram.com/1___cm" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imageinsta','','images/icon_instaover.png')"><img src="images/icon_insta.png" alt="" name="imageinsta"></a></span>
			</div> -->
			<div class="mt_30">
				<a>本網頁已閒置超過三分鐘。請移動滑鼠或鍵盤任意鍵或點擊空白處即可回到原網頁。</a>
			</div>
		</header>

		<section>
			<div class="mb_30 headerC">
			</div>
			<div class="subtitle-advtise">
                <?php if(isset($adv["11"])){echo $adv["11"];}?>
			</div>
			<div class="idle_container">
				<div class="idle_showbox">
					<img id="show-image" src= "<?php echo $web_path_news,"s",$rows_img[0];  ?>" />
				</div>
				<div class="idle_list">
					<ul>
						<?php
							$i = 0;
							foreach($rows_news as $row_news)
							{
								if($i < 5)
								{
						?>
								<li>
									<div class="titleL"><a><?php echo $i+1;?></a></div>
									<a target="_parent" href="news_detail.php?nid=<?php echo $rows_id[$i];?>"><?php echo $rows_title[$i];?></a>
									<a name="<?php echo $web_path_news,"s",$rows_img[$i];?>"><img src="<?php echo $web_path_news,"s",$rows_img[$i];  ?>"></img></a>
								</li>
						<?php
								}
								$i++;
							}
						?>
					</ul>
				</div>
			</div>
			<div>
				<ul class="idle_adv" <?php if(isset($adv["20"]) && isset($adv["21"])){ echo ''; }else{ echo 'style="display: none;"'; } ?> >
					<li><?php if(isset($adv["20"])){echo $adv["20"];}?></li>
					<li><?php if(isset($adv["21"])){echo $adv["21"];}?></li>
				</ul>
			</div>
			<div class="idle_container">
				<div class="idle_footer">
					<a target="_parent" href="index.php"><img src= "images/idle_logo.png"><a>
				</div>
			</div>
		</section>

		<footer id="footer">
			<!--<ul class="hidden-mobile">
				<li><img src="images/footer_logo.png" alt=""></li>
				<li>2014 1CM MEDIA. ALL RIGHT RESERVED</li>
				<li class="mailinfo"><a href="mailto:onecentimetremag@gmail.com">onecentimetremag@gmail.com</a></li>
			</ul>
			<div class="mobile_footer visible-mobile">
				<img src="images/footer_logo.png" alt="">
			</div> -->
			<!--<div class="footer_logo hidden-mobile">
				<a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('flogo','','images/flogoover.png'),'1'"><img src="images/flogo.png" height="32" width="80" alt="" name="flogo"></a>
			</div>
			<ul>
				<li class="footer_backindex"><a href="index.php">返回首頁</a></li>
				<li class="footer_gotop"><a href="javascript: void(0)">回到上方</a></li>
				<li class="hidden-mobile"><a href="about.php">關於我們</a></li>
				<li class="hidden-mobile"><a href="contact.php">聯絡我們</a></li>
			</ul>-->
		</footer>

	</div>
<!-- lazyload -->
    <script type="text/javascript" src="ui/lazyload-master/jquery.lazyload.js"></script>
    <script>
	$(document).ready(function(e) {
        /*$(".content_block .thumbimg img").lazyload({
            effect : "fadeIn",
			//placeholder: "http://1.bp.blogspot.com/-Qt2R-bwAb4M/T8WKoNKBHRI/AAAAAAAACnA/BomA-Whl_Bk/s1600/grey.gif"
        });*/
		$(".popupBox-close").hide();
		$("#popupBox").hide();
		popupDiv("popupBox");
		
		$(function(){
			// 用來顯示大圖片用
			var $showImage = $('#show-image');
		 
			// 當滑鼠移到 .abgne-block-20120106 中的某一個超連結時
			$('.idle_list li a').mouseover(function(){
				// 把 #show-image 的 src 改成被移到的超連結的位置
				$showImage.attr('src', $(this).next().attr('name'));
			});
		});
    });
    </script>
</body>
</html>