<?php
include_once("_config.php");
include_once($inc_path."_getpage.php");

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
			ORDER BY RAND()
			Limit 0,1";

$rowsp_adv = $db -> query_first($sql_adv);


//大banner
$sql_banner = "SELECT * 
		       FROM $table_banner_b
			   WHERE $isshow_banner_b=1
			   ORDER BY $ind_banner DESC";
$rows_banner = $db -> fetch_all_array($sql_banner);


//右方新聞
$sql_rnews = "SELECT * 
		      FROM $table_news
			  WHERE $isshow_news=1 AND $isrightshow_news=1 AND $news_upday<=NOW()
			  ORDER BY RAND() LIMIT 8";

$rows_rnews = $db -> fetch_all_array($sql_rnews);


//搜尋
$sql_str = "";
if($keyword != ""){
	$sql_str .= "AND (news_title LIKE '%$keyword%' OR news_content LIKE '%$keyword%')";
}

//新聞列表
$sql = "SELECT * 
		FROM $table_news n,$table_newstype nt ,$table_admin a
	    WHERE n.newsType_id=nt.newsType_id AND a.admin_id=n.news_aut_id AND n.$news_upday<=NOW() AND n.$isshow_news = 1 $sql_str
		ORDER BY $news_upday DESC";

getSql($sql, 10, $query_str);
$rows_news = $db -> fetch_all_array($sql);

//讀者熱選
$sql = "SELECT * 
		FROM $table_news
	    WHERE $isshow_news=1 AND TO_DAYS(NOW()) - TO_DAYS(news_upday) <= 60 AND news_upday<=NOW()
	    ORDER BY RAND() LIMIT 3";
$rows_likenews = $db -> fetch_all_array($sql);


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
	<script src="scripts/jquery.timeout.interval.idle.js"></script>
	<script src="scripts/jquery.cookie.js"></script>
	<script src="scripts/bootstrap.js"></script>
	<script src="scripts/idle.js"></script>
	<script src="scripts/all.js"></script>
    <script src="scripts/search.js"></script>
    <script src="scripts/fancybox/jquery.fancybox.js"></script>
    <script>
    	/*$(function(){
    		$('.fancybox').fancybox({
    			"width": "750",
    			"height": "730",
    			"openEffect": "elastic",
    			"closeEffect": "elastic",
    		});
    	});*/
    </script>
	<script defer>
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
	<script type="text/javascript" defer>
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

	<script defer>
		googletag = window.googletag || {cmd:[]};
		googletag.cmd.push(function() {
			var mapping = googletag.sizeMapping().addSize([0, 0], [300, 250]).addSize([400, 0], [160, 600]).build();
			googletag.defineSlot('/7682122/1CM_all_160x600_RT', [[160, 600], [300, 250]], 'div-gpt-ad-1411546601925-0').defineSizeMapping(mapping).addService(googletag.pubads());
    	    googletag.enableServices();
		});
	</script>
	<script type="text/javascript" src="/ysm/1cm/sf_ysm.js" id="sf_script" slot="1cm_home" defer></script>
	<script type="text/javascript" src="/ysm/1cm/sf_ysm_hk.js" id="sf_hk_script" defer></script>
