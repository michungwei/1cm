<?php
include_once("_config.php");
include_once($inc_path."_getpage.php");

/*$nid=get("nid");*/
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

//右方新聞
$sql_rnews = "SELECT * 
		      FROM $table_news
			  WHERE $isshow_news=1 AND $isrightshow_news=1 AND $news_upday<=NOW()
			  ORDER BY RAND() LIMIT 8";
$rows_rnews = $db -> fetch_all_array($sql_rnews);



//新聞內容
$sql = "SELECT * 
		FROM $table_news n,$table_newstype nt,$table_admin a
		WHERE n.newsType_id=nt.newsType_id AND a.admin_id=n.news_aut_id AND n.$isshow_news=1 AND n.news_id='$nid' AND n.$news_upday<=NOW()";
$row_news = $db -> query_first($sql);


//點擊次數紀錄
//if($row_news!=false&&!isset($SESSION["news$nid"])){
  //$_SESSION["news$nid"] = 1;防止灌水
  $sql_clicknum = "SELECT news_clicknum FROM $table_news WHERE news_id = '$nid'";
  $row_news_clicknum = $db -> query_first($sql_clicknum);
  
  
  
  $thisid=$row_news["news_id"];
  $data["news_clicknum"] = $row_news_clicknum["news_clicknum"]+1;
  $db -> query_update($table_news, $data, "$N_id = $thisid");
//}


//下一筆next
$sql = "SELECT news_id 
		FROM $table_news
		WHERE $isshow_news=1 AND $news_upday<=NOW() AND $news_upday<(SELECT $news_upday FROM $table_news WHERE news_id='$nid') AND $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid')
		ORDER BY $news_upday DESC
		limit 1";
$row_nextnews = $db -> query_first($sql);



//上一筆pre
$sql = "SELECT news_id 
		FROM $table_news
		WHERE $isshow_news=1 AND $news_upday<=NOW() AND $news_upday>(SELECT $news_upday FROM $table_news WHERE news_id='$nid') AND $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid')
		ORDER BY $news_upday ASC
		limit 1";
$row_prenews = $db -> query_first($sql);

//推薦閱讀
$sql = "SELECT * 
		FROM $table_news
	    WHERE $isshow_news=1 AND   TO_DAYS(NOW()) - TO_DAYS(news_upday) <= 60 AND  news_upday<=NOW() AND $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid') AND $N_id<>'$nid'
	    ORDER BY RAND() LIMIT 8";
$rows_likenews = $db -> fetch_all_array($sql);

//翻頁圖片
$sql = "SELECT * 
		FROM $table_news_pic 
		WHERE news_pic_isshow = 1 AND news_id = $nid 
		ORDER BY news_pic_ind DESC";
$rows_pic = $db -> fetch_all_array($sql);

