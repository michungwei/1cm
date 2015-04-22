<?php
/*Initial*/
ini_set('display_errors', 1);   # 0不顯示 1顯示 //錯誤是否顯示
error_reporting(E_ALL);         # report all errors
date_default_timezone_set("Asia/Taipei");//定義時區
mb_internal_encoding("UTF-8");//定義編碼
ini_set('magic_quotes_runtime', 0);//自動加上跳脫字元
ob_start();
session_start();//開session
header("Content-type:text/html; charset=utf-8");

$web_name = "1CM 質感生活";//網站名稱
$web_url = "http://1cm.life/";//網址
$web_url_rel = "../../";//圖片用相對網址
/*"http://1cm.life/"
"http://demo.coder.com.tw/1CM/";
"http://localhost/1cm/";*/
$description = "「1cm – 質感生活」 - 多1公分的視野，體驗更多原創分享。";//網站描述-------------------------
$keywords = "知識,1cm,探索,文章,新聞";//關鍵字設定---------------------------------
//$author = "CODER 誠智數位";//作者
$copyright = "1CM © 2014";//版權
$manage_name = "1CM－網站管理系統";
$web_icon = "images/1cm_icon.png";//網頁icon
$admin_icon = "../images/1cm_icon.png";//網頁icon

$web_fb_url = "https://www.facebook.com/1CMDaily";//網站FB連結

/*Database資料庫設定*/


 // $HS = "localhost";
 // $ID = "root";
 // $PW = "123456789";
 // $DB = "onecm";

/*$HS = "localhost";
$ID = "root";
$PW = "123";
$DB = "1cm"*/;

$HS = "192.168.192.182";
$ID = "popdaily";
$PW = "popdailypass";
$DB = "1cm";


/*SMTP Server E-mail設定*/
$smtp_auth = false;
$smtp_host = "127.0.0.1";
$smtp_port = 25;
$smtp_id   = "";
$smtp_pw   = "";

/*Table 資料庫表格名稱*/
$table_admin    = "1cm_admin";
$table_banner_b = "1cm_banner_b";
$table_contact  = "1cm_contact";
$table_news     = "1cm_news";
$table_news_pic = "1cm_news_pic";
$table_newstype = "1cm_newstype";
$table_adv      = "1cm_adv";

/*Upload path 存圖路徑*/
//banner_b
$web_path_banner_b = "upload/banner_b/";
$admin_path_banner = "../../upload/banner_b/";

//news
$web_path_news = "upload/news/";
$admin_path_news = "../../upload/news/";

//news_pic
$web_path_news_pic = "upload/news_pic/";
$admin_path_news_pic = "../../upload/news_pic/";

//newstype
$web_path_newstype = "upload/newstype/";
$admin_path_newstype = "../../upload/newstype/";

//newscontent
$web_path_newscontent ="upload/newscontent/";
$admin_path_newscontent = "../../upload/newscontent/";

//newstype_c
$web_path_newstypec = "upload/newstypec/";
$admin_path_newstypec = "../../upload/newstypec/";

/*Image setup 圖片規格*/
//banner
$banner_pic_w = 1060;
$banner_pic_h = 600;


//newstype 列表圖
$newstype_mpic_w = 720;
$newstype_mpic_h = 513;
//newstype banner大圖
$newstype_bpic_w = 1060;
$newstype_bpic_h = 600;


//news banner代表圖
$news_bannerpic_w = 1060;
$news_bannerpic_h = 600;
//news 列表圖
$news_mpic_w = 730;
$news_mpic_h = 285;
//news 右邊小圖
$news_spic_w = 300;
$news_spic_h = 170;
//news 下方同類推薦小圖
$news_slpic_w = 440;
$news_slpic_h = 440;
//news 大量上圖
$news_mostpic_w = 600;
$news_mostpic_h = 300;


/*資料用ARY*/
$ary_yn = array('否', '是');
$ary_stop_yn = array('是', '否');
$ary_page = array('不限', '首頁', '概念', '最新消息');//放置各網頁名稱
$ary_pro_status=array('未處理','已處理');
$aryAdminAuth=array('1'=>'全部','2'=>'新聞列表');
$ary_adv_type = array('1'=>'下方(左)','2'=>'下方(右)','3'=>'右側(上方)','4'=>'右側(下方1)','5'=>'右側(下方2)','6'=>'上方橫幅','7'=>'手機(320*50)',
'8'=>'測試用', '9'=>'測試用','11'=>'全站_728x90_上','12'=>'全站_300x250_右1','13'=>'全站_300x600_右下','14'=>'全站_336x280_左下','15'=>'全站_336x280_右下','16'=>'文章下_728x90','17'=>'文章_468x60_中',
'18'=>'mobile_300x250_彈出', '19'=>'手機專用_300x250',);

/*Email*/
/*$sys_email = "bill@coder.com.tw";
$sys_name = "客服中心";*/

require_once($inc_path."_func.php");
require_once($inc_path."_database.class.php");

/*End PHP*/

