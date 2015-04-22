var sf_pic_rand=[];

(function() {
    function sf_async_load(){
        var sf_header = document.getElementsByTagName('head')[0];
        if(!document.getElementById("sfysmstyle")) {
	        var sf_css = document.createElement('link');
	        sf_css.id = "sfysmstyle";
			sf_css.type = 'text/css'; 
			sf_css.async = true; 
			sf_css.href = "/ysm/1cm/sfysmstyle.css"; 
			sf_css.rel = 'stylesheet'; 
			sf_header.appendChild(sf_css);
		}
    	if(!window.jQuery) {
    		var sf_js = document.createElement('script');
	        sf_js.type = 'text/javascript'; 
        	sf_js.async = true; 
	        sf_js.src = 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'; 
    	    sf_js.onload = sf_init;
			//ie6, 7
			sf_js.onreadystatechange = function() {if(this.readyState == 'complete'||this.readyState == 'loaded') {sf_init();}}
    	    sf_header.appendChild(sf_js);
    	}else {
    		sf_init();
    	}
    }
    if(window.attachEvent) {window.attachEvent('onload', sf_async_load);} else {window.addEventListener('load', sf_async_load, false);}
})();

function sf_init() {
	var sfysmad_kid=[379, 380, 381, 382, 383, 384];//關鍵字組
	var sfysmad_query="keyword";//關鍵字搜尋框的參數名稱
	var sfysmad_adurl="";//呼叫廣告模式
	var sfysmad_index=0;//關鍵字組的索引
	var sfysmad_ctxtId_index=0;//ctxtId的索引
	var sfysmad_getad=[];//廣告樣式陣列
	var sfysmad_slot=window.document.getElementById('sf_script').getAttribute('slot');
	var sf_server_url=document.location;

	if (document.location.toString().indexOf("www.sales-frontier.com")>0) sf_server_url="http://onecentimetre.com/";

	var sf_user_agent=navigator.userAgent;
	var sf_pm_source_tag="tw_syndication_salesfrontier_onecentimetre_pm";
	var sf_cm_source_tag="tw_syndication_salesfrontier_onecentimetre_cm"; //雅虎給的
	var sf_ctxtId=['tw_syndication_sfrontier_ent_1']; //雅虎給的
	var sf_maxCount=10;
	var sf_mkt="tw";
	var sf_config='20618435762';

    //處理 ctxtId，如果是原設定是陣列，隨機取出一個
	sfysmad_ctxtId_index = Math.floor(Math.random() * sf_ctxtId.length); sf_ctxtId=sf_ctxtId[sfysmad_ctxtId_index];

	if (sfysmad_slot==null || sfysmad_slot=="") sfysmad_slot="";
	for(var sf_idx_i=0;sf_idx_i<jQuery("div[data]").length;sf_idx_i++) {if(jQuery("div[data]").eq(sf_idx_i)) {sfysmad_getad[sf_idx_i]=get_sfysmad_data(sf_idx_i);}}
	//隨機取得一組關鍵字組
	if(sfysmad_kid==null || sfysmad_kid=="") {
		sfysmad_kid=379;
	} else {
		sfysmad_index = Math.floor(Math.random() * sfysmad_kid.length); sfysmad_kid=sfysmad_kid[sfysmad_index];
	}

	//取得關鍵字
	if(sfysmad_query!="") {
		var sfysmad_query_new="";
		var thisParameter=decodeURIComponent(document.location.toString());
		if(thisParameter.indexOf("?")!=-1) {
			var sfysmad_ary=thisParameter.split("?")[1].split("#")[0].split("&");
			for(var sf_i in sfysmad_ary) {
				var sfysmad_str=sfysmad_ary[sf_i].split("=")[0];
				if(sfysmad_str == sfysmad_query) {sfysmad_query_new = sfysmad_ary[sf_i].split("=")[1];}
			}
		} else if(document.getElementById(sfysmad_query)) {
			if (document.getElementById(sfysmad_query).value!="") {sfysmad_query_new = document.getElementById(sfysmad_query).value;}
		} else if (document.getElementsByName(sfysmad_query)[0]) {
		    if(document.getElementsByName(sfysmad_query)[0].value!="") {sfysmad_query_new = document.getElementsByName(sfysmad_query)[0].value;}
		} else {sfysmad_query=null;}

		(sfysmad_query==sfysmad_query_new)?sfysmad_query=null:sfysmad_query=sfysmad_query_new;
	}

	if(sfysmad_query==null) {sfysmad_query="";}

	//決定廣告模式
	(sfysmad_query!="")?sfysmad_adurl="N":sfysmad_adurl="Y";
	var sf_kid=sfysmad_kid;
	var sf_slot=sfysmad_slot;
	var sf_query=sfysmad_query;
	var sf_adurl=sfysmad_adurl;
	var sf_data=sfysmad_getad;
	var sf_refurl=encodeURIComponent(parent.document.location);
	var sf_rnd=Math.random() + Date.parse(new Date());
	var sf_k;
	sf_getkid=379; if(sf_kid!="") {sf_getkid=sf_kid;} //要取得的關鍵字組
	sf_getadslot=""; if(sf_slot!="") {sf_getadslot=sf_slot;} //YSM 廣告的版位識別（type）
	sf_getadquery=""; if(sf_query!="") {sf_getadquery=sf_query;}//PM 要塞的關鍵字
	sf_getadurl=""; if(sf_adurl!="") {sf_getadurl=sf_adurl;}//決定呼叫模式
	sf_getaddata=""; if(sf_data!="") {sf_getaddata=sf_data;}//廣告樣式
	sf_getrefurl=""; if(sf_refurl!="") {sf_getrefurl=sf_refurl;}//廣告呼叫網址
	sf_getrnd=""; if(sf_rnd!="") {sf_getrnd=sf_rnd;}//隨機數字，防 cache
	//處理取得的廣告呈現參數，計算總呈現數量
	var sf_total_count=0;
	var sf_total_hkcount=0;
	var sf_data_array=sf_getaddata;
	var sf_temp;
	var sf_hks;
	var sf_chk=false;
	
	for(sf_idx_i=0; sf_idx_i<sf_data_array.length; sf_idx_i++) {
		if(sf_data_array[sf_idx_i]!="") {
			sf_temp=sf_data_array[sf_idx_i].split('/');
			sf_total_count=sf_total_count + parseInt(sf_temp[1]);
			sf_total_hkcount=sf_total_hkcount + parseInt(sf_temp[2]);
		}
	}

	//最小廣告呼叫數量為 3 則
	if (sf_total_count<3) {sf_total_count=3;}
	sf_maxCount=sf_total_count;

    //建立取用之圖檔陣列
	var sf_can_use_pic=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48];
	if(sf_maxCount>0) {
       for (var sf_i=0;sf_i<sf_maxCount;sf_i++) {
			var sf_r = Math.floor(Math.random()*sf_can_use_pic.length);
			sf_pic_rand[sf_i] = sf_can_use_pic[sf_r];
			sf_can_use_pic.splice(sf_r, 1); 
       }
	}

	//取得關鍵字組，使用 PM 方式或廣告參數有熱字數量才處理
	if(sf_getadurl!="Y" || sf_total_hkcount!=0) {
		sf_kid=sf_getkid;
		var sf_hkcount=sf_total_hkcount;
		jQuery.get('/ysm/1cm/keywords_'+sf_kid+'.txt', {}, function(res) {
			var sf_words=res.split("\n");
		    var sf_new_words=sf_words;
			var sf_words_rand=[];
			if(sf_getadquery=="") {sf_getadquery=sf_words[Math.floor(Math.random() * sf_words.length)];}
			if(sf_hkcount>0) {
				if(sf_hkcount>sf_words.length) {sf_hkcount=sf_words.length;}
                for (var sf_i=0;sf_i<sf_hkcount;sf_i++) {
				    var sf_r = Math.floor(Math.random()*sf_new_words.length);
					sf_words_rand[sf_i] = sf_new_words[sf_r];
					sf_new_words.splice(sf_r, 1); 
                }
				sf_hks=sf_words_rand;
			}
			sf_getadquery=encodeURIComponent(sf_getadquery);
			get_ysm_ads(sf_getadurl, sf_hks, sf_getadquery, sf_data_array, sf_config, sf_cm_source_tag, sf_ctxtId, sf_getadquery, sf_pm_source_tag, sf_mkt, sf_maxCount, sf_server_url, sf_getadslot, sf_getrnd)
		});
	} else {
		sf_getadquery=encodeURIComponent(sf_getadquery);
		get_ysm_ads(sf_getadurl, sf_hks, sf_getadquery, sf_data_array, sf_config, sf_cm_source_tag, sf_ctxtId, sf_getadquery, sf_pm_source_tag, sf_mkt, sf_maxCount, sf_server_url, sf_getadslot, sf_getrnd);
	}
}

