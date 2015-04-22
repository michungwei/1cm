(function() {
	function sf_hk_async_load(){
        var sf_hk_header = document.getElementsByTagName('head')[0];
        if(!document.getElementById("sfysmstyle")) {
	        var sf_hk_css = document.createElement('link');
	        sf_hk_css.id = "sfysmstyle";
			sf_hk_css.type = 'text/css'; 
			sf_hk_css.async = true; 
			sf_hk_css.href = "/ysm/1cm/sfysmstyle.css"; 
			sf_hk_css.rel = 'stylesheet'; 
			sf_hk_header.appendChild(sf_hk_css);
		}
    	if(!window.jQuery) {
    		var sf_hk_js = document.createElement('script');
	        sf_hk_js.type = 'text/javascript'; 
        	sf_hk_js.async = true; 
	        sf_hk_js.src = 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'; 
    	    sf_hk_js.onload = sf_hk_init;
			//ie6, 7
			sf_hk_js.onreadystatechange = function() {if(this.readyState == 'complete'||this.readyState == 'loaded') {sf_hk_init();}}
    	    sf_hk_header.appendChild(sf_hk_js);
    	}else {
    		sf_hk_init();
    	}
    }
    if(window.attachEvent) {
    	window.attachEvent('onload', function(res) {sf_hk_async_load();});
    } else {
    	window.addEventListener('load', function(res) {sf_hk_async_load();}, false);
    }
})();

var sf_hk_datas=[];
var sf_hk_data_count;
var script_str='';

function sf_hk_init() {
	sf_hk_data_count = jQuery("div[hkdata]").length;

	jQuery("div[hkdata]").each(function() {
		var kid = jQuery(this).attr('kid');
		var getad = jQuery(this).attr('hkdata');
		var sfid=jQuery("div[hkdata]").index(jQuery(this));
		var getadhkcount = jQuery(this).attr('hkcount');
		var getadfill = jQuery(this).attr('adfill');
		if(kid==null) {kid="212";}
		if(getadfill==null) getadfill="N";
		getadhkcount = parseInt(getadhkcount);
		var temp=getad.split(",");
		for(var kk=0;kk<temp.length;kk++) {if(temp[kk]!="1CM_all_1103x40_marquee1" && temp[kk]!="landingpage_right_hk_1" && temp[kk]!="landingpage_right_hk_2" && temp[kk]!="landingpage_right_hk_3" && temp[kk]!="landingpage_right_hk_4" && temp[kk]!="landingpage_right_hk_5" && temp[kk]!="landingpage_right_hk_6" && temp[kk]!="landingpage_right_hk_7") {getadhkcount = 0; break;}}
		var getkid=kid;
		var hkcount=getadhkcount;
		var getkid_array=getkid.split(',');
		var getad_array=getad.split(',');
		var getkid_array_count=getkid_array.length;
		var getad_array_count=getad_array.length;
		if(getkid_array_count==1) {
			getkid=parseInt(getkid_array[0]);
			if(getad_array_count==1) {
				getad=getad_array[0];
			} else {
				rand_res=array_rand(getad_array, 1); getad=getad_array[rand_res];
			}
		} else {
			rand_res=array_rand(getkid_array, 1);
			getkid=parseInt(getkid_array[rand_res]);
			if(getad_array_count==1) {
				getad=getad_array[0]; 
			} else {
				if(rand_res>=getad_array_count) {getad=getad_array[getad_array_count-1];} else {getad=getad_array[rand_res];}
			}
		}
		jQuery.get('keywords_hk'+getkid+'.txt', {}, function(res) {
			getsfhkwords(res.split(/\n/), getad, hkcount, sfid);	
		    if(script_str!="") eval(script_str);
		});
	});
}

