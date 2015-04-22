<?php
include_once("_config.php");

$id = get("id");
if($id == 0){
	script("資料傳輸不正確", "index.php");
}

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

$sql = "SELECT *
		FROM $table 
		WHERE $id_column = '$id'";
$row = $db -> query_first($sql);

if($row){
    $news_pic_id = $row["news_pic_id"];
	$news_id = $row["news_id"];
	$news_pic_name = $row["news_pic_name"];
	$news_pic_isshow = $row["news_pic_isshow"];
	$news_pic_ind = $row["news_pic_ind"];
	$news_pic_createtime = $row["news_pic_createtime"];
}else{
 	script("資料不存在");
}

$db -> close();
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
		var re = true;
		err_msg = '';
		if(re){re = isnull("multi_pic", "圖片", 0, 1, 9999);}
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
        <h2> <img src="../images/admintitle.png" />&nbsp;&nbsp;<?php echo $mtitle; ?> >&nbsp;&nbsp;修改</h2>
        <div class="accordion ">
            <div class="tableheader">
                <div class="handlediv"></div>
                <p align="left">修改新聞分類</p>
            </div>
            <div class="listshow">
                <form action="edit_save.php?<?php echo $query_str; ?>" method="post" enctype="multipart/form-data" name="form" id="form">
                    <input type="hidden" name="cid" value="<?php echo $news_pic_id?>">
					<input type="hidden" name="news_id" value="<?php echo $news_id?>">
					<input type="hidden" name="pic_origin" id="pic_origin" value="<?php echo $news_pic_name; ?>" />
                    <table width="850" border="0" cellpadding="0" cellspacing="3">
                         <tr>
						  <td valign="top"><h4 class="input-text-title">最後修改時間</h4></td>
						  <td><?php echo $news_pic_createtime?></td>
						  <td width="299" rowspan="4">
							<?php 
							if ($news_pic_name != ""){
							  echo '<a href="'.$file_path.$news_pic_name.'" target="_blank"><img src="'.$file_path.$news_pic_name.'" width="200" height="130"></a>';
							}
							?>
							<br />
							<br /></td>
						</tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">是否顯示</h4></td>
                            <td><input type="checkbox" name="isshow" id="isshow" <?php echo ($news_pic_isshow == 1) ? "checked" : ""; ?> value="1" />
                                顯示 </td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">圖片</h4></td>
                            <td><p>
                                    <input type="file" name="pic" id="pic" value="<?php echo $news_pic_name; ?>" />
                                    <br />
                            (請上傳符合 <?php echo $news_bannerpic_w; ?> x <?php echo $news_bannerpic_h; ?> 尺寸的圖片)&nbsp;&nbsp;&nbsp;&nbsp;<input name="pic_del" type="checkbox" id="pic_del" value="1">&nbsp;刪除圖片</p></td>
                        </tr>
                        <tr>
                            <td width="150"></td>
                            <td height="30"><input name="savenews" type="submit" id="savenews" value=" 送 出 " />
                                &nbsp;&nbsp;&nbsp;
                                <input name="" type="reset" value=" 重 設 " /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
