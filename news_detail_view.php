<?php
include_once("_config.php");
include_once($inc_path."_getpage.php");

$nid = get("nid");
/*$nid=get("nid");*/
$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

/*//廣告
$sql_adv = "SELECT * 
		    FROM $table_adv
			WHERE $isshow_adv=1";

$rows_adv = $db -> fetch_all_array($sql_adv);

foreach($rows_adv as $row_adv){
  $adv[$row_adv["adv_id"]]=$row_adv["adv_link"];
}


//右方新聞
$sql_rnews = "SELECT * 
		      FROM $table_news
			  WHERE $isshow_news=1 AND $isrightshow_news=1 AND $news_upday<=NOW()
			  ORDER BY RAND() LIMIT 6";
$rows_rnews = $db -> fetch_all_array($sql_rnews);*/


//分類
$sql_newt = "SELECT * 
		    FROM $table_newstype
			WHERE $isshow_newsType=1
			ORDER BY $ind_nType DESC";

$rows_newt = $db -> fetch_all_array($sql_newt);
//新聞內容
$sql = "SELECT * 
		FROM $table_news n,$table_newstype nt,$table_admin a
		WHERE n.newsType_id=nt.newsType_id AND a.admin_id=n.news_aut_id AND n.news_id='$nid'";
$row_news = $db -> query_first($sql);


/*//點擊次數紀錄
if($row_news!=false&&!isset($SESSION["news$nid"])){
  //$_SESSION["news$nid"] = 1;防止灌水
  $thisid=$row_news["news_id"];
  $data["news_clicknum"] = "news_clicknum"+1;
  $db -> query_update($table_news, $data, "$N_id = $thisid");
}*/


//下一筆next
/*$sql = "SELECT news_id 
		FROM $table_news
		WHERE $isshow_news=1 AND $news_upday<=NOW() AND $news_upday<(SELECT $news_upday FROM $table_news WHERE news_id='$nid') AND $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid')
		ORDER BY $news_upday DESC
		limit 1";
$row_nextnews = $db -> query_first($sql);*/



//上一筆pre
/*$sql = "SELECT news_id 
		FROM $table_news
		WHERE $isshow_news=1 AND $news_upday<=NOW() AND $news_upday>(SELECT $news_upday FROM $table_news WHERE news_id='$nid') AND $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid')
		ORDER BY $news_upday ASC
		limit 1";
$row_prenews = $db -> query_first($sql);*/

//也許你會喜歡
$sql = "SELECT * 
		FROM $table_news
	    WHERE $isshow_news=1 AND   TO_DAYS(NOW()) - TO_DAYS(news_upday) <= 30 AND  news_upday<=NOW() AND $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid') AND $N_id<>'$nid'
	    ORDER BY RAND() LIMIT 8";
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
    <link rel="icon" href="<?php echo $web_icon?>" type="image/png" />
	<script src="scripts/jquery-1.9.1.js"></script>
	<script src="scripts/all.js"></script>
    <script src="scripts/search.js"></script>