function getsfhkwords(sfhks, getad, hkcount, sfid) {
	var sf_hk_tmp={'res':sfhks, 'getad':getad, 'hkcount':hkcount, 'sfid':sfid};
	sf_hk_datas.push(sf_hk_tmp);
	if(sf_hk_datas.length==sf_hk_data_count) {
		//console.log(sf_hk_datas);
		for(sf_hk_idx=0;sf_hk_idx<sf_hk_datas.length;sf_hk_idx++) {
			var tmp_sf_hk_data=sf_hk_datas[sf_hk_idx];
			showHotKeywords(tmp_sf_hk_data.res, tmp_sf_hk_data.getad, tmp_sf_hk_data.hkcount, tmp_sf_hk_data.sfid);			
		}
	}
}

function showHotKeywords(res, getad, hkcount, sfid) {
	gettitle=res[0];
	new_list_key = new Array();
	new_search_key = new Array();
	res.shift();
	res_count=res.length;
	if(res_count>=hkcount) {list_count=hkcount;}else{list_count=res_count;}
	rand_res=array_rand(res, list_count);
	for(sf_hk_i=0;sf_hk_i<rand_res.length;sf_hk_i++) {
		list_key='';
		search_key='';
		if(res[rand_res[sf_hk_i]]&&res[rand_res[sf_hk_i]]!='') {
			res[rand_res[sf_hk_i]]=res[rand_res[sf_hk_i]].replace("/[\n\r\t]/", "");
			if(res[rand_res[sf_hk_i]].indexOf('-')>=0) {
				tmps=res[rand_res[sf_hk_i]].split('-');
				list_key=tmps[1];
				search_key=tmps[0];
			} else {
				list_key=res[rand_res[sf_hk_i]];
				search_key=res[rand_res[sf_hk_i]];
			}
			new_list_key.push(list_key);
			new_search_key.push(search_key);
		}
	}
	if(list_count>0) {
		html=getsfhkbody(getad, new_list_key, new_search_key);
		jQuery("div[hkdata]").eq(sfid).after(html);
	}
}