function get_ysm_ads(sf_getadurl, sf_hks, sf_getadquery, sf_data_array, sf_config, sf_cm_source_tag, sf_ctxtId, sf_getadquery, sf_pm_source_tag, sf_mkt, sf_maxCount, sf_server_url, sf_getadslot, sf_getrnd) {

	var results = new Array();
	if(sf_getadurl=="Y") {
		//cm
		var ysm_url = 'https://tw-cm.ysm.yahoo.com/js_flat_1_0/';
		this_ad_type="CM";
		chk_flag="";
		var param="config="+sf_config+"&source="+sf_cm_source_tag+"&mkt="+sf_mkt+"&ctxtId="+sf_ctxtId+"&maxCount="+sf_maxCount+"&ctxtUrl="+sf_server_url+"&type="+sf_getadslot;
		jQuery.ajax({
			type:"GET", 
			url:ysm_url, 
			data:param, 
			dataType:'script',
			cache:true,
			success:function() {
				if(zSr.length>6) {
					for(idx=0;idx<zSr.length;idx+=6) {
						var tmp=zSr.slice(idx, idx+6);
						var tmp1={"clickurl":tmp[2], "title":tmp[3], "description":tmp[0], "siteHost":tmp[4]};
						if(tmp[0]!="") {results.push(tmp1);}
					}
					if(results.length>0) {
						new_result=results.slice(1, results.length);
						getAdBody(new_result, sf_hks, sf_getadquery, sf_data_array, chk_flag);
					}
				}
			}
		});
	} else {
		//pm
		var ysm_url="https://js-apac-ss.ysm.yahoo.com/d/search/p/yahoo/js/flat/tw/kk/";
		this_ad_type="PM";
		chk_flag="！";
		var param="Keywords="+sf_getadquery+"&Partner="+sf_pm_source_tag+"&mkt="+sf_mkt+"&maxCount="+sf_maxCount+"&serveUrl="+sf_server_url+"&type="+sf_getadslot+"&cb="+sf_getrnd;
		jQuery.ajax({
			type:"GET", 
			url:ysm_url, 
			data:param,
			dataType:'script',
			cache:true,
			success:function() {
				if(zSr.length>6) {
					for(idx=0;idx<zSr.length;idx+=6) {
						var tmp=zSr.slice(idx, idx+6);
						var tmp1={"clickurl":tmp[2], "title":tmp[3],  "description":tmp[0], "siteHost":tmp[4]};
						if(tmp[0]!="") {results.push(tmp1);}
					}
					if(results.length>0) {
						new_result=results.slice(1, results.length);
						getAdBody(new_result, sf_hks, sf_getadquery, sf_data_array, chk_flag);
					}
				}
			}
		});
	}
}