<script>
/*重整原頁面*/
$(document).ready(function(e) {
window.opener.location.reload();
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
		<!-- <div class="scroll_top50 hidden-mobile hidden-tablet">
			<a href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image1','','images/scroll_topover.png')"><img src="images/scroll_top.png" height="101" width="101" name="image1" alt=""></a>
		</div>
		<div class="scroll_top90 hidden-mobile hidden-tablet">
			<a href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image2','','images/scroll_topover.png')"><img src="images/scroll_top.png" height="101" width="101" name="image2" alt=""></a>
		</div> -->
		<ul class="mobile-list">
			<li class="mobileClose"><img src="images/mobileClose.png" height="31" width="31" alt=""></li>
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
		</ul>
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
				<span class="hidden-tablet"><a href="https://www.facebook.com/pages/1cm/761735067202346" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagefb','','images/icon_fbover.png')"><img src="images/icon_fb.png" alt="" name="imagefb"></a></span>
				<span class="hidden-tablet"><a href="http://instagram.com/1___cm" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imageinsta','','images/icon_instaover.png')"><img src="images/icon_insta.png" alt="" name="imageinsta"></a></span>
			</div>
			<div class="mobile-switch visible-mobile"></div>
			<div class="mobile-fb visible-mobile"><a href="https://www.facebook.com/pages/1cm/761735067202346" target="_blank"><img src="images/icon_fb.png" alt=""></a></div>
			<div class="mobile-insta visible-mobile"><a href="http://instagram.com/1___cm" target="_blank"><img src="images/icon_insta.png" alt=""></a></div>
		</header>

		<section id="content">
			<div class="subtitle"><img src="images/subtitle.png" alt=""></div>
			<div class="subtitle-advtise">
            <?php /*
				<div class="subtitle-advtiseL">
					<?php if(isset($adv["6"])){echo $adv["6"];}?>
				</div>
				<div class="subtitle-advtiseR hidden-mobile">
					<p class="title hidden-tablet">按下讚與我們一起探索知識的無窮！</p>
					<p class="title visible-tablet">按下讚探索知識的無窮！</p>
					<iframe class="visible-tablet" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
					<!-- <div class="fb-like top-right-fb-like-button fb_iframe_widget hidden-tablet" data-href="https://www.facebook.com/pages/1cm%E7%94%9F%E6%B4%BB%E5%93%81%E5%91%B3%E6%8E%A2%E7%B4%A2/761735067202346" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div> -->
					<iframe class="top-right-fb-like-button fb_iframe_widget hidden-tablet" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;locale=en_US&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
				</div>
            */?>  
                
			</div>
            <?php
			if($row_news["news_showType"]==1){
			?>
			<div class="banner">
				<div class="fblike hidden-mobile hidden-tablet">
					<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=40&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:43px; height:65px;" allowTransparency="true"></iframe>
					<div class="fb-share-button" data-href="https://www.facebook.com/pages/1cm/761735067202346" data-width="40" data-type="box_count"></div>
				</div>
                <?php
				echo '<img src="'.$web_path_news.'banner'.$row_news["news_banner"].'" alt="">';
				?>
			</div>
            <?php }?>
            
			<div class="content_section">
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
							<div class="titleR"><?php echo substr($row_news["newsType_Ename"],0,1);?><!--H--></div>
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
							<span>
								<!--<div class="fb-share-button" data-href="https://www.facebook.com/pages/1cm/761735067202346" data-width="57" data-type="button"></div>-->
                                <div><a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $web_url."news_detail.php?nid=".$nid;?>" target="_blank"><img src="images/icon_share.png"></a></div>
							</span>
						</div>
						<!--<div class="thumbimg"><img src="images/content_img.png" alt=""></div>-->
						<div class="description">
                            <?php echo $row_news["news_content"];?>
						</div>
                        
                        <?php
						}
						?>
					</div>
                    
                    <div class="fb_block">
                    <div class="fbshare_btn">
                    	<!--<a href="http://www.facebook.com/sharer/sharer.php?u=<?php /*echo $web_url."news_detail.php?nid=".$nid;*/?>" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image3','','images/fbshare_btnover.png')">--><img src="images/fbshare_btn.png" alt="" name="image3"><!--</a>-->
                    </div>
					<!--<div class="fbshare_btn"><a href="#"><img src="images/fbshare_btn.png" alt=""></a></div>-->
					<div class="fbjoin_btn">
						<!--<a href="https://www.facebook.com/pages/1cm/761735067202346" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image4','','images/fbjoin_btnover.png')">--><img src="images/fbjoin_btn.png" alt="" name="image4"><!--</a>-->
					</div>
				</div>
				<div class="page_btn">
					<span class="prev"><?php /*if($row_prenews["news_id"]!=""){echo '<a href="news_detail.php?nid='.$row_prenews["news_id"].'">';}*/?><img src="images/btn_prev.png" alt=""><?php /*if($row_prenews["news_id"]!=""){echo "</a>";}*/?></span>
					<span class="next"><?php /* if($row_nextnews["news_id"]!=""){echo '<a href="news_detail.php?nid='.$row_nextnews["news_id"].'">';}*/?><img src="images/btn_next.png" alt=""><?php /*if($row_nextnews["news_id"]!=""){echo "</a>";}*/?></span>
				</div>
					<!-- 內文 End -->

				</div>

				<!-- Sidebar Start -->
				<aside class="content_sectionR hidden-mobile">
					<div class="content_blockAdv"><?php /*if(isset($adv["3"])){echo $adv["3"];}*/?></div>
                    <?php
					 /*foreach($rows_rnews as $row_rnews){
					?>
					<div class="content_blockAdv">
                        <a href="news_detail.php?nid=<?php echo $row_rnews["news_id"];?>">
						<div class="thumbimg"><img src="<?php echo $web_path_news,"s",$row_rnews["news_banner"];?>" alt=""></div>
						<div class="title"><?php echo tc_left($row_rnews["news_title"],23);?></div>
                        </a>
					</div>
                    <?php
                     }*/
					?>
					<div class="content_blockAdv"><?php /* if(isset($adv["4"])){echo $adv["4"];}*/?></div>
					<div class="content_blockAdv"><?php /* if(isset($adv["5"])){echo $adv["5"];}*/?></div>
					<div class="content_blockFB">
						<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; background: #f5f5f5;" allowTransparency="true"></iframe>
					</div>
				</aside>
				<!-- Sidebar End -->
				
				<div class="like_section recommendRead_section">
                    <?php
					if($rows_likenews!=false){
					echo '<p style="margin: 0 0 17px 0;"><img src="images/like_block_titleRecommend.png" alt=""></p>';
					}
					?>
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

				<?php /*
                <ul class="advertisement hidden-mobile">
					<li><?php if(isset($adv["1"])){echo $adv["1"];}?></li>
					<li><?php if(isset($adv["2"])){echo $adv["2"];}?></li>
				</ul>
                */?>
				<div class="fbslide hidden-mobile" id="fbslide">
					<div class="closebtn"></div>
					<p class="title">歡迎加入我們，<br />一同探索簡單有趣的生活品味：）</p>
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%;" allowTransparency="true"></iframe>
				</div>
				<div class="mobile_advertisement visible-mobile">
					<?php
/*					   echo $adv_p[array_rand($adv_p,1)];
*/					?>
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
			<div class="footer_logo hidden-mobile">
				<a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('flogo','','images/flogoover.png'),'1'"><img src="images/flogo.png" height="32" width="80" alt="" name="flogo"></a>
			</div>
			<ul>
				<li class="footer_backindex"><a href="index.php">返回首頁</a></li>
				<li class="footer_gotop"><a href="javascript: void(0)">回到上方</a></li>
				<li class="hidden-mobile"><a href="about.php">關於我們</a></li>
				<li class="hidden-mobile"><a href="contact.php">聯絡我們</a></li>
			</ul>
		</footer>

	</div>
</body>
</html>