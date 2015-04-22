<?php
include_once("_config.php");
include_once($inc_path."_getpage.php");

$nid=get("ntid");
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

//新聞人氣排行
$sql = "SELECT * 
		FROM $table_news n,$table_newstype nt ,$table_admin a
	    WHERE n.newsType_id=nt.newsType_id AND a.admin_id=n.news_aut_id AND n.$news_upday<=NOW() AND n.$isshow_news = 1 AND n.newsType_id='$ntid'
		ORDER BY n.news_clicknum DESC LIMIT 10";

$rows_news_top = $db -> fetch_all_array($sql);

//新聞列表
$sql = "SELECT * 
		FROM $table_news n,$table_newstype nt ,$table_admin a
	    WHERE n.newsType_id=nt.newsType_id AND a.admin_id=n.news_aut_id AND n.$news_upday<=NOW() AND n.$isshow_news = 1 AND n.newsType_id='$ntid'
		ORDER BY $news_upday DESC";

getSql($sql, 9, $query_str);
$rows_news = $db -> fetch_all_array($sql);

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
	<link href="css/all.css" rel="stylesheet" type="text/css">
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
		 	window.open("http://www.facebook.com/sharer/sharer.php?u=<?php echo $web_url."news_detail.php?nid=".$nid; ?>",'','width=653,height=369');
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
						return "video_list.php?ntid=<?php echo $ntid; ?>&page=" + index;
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
		<div class="clear_both"></div>
		<!--===下面內容content===-->
		<div id="content">
		  <!--===左邊內容區 left_content===-->
		  <div class="left_content">
			<?php include_once("video_list_top.php"); ?>
		  </div>
		  <?php include_once("video_rightbar.php"); ?>
		  <div class="infinite_container">
		  <?php include_once("video_list_bottom.php"); ?>
		  </div>
		  <div class="clear_both"></div>
		  <div id="page-nav">
			<a href="video_list.php?ntid=<?php echo $ntid; ?>&page=1"></a>
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