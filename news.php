<?php
include_once("_config.php");
include_once($inc_path."_getpage.php");

$ntid=get("ntid");
$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

//分類
$sql_newt = "SELECT * 
		    FROM $table_newstype
			WHERE $isshow_newsType=1
			ORDER BY $ind_nType DESC";

$rows_newt = $db -> fetch_all_array($sql_newt);
//廣告
$sql_adv = "SELECT * 
		    FROM $table_adv
			WHERE $isshow_adv=1";

$rows_adv = $db -> fetch_all_array($sql_adv);

foreach($rows_adv as $row_adv){
  $adv[$row_adv["adv_id"]]=$row_adv["adv_link"];
}
//手機下方廣告
$sql_adv = "SELECT * 
		    FROM $table_adv
			WHERE $isshow_adv=1 AND adv_id in(1,2)
			Limit 0,1";

$rowsp_adv = $db -> query_first($sql_adv);
shuffle($rowsp_adv);
//右方新聞
$sql_rnews = "SELECT * 
		      FROM $table_news
			  WHERE $isshow_news=1 AND $isrightshow_news=1 AND $news_upday<=NOW()
			  ";

$rows_rnews = $db -> fetch_all_array($sql_rnews);
shuffle($rows_rnews);
$rows_rnews = array_slice($rows_rnews, 0, 8);

//類別banner
$sql_ntbanner = "SELECT newsType_pic 
		         FROM $table_newstype
			     WHERE newsType_id='$ntid' AND $isshow_newsType=1";
$rows_ntbanner = $db -> query_first($sql_ntbanner);


//搜尋
$sql_str = "";
if($ntid != ""){
    $sql_str .= "AND n.newsType_id='$ntid'";
}


//新聞列表
$sql = "SELECT * 
		FROM $table_news n,$table_newstype nt,$table_admin a
	    WHERE n.newsType_id=nt.newsType_id AND a.admin_id=n.news_aut_id AND n.$isshow_news=1 AND $news_upday<=NOW() $sql_str
		ORDER BY $news_upday DESC";

getSql($sql, 10, $query_str);
$rows_news = $db -> fetch_all_array($sql);



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
	<link rel="stylesheet" href="css/style.css?ver=150409">
    <link rel="icon" href="<?php echo $web_icon?>" type="image/png" />
	<link rel="stylesheet" href="scripts/fancybox/jquery.fancybox.css">
	<script src="scripts/jquery-1.9.1.js"></script>
	<script src="scripts/jquery.infinitescroll.min.js"></script>
	<script src="scripts/jquery.timeout.interval.idle.js"></script>
	<script src="scripts/jquery.cookie.js"></script>
	<script src="scripts/idle.js"></script>
	<script src="scripts/all.js"></script>
    <script src="scripts/search.js"></script>
	<script src="scripts/fancybox/jquery.fancybox.js"></script>
	
	<script>
		/*$(function(){
			$('#content_').infinitescroll({
				navSelector 	:	'#page-nav',
				nextSelector	:	'#page-nav a',
				itemSelector	:	'.content_sectionL',
				animate      	:   true,
				maxPage			:	<?php echo $page_count; ?>,
				path: function(index) {
					return "news.php?ntid=" + $.urlParam("ntid") + "&page=" + index;
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
		});*/
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

	<script type="text/javascript" src="ysm/1cm/sf_ysm.js" id="sf_script" slot="1cm_home"></script>
	<script type="text/javascript" src="ysm/1cm/sf_ysm_hk.js" id="sf_hk_script"></script>
	<?php include_once("analytics.php"); ?>
