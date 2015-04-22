<?php
include("_config.php");
include($inc_path."_imgupload.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

$db = NEW Database($HS, $ID, $PW, $DB);
$db -> connect();

$pic_origin = post("pic_origin",1);

$id                 = post("cid");
$data["news_id"]    = post("news_id");
$data["news_pic_isshow"]     = post("isshow");
$data["news_pic_createtime"] = request_cd();

$file =new imgUploder($_FILES['pic']);
if ($file->file_name != "")
{		
	$rr=substr($file->file_name,-4);
	$file->set("file_name",time().'1'.$rr);
	$file->set("file_max",1024*1024*3); 
	$file->set("file_dir",$file_path); 
	$file->set("overwrite","3"); 
	$file->set("fstyle","image"); 
	if ($file->upload() && $file->file_name!=""){
		$file->file_sname="pic";
		$file->createSmailImg($news_bannerpic_w,$news_bannerpic_h,6);
		$data["news_pic_name"]=$file->file_name;
		if(isset($pic_origin) && $pic_origin != ""){
			unlink($file_path.$pic_origin);
			unlink($file_path."pic".$pic_origin);
		}
	}	
}


  $db -> query_update( $table, $data, "news_pic_id = $id" );
  $db -> close();
  //script("修改完成!","edit.php?id=".$id."&".$query_str);
  script("修改完成!","index.php?news_id=".post("news_id"));

?>
</body>
</html>
