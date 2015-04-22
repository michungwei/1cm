<?php
include_once("_config.php");
include_once($inc_path."_getpage.php");

$nid=get("nid");
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
$sql = "SELECT * 
		FROM $table_news
		WHERE $isshow_news=1 AND $news_upday<=NOW() AND $news_upday<(SELECT $news_upday FROM $table_news WHERE news_id='$nid') AND $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid')
		ORDER BY $news_upday DESC
		limit 1";
$row_nextnews = $db -> query_first($sql);



//上一筆pre
$sql = "SELECT * 
		FROM $table_news
		WHERE $isshow_news=1 AND $news_upday<=NOW() AND $news_upday>(SELECT $news_upday FROM $table_news WHERE news_id='$nid') AND $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid')
		ORDER BY $news_upday ASC
		limit 1";
$row_prenews = $db -> query_first($sql);

//推薦閱讀
$sql = "SELECT * 
		FROM $table_news
	    WHERE $isshow_news=1 AND   TO_DAYS(NOW()) - TO_DAYS(news_upday) <= 60 AND  news_upday<=NOW() AND $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid') AND $N_id<>'$nid'
	    ORDER BY RAND() LIMIT 6";
$rows_likenews = $db -> fetch_all_array($sql);

//翻頁圖片
$sql = "SELECT * 
		FROM $table_news_pic 
		WHERE news_pic_isshow = 1 AND news_id = $nid 
		ORDER BY news_pic_ind DESC";
$rows_pic = $db -> fetch_all_array($sql);

//人氣排行
$sql = "SELECT * 
		FROM $table_news n
	    WHERE $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid') AND $N_id<>'$nid' AND n.$isshow_news=1 AND n.news_upday<=NOW()
	    ORDER BY n.news_clicknum DESC LIMIT 10";
$rows_hotnews = $db -> fetch_all_array($sql);
$ntid = $rows_hotnews[0]["newsType_id"];
//新聞列表
$sql = "SELECT * 
		FROM $table_news n,$table_newstype nt ,$table_admin a
	    WHERE n.newsType_id=nt.newsType_id AND a.admin_id=n.news_aut_id AND n.$news_upday<=NOW() AND n.$isshow_news = 1 AND n.newsType_id='$ntid'
		ORDER BY $news_upday DESC";

getSql($sql, 17, $query_str);
$rows_news = $db -> fetch_all_array($sql);

$db -> close();

$href = "";

$content_first_img_url = $web_url.substr($row_news["news_content"], strpos($row_news["news_content"], "upload/"), 39 );
 //$content_first_img_url = $('.description img').attr('src', $('img:first').attr('src'));
 echo "<script>console.log( 'Debug Objects: " . $content_first_img_url . "' );</script>";