$db -> close();
?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="copyright" content="<?php echo $copyright; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:title" content="<?php echo $row_news["news_title"];?> - 1CM 質感生活誌" ></meta>
	<meta property="og:type" content="article" ></meta>
	<meta property="og:description" content="<?php echo strip_tags(trim($row_news["news_content"])); ?>" ></meta>
	<title><?php echo $web_name; ?></title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css?ver=150412">
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
		function share2FB(){
		 	window.open("http://www.facebook.com/sharer/sharer.php?u=<?php echo $web_url."news_detail.php?nid=".$nid; ?>",'','width=653,height=369');
		}
	</script>
	<script>
		$(function(){
			$('#content_').infinitescroll({
				navSelector 	:	'#page-nav',
				nextSelector	:	'#page-nav a',
				itemSelector	:	'.content_sectionL',
				animate      	:   true,
				path: function(index) {
					return "index_forIS.php?startId="+<?php echo $nid ?>+"&page=" + (index-1);
				},
				
				loading: {
					msgText : 'Loading...',    //加载时的提示语
					finishedMsg: '您已經閱讀完全部了喔！',
					finished: function() {
						var el = document.body; 
						$('#infscr-loading').hide();
						$('#page-nav').show();
						if (typeof FB !== "undefined") { FB.XFBML.parse(el); }
					}
				}

			});

			$(window).unbind('.infscr');
			$('#page-nav').click(function() {
				console.log("[desktop]page-nav clicked!!!");
				$('#content_').infinitescroll('retrieve');
				return false;
			});
			$(document).ajaxError(function(e,xhr,opt) {
				if(xhr.status==404)
				  $('#page-nav').remove();
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
	<script type="text/javascript" src="ysm/1cm/sf_ysm.js" id="sf_script" slot="1cm_home"></script>
	<script type="text/javascript" src="ysm/1cm/sf_ysm_hk.js" id="sf_hk_script"></script>
	<script>
		googletag = window.googletag || {cmd:[]};
		googletag.cmd.push(function() {
			var mapping = googletag.sizeMapping().addSize([0, 0], [300, 250]).addSize([400, 0], [160, 600]).build();
			googletag.defineSlot('/7682122/1CM_all_160x600_RT', [[160, 600], [300, 250]], 'div-gpt-ad-1411546601925-0').defineSizeMapping(mapping).addService(googletag.pubads());
    	    googletag.enableServices();
		});
	</script>
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
		<!--<div id="popupBox_Article" class="hidden-mobile">
			<div class="close">
				<img src="images/mask_closebtn.png" onclick="hideFB('popupBox_Article');">
			</div>
			<div class="title">
				<h1>喜歡這篇文章嗎?</h1>
				加入我們接收更多資訊內容！<br>
				『每天的靈感補給，儘在 1CM Life！』
			</div>
			<div class="fb-block">
				<div class="fb-like-box" data-href="https://www.facebook.com/1cmLife" data-width="300px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
				<div class="fb-like mb_5"  data-href= "https://www.facebook.com/1cmLife" data-layout= "box_count" data-action="like" data-show-faces="false" data-share="false"></div>
			</div>
		</div>-->
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
					<!-- <div class="fb-like top-right-fb-like-button fb_iframe_widget hidden-tablet" data-href="https://www.facebook.com/pages/1cm%E7%94%9F%E6%B4%BB%E5%93%81%E5%91%B3%E6%8E%A2%E7%B4%A2/761735067202346" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>-->
					<iframe class="top-right-fb-like-button fb_iframe_widget hidden-tablet" src="//www.facebook.com/plugins/like.php?href=<?php echo $web_fb_url;?>&amp;locale=en_US&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
				</div>
			</div>
			<?php
				/*echo("<script>console.log('PHP: table_name = ".$table_news_pic."');</script>");
				echo("<script>console.log('PHP: nid = ".$nid."');</script>");*/
				echo("<script>console.log('PHP: news_slidershow = ".$row_news["news_slidershow"]."');</script>");
				if(!empty($rows_pic) && $row_news["news_slidershow"]){
			?>
			<div id="carousel-example-generic" class="mb_30 carousel slide hidden-xs" data-ride="carousel">
				<ol class="carousel-indicators hidden-mobile hidden-tablet" style="background-color: rgba(248, 248, 248, 0);">
					<?php
					   $i=0;
					   foreach($rows_pic as $row_pic){
					?>
					<li data-target="#carousel-example-generic" <?php if($i==0){echo'class="active"';}?> data-slide-to="<?php echo "$i";$i++;?>"></li>
					<?php
					   }
					   unset($i);
					?>
				</ol>
				<div class="carousel-inner">
					<?php
						$i = 0;
						foreach($rows_pic as $row_pic){
					?>
				    <div class="item <?php echo $i == 0 ? 'active' : ""; ?>">
				      	<img src="<?php echo $web_path_news_pic.'pic'.$row_pic["news_pic_name"]; ?>" alt="">
				    </div>
				    <?php
				    	$i++;
				    	}
				    	unset($i);
				    ?>
				</div>
				<a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('prevBtn','','images/pic_prev.png')" class="left left_icon carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				    <img name="prevBtn" src="images/pic_prev_over.png" alt="">
				</a>
				<a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('nextBtn','','images/pic_next.png')" class="right right_icon carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				    <img name="nextBtn" src="images/pic_next_over.png" alt="">
				</a>
			</div>
			<?php
				//$i++;
				}
				//unset($i);
				?>
            <?php
			if($row_news["news_showType"]==1){
			?>
			<div class="banner">
				<div class="fblike hidden-mobile hidden-tablet">
					<div class="fb-like mb_5"  data-href="http://1cm.life/news_detail.php?nid=<?php echo $nid; ?>" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>
					<div class="fb-share-button" data-href="http://1cm.life/news_detail.php?nid=<?php echo $nid; ?>" data-width="40" data-type="box_count"></div>
				</div>
                <?php
					echo '<img src="'.$web_path_news.'banner'.$row_news["news_banner"].'" alt="">';
				?>
			</div>
            <?php } else{ ?>
            	<div class="fblike hidden-mobile hidden-tablet">
					<div class="fb-like mb_5"  data-href= "<?php echo $web_fb_url;?>" data-layout= "box_count" data-action="like" data-show-faces="false" data-share="false"></div>
					<div class="fb-share-button" data-href="http://1cm.life/news_detail.php?nid=<?php echo $nid; ?>" data-width="40" data-type="box_count"></div>
				</div>
            <?php } ?>
			<div id="content_" class="content_section">
				<div class="content_sectionL content_sectionL_in" id="content_sectionL">

					<!-- 內文 Start -->
					<div class="content_block news_detail_block">
                        <?php
						if(!isset($row_news)||$row_news=="" ){
						?>	
                         <div class="delete_block">
						 <p class="icon"><img src="images/deleteimg.png" alt=""></p>
						 <p class="btn_home"><a href="index.php"><img src="images/btn_home.png" alt=""></a></p>
					     </div>
						<?php	
						}else{
                        ?>
						<div class="title">
							<div class="titleL"><h3><?php echo $row_news["news_title"];?><!--亞馬遜3D手機Fire Phone 7月開賣--></h3></div>
							<div class="titleR"><a href="news.php?ntid=<?php echo $row_news["newsType_id"]; ?>"><?php echo substr($row_news["newsType_Ename"],0,1);?></a><!--H--></div>
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
                              <!--06.20.2014 / Tuesday-->
                            </span>
							<div>
								<!--<div class="fb-share-button" data-href="https://www.facebook.com/pages/1cm/761735067202346" data-width="57" data-type="button"></div>-->
                                <!-- <div><a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $web_url."news_detail.php?nid=".$nid;?>" target="_blank"><img src="images/icon_share.png"></a></div> -->
                                <div class="fb-share-button" data-href="http://1cm.life/news_detail.php?nid=<?php echo $nid; ?>" data-layout="button"></div>
								<div class="fb-like" data-href="http://1cm.life/news_detail.php?nid=<?php echo $nid; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
							</div>
						</div>
						<!--<div class="thumbimg"><img src="images/content_img.png" alt=""></div>-->
						<div class="description">
							<?php if($row_news["video_url"]!=""){echo $row_news["video_url"];}?>
                            <?php echo $row_news["news_content"];?>
							<div class="hidden-mobile">
								<?php if(isset($adv["16"])){echo $adv["16"];}?>
							</div>
						</div>
                        
                        <?php
						}
						?>
						<div class="fb_line">
							<nobr>
								<font color="#4169e1">Facebook</font>
								<div class="fb-like mb_5" data-href="<?php echo $web_fb_url;?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>	
							</nobr>
							歡迎加入我們，一同探索簡單有趣的生活品味：）
						</div>
						<div class="mobileADV visible-mobile mb_15">
							<?php if(isset($adv["19"])){echo $adv["19"];}?>
						</div>
					</div>
					<div class="fb_block">
						<div class="fbshare_btn">
							<!-- <a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $web_url."news_detail.php?nid=".$nid;?>" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image3','','images/fbshare_btnover.png')"><img src="images/fbshare_btn.png" alt="" name="image3"></a> -->
							<a onclick="share2FB()" href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image3','','images/fbshare_btnover.png')"><img src="images/fbshare_btn.png" alt="" name="image3"></a>
						</div>
						<!--<div class="fbshare_btn"><a href="#"><img src="images/fbshare_btn.png" alt=""></a></div>-->
						<div class="fbjoin_btn">
							<a href="<?php echo $web_fb_url;?>" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image4','','images/fbjoin_btnover.png')"><img src="images/fbjoin_btn.png" alt="" name="image4"></a>
						</div>
					</div>
					<div class="mt_15" name="sfysmad" data="1CM_article_720x90(320x120)_end" count="1" ></div>
					<div class="mobileADV visible-mobile mb_15">
						<?php if(isset($adv["19"])){echo $adv["19"];}?>
					</div>
					<div class="page_btn">
						<span class="prev"><?php if($row_prenews["news_id"]!=""){echo '<a href="news_detail.php?nid='.$row_prenews["news_id"].'" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('."'imgPrev'".','."''".','."'images/btn_prevover.png'".')">';}?><img src="images/btn_prev.png" alt="" name="imgPrev"><?php if($row_prenews["news_id"]!=""){echo "</a>";}?></span>
						<span class="next"><?php if($row_nextnews["news_id"]!=""){echo '<a href="news_detail.php?nid='.$row_nextnews["news_id"].'" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('."'imgNext'".','."''".','."'images/btn_nextover.png'".')">';}?><img src="images/btn_next.png" alt="" name="imgNext"><?php if($row_nextnews["news_id"]!=""){echo "</a>";}?></span>
					</div>
					<ul class="advertisement_detail hidden-mobile" <?php if(isset($adv["14"]) && isset($adv["15"])){ echo ''; }else{ echo 'style="display: none;"'; } ?> >
						<li><?php if(isset($adv["14"])){echo $adv["14"];}?></li>
						<li><?php if(isset($adv["15"])){echo $adv["15"];}?></li>
					</ul>
					<div class="fb-comments" data-href="http://1cm.life/news_detail.php?nid=<?php echo $row_news["news_id"];?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
					<!-- 內文 End -->
					<div class="like_section_detail recommendRead_section">
						<?php
						if($rows_likenews!=false){
						echo '<p style="margin: 0 0 17px 0;"><img src="images/like_block_titleRecommend.png" width="100%" alt=""></p>';
						}
						?>
						<div class="recommendRead_block_ysm">
							<div name="sfysmad" data="1CM_article_338x260(320x300)_readL" count="2" ></div>
						</div>
						<?php
						//$i=1;
						foreach($rows_likenews as $row_likenews){
						?>
						<!-- <div class="like_block <?php if($i==3){echo "border_rightNone";}?>">
							<a href="news_detail.php?nid=<?php echo $row_likenews["news_id"];?>">
							<p class="like_blockimg">
							  <img src="<?php echo $web_path_news,"sl",$row_likenews["news_banner"];?>" alt=""></p>
							</a>
							<p class="like_blockdescription"><a href="news_detail.php?nid=<?php echo $row_likenews["news_id"];?>"><?php echo tc_left($row_likenews["news_title"],30);?></a></p>
						</div> -->
						<div class="recommendRead_block">
							<div class="recommendRead_img">
								<a href="news_detail.php?nid=<?php echo $row_likenews["news_id"];?>">
									<img src="<?php echo $web_path_news,"sl",$row_likenews["news_banner"];?>" alt="">
								</a>
							</div>
							<div class="recommendRead_description">
								<a href="news_detail.php?nid=<?php echo $row_likenews["news_id"];?>">
									<?php echo tc_left($row_likenews["news_title"],30); ?>
								</a>
							</div>
						</div>
						<?php
						//$i++;
						}
						//unset($i);
						?>
					</div>
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
							<div class="fb-like-box" data-href="<?php echo $web_fb_url;?>" data-width="300" data-height="600" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="true" data-show-border="true"></div>
						</div>
					</div>
					<div class="visible-tablet">
						<?php
							if( !isset($adv["13"]) ){
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

				<!--<div class="fbslide hidden-mobile" id="fbslide">
					<div class="closebtn"></div>
					<p class="title">歡迎加入我們，<br />一同探索簡單有趣的生活品味：）</p>
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%;" allowTransparency="true"></iframe>
				</div>-->
				<!--<div class="mobileADV visible-mobile mb_15">
					<?php /*if(isset($adv["19"])){echo $adv["19"];}*/?>
				</div>-->
				<div class="mobile_advertisement visible-mobile">
					<div name="sfysmad" data="1CM_article_300x780_RT_mo" count="3" ></div>
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
				<div class="mobileADV visible-mobile mb_15">
					<?php if(isset($adv["19"])){echo $adv["19"];}?>
				</div>
			</div>
			<div class="clear"></div>
			<!--<div class="hidden-mobile">
				<div kid="212" hkdata="1CM_all_1103x40_marquee1" hkcount="30"></div>
			</div>-->
		</section>

		<footer id="footer">
			<div id="page-nav" align="center">
				<a href="index.php">獲得更多生活靈感</a>
			</div>
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
	<!--<nav id="page-nav">
				<a href="index.php?page=2"></a>
			</nav>-->
<!-- lazyload -->
    <script type="text/javascript" src="ui/lazyload-master/jquery.lazyload.js"></script>
    <script>
	$(document).ready(function(e) {
        /*$(".description img").lazyload({
            effect : "fadeIn",
			placeholder: "http://1.bp.blogspot.com/-Qt2R-bwAb4M/T8WKoNKBHRI/AAAAAAAACnA/BomA-Whl_Bk/s1600/grey.gif"
        });*/
		$(".popupBox-close").hide();
		$("#popupBox").hide();
		$("#popupBox_Article").hide();
		popupDiv("popupBox");
		
		/*$('#carousel-example-generic').hover(function () { 
		  $(this).carousel('pause');
		});*/
    });
	/*$(window).load(function() {

		var $win = $(window).scroll(function() {
			//console.log($win.scrollTop());
			if($win.scrollTop() > jQuery(document).height() - 1800)
			{
				popupFB("popupBox_Article");
			}
		});
	});
	function popupFB(div_id)
	{
		var date = new Date();
		
		if( !$.cookie('1cm_art') && jQuery(window).width() > 767)
		{
			date.setTime( date.getTime() + (24 * 60 * 60 * 1000) );
			
			console.log(date);
		
			$.cookie( '1cm_art', 'yes', { expires : date } );
			var div_obj = $("#"+ div_id);
			$("#mask").show();
			$(div_obj).fadeIn();
		}
	}
	function hideFB(div_id)
	{
		$(".popupBox-close").hide();
		$("#mask").hide();
		$("#" + div_id).fadeOut();
	}*/
    </script>
</body>
</html>