</head>
<body>
	<!-- scrollTop Start -->
	<div id="slidebar_goTop" class="bottom_scrollTop hidden-mobile">
		<a href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image1','','images/scroll_topover.png'),'1'"><img src="images/scroll_top.png" width="80" height="80" alt="" id="scrollTop" name="image1"></a>
	</div>
	<!-- scrollTop End -->
	<div id="mask" class="mask"></div>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div id="header_background">
	</div>
	<div id="wrapper">
		<!-- <div class="scroll_top50 hidden-mobile hidden-tablet">
			<a href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image1','','images/scroll_topover.png')"><img src="images/scroll_top.png" height="80" width="80" name="image1" alt=""></a>
		</div>
		<div class="scroll_top90 hidden-mobile hidden-tablet">
			<a href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image2','','images/scroll_topover.png')"><img src="images/scroll_top.png" height="80" width="80" name="image2" alt=""></a>
		</div> -->
		<ul class="mobile-list">
			<li class="mobileClose"><img src="images/mobileClose.png" height="22" width="22" alt=""></li>
				<li>
					<a href="index.php">
						首頁
					</a>
				</li>
			<?php
				foreach($rows_newt as $row_newt){
			?>
				<li>
					<a href="news.php?ntid=<?php echo $row_newt["newsType_id"];?>">
						<?php echo $row_newt["newsType_Cname"]; ?>
					</a>
				</li>
			<?php
				}
			?>
			<li>
				<a href="contact.php">聯絡我們</a>
			</li>
		</ul>
		<div id="popupBox" class="hidden-mobile hidden-tablet hidden-desktop">
			<div class="popupBox-close">
				<img src="images/mask_closebtn.png" onclick="hideDiv('popupBox');">
			</div>
			<?php /*if(isset($adv["18"])){echo $adv["18"];}*/?>
			<!-- 1CM_mobile_320x480_inter -->
			<div class="popupBox-Ad" align = "center">
				<div id='div-gpt-ad-1427868067692-0'>
				<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1427868067692-0'); });
				</script>
				</div>
			</div>
		</div>
		<header id="header">
			<div class="headerC">
				<p><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagelogo','','images/logoover.png')"><img src="images/logo.png" alt="" name="imagelogo"></a></p>
			</div>
			<nav class="headerL hidden-mobile">
				<?php
					foreach($rows_newt as $row_newt){
				?>
					<span><a href="news.php?ntid=<?php echo $row_newt["newsType_id"];?>"><?php echo $row_newt["newsType_Cname"]; ?></a></span>
				<?php
					}
				?>
			</nav>
			<div class="headerR hidden-mobile">
				<div class="search">
					<input type="text" id="search" name="search" value="search">
					<p class="btn" id="search_btn" onClick="search()"><img src="images/search_btn.png" alt=""></p>
				</div>
				<span class="hidden-tablet"><a href="<?php echo $web_fb_url;?>" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagefb','','images/icon_fbover.png')"><img src="images/icon_fb.png" alt="" name="imagefb"></a></span>
				<span class="hidden-tablet"><a href="http://instagram.com/1cm.life" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imageinsta','','images/icon_instaover.png')"><img src="images/icon_insta.png" alt="" name="imageinsta"></a></span>
				<span class="hidden-tablet"><a href="contact.php" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagecontact','','images/icon_mailover.png')"><img src="images/icon_mail.png" alt="" name="imagecontact"></a></span>
			</div>
			<div class="mobile-switch visible-mobile"></div>
			<div class="mobile-fb visible-mobile"><a href="<?php echo $web_fb_url;?>" target="_blank"><img src="images/icon_fb.png" alt=""></a></div>
			<div class="mobile-insta visible-mobile"><a href="http://instagram.com/1cm.life" target="_blank"><img src="images/icon_insta.png" alt=""></a></div>
		</header>

		<section id="content">
			<div class="subtitle"><img src="images/subtitle.png" alt=""></div>
			<div class="subtitle-advtise">
				<div class="subtitle-advtiseL">
					<?php if(isset($adv["11"])){echo $adv["11"];}?>
				</div>
				<div class="subtitle-advtiseR hidden-mobile">
					<p class="title hidden-tablet">按下讚與我們一起探索知識的無窮！</p>
					<p class="title visible-tablet">按下讚探索知識的無窮！</p>
					<iframe class="visible-tablet" src="//www.facebook.com/plugins/like.php?href=<?php echo $web_fb_url;?>&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
					<!-- <div class="fb-like top-right-fb-like-button fb_iframe_widget hidden-tablet" data-href="https://www.facebook.com/pages/1cm%E7%94%9F%E6%B4%BB%E5%93%81%E5%91%B3%E6%8E%A2%E7%B4%A2/761735067202346" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div> -->
					<iframe class="top-right-fb-like-button fb_iframe_widget hidden-tablet" src="//www.facebook.com/plugins/like.php?href=<?php echo $web_fb_url;?>&amp;locale=en_US&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
				</div>
			</div>
            
            <?php
			if($keyword == ""){
			?>
			<div class="banner">
				<div class="fblike hidden-mobile hidden-tablet">
					<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo $web_fb_url;?>&amp;width=40&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:65px;" allowTransparency="true"></iframe>
					<div class="fb-share-button" data-href="<?php echo $web_fb_url;?>" data-width="40" data-type="box_count"></div>
				</div>
				<img src="<?php if(isset($rows_ntbanner["newsType_pic"])){echo $web_path_newstype."b".$rows_ntbanner["newsType_pic"];} ?>" alt="">
			</div>
            <?php
			}
			?>
			<div class="subtitle-advtise">
                <?php if(isset($adv["11"])){echo $adv["11"];}?>
			</div>
            
			<div id="content_" class="content_section">
				<div class="content_sectionL">

					<!-- 內文 Start -->
                    <?php
					 $i=1;
					 foreach($rows_news as $row_news){
					?>
					<div class="content_block">
						<div class="title">
							<div class="titleL"><h3><a href="news_detail.php?nid=<?php echo $row_news["news_id"];?>" class="btn"><?php echo $row_news["news_title"];?></a></h3></div>
							<div class="titleR"><a href="news.php?ntid=<?php echo $row_news["newsType_id"]; ?>"><?php echo substr($row_news["newsType_Ename"],0,1);?></a></div>
						</div>
						<div class="date">
							<span><img src="images/icon_cal.png" height="19" width="23" alt=""></span>
							<span class="date_text">
							    <?php 
								   echo date("m.d.y",strtotime($row_news["news_createtime"]));//strtotime轉化為int格式
								   echo "&nbsp;/&nbsp;";
								   echo date("l",strtotime($row_news["news_createtime"]));//strtotime轉化為int格式
								   echo "&nbsp;/&nbsp;";
								   echo $row_news["admin_cname"];
								?>
                            </span>
							<div>
								<!--<div class="fb-share-button" data-href="https://www.facebook.com/pages/1cm/761735067202346" data-width="57" data-type="button"></div>-->
                                <!-- <div><a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $web_url."news_detail.php?nid=".$row_news["news_id"];?>" target="_blank"><img src="images/icon_share.png"></a></div> -->
                                <div class="fb-share-button" data-href="http://1cm.life/news_detail.php?nid=<?php echo $row_news["news_id"]; ?>" data-layout="button"></div>
								<div class="fb-like" data-href="http://1cm.life/news_detail.php?nid=<?php echo $row_news["news_id"]; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
							</div>
						</div>
						<div class="thumbimg"><a href="news_detail.php?nid=<?php echo $row_news["news_id"];?>" class="btn"><img src="<?php if($row_news["news_banner"]!=""){echo $web_path_news,"m",$row_news["news_banner"];}?>" height="284" alt="" onerror="javascript:this.src='images/nopic.png'"></a></div>
						<div class="description">
                            <?php echo tc_left(strip_tags($row_news["news_content"]),85)?>
							<a href="news_detail.php?nid=<?php echo $row_news["news_id"];?>" class="btn" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image0<?php echo $row_news["news_id"]; ?>','','images/content_btnover.png')"><img src="images/content_btn.png" alt="" name="image0<?php echo $row_news["news_id"]; ?>"></a>
						</div>
						<div class="mobileADV visible-mobile mb_15">
							<?php if(isset($adv["19"]) && $i==3 or $i==6 or $i==9){echo $adv["19"];}?>
						</div>
					</div>
                    <?php
                     $i++;
                     }
					 unset($i);
					?>
                    
                    <!-- 分頁 Start -->
					
					<div class="pagination_outer">
						<div>
							<ul class="pagination">
							    <?php showPage_front(); ?>
							</ul>
						</div>
					</div>
					
					<!-- 分頁 End -->

					<!-- 內文 End -->

				</div>

				<!-- Sidebar Start -->
				<aside class="content_sectionR hidden-mobile">
                    
					<?php
						if( isset($adv["12"]) ){
					?>
						<div class="content_blockAdv">
						<!-- 1CM_all_160x600_RT -->
							<div id='div-gpt-ad-1411546601925-0' style="margin:0 auto;">
								<script type='text/javascript'>
									googletag.cmd.push(function() { googletag.display('div-gpt-ad-1411546601925-0'); });
								</script>
							</div>
						</div>
					<?php
						}else{ echo ''; }
					?>
                    <?php
					 foreach($rows_rnews as $row_rnews){
					?>
					<div class="content_blockAdv recommend_block">
                        <a href="news_detail.php?nid=<?php echo $row_rnews["news_id"];?>">
						<div class="thumbimg"><img src="<?php echo $web_path_news,"s",$row_rnews["news_banner"];?>" alt=""></div>
						<div class="title"><?php echo tc_left($row_rnews["news_title"],23);?></div>
                        </a>
					</div>
                    <?php
                     }
					?>
					<div id="ysm">
						<!--<div name="sfysmad" data="1CM_home_300x780_RT_pc" count="3" ></div>-->
						<div class="content_blockFB">
							<!--<div class="fb-like-box" data-href="https://www.facebook.com/1cmLife" data-width="300px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>-->
							<!--<div class="fb-like-box" data-href="<?php if($ntid == 10) echo $web_fb_url; else echo $web_fb_url;?>" data-width="300" data-height="600" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="true" data-show-border="true"></div>-->
							<div class="fb-page" data-href="<?php echo $web_fb_url;?>" data-hide-cover="true" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo $web_fb_url;?>"><a href="<?php echo $web_fb_url;?>">1CM 質感生活</a></blockquote></div></div>
						</div>
					</div>
					<div class="visible-tablet">
						<?php
							if( isset($adv["13"]) ){
						?>
							<div class="content_blockAdv"><?php if(isset($adv["13"])){echo $adv["13"];}?></div>
						<?php
							}else{ echo ''; }
						?>

						<?php
							/*if( isset($adv["5"]) ){*/
						?>
							<!--<div class="content_blockAdv height_adjust"><?php /*if(isset($adv["5"])){echo $adv["5"];}*/?></div>-->
						<?php
							/*}else{ echo ''; }*/
						?>
					</div>
					<div id="slidebar_adv" class="hidden-mobile hidden-tablet">
						<?php
							if( isset($adv["13"]) ){
						?>
							<div class="content_blockAdv"><?php if(isset($adv["13"])){echo $adv["13"];}?></div>
						<?php
							}else{ echo ''; }
						?>

						<?php
							/*if( isset($adv["5"]) ){*/
						?>
							<!--<div class="content_blockAdv height_adjust"><?php /*if(isset($adv["5"])){echo $adv["5"];}*/?></div>-->
						<?php
							/*}else{ echo ''; }*/
						?>
					</div>
				</aside>
				<!-- Sidebar End -->

				<ul class="advertisement hidden-mobile" <?php if(isset($adv["14"]) || isset($adv["15"])){ echo ''; }else{ echo 'style="display: none;"'; } ?> ><!--廣告1.2-->
					<li><?php if(isset($adv["14"])){echo $adv["14"];}?></li>
					<li><?php if(isset($adv["15"])){echo $adv["15"];}?></li>
				</ul>
				<!--<div class="fbslide hidden-mobile" id="fbslide">
					<div class="closebtn"></div>
					<p class="title">歡迎加入我們，<br />一同探索簡單有趣的生活品味：）</p>
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%;" allowTransparency="true"></iframe>
				</div>-->
				<!-- <div class="mobile_advertisement visible-mobile">
					<?php
					  //echo $rowsp_adv["adv_link"];
					?>
				</div> -->
				<!--<div class="mobileADV visible-mobile mb_15">
					<?php /*if(isset($adv["19"])){echo $adv["19"];}*/?>
				</div>-->
				<div class="mobile_advertisement visible-mobile">
					<div name="sfysmad" data="1CM_home_300x780_RT_mo" count="3" ></div>
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
			<nav id="page-nav">
				<a href="..."></a>
			</nav>
			<!--<div class="hidden-mobile">
				<div kid="212" hkdata="1CM_all_1103x40_marquee1" hkcount="30"></div>
			</div>-->
		</section>

		<footer id="footer">
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
		/*$(".popupBox-close").hide();
		$("#popupBox").hide();
		popupDiv("popupBox");*/
    });
    </script>
</body>
</html>