?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<meta name="description" content="<?php echo $description; ?>" />
	<meta name="copyright" content="<?php echo $copyright; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:title" content="<?php echo $row_news["news_title"];?> - <?php echo $web_name; ?>" ></meta>
	<meta property="og:type" content="article" ></meta>
	<meta property="og:description" content="<?php echo strip_tags(trim($row_news["news_content"])); ?>" ></meta>
	<meta property="og:image" content="<?php echo $content_first_img_url; ?>" ></meta>
	<title><?php echo $web_name; ?></title>
	<link href="css/all.css?ver=150401" rel="stylesheet" type="text/css">
	<link href="css/mstyle.css" rel="stylesheet" type="text/css">
	<link href="css/jquery.jscrollpane.css" type="text/css"  rel="stylesheet" media="all" />
	<link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="icon" href="<?php echo $web_icon?>" type="image/png" />
	<link rel="stylesheet" href="scripts/fancybox/jquery.fancybox.css"/>
	<link type="text/css" rel="stylesheet" href="css/jquery.mmenu.all.css" />
	<script src="scripts/jquery-1.9.1.js"></script>
	<script src="scripts/jquery.infinitescroll.min.js"></script>
	<script src="scripts/jquery.timeout.interval.idle.js"></script>
	<script src="scripts/jquery.cookie.js"></script>
	<script src="scripts/bootstrap.js"></script>
	<script src="scripts/idle.js"></script>
	<script src="scripts/all.js"></script>
    <script src="scripts/search.js"></script>
	<script src="scripts/fancybox/jquery.fancybox.js"></script>
	<script type="text/javascript" src="scripts/jquery.mmenu.min.all.js"></script>
    <script>
		function share2FB(){
		 	window.open("http://www.facebook.com/sharer/sharer.php?u=<?php echo $web_url.$href."news_detail.php?nid=".$nid; ?>",'','width=653,height=369');
		}
	</script>
	<!-- the mousewheel plugin -->
	<script type="text/javascript" src="scripts/jquery.mousewheel.js"></script>
	<!-- the jScrollPane script -->
	<script type="text/javascript" src="scripts/jquery.jscrollpane.min.js"></script>
	<!-- scripts specific to this demo site -->
	<script type="text/javascript" id="sourcecode">
		$(function()
		{
			$('.scroll-pane').jScrollPane();
		});
	</script>
	<script>
		$(function(){
				$('.infinite_container').infinitescroll({
					navSelector 	:	'#page-nav',
					nextSelector	:	'#page-nav a',
					itemSelector	:	'.infinte_list',
					animate      	:   true,
					debug 			:   true,
					maxPage			:	<?php echo $page_count; ?>,
					path: function(index) {
						console.log("mother fucker!!!");
						return "<?php echo $href; ?>news_detail.php?nid=<?php echo $nid; ?>&page=" + index;
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
	<script type="text/javascript" src="//media.line.me/js/line-button.js?v=20140411" ></script>
	<?php include_once("analytics.php"); ?>
</head>
<body>
	<!-- scrollTop Start -->
	<!--<div id="slidebar_goTop" class="bottom_scrollTop hidden-mobile">
		<a href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image1','','images/scroll_topover.png'),'1'"><img src="images/scroll_top.png" width="80" height="80" alt="" id="scrollTop" name="image1"></a>
	</div>-->
	<!-- scrollTop End -->
	<div id="wrapper">
	<div id="mask" class="mask"></div>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
		<?php include_once("header.php"); ?>
		<!--===影音===-->
		<div class="topbox">
		  <!--mad-->
		  <div align="center">
			<?php if(isset($adv["19"])){echo $adv["19"];}?>
		  </div>
		  <div class="mad">
			<a href="#">
			  <img src="images/banner/622x98.gif" width="622" height="98" />
			</a>
		  </div>
			<?php
			if(!isset($row_news)||$row_news=="" ){
			?>	
			<?php	
			}else{
			?>
				<img src="<?php if($row_news["news_banner"]!=""){echo $web_path_news,$row_news["news_banner"];}?>" width="863" height="445" alt="" onerror="javascript:this.src='images/nopic.png'">
			<?php
			}
			?>
		</div>
		<!--line=-->
		<div class="line"></div>
		<!--ad-->
		<div class="ad72802 ad">
			<?php if(isset($adv["11"])){echo $adv["11"];}?>
		</div>
		<div id="content">
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
		  <div class="left_content">
			<!--article-->
			<div class="article">
			  <!--分享或讚-->
			  <div class="sharebox">
			  <div class="fb-like mb_5"  data-href= "<?php echo $web_fb_url;?>" data-layout= "box_count" data-action="like" data-show-faces="false" data-share="false"></div> 
			  <div class="fb-share-button" data-href="http://1cm.life/news_detail.php?nid=<?php echo $nid; ?>" data-width="40" data-type="box_count"></div>
			  </div>
			  <!--===我是標題===-->
			  <div class="n_title02"><?php echo $row_news["news_title"];?></div>
			  <!--===mobile webicon===-->
			  <div class="mobile_webicon">
				<ul>
				  <li>
					<a href="http://www.facebook.com/sharer/sharer.php?u=http://1cm.life/news_detail.php?nid=<?php echo $nid; ?>">
					  <span class="mic mfb02">fb</span>
					</a>
				  </li>
				  <li>
					<a href="http://line.me/R/msg/text/?<?php echo $row_news["news_title"];?> - 1CM 質感生活誌%0D%0Ahttp://1cm.life/news_detail.php?nid=<?php echo $nid; ?>">
					  <span class="mic mlineicon">line</span>
					</a>
				  </li>
				  <li>
					<a href="http://instagram.com/1cm.life">
					  <span class="mic mins">instagram</span>
					</a>
				  </li>
				  <!--<li>
					<a href="#">
					  <span class="mic memail">Email</span>
					</a>
				  </li>-->
				  <li>
					<div class="fb-share-button" data-href="http://1cm.life/news_detail.php?nid=<?php echo $nid; ?>" data-layout="button"></div>
				  </li>
				  <li>
					<div class="fb-like" data-href="http://1cm.life/news_detail.php?nid=<?php echo $nid; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
				  </li>
				</ul>
			  </div>
			  <div align="center">
				<?php if(isset($adv["19"])){echo $adv["19"];}?>
			  </div>
			  <div class="n_time">
				<span class="ic day"></span>
				<?php 
					echo "20";
					echo date("y/m/d",strtotime($row_news["news_createtime"]));
					echo "&nbsp;&nbsp;";
					echo $row_news["admin_cname"];
				?>
			  </div>
			  <!--===share===-->
			  <div class="share">
				<div class="ic sicon toggle">
				</div>
				<div class="sweb">
				  <ul>
					<li>
					  <a style="cursor:pointer;" onclick="window.open('http://www.facebook.com/sharer/sharer.php?u=http://1cm.life/news_detail.php?nid=<?php echo $nid; ?>','Facebook',
                   config='height=小視窗高度,width=小視窗寬度')"><span class="ic fb"></span>facebook</a>
					</li>
					<!--<li>
					  <a href="http://instagram.com/1cm.life"><span class="ic instagram"></span>instagram</a>
					</li>
					<li>
					  <a href="http://line.me/R/msg/text/?<?php echo $row_news["news_title"];?> - 1CM 質感生活誌%0D%0Ahttp://1cm.life/news_detail.php?nid=<?php echo $nid; ?>"><span class="ic lineicon"></span>line</a>
					</li>-->
					<!--<li>
					  <a href="#"><span class="ic email"></span>Email</a>
					</li>-->
				  </ul>
				</div>
			  </div>
			  <div class="clear_both"></div>
			  <!--===內容===-->
			  <div class="description">
				<?php 
					$row_news["news_content"] = str_replace('src="http://admin.1cm.life/', 'src="', $row_news["news_content"]);
					$row_news["news_content"] = str_replace('src="http://www.onecentimetre.com/', 'src="', $row_news["news_content"]);
					echo $row_news["news_content"];
				?>
			  </div>
			</div>
			<div class="artical02">
			  <!--ad-->
			  <ul class="artad">
				<li>
				  <?php if(isset($adv["18"])){echo $adv["18"];}?>
				</li>
				<li>
				  <?php if(isset($adv["18"])){echo $adv["18"];}?>
				</li>
			  </ul>
			  <div class="clear_both"></div>
			  <!--shareORlike-->
			  <ul class="artad">
				<li>
				  <a href="<?php echo $web_fb_url;?>">
					<span class="ic fb"></span><span class="ic likeit">likeit</span>
				  </a>
				</li>
				<li>
				  <a
				  onclick="window.open('http://www.facebook.com/sharer/sharer.php?u=http://1cm.life/news_detail.php?nid=<?php echo $nid; ?>','Facebook',
                   config='height=小視窗高度,width=小視窗寬度')">
					<span class="ic shareit">share</span>
				  </a>
				</li>
			  </ul>
			  <div class="clear_both"></div>
			  <!--mshareORlike-->
			  <div class="mshareorlike">
				<ul>
				  <li>
					<a href="<?php echo $web_fb_url;?>">
					  <span class="mic mfb"></span><span class="mic mlikeit">likeit</span>
					</a>
				  </li>
				  <li>
					<a href="http://www.facebook.com/sharer/sharer.php?u=http://1cm.life/news_detail.php?nid=<?php echo $nid; ?>">
					  <span class="mic mshare">share</span>
					</a>
				  </li>
				</ul>
			  </div>
			  <!--mad-->
			  <div class="mad">
				<a href="#">
				  <img src="images/banner/622x98.gif" width="622" height="98" />
				</a>
			  </div>
			  <!--next-->
			  <ul>
				<?php 
				if($row_prenews["news_id"]!=""){ 
				?>
					<li>
					  <a href="<?php echo $href; ?>news_detail.php?nid=<?php echo $row_prenews["news_id"];?>">
						<div class="sarticle">
						  <div class="stitle"><?php echo tc_left(strip_tags($row_prenews["news_title"]),20);?></div>
						  <div class="vblack"></div>
						  <img src="<?php if($row_prenews["news_banner"]!=""){echo $web_path_news,"sl",$row_prenews["news_banner"];}?>" width="140" height="140" alt="" onerror="javascript:this.src='images/nopic.png'">
						</div>
						<span class="next">上一篇</span>
					  </a>
					</li>
				<?php 
				}
				?>
				<?php 
				if($row_nextnews["news_id"]!=""){ 
				?>
					<li>
					  <a href="<?php echo $href; ?>news_detail.php?nid=<?php echo $row_nextnews["news_id"];?>">
						<div class="sarticle">
						  <div class="stitle"><?php echo tc_left(strip_tags($row_nextnews["news_title"]),20);?></div>
						  <div class="vblack"></div>
						  <img src="<?php if($row_nextnews["news_banner"]!=""){echo $web_path_news,"sl",$row_nextnews["news_banner"];}?>" width="140" height="140" alt="" onerror="javascript:this.src='images/nopic.png'">
						</div>
						<span class="next">下一篇</span>
					  </a>
					</li>
				<?php 
				}
				?>
			  </ul>
			</div>
			<!--mobile_may-->
			<div class="mobile_may">
			  <div class="title">you may like
			  <span class="mleft">相關新聞</span></div>
			  <?php
			  foreach($rows_likenews as $row_likenews){
			  ?>
			  <!--may_news-->
			  <div class="may_news">
				<div class="may_pic">
				  <a href="<?php echo $href; ?>news_detail.php?nid=<?php echo $row_likenews["news_id"];?>">
					<img src="<?php echo $web_path_news,"sl",$row_likenews["news_banner"];?>" width="140" height="110">
				  </a>
				</div>
				<div class="may_data">
				  <p>
					<a href="<?php echo $href; ?>news_detail.php?nid=<?php echo $row_likenews["news_id"];?>">
						<?php echo $row_likenews["news_title"]; ?>
					</a>
				  </p>
				</div>
			  </div>
			  <div class="clear_both"></div>
			  <div class="mobile_line"></div>
			  <?php
		      //$i++;
			  }
			  //unset($i);
			  ?>
			</div>
			<!--leftcontent EDN-->
		  </div>
		  <!--右邊區塊right-->
		  <div id="rightbar">
			<!--按讚-->
			<div class="subtitle-advtiseR hidden-mobile">
				<p class="title hidden-tablet">按下讚與我們一起探索知識的無窮！</p>
				<p class="title visible-tablet">按下讚探索知識的無窮！</p>
				<iframe class="visible-tablet" src="//www.facebook.com/plugins/like.php?href=<?php echo $web_fb_url;?>&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="margin-left:30%; border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>

				<iframe class="top-right-fb-like-button fb_iframe_widget hidden-tablet" src="//www.facebook.com/plugins/like.php?href=<?php echo $web_fb_url;?>&amp;locale=en_US&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
			</div>
			<!--ad-->
			<div class="ad">
			<?php if(isset($adv["18"])){echo $adv["18"];}?>
			</div>
			<?php
				foreach($rows_rnews as $row_rnews){
			?>
				<div class="newbox">
					<div class="n_pic">
						<a href="news_detail.php?nid=<?php echo $row_rnews["news_id"];?>">
							<img src="<?php echo $web_path_news,"s",$row_rnews["news_banner"];?>" width="300" height="168">
						</a>
					</div>
					<div class="n_data">
						<ul>
							<li class="n_title01"><a href="news_detail.php?nid=<?php echo $row_rnews["news_id"];?>"><?php echo $row_rnews["news_title"];?></a></li>			
							<!--<li class="n_word"><?php/* echo tc_left(strip_tags($row_news["news_content"]),85) */?></li>-->
							<li class="n_time"><span class="ic day"></span><span class="mic mday"></span>
								<?php 
									echo "20";
									echo date("y/m/d",strtotime($row_rnews["news_createtime"]));
									echo "&nbsp;&nbsp;";
									//echo $row_news["admin_cname"];
								?>
							</li>
						</ul>
					</div>
				</div>
			<?php
				}
			?>
			<!--ad-->
			<div class="ad">
			<?php if(isset($adv["18"])){echo $adv["18"];}?>
			</div>
			<div class="content_blockFB">
				<div class="fb-like-box" data-href="<?php echo $web_fb_url;?>" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="true" data-show-border="true"></div>
			</div>
			<!--rightbar EDN-->
		  </div>
		<!--content EDN-->
		</div>
		<div class="clear_both"></div>
		<!--line=-->
		<div class="line"></div>
		<div class="maybox">
		  <div class="ic maylike">you may like 相關新聞</div>
		  <ul>
			 <?php
			  foreach($rows_likenews as $row_likenews){
			  ?>
			  <li class="b01">
				<a href="<?php echo $href; ?>news_detail.php?nid=<?php echo $row_likenews["news_id"];?>">
				  <img src="<?php echo $web_path_news,"sl",$row_likenews["news_banner"];?>" width="140" height="110">
				  <?php echo $row_likenews["news_title"]; ?>
				</a>
			  </li>
			  <?php
		      //$i++;
			  }
			  //unset($i);
			  ?>
		  </ul>
		</div>
		<div class="clear_both"></div>
		<!--line=-->
		<div class="line"></div>
		<div class="maybox">
		  <div class="ic most">you may like 相關新聞</div>
		  <ul>
			<?php
				$i = 0;
				foreach( $rows_hotnews as $row_hotnews )
				{
					if($i < 3)
					{
			?>
						<li class="b02">
						  <a href="<?php echo $href; ?>news_detail.php?nid=<?php echo $row_hotnews["news_id"];?>">
							<img src="<?php echo $web_path_news,"m",$row_hotnews["news_banner"];?>" width="300" height="140">
							<?php echo $row_hotnews["news_title"];?>
						  </a>
						</li>
			<?php
					}
					$i ++;
				}
			?>
		  </ul>
		</div>
		<div class="clear_both"></div>
		<!--line=-->
		<div class="line"></div>
		<!--===下面內容content===-->
		<div id="content">
		  <!--===左邊內容區 left_content===-->
		  <div class="left_content infinite_container">
			<?php include_once("list.php"); ?>
		  </div>
		  <?php include_once("rightbar.php"); ?>
		  <div class="clear_both"></div>
		  <div id="page-nav">
			<a href="<?php echo $href; ?>news_detail.php?nid=<?php echo $nid; ?>&page=1"></a>
		  </div>
		</div>
	</div>	
<!-- lazyload -->
    <script type="text/javascript" src="ui/lazyload-master/jquery.lazyload.js"></script>
    <script>
	$(document).ready(function(e) {
        /*$(".description img").lazyload({
            effect : "fadeIn",
			placeholder: "http://1.bp.blogspot.com/-Qt2R-bwAb4M/T8WKoNKBHRI/AAAAAAAACnA/BomA-Whl_Bk/s1600/grey.gif"
        });*/
		/*$(".popupBox-close").hide();
		$("#popupBox").hide();
		$("#popupBox_Article").hide();
		popupDiv("popupBox");*/
		
		$(".toggle").click(function() {
			//$(this).toggleClass("active");
			$(".sweb").slideToggle();
		});

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