function get_sfysmad_data(obj) {
  var objs=jQuery("div[data]").eq(obj);
  var getdata = objs.attr("data");
  var getcount = objs.attr("count");
  var gethkcount = objs.attr("hkcount");
  var getadfill = objs.attr("adfill");
  var getadlogo = objs.attr("adlogo");
  var getarray="";
  if (getdata==null || getdata=="") getdata="";
  getdata=getdata.split(",");
  getdata_index = Math.floor(Math.random() * getdata.length);
  getdata=getdata[getdata_index];
  (getcount==null || getcount=="")?getcount="0":getcount=parseInt(getcount);
  (getcount==null || getcount=="")?getcount="0":getcount=parseInt(getcount);
  (gethkcount==null || gethkcount=="")?gethkcount="0":gethkcount=parseInt(gethkcount);
  if(getadfill==null || getadfill=="") getadfill="N";
  if(getadlogo==null || getadlogo=="") getadlogo="C";
  (getdata!="" && getcount!="")?getarray=getdata+"/"+getcount+"/"+gethkcount+"/"+getadfill+"/"+getadlogo:getarray="";
  return getarray;
}

function getAdBody(sf_ads_array, sf_hks, keyword, data_array, sf_chk_flag) {
	sf_pool=sf_ads_array;
	//確認回傳的廣告數量
	var sf_zsr_count=sf_pool.length;
	//若有取得回傳的 ysm 廣告，依廣告樣式呈現在各區塊。若未取得，依廣告樣式遞補 AdSense 廣告。
	if(sf_zsr_count>0) {
		var keyword_color="#FF0000";
		var change_keyword=keyword;
		var sf_new_array=sf_hks;
		var sf_html="";
		var sf_html_title="";
		var sf_html_content="";
		var sf_k=0;
		var sf_html_script="";

		for(sf_ads_idx=0; sf_ads_idx<data_array.length; sf_ads_idx++) {
			if(data_array[sf_ads_idx]!=""|| data_array[sf_ads_idx]!=null) {
				var sf_temp = data_array[sf_ads_idx].split("/");
				//判斷要呈現「Ads by Yahoo」或「贊助廣告」字樣
				var sf_list_str="";
				if(sf_temp[4]=="Y") {sf_list_str="Ads by Yahoo";}
				if(sf_temp[4]=="C") {sf_list_str="贊助廣告";}          
			
				switch(sf_temp[0]) {
					// 廣告種類 1CM_home_300x780_RT_pc
					case "1CM_home_300x780_RT_pc":
					// 廣告種類 1CM_article_300x780_RT_pc
					case "1CM_article_300x780_RT_pc":
						sf_html="";
						sf_html_title='';
						for (sf_idx_j=0; sf_idx_j<sf_temp[1]; sf_idx_j++) {
							if (sf_k < sf_zsr_count) {
	                            sf_html_content='<div class="content_blockAdv recommend_block">';
								sf_html_content=sf_html_content+'<a target="_blank" href="'+sf_pool[sf_k]["clickurl"]+'">';
	                            sf_html_content=sf_html_content+'<div class="thumbimg"><img src="http://capture.heartrails.com/300x170/shorten?'+sf_pool[sf_k]["siteHost"]+'/" /></div>';
	                            sf_html_content=sf_html_content+'<div class="title">'+sf_pool[sf_k]["title"].replace("'","\'").replace(change_keyword, '<span style="color:'+keyword_color+'">'+change_keyword+'</span>')+'<br /><span class="sf_300_s">'+sf_pool[sf_k]["description"].replace(change_keyword, '<span style="color:'+keyword_color+'">'+change_keyword+'</span>')+'</span><br /><span class="sf_300_w">'+sf_pool[sf_k]["siteHost"]+'</span>';
								if(sf_list_str!="") {
								   sf_html_content=sf_html_content+'<br /><span class="sf_300_logo">'+sf_list_str+sf_chk_flag+'</span>';
								}
								sf_html_content=sf_html_content+'</div>';
								sf_html_content=sf_html_content+'</a>';
								sf_html_content=sf_html_content+'</div>';
		                    	sf_k++;
			                } else {
			                	sf_html_content="";
						  	}
						    if (sf_html_content!="") sf_html=sf_html+sf_html_content;
					  	}

			            if (sf_html!="") {
	                       sf_html=sf_html_title+sf_html+'';
                        }

						if (sf_html=="" && sf_temp[3]=="Y") {
		          			sf_html="";//AdSense Code
			          	}
					break;
						        	    						        	    
					// 廣告種類 1CM_home_300x780_RT_mo
					case "1CM_home_300x780_RT_mo":
					// 廣告種類 1CM_article_300x780_RT_mo
					case "1CM_article_300x780_RT_mo":
						sf_html="";
						sf_html_title='';
						for (sf_idx_j=0; sf_idx_j<sf_temp[1]; sf_idx_j++) {
							if (sf_k < sf_zsr_count) {
	                            sf_html_content='<div class="content_blockAdv mt_15 mb_15">';
								sf_html_content=sf_html_content+'<a target="_blank" href="'+sf_pool[sf_k]["clickurl"]+'">';
	                            sf_html_content=sf_html_content+'<div class="thumbimg"><img src="http://capture.heartrails.com/300x170/shorten?'+sf_pool[sf_k]["siteHost"]+'/" /></div>';
	                            sf_html_content=sf_html_content+'<div class="title">'+sf_pool[sf_k]["title"].replace("'","\'").replace(change_keyword, '<span style="color:'+keyword_color+'">'+change_keyword+'</span>')+'<br /><span class="sf_300_s">'+sf_pool[sf_k]["description"].replace(change_keyword, '<span style="color:'+keyword_color+'">'+change_keyword+'</span>')+'</span><br /><span class="sf_300_w">'+sf_pool[sf_k]["siteHost"]+'</span>';
								if(sf_list_str!="") {
								   sf_html_content=sf_html_content+'<br /><span class="sf_300_logo">'+sf_list_str+sf_chk_flag+'</span>';
								}
								sf_html_content=sf_html_content+'</div>';
								sf_html_content=sf_html_content+'</a>';
								sf_html_content=sf_html_content+'</div>';
		                    	sf_k++;
			                } else {
			                	sf_html_content="";
						  	}
						    if (sf_html_content!="") sf_html=sf_html+sf_html_content;
					  	}

			            if (sf_html!="") {
	                       sf_html=sf_html_title+sf_html+'';
                        }

						if (sf_html=="" && sf_temp[3]=="Y") {
		          			sf_html="";//AdSense Code
			          	}
					break;
						        	    						        	    
					// 廣告種類 1CM_home_725x305_B_pc
					case "1CM_home_725x305_B_pc":
					// 廣告種類 1CM_home_725x305_B_mo
					case "1CM_home_725x305_B_mo":
						sf_html="";
						sf_html_title='';
						for (sf_idx_j=0; sf_idx_j<sf_temp[1]; sf_idx_j++) {
							if (sf_k < sf_zsr_count) {
							    (sf_idx_j==(sf_temp[1]-1) || sf_k==sf_zsr_count-1)?this_tyle=" border_rightNone":this_tyle="";
	                            sf_html_content='<div class="like_block'+this_tyle+'">';
								sf_html_content=sf_html_content+'<a target="_blank" href="'+sf_pool[sf_k]["clickurl"]+'">';
	                            sf_html_content=sf_html_content+'<p class="like_blockimg"><img src="http://capture.heartrails.com/300x170/shorten?'+sf_pool[sf_k]["siteHost"]+'/" /></p>';
								sf_html_content=sf_html_content+'</a>';
	                            sf_html_content=sf_html_content+'<p class="like_blockdescription">';
								sf_html_content=sf_html_content+'<a target="_blank" href="'+sf_pool[sf_k]["clickurl"]+'">'+sf_pool[sf_k]["title"].replace("'","\'").replace(change_keyword, '<span style="color:'+keyword_color+'">'+change_keyword+'</span>')+'<br /><span class="sf_300_s">'+sf_pool[sf_k]["description"].replace(change_keyword, '<span style="color:'+keyword_color+'">'+change_keyword+'</span>')+'</span><br /><span class="sf_300_w">'+sf_pool[sf_k]["siteHost"]+'</span>';
								if(sf_list_str!="") {
								   sf_html_content=sf_html_content+'<br /><span class="sf_300_logo">'+sf_list_str+sf_chk_flag+'</span>';
								}
								sf_html_content=sf_html_content+'</a>';
								sf_html_content=sf_html_content+'</p>';
								sf_html_content=sf_html_content+'</div>';
		                    	sf_k++;
			                } else {
			                	sf_html_content="";
						  	}
						    if (sf_html_content!="") sf_html=sf_html+sf_html_content;
					  	}

			            if (sf_html!="") {
	                       sf_html=sf_html_title+sf_html+'';
                        }

						if (sf_html=="" && sf_temp[3]=="Y") {
		          			sf_html="";//AdSense Code
			          	}
					break;
						        	    						        	    
					// 廣告種類 1CM_article_720x90(320x120)_end
					case "1CM_article_720x90(320x120)_end":
						sf_html="";
						sf_html_title='<div id="sf_728npv12_bg">';
						for (sf_idx_j=0; sf_idx_j<sf_temp[1]; sf_idx_j++) {
							if (sf_k < sf_zsr_count) {
	                            sf_html_content='<a target="_blank" href="'+sf_pool[sf_k]["clickurl"]+'">';
								sf_html_content=sf_html_content+'<div class="sf_728npv12_tagbg">';
								sf_html_content=sf_html_content+'<div class="sf_728npv12_box">';
								sf_html_content=sf_html_content+'<div class="sf_728npv12_tit">'+sf_pool[sf_k]["title"].replace("'","\'").replace(change_keyword, '<span style="color:'+keyword_color+'">'+change_keyword+'</span>')+'</div>';
	                            sf_html_content=sf_html_content+'<div class="sf_728npv12_s">'+sf_pool[sf_k]["description"].replace(change_keyword, '<span style="color:'+keyword_color+'">'+change_keyword+'</span>')+'</div>';
	                            sf_html_content=sf_html_content+'<div class="sf_728npv12_w">'+sf_pool[sf_k]["siteHost"]+'</div>';
								sf_html_content=sf_html_content+'</div>';
								sf_html_content=sf_html_content+'<div class="CLEAR_sf"></div>';
								sf_html_content=sf_html_content+'</div>';
								sf_html_content=sf_html_content+'</a>';
								if(sf_list_str!="") {
								   sf_html_content=sf_html_content+'<div class="sf_728npv12_logo">'+sf_list_str+sf_chk_flag+'</div>';
								}
		                    	sf_k++;
			                } else {
			                	sf_html_content="";
						  	}
						    if (sf_html_content!="") sf_html=sf_html+sf_html_content;
					  	}

			            if (sf_html!="") {
	                       sf_html=sf_html_title+sf_html+'</div>';
                        }

						if (sf_html=="" && sf_temp[3]=="Y") {
		          			sf_html="";//AdSense Code
			          	}
					break;
						        	    						        	    
					// 廣告種類 1CM_article_338x260(320x300)_readL
					case "1CM_article_338x260(320x300)_readL":
						sf_html="";
						sf_html_title='';
						for (sf_idx_j=0; sf_idx_j<sf_temp[1]; sf_idx_j++) {
							if (sf_k < sf_zsr_count) {
	                            sf_html_content='<div class="recommendRead_block">';
								sf_html_content=sf_html_content+'<div class="recommendRead_img">';
								sf_html_content=sf_html_content+'<a target="_blank" href="'+sf_pool[sf_k]["clickurl"]+'">';
								sf_html_content=sf_html_content+'<img src="http://capture.heartrails.com/300x170/shorten?'+sf_pool[sf_k]["siteHost"]+'/" alt="">';
	                            sf_html_content=sf_html_content+'</a>';
								sf_html_content=sf_html_content+'</div>';
								sf_html_content=sf_html_content+'<div class="recommendRead_description">';
								sf_html_content=sf_html_content+'<a style="font-size:12px;" target="_blank" href="'+sf_pool[sf_k]["clickurl"]+'">'+sf_pool[sf_k]["title"].replace("'","\'").replace(change_keyword, '<span style="color:'+keyword_color+'">'+change_keyword+'</span>')+'／'+sf_pool[sf_k]["description"].replace(change_keyword, '<span style="color:'+keyword_color+'">'+change_keyword+'</span>')+'／'+sf_pool[sf_k]["siteHost"];
								if(sf_list_str!="") {
								   sf_html_content=sf_html_content+'&nbsp;&nbsp;'+sf_list_str+sf_chk_flag;
								}
								sf_html_content=sf_html_content+'</a>';
								sf_html_content=sf_html_content+'</div>';
								sf_html_content=sf_html_content+'</div>';
		                    	sf_k++;
			                } else {
			                	sf_html_content="";
						  	}
						    if (sf_html_content!="") sf_html=sf_html+sf_html_content;
					  	}

			            if (sf_html!="") {
	                       sf_html=sf_html_title+sf_html+'';
                        }

						if (sf_html=="" && sf_temp[3]=="Y") {
		          			sf_html="";//AdSense Code
			          	}
					break;
						        	    						        	    
					// 廣告種類 1CM_landingpage
					case "1CM_landingpage":
						this_style='';
						sf_html="";
						sf_html_title='<div class="content_sectionL content_sectionL_in" id="content_sectionL">';
						sf_html_title=sf_html_title+'<div class="search_tit">'+decodeURIComponent(sf_getadquery)+'</div>';
                        if(sf_list_str!="") {
						  sf_html_title=sf_html_title+'<p style="float: right; color: #cccccc; font-size: 12px; margin: 3px;">'+sf_list_str+sf_chk_flag+'</p>';
		                }
						sf_html_title=sf_html_title+'<ul class="media-list ysmad" style="clear: both;padding-left:0;">';
						for (sf_idx_j=0; sf_idx_j<sf_temp[1]; sf_idx_j++) {
							if (sf_k < sf_zsr_count) {
                                (sf_idx_j % 2==0)?this_style=' on':this_style='';
								sf_html_content='<li class="media'+this_style+'">';
	                            sf_html_content=sf_html_content+'<a class="pull-left" target="_blank" href="'+sf_pool[sf_k]["clickurl"]+'">';
								sf_html_content=sf_html_content+'<img class="media-object" src="http://capture.heartrails.com/120x120/shorten?'+sf_pool[sf_k]["siteHost"]+'/">';
								sf_html_content=sf_html_content+'</a>';
								sf_html_content=sf_html_content+'<div class="media-body">';
								sf_html_content=sf_html_content+'<h4 class="media-heading"><a target="_blank" href="'+sf_pool[sf_k]["clickurl"]+'">'+sf_pool[sf_k]["title"].replace("'","\'").replace(change_keyword, '<span style="color:'+keyword_color+'">'+change_keyword+'</span>')+'</a></h4>';
								sf_html_content=sf_html_content+'<p>'+sf_pool[sf_k]["description"].replace(change_keyword, '<span style="color:'+keyword_color+'">'+change_keyword+'</span>')+'</p>';
								sf_html_content=sf_html_content+'<span>'+sf_pool[sf_k]["siteHost"]+'</span>';
								sf_html_content=sf_html_content+'</div>';
								sf_html_content=sf_html_content+'</li>';
		                    	sf_k++;
			                } else {
			                	sf_html_content="";
						  	}
						    if (sf_html_content!="") sf_html=sf_html+sf_html_content;
					  	}

			            if (sf_html!="") {
	                        sf_html=sf_html_title+sf_html+'</ul>';
	                        sf_html=sf_html+'</div>';
                        }

						if (sf_html=="" && sf_temp[3]=="Y") {
		          			sf_html="";//AdSense Code
			          	}
					break;
						        	    						        	    
	            	default:
	            		sf_html="no";
		            break;
		        }
	    	} else {
	    		sf_html="";
		    }
			jQuery("div[data]").eq(sf_ads_idx).html(sf_html);
		}
	    eval(sf_html_script);
	}
}

