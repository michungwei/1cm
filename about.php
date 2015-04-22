<?php
include_once("_config.php");
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
			  ORDER BY RAND() LIMIT 1";

$rows_rnews = $db -> query_first($sql_rnews);



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
			</div>
			<div class="banner">
				<div class="fblike hidden-mobile hidden-tablet">
					<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=40&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:65px;" allowTransparency="true"></iframe>
					<div class="fb-share-button" data-href="https://www.facebook.com/pages/1cm/761735067202346" data-width="40" data-type="box_count"></div>
				</div>
				<img src="images/about_banner.png" alt="">
			</div>
			<div class="content_section">
				<div class="content_sectionL border_bottomNone">

					<!-- 內文 Start -->
					<div class="beadcrumbs_img"><a href="index.php">首頁</a></div>
					<div class="about_description">

						<p>cm 是以 cosmos（宇宙）所衍生出的縮寫字，代表了人們對於知識無窮盡的探索，如同宇宙一樣不斷擴張。1是數量的表示，是一種對知識追求的選擇。1cm的名稱構成，簡化了原始含義，轉換成以視野解釋，寫意表達我們對渴望原創的追求。</p>

						<p>編輯群發佈的文章，在生活中以人為中心透過體驗、觀察、吸收、分享四個階段烘培而出，代表著對每一道訊息傳遞的責任與情感；我們將訊息條列整理，建立起正向循環的幽默文字系統，擺脫閱讀上的干擾，消除過度重複帶來的悶熱，注入文字匹配視覺的清爽調劑。</p>

						<p>探索Explore：因為探索，即便過眼雲煙也是創造基石<br />
						新奇Novel：因為新奇，所以無聊離我們遠去<br />
						品味Taste： 因為品味，讓我們靠近生活一些<br />
						故事Story： 因為故事，寫下生活大小之事<br />
						精選Collection：因為精選，成就了1cm</p>

						<p>CM is the abbreviation of COSMOS, it represents people's exploration of the endless knowledge, just like the universe still expanding day after day. 1 represents amount, which means the choice of our pursuance to knowledge. The composition of the name 1CM, simplified its traditional meaning, transformed the meaning to transmit our eagerness to the original.</p>

						<p>The articles of editor announced are derived from human’s experience, observation, imbibitions and participation in life. Representing the responsibility and emotion of the messages transmitted. We organized the information and established the word system with humor. We get rid of the interference of reading and clear the impatience of reduplication. Ultimately we infused fresh favor into our composition.</p>

						<p>Explore：Because of exploration, even the ordinary will become the cornerstone of creation.<br />
						Novel：Because of novelty, we are away from tediousness.<br />
						Taste：Because we taste, we live lifes.<br />
						Story：Because of story, we write down our lifes.<br />
						Collection：Because of collection, we  accomplish 1CM.</p>

					</div>
					<div class="fb-share-button" data-href="<?php echo $web_url?>" data-width="57" data-type="button"></div><!--https://www.facebook.com/pages/1cm/761735067202346-->
					<div class="contact_btn">
						<a href="contact.php"><img src="images/contact_btn.png" alt=""></a>
					</div>
					<!-- 內文 End -->

				</div>

				<!-- Sidebar Start -->
				<aside class="content_sectionR hidden-mobile">

					<?php
						if( isset($adv["3"]) ){
					?>
						<div class="content_blockAdv"><?php echo $adv["3"]; ?></div>
					<?php
						}else{ echo ''; }
					?>
                    
                    <?php
					if(isset($rows_rnews["news_id"])){
					?>
					<div class="content_blockAdv recommend_block">
                        <a href="news_detail.php?nid=<?php echo $rows_rnews["news_id"];?>">
						<div class="thumbimg"><img src="<?php echo $web_path_news,"s",$rows_rnews["news_banner"];?>" alt=""></div>
						<div class="title"><?php echo tc_left($rows_rnews["news_title"],23);?></div>
                        </a>
					</div>
                    <?php
					}
					?>
					<div class="content_blockFB">
						<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; background: #f5f5f5;" allowTransparency="true"></iframe>
					</div>
				</aside>
				<!-- Sidebar End -->

				<ul class="advertisement hidden-mobile" <?php if(isset($adv["1"]) || isset($adv["2"])){ echo ''; }else{ echo 'style="display: none;"'; } ?> ><!--廣告1.2-->
					<li><?php if(isset($adv["1"])){echo $adv["1"];}?></li>
					<li><?php if(isset($adv["2"])){echo $adv["2"];}?></li>
				</ul>
				<div class="fbslide hidden-mobile" id="fbslide">
					<div class="closebtn"></div>
					<p class="title">歡迎加入我們，<br />一同探索簡單有趣的生活品味：）</p>
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%;" allowTransparency="true"></iframe>
				</div>

				<?php
					if(isset($rowsp_adv["adv_link"])&&$rowsp_adv["adv_link"]!=""){
				?>
					<div class="mobile_advertisement visible-mobile">
						<?php echo $rowsp_adv["adv_link"]; ?>
					</div>
				<?php
					}else { echo ''; }
				?>

				<div class="mobile_advertisement visible-mobile">
                    <?php
						if(isset($rows_rnews["news_id"])){
					?>
						<div class="content_blockAdv mt_15 mb_15">
	                        <a href="news_detail.php?nid=<?php echo $rows_rnews["news_id"];?>">
							<div class="thumbimg"><img src="<?php echo $web_path_news,"s",$rows_rnews["news_banner"];?>" alt=""></div>
							<div class="title"><?php echo tc_left($rows_rnews["news_title"],23);?></div>
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