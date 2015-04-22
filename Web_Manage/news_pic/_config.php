<?php
$inc_path="../../inc/";
include_once("../_config.php");

$id_column = "news_pic_id";//id欄位
$ind_column = "news_pic_ind";//排序欄位

$file_path = $admin_path_news_pic;
$file_c_path = $admin_path_news_pic;
$news_path_index = "../news_pic/index.php";//連結到news首頁

$table      = "1cm_news_pic";
$page = request_pag("page");
$keyword = get("keyword", 1);
$is_show = get("isshow", 1);
$news_id=get("news_id", 1);

$query_str = "isshow=$is_show&news_id=$news_id&keyword=$keyword&page=".$page;
$mtitle = "<a href='index.php?".$query_str."'> 翻頁圖片管理 </a>";

/*End PHP*/