function getsfhkbody(getad, new_list_key, new_search_key) {
	html='';
	switch(getad) {		
		case "1CM_all_1103x40_marquee1":
			var border_style="";
			this_style="";
			html='<div id="sf_fix_bottom">';
			html=html+'<h2 id="sf_ysm_title"><span class="center">熱門</span></h2>';
			html=html+'<div id="sf_ysm_list">';
			html=html+'<ul id="sf_sf_ysm_list_in">';
			if(new_list_key.length>0) {
				for(sf_hk_s=0;sf_hk_s<new_list_key.length;sf_hk_s++) {
				    html=html+'<li><a href="/ysm/1cm/site.html?keyword='+new_search_key[sf_hk_s]+'" target="_blank">'+new_list_key[sf_hk_s]+'</a></li>';
				}
				script_str="jQuery(document).ready(function () {change_width();y_srcollAd();});";
				script_str=script_str+"jQuery(window).resize(function () {change_width();});";
			}
			html=html+'</ul>';
			html=html+'</div>';
			html=html+'</div>';
		break;
		
		case "landingpage_right_hk_1":
			html='<div class="right-tag">';
			html=html+'<div class="tag-header TH_bg1">';
			html=html+'<div style="float:left">'+gettitle+'</div>';
			html=html+'<div style="float:right">';
			html=html+'<a href="/ysm/1cm/site.html?keyword='+gettitle+'">more</a>';
			html=html+'</div>';
			html=html+'</div>';
			html=html+'<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			html=html+'<tbody>';
			html=html+'<tr>';
			html=html+'<td valign="top" class="TK_color1">';
			if(new_list_key.length>0) {
				for(sf_hk_s=0;sf_hk_s<new_list_key.length;sf_hk_s++) {
				    html=html+'<div class="tag_keyword">●&nbsp;<a href="/ysm/1cm/site.html?keyword='+new_search_key[sf_hk_s]+'"\>'+new_list_key[sf_hk_s]+'</a></div>';
				}
			}
			html=html+'</td>';
			html=html+'</tr>';
			html=html+'</tbody>';
			html=html+'</table>';
			html=html+'</div>';
		break;
		
		case "landingpage_right_hk_2":
			html='<div class="right-tag">';
			html=html+'<div class="tag-header TH_bg2">';
			html=html+'<div style="float:left">'+gettitle+'</div>';
			html=html+'<div style="float:right">';
			html=html+'<a href="/ysm/1cm/site.html?keyword='+gettitle+'">more</a>';
			html=html+'</div>';
			html=html+'</div>';
			html=html+'<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			html=html+'<tbody>';
			html=html+'<tr>';
			html=html+'<td valign="top" class="TK_color2">';
			if(new_list_key.length>0) {
				for(sf_hk_s=0;sf_hk_s<new_list_key.length;sf_hk_s++) {
				    html=html+'<div class="tag_keyword">●&nbsp;<a href="/ysm/1cm/site.html?keyword='+new_search_key[sf_hk_s]+'">'+new_list_key[sf_hk_s]+'</a></div>';
				}
			}
			html=html+'</td>';
			html=html+'</tr>';
			html=html+'</tbody>';
			html=html+'</table>';
			html=html+'</div>';
		break;
		
		case "landingpage_right_hk_3":
			html='<div class="right-tag">';
			html=html+'<div class="tag-header TH_bg3">';
			html=html+'<div style="float:left">'+gettitle+'</div>';
			html=html+'<div style="float:right">';
			html=html+'<a href="/ysm/1cm/site.html?keyword='+gettitle+'">more</a>';
			html=html+'</div>';
			html=html+'</div>';
			html=html+'<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			html=html+'<tbody>';
			html=html+'<tr>';
			html=html+'<td valign="top" class="TK_color3">';
			if(new_list_key.length>0) {
				for(sf_hk_s=0;sf_hk_s<new_list_key.length;sf_hk_s++) {
				    html=html+'<div class="tag_keyword">●&nbsp;<a href="/ysm/1cm/site.html?keyword='+new_search_key[sf_hk_s]+'">'+new_list_key[sf_hk_s]+'</a></div>';
				}
			}
			html=html+'</td>';
			html=html+'</tr>';
			html=html+'</tbody>';
			html=html+'</table>';
			html=html+'</div>';
		break;
		
		case "landingpage_right_hk_4":
			html='<div class="right-tag">';
			html=html+'<div class="tag-header TH_bg4">';
			html=html+'<div style="float:left">'+gettitle+'</div>';
			html=html+'<div style="float:right">';
			html=html+'<a href="/ysm/1cm/site.html?keyword='+gettitle+'">more</a>';
			html=html+'</div>';
			html=html+'</div>';
			html=html+'<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			html=html+'<tbody>';
			html=html+'<tr>';
			html=html+'<td valign="top" class="TK_color4">';
			if(new_list_key.length>0) {
				for(sf_hk_s=0;sf_hk_s<new_list_key.length;sf_hk_s++) {
				    html=html+'<div class="tag_keyword">●&nbsp;<a href="/ysm/1cm/site.html?keyword='+new_search_key[sf_hk_s]+'">'+new_list_key[sf_hk_s]+'</a></div>';
				}
			}
			html=html+'</td>';
			html=html+'</tr>';
			html=html+'</tbody>';
			html=html+'</table>';
			html=html+'</div>';
		break;
		
		case "landingpage_right_hk_5":
			html='<div class="right-tag">';
			html=html+'<div class="tag-header TH_bg5">';
			html=html+'<div style="float:left">'+gettitle+'</div>';
			html=html+'<div style="float:right">';
			html=html+'<a href="/ysm/1cm/site.html?keyword='+gettitle+'">more</a>';
			html=html+'</div>';
			html=html+'</div>';
			html=html+'<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			html=html+'<tbody>';
			html=html+'<tr>';
			html=html+'<td valign="top" class="TK_color5">';
			if(new_list_key.length>0) {
				for(sf_hk_s=0;sf_hk_s<new_list_key.length;sf_hk_s++) {
				    html=html+'<div class="tag_keyword">●&nbsp;<a href="/ysm/1cm/site.html?keyword='+new_search_key[sf_hk_s]+'">'+new_list_key[sf_hk_s]+'</a></div>';
				}
			}
			html=html+'</td>';
			html=html+'</tr>';
			html=html+'</tbody>';
			html=html+'</table>';
			html=html+'</div>';
		break;
		
		case "landingpage_right_hk_6":
			html='<div class="right-tag">';
			html=html+'<div class="tag-header TH_bg6">';
			html=html+'<div style="float:left">'+gettitle+'</div>';
			html=html+'<div style="float:right">';
			html=html+'<a href="/ysm/1cm/site.html?keyword='+gettitle+'">more</a>';
			html=html+'</div>';
			html=html+'</div>';
			html=html+'<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			html=html+'<tbody>';
			html=html+'<tr>';
			html=html+'<td valign="top" class="TK_color6">';
			if(new_list_key.length>0) {
				for(sf_hk_s=0;sf_hk_s<new_list_key.length;sf_hk_s++) {
				    html=html+'<div class="tag_keyword">●&nbsp;<a href="/ysm/1cm/site.html?keyword='+new_search_key[sf_hk_s]+'">'+new_list_key[sf_hk_s]+'</a></div>';
				}
			}
			html=html+'</td>';
			html=html+'</tr>';
			html=html+'</tbody>';
			html=html+'</table>';
			html=html+'</div>';
		break;
		
		case "landingpage_right_hk_7":
			html='<div class="right-tag">';
			html=html+'<div class="tag-header TH_bg7">';
			html=html+'<div style="float:left">'+gettitle+'</div>';
			html=html+'<div style="float:right">';
			html=html+'<a href="/ysm/1cm/site.html?keyword='+gettitle+'">more</a>';
			html=html+'</div>';
			html=html+'</div>';
			html=html+'<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			html=html+'<tbody>';
			html=html+'<tr>';
			html=html+'<td valign="top" class="TK_color7">';
			if(new_list_key.length>0) {
				for(sf_hk_s=0;sf_hk_s<new_list_key.length;sf_hk_s++) {
				    html=html+'<div class="tag_keyword">●&nbsp;<a href="/ysm/1cm/site.html?keyword='+new_search_key[sf_hk_s]+'">'+new_list_key[sf_hk_s]+'</a></div>';
				}
			}
			html=html+'</td>';
			html=html+'</tr>';
			html=html+'</tbody>';
			html=html+'</table>';
			html=html+'</div>';
		break;
	}
	return html;
}

