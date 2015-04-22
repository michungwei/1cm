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

getSql($sql, 15, $query_str);
$rows_news = $db -> fetch_all_array($sql);

//各分類新聞列表
$i = 0;
$temp_rows_newt = $rows_newt;
foreach($temp_rows_newt as $temp_rows_newt)
{
	$temp_id = $temp_rows_newt['newsType_id'];
	$sql = "SELECT * 
			FROM $table_news n, $table_admin a
			WHERE n.newsType_id=$temp_id AND a.admin_id=n.news_aut_id AND n.$news_upday<=NOW() AND n.$isshow_news = 1 $sql_str
			ORDER BY $news_upday DESC";
	getSql($sql, 7, $query_str);
	$rows_allnews[$i] = $db -> fetch_all_array($sql);
	$temp_allnews[$i] = $rows_allnews[$i];
	$i ++;
}

//讀者熱選
$sql = "SELECT * 
		FROM $table_news
	    WHERE $isshow_news=1 AND TO_DAYS(NOW()) - TO_DAYS(news_upday) <= 60 AND news_upday<=NOW()
	    ORDER BY RAND() LIMIT 3";
$rows_likenews = $db -> fetch_all_array($sql);

//人氣排行
$sql = "SELECT * 
		FROM $table_news
	    WHERE $isshow_news=1 AND news_upday<=NOW()
	    ORDER BY news_clicknum DESC LIMIT 10";
$rows_hotnews = $db -> fetch_all_array($sql);


$db -> close();

$href = "";
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
	<link href="css/all.css" rel="stylesheet" type="text/css">
	<link href="css/mstyle.css" rel="stylesheet" type="text/css">
	<link href="css/jquery.jscrollpane.css" type="text/css"  rel="stylesheet" media="all" />
	<link rel="stylesheet" href="css/bootstrap.css">
    <link rel="icon" href="<?php echo $web_icon?>" type="image/png" />
    <link rel="stylesheet" href="scripts/fancybox/jquery.fancybox.css">
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
				$('.left_content').infinitescroll({
					navSelector 	:	'#page-nav',
					nextSelector	:	'#page-nav a',
					itemSelector	:	'.infinte_list',
					animate      	:   true,
					debug 			:   true,
					maxPage			:	<?php echo $page_count; ?>,
					path: function(index) {
						console.log("mother fucker!!!");
						return "<?php echo $href; ?>search.php?page=" + index;
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
	<div id="content_banner">
		<div id="banner2">
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
	</div>
	<div class="clear_both"></div>
	<!-----下面內容content----->
	<div id="content">
	<!-----左邊內容區 left_content----->
		<div class="left_content">
			<?php include_once("list.php"); ?>
		</div>
			<?php include_once("rightbar.php"); ?>
		<div class="clear_both"></div>
		<nav id="page-nav">
			<a href="search.php?page=1"></a>
		</nav>
	</div>
	</div>
<!-- lazyload -->
    <script type="text/javascript" src="ui/lazyload-master/jquery.lazyload.js"></script>
    <script>
	$(document).ready(function(e) {
		console.log("document height:"+$(document).height());
		console.log("page-nav top:"+$('#page-nav').offset().top);
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