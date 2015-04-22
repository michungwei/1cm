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
		
//getSql($sql, 100, $query_str);
$rows_news = $db -> fetch_all_array($sql);

//讀者熱選
$sql = "SELECT * 
		FROM $table_news
	    WHERE $isshow_news=1 AND TO_DAYS(NOW()) - TO_DAYS(news_upday) <= 60 AND news_upday<=NOW()
	    ORDER BY RAND() LIMIT 3";
$rows_likenews = $db -> fetch_all_array($sql);


$db -> close();

?>
<?php
	header("Content-Type: text/xml; charset=utf-8");
	$xml = '<?xml version="1.0"?>'; 
	$xml .='<!DOCTYPE channel [
			<!ENTITY nbsp " ">
			<!ENTITY copy "©">
			<!ENTITY reg "®">
			<!ENTITY trade "™">
			<!ENTITY mdash "—">
			<!ENTITY ldquo "“">
			<!ENTITY rdquo "”"> 
			<!ENTITY lsquo "‘">
			<!ENTITY rsquo "’"> 
			<!ENTITY hellip "…"> 
			<!ENTITY middot "·"> 
			<!ENTITY ouml "ö"> 
			<!ENTITY deg "°"> 
			<!ENTITY eacute "é"> 
			<!ENTITY pound "£">
			<!ENTITY yen "¥">
			<!ENTITY euro "€">
			<!ENTITY prime "&#8242;">
			<!ENTITY Prime "&#8243;">
			<!ENTITY nbsp    "&#160;">
			<!ENTITY iexcl   "&#161;">
			<!ENTITY cent    "&#162;">
			<!ENTITY pound   "&#163;">
			<!ENTITY curren  "&#164;">
			<!ENTITY yen     "&#165;">
			<!ENTITY brvbar  "&#166;">
			<!ENTITY sect    "&#167;">
			<!ENTITY uml     "&#168;">
			<!ENTITY copy    "&#169;">
			<!ENTITY ordf    "&#170;">
			<!ENTITY laquo   "&#171;">
			<!ENTITY not     "&#172;">
			<!ENTITY shy     "&#173;">
			<!ENTITY reg     "&#174;">
			<!ENTITY macr    "&#175;">
			<!ENTITY deg     "&#176;">
			<!ENTITY plusmn  "&#177;">
			<!ENTITY sup2    "&#178;">
			<!ENTITY sup3    "&#179;">
			<!ENTITY acute   "&#180;">
			<!ENTITY micro   "&#181;">
			<!ENTITY para    "&#182;">
			<!ENTITY middot  "&#183;">
			<!ENTITY cedil   "&#184;">
			<!ENTITY sup1    "&#185;">
			<!ENTITY ordm    "&#186;">
			<!ENTITY raquo   "&#187;">
			<!ENTITY frac14  "&#188;">
			<!ENTITY frac12  "&#189;">
			<!ENTITY frac34  "&#190;">
			<!ENTITY iquest  "&#191;">
			<!ENTITY Agrave  "&#192;">
			<!ENTITY Aacute  "&#193;">
			<!ENTITY Acirc   "&#194;">
			<!ENTITY Atilde  "&#195;">
			<!ENTITY Auml    "&#196;">
			<!ENTITY Aring   "&#197;">
			<!ENTITY AElig   "&#198;">
			<!ENTITY Ccedil  "&#199;">
			<!ENTITY Egrave  "&#200;">
			<!ENTITY Eacute  "&#201;">
			<!ENTITY Ecirc   "&#202;">
			<!ENTITY Euml    "&#203;">
			<!ENTITY Igrave  "&#204;">
			<!ENTITY Iacute  "&#205;">
			<!ENTITY Icirc   "&#206;">
			<!ENTITY Iuml    "&#207;">
			<!ENTITY ETH     "&#208;">
			<!ENTITY Ntilde  "&#209;">
			<!ENTITY Ograve  "&#210;">
			<!ENTITY Oacute  "&#211;">
			<!ENTITY Ocirc   "&#212;">
			<!ENTITY Otilde  "&#213;">
			<!ENTITY Ouml    "&#214;">
			<!ENTITY times   "&#215;">
			<!ENTITY Oslash  "&#216;">
			<!ENTITY Ugrave  "&#217;">
			<!ENTITY Uacute  "&#218;">
			<!ENTITY Ucirc   "&#219;">
			<!ENTITY Uuml    "&#220;">
			<!ENTITY Yacute  "&#221;">
			<!ENTITY THORN   "&#222;">
			<!ENTITY szlig   "&#223;">
			<!ENTITY agrave  "&#224;">
			<!ENTITY aacute  "&#225;">
			<!ENTITY acirc   "&#226;">
			<!ENTITY atilde  "&#227;">
			<!ENTITY auml    "&#228;">
			<!ENTITY aring   "&#229;">
			<!ENTITY aelig   "&#230;">
			<!ENTITY ccedil  "&#231;">
			<!ENTITY egrave  "&#232;">
			<!ENTITY eacute  "&#233;">
			<!ENTITY ecirc   "&#234;">
			<!ENTITY euml    "&#235;">
			<!ENTITY igrave  "&#236;">
			<!ENTITY iacute  "&#237;">
			<!ENTITY icirc   "&#238;">
			<!ENTITY iuml    "&#239;">
			<!ENTITY eth     "&#240;">
			<!ENTITY ntilde  "&#241;">
			<!ENTITY ograve  "&#242;">
			<!ENTITY oacute  "&#243;">
			<!ENTITY ocirc   "&#244;">
			<!ENTITY otilde  "&#245;">
			<!ENTITY ouml    "&#246;">
			<!ENTITY divide  "&#247;">
			<!ENTITY oslash  "&#248;">
			<!ENTITY ugrave  "&#249;">
			<!ENTITY uacute  "&#250;">
			<!ENTITY ucirc   "&#251;">
			<!ENTITY uuml    "&#252;">
			<!ENTITY yacute  "&#253;">
			<!ENTITY thorn   "&#254;">
			<!ENTITY yuml    "&#255;">
			<!ENTITY diams   "&#9830;">
			<!ENTITY bull    "&#8226;">
			<!ENTITY ndash   "&#8211;">
			<!ENTITY infin   "&#8734;">
			<!ENTITY rarr    "&#8594;">
			<!ENTITY larr    "&#8592;">
			<!ENTITY uarr    "&#8593;">
			<!ENTITY darr    "&#8595;">
			]>';
	$xml .= '<rss version="2.0"><channel>';
	// 表頭資訊
	$xml.='<title>1CM質感生活誌</title>';
	$xml.='<description>多1公分的視野，體驗更多原創分享。</description>';
	$xml.='<link>http://1cm.life/</link>';
	
	$search = array("'<script(.*?)<\/script>'is",
					'/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u',
					'/&(?!#?[a-z0-9]+;)/');
	$replace = array('',
					'',
					'&amp;');
	//$str = "<script async src=\"//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>";
	//$str = preg_replace($search, $replace, $str);
	//echo $str;
	
	foreach( $rows_news as $rows_news )
	{
		$xml.='<item>';
		$xml.='<title>'.$rows_news["news_title"].'</title>';
		//$rows_news["new_content"] = str_replace("&nbsp;","&#160", $rows_news["news_content"]);
		$rows_news["new_content"] = preg_replace($search, $replace, $rows_news["news_content"]);
		$xml.='<description><![CDATA['.$rows_news["new_content"].']]></description>';
		$xml.='<link>'.'http://1cm.life/news_detail.php?nid='.$rows_news["news_id"].'</link>';
		$xml.='</item>';
	}
	
	$xml .= '</channel>';
	$xml .= '</rss>';
	echo $xml; 
?>