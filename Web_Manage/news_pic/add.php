<?php
include_once("_config.php");
?>
<!doctype html>
<html>
<head>
<title>Untitled Document</title>
<meta charset="utf-8" />
<link href="../css/admin_style_gray.css" rel="stylesheet" />
<script src="../../scripts/jquery-1.6.1rc1.min.js"></script>
<script src="../../scripts/public.js"></script>
<script src="../../scripts/function.js"></script>
<script>
$(document).ready(function(){
		$("form").submit(function(){
		var re=true;
		err_msg='';
		if(re){re=isnull("multi_pic","圖片",0,1,100);}
		if (!re){
		  alert(err_msg) 
		  return false;  
		}
	   return true;
	  });
});
</script>
</head>

<body>
<div id="mgbody-content">
  <div id="adminlist">
    <h2> <img src="../images/admintitle.png" />&nbsp;&nbsp;<?php echo $mtitle?> >&nbsp;&nbsp;新增</h2>
    <div class="accordion ">
      <div class="tableheader">
        <div class="handlediv"></div>
        <p align="left">新增翻頁圖片</p>
      </div>
      <div class="listshow">
        <FORM action="save.php?<?php echo $querystr ?>" method="post" enctype="multipart/form-data" name="form" id="form">
          <input type="hidden" name="news_id" value="<?php echo $news_id?>">
          <table width="700" border="0" cellpadding="0" cellspacing="3">
            <tr>
              <td valign="top"><h4 class="input-text-title">是否顯示</h4></td>
              <td>
                <label>
                  <input type="checkbox" name="isshow" id="isshow" checked value="1"/>顯示 
                </label>
              </td>
            </tr>
            <tr>
              <td valign="top"><h4 class="input-text-title">圖片</h4></td>
              <td>
                <label>
                  <input type="file" name="multi_pic[]" id="multi_pic" size="80" value="" multiple/>
                </label>
              </td>
            </tr>
            <tr>
              <td width="141" valign="top">&nbsp;</td>
              <td width="559">
                (請上傳符合 <?php echo $news_bannerpic_w; ?> x <?php echo $news_bannerpic_h; ?> 尺寸的圖片)
              </td>
            </tr>
            <tr>
              <td></td>
              <td height="30"><input name="savenews" type="submit" id="savenews" value=" 送 出 " />
                &nbsp;&nbsp;&nbsp;
                <input name="" type="reset" value=" 重 設 " /></td>
            </tr>
          </table>
        </FORM>
        <?php
          //$db -> close();
        ?>
      </div>
    </div>
  </div>
</div>
</body>
</html>
