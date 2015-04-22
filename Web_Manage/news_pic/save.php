<?php
include("_config.php");
//include($inc_path."_imgupload.php");
include($inc_path."_multiImgupload.php");


foreach ($_FILES["multi_pic"]["error"] as $key => $error) {

	$db = NEW Database($HS, $ID, $PW, $DB);
	$db -> connect();
	$data["news_id"]     = post("news_id");
	$data["news_pic_isshow"]     = post("isshow");
	$data["news_pic_createtime"] = request_cd();
	$data["news_pic_ind"]        = getMaxInd($table,"news_pic_ind","");

	/*$file =new imgUploder($_FILES['pic']);
	if ($file->file_name != "")
	{		

		$rr=substr($file->file_name,-4);
		$file->set("file_name",time().'1'.$rr);
		$file->set("file_max",1024*1024*3); 
		$file->set("file_dir",$filepath); 
		$file->set("overwrite","3"); 
		$file->set("fstyle","image"); 
		if ($file->upload() && $file->file_name!=""){
			$file->file_sname="bn";
			$file->createSmailImg($news_banner_w,$news_banner_h,0);
			$data["{$prefix}pic"]=$file->file_name;
		}	
		echo("<script>console.log('PHP: pic');</script>");
	}*/

	
		$file =new multiImgUploder($_FILES["multi_pic"], $key);
		if ($file->file_name != "")
		{		
			$rr=substr($file->file_name,-4);
			$file->set("file_name",time().$key.$rr);
			$file->set("file_max",1024*1024*3); 
			$file->set("file_dir",$file_path); 
			$file->set("overwrite","3"); 
			$file->set("fstyle","image"); 
			if ($file->upload() && $file->file_name!=""){
				$file->file_sname="pic";
				$file->createSmailImg($news_bannerpic_w,$news_bannerpic_h,0);
				$data["news_pic_name"]=$file->file_name;
			}	
		}
		echo("<script>console.log('PHP: ".$data["news_pic_name"]."');</script>");
		
	  $db -> query_insert($table,$data);
	  $db -> close();
}
	echo("<script>console.log('PHP: ".$query_str."');</script>");
	script("新增成功!","index.php?news_id=".post("news_id"));

?>