function sf_change1(mk,sf_idx_j,obj) {
  for (var i=0;i<sf_idx_j;i++) {
	  if (document.getElementById(obj+"_ad1_"+i+"_"+mk).style.display=="block") {
		 document.getElementById(obj+"_ad1_"+i+"_"+mk).style.display="none";
		 document.getElementById(obj+"_ad2_"+i+"_"+mk).style.display="block";
	  } else {
		 document.getElementById(obj+"_ad1_"+i+"_"+mk).style.display="block";
		 document.getElementById(obj+"_ad2_"+i+"_"+mk).style.display="none";
	  }
  }
}

function showpage(tmpn,val,pagenum) {
  var topage=val;
  for (var i=1;i<20;i++) {
	  if (document.getElementById("topage"+i)) document.getElementById("topage"+i).style.display="none";
  }
  document.getElementById("topage"+val).style.display="";
  getpage(tmpn,val,pagenum);
}

function getpage(tmpn,topage,pagenum) {
  var page_html="";
  var page_left_html="";
  var page_right_html="";

  for (var j=1;j<=pagenum;j++) {
	  (j==topage)?page_html=page_html + "<span class='current'>" + j + "</span>":page_html=page_html + "<a href=\'javascript:showpage(" + tmpn + "," + j + "," + pagenum + ")\'>" + j + "</a>";
  }

  if (topage==1 && pagenum>1) {
	  page_right_html="<a href=\'javascript:showpage(" + tmpn + "," + (parseInt(topage)+1) + "," + pagenum + ")\'>&gt;</a><a href=\'javascript:showpage(" + tmpn + "," + pagenum + "," + pagenum + ")\'>&gt;&gt;</a>";
  } else if (topage>1 && topage<pagenum) {
	  page_right_html="<a href=\'javascript:showpage(" + tmpn + "," + (parseInt(topage)+1) + "," + pagenum + ")\'>&gt;</a><a href=\'javascript:showpage(" + tmpn + "," + pagenum + "," + pagenum + ")\'>&gt;&gt;</a>";
	  page_left_html="<a href=\'javascript:showpage(" + tmpn + ",1," + pagenum + ")\'>&lt;&lt;</a><a href=\'javascript:showpage(" + tmpn + "," + (parseInt(topage)-1) + "," + pagenum + ")\'>&lt;</a>";
  } else if (topage>1 && topage==pagenum) {
	  page_left_html="<a href=\'javascript:showpage(" + tmpn + ",1," + pagenum + ")\'>&lt;&lt;</a><a href=\'javascript:showpage(" + tmpn + "," + (parseInt(topage)-1) + "," + pagenum + ")\'>&lt;</a>";
  }

  page_html=page_left_html + page_html + page_right_html;
  document.getElementById("news_nav").innerHTML=page_html;
}