</head>
<body>
	<!-- scrollTop Start -->
	<div id="slidebar_goTop" class="bottom_scrollTop hidden-mobile">
		<a href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image1','','images/scroll_topover.png'),'1'"><img src="images/scroll_top.png" width="80" height="80" alt="" id="scrollTop" name="image1"></a>
	</div>
	<!-- scrollTop End -->
	<div id="mask" class="mask"></div>
	<div id="fb-root"></div>
	<script defer>(function(d, s, id) {
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
		<div id="popupBox" class="hidden-tablet">
			<div class="popupBox-close">
				<img src="images/mask_closebtn.png" onclick="hideDiv('popupBox');">
			</div>
			<?php if(isset($adv["18"])){echo $adv["18"];}?>
		</div>
		<header id="header">
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
				<span class="hidden-tablet"><a href="https://www.facebook.com/pages/1cm/761735067202346" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagefb','','images/icon_fbover.png')"><img src="images/icon_fb.png" alt="" name="imagefb"></a></span>
				<span class="hidden-tablet"><a href="http://instagram.com/1cm.life" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imageinsta','','images/icon_instaover.png')"><img src="images/icon_insta.png" alt="" name="imageinsta"></a></span>
				<span class="hidden-tablet"><a href="contact.php" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagecontact','','images/icon_mailover.png')"><img src="images/icon_mail.png" alt="" name="imagecontact"></a></span>
			</div>
			<div class="mobile-switch visible-mobile"></div>
			<div class="mobile-fb visible-mobile"><a href="https://www.facebook.com/pages/1cm/761735067202346" target="_blank"><img src="images/icon_fb.png" alt=""></a></div>
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
					<iframe class="visible-tablet" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>

					<iframe class="top-right-fb-like-button fb_iframe_widget hidden-tablet" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;locale=en_US&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
				</div>
			</div>
			<div class="banner" <?php echo $keyword != "" ? 'style="display: none;"' : ""; ?> >
				<div class="fblike hidden-mobile hidden-tablet">
					<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=40&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:65px;" allowTransparency="true"></iframe>
					<div class="fb-share-button" data-href="https://www.facebook.com/pages/1cm/761735067202346" data-width="40" data-type="box_count"></div>
				</div>
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  	<ol class="carousel-indicators hidden-mobile hidden-tablet">
                        <?php
						   $i=0;
						   foreach($rows_banner as $row_banner){
						?>
					    <li data-target="#carousel-example-generic" <?php if($i==0){echo'class="active"';}?> data-slide-to="<?php echo"$i";$i++;?>"></li>
                        <?php
						   }
						   unset($i);
						?>
				  	</ol>
				  	<div class="carousel-inner">

                    <?php
					 $i=true;
					 foreach($rows_banner as $row_banner){
					?>
					    <div class="item <?php if($i){$i=0;echo "active";}?>"><!--active-->
						    <?php  if($row_banner["banner_b_href"]!=""){echo '<a href="'.$row_banner["banner_b_href"],'"';if($row_banner["banner_hreftarget"]==1){echo 'target="_blank"';} echo '>';}?><img src="<?php echo $web_path_banner_b.$row_banner["banner_b_pic"];?>" alt=""><?php  if($row_banner["banner_b_href"]!=""){echo '</a>';}?>
					    </div>
                    <?php
					 }
					?>
				  	</div>
				  	<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('bnPrev','','images/banner_prevover.png')">
				    	<img src="images/banner_prev.png" alt="" name="bnPrev">
				  	</a>
				  	<a class="right carousel-control" href="#carousel-example-generic" data-slide="next" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('bnNext','','images/banner_nextover.png')">
				    	<img src="images/banner_next.png" alt="" name="bnNext">
				  	</a>
				</div>
			</div>
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
							<div class="titleR"><a href="news.php?ntid=<?php echo $row_news["newsType_id"];?>"><?php echo substr($row_news["newsType_Ename"],0,1);?></a></div>
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
                                <div class="fb-share-button" data-href="http://1cm.life/news_detail.php?nid=<?php echo $row_news["news_id"]; ?>" data-layout="button"></div>
								<div class="fb-like" data-href="http://1cm.life/news_detail.php?nid=<?php echo $row_news["news_id"]; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
							</div>
						</div>
						<div class="thumbimg"><a href="news_detail.php?nid=<?php echo $row_news["news_id"];?>" class="btn"><img src="<?php if($row_news["news_banner"]!=""){echo $web_path_news,"m",$row_news["news_banner"];}?>" height="284" alt="" onerror="javascript:this.src='images/nopic.png'"></a></div>
						<div class="description">
							<?php echo tc_left(strip_tags($row_news["news_content"]),85)?>
							<a href="news_detail.php?nid=<?php echo $row_news["news_id"];?>" class="btn" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image0<?php echo $row_news["news_id"]; ?>','','images/content_btnover.png')"><img src="images/content_btn.png" name="image0<?php echo $row_news["news_id"]; ?>" alt=""></a>
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
					<?php
					if(count($rows_news)=="0"){
					?>
                    <div class="sorry_error">抱歉，我們沒有找到任何相關資訊</div>
                    <?php 
				    }else{
					?>
					<!-- 分頁 Start -->
					<!--
					<div class="pagination_outer">
						<div>
							<ul class="pagination">
							    <?php /*showPage_front();*/ ?>
							</ul>
						</div>
					</div>
					-->
					<!-- 分頁 End -->
                    <?php
					}
					?>

					<!-- 內文 End -->			

				</div>

				<!-- Sidebar Start -->
				<aside class="content_sectionR hidden-mobile" id="sidebar">
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
							<div class="fb-like-box" data-href="https://www.facebook.com/1cmLife" data-width="300" data-height="600" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="true" data-show-border="true"></div>

						</div>
					</div>
					<div class="visible-tablet">
						<?php
							if( !isset($adv["4"]) ){
						?>
							<div class="content_blockAdv"><?php if(isset($adv["4"])){echo $adv["4"];}?></div>
						<?php
							}else{ echo ''; }
						?>

						<?php
							if( isset($adv["5"]) ){
						?>
							<div class="content_blockAdv height_adjust"><?php if(isset($adv["5"])){echo $adv["5"];}?></div>
						<?php 
							}else{ echo ''; }
						?>
					</div>
					<div id="slidebar_adv" class="hidden-mobile">
						<?php
							if( isset($adv["13"]) ){
						?>
							<div class="content_blockAdv"><?php if(isset($adv["13"])){echo $adv["13"];}?></div>
						<?php
							}else{ echo ''; }
						?>

						<?php
							if( isset($adv["5"]) ){
						?>
							<div class="content_blockAdv height_adjust"><?php if(isset($adv["5"])){echo $adv["5"];}?></div>
						<?php
							}else{ echo ''; }
						?>
					</div>
				</aside>
				<!-- Sidebar End -->

				<ul class="advertisement hidden-mobile" <?php if(isset($adv["14"]) && isset($adv["15"])){ echo ''; }else{ echo 'style="display: none;"'; } ?> >
					<li><?php if(isset($adv["14"])){echo $adv["14"];}?></li>
					<li><?php if(isset($adv["15"])){echo $adv["15"];}?></li>
				</ul>
				<div class="like_section hidden-mobile">
                    <?php
					if($rows_likenews!=false){
					echo '<p style="margin-top: 0px;"><img src="images/like_block_titleChoice.png" width="100%" alt=""></p>';
					}
					?>
                    <?php
					$i=1;
					foreach($rows_likenews as $row_likenews){
					?>
					<div class="like_block <?php if($i==3){echo "border_rightNone";}?>">
                        <a href="news_detail.php?nid=<?php echo $row_likenews["news_id"];?>">
						<p class="like_blockimg">
                          <img src="<?php echo $web_path_news,"sl",$row_likenews["news_banner"];?>" alt=""></p>
						</a>
                        <p class="like_blockdescription"><a href="news_detail.php?nid=<?php echo $row_likenews["news_id"];?>"><?php echo tc_left($row_likenews["news_title"],25);?></a></p>
					</div>
                    <?php
					$i++;
					}
					unset($i);
					?>
                    <div name="sfysmad" data="1CM_home_725x305_B_pc" count="3" ></div>
                    
				</div>
				<div class="like_section visible-mobile">
					<?php
					if($rows_likenews!=false){
						echo '<p style="margin: 0 0 17px 0;"><img src="images/like_block_titleChoice.png" width="100%" alt=""></p>';
					}
					?>
                    <?php
					$i=1;
					foreach($rows_likenews as $row_likenews){
					?>
					<div class="like_block <?php if($i==2){echo "border_rightNone";}?>">
                        <a href="news_detail.php?nid=<?php echo $row_likenews["news_id"];?>">
						<p class="like_blockimg">
                          <img src="<?php echo $web_path_news,"sl",$row_likenews["news_banner"];?>" alt=""></p>
						</a>
                        <p class="like_blockdescription"><a href="news_detail.php?nid=<?php echo $row_likenews["news_id"];?>"><?php echo $row_likenews["news_title"];?></a></p>
					</div>
                    <?php
					$i++;
					if($i==3){break;}
					}
					unset($i);
					?>
					<div name="sfysmad" data="1CM_home_725x305_B_mo" count="2" ></div>
				</div>
				<!--<div class="fbslide hidden-mobile" id="fbslide">
					<div class="closebtn"></div>
					<p class="title">歡迎加入我們，<br />一同探索簡單有趣的生活品味：）</p>
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%;" allowTransparency="true"></iframe>
				</div>-->
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
		
    });
    </script>
</body>
</html>