function array_rand(input, num_req) {
	var indexes = [];
	var ticks = num_req || 1;
	var checkDuplicate = function(input, value) {
		var exist = false, index = 0, il = input.length;
		while (index < il) {
			if (input[index] === value) {exist = true; break;}
			index++;
		}
		return exist;
	};	
	if (Object.prototype.toString.call(input) === '[object Array]' && ticks <= input.length) {
    	while (true) {
    		var rand = Math.floor((Math.random() * input.length));
    		if (indexes.length === ticks) {break;}
    		if (!checkDuplicate(indexes, rand)) {indexes.push(rand);}
    	}
    } else {
    	indexes = null;
	}
	return ((ticks == 1) ? indexes.join() : indexes);
}

function y_srcollAd(){
	var obj = jQuery("#sf_sf_ysm_list_in"),
		prevObj = jQuery("#sf_ysm_list"),
		marqueeli = obj.append(obj.html()).children(),
		neweidth=0,
		speed = 30,
		autoScrollAd,
		scrollad = function(){
		if(prevObj.scrollLeft()==neweidth/2){
			prevObj.scrollLeft(0);
		}else{
			prevObj.scrollLeft(prevObj.scrollLeft()+1);
		}
	};

	obj.find("li").each(function(){neweidth+=jQuery(this).width()+21;});
	obj.css("width",neweidth);


	setTimeout(function(){
		autoScrollAd = setInterval(scrollad, speed);
		prevObj.hover(function() {
			clearInterval(autoScrollAd);
		}, function() {
			autoScrollAd = setInterval(scrollad , speed);
		});
	}, 1000);
}

function change_width(){
	var obj = jQuery("#sf_fix_bottom");
	obj.css("width",jQuery(window).width()-150);
	obj.css("margin-left",-(jQuery(window).width()-150)/2);
}
