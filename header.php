<?php $href = ""; ?>
<script type="text/javascript">
		$(function() {
			$('nav#menu2').mmenu({
				extensions: ["border-full"],
				footer: {
				   add: true,
				   content: "1cm.life"
				},
				"offCanvas": {
                  "zposition": "next"
				}
			 });
			$("nav#menu2").removeClass('hidden-mobile'); 
		});
		$(document).ready(function() {
			$(".popupBox-close").hide();
			$("#popupBox").hide();
			//$("#popupBox").removeClass('hidden-mobile');
			popupDiv("popupBox");
		
		});
	</script>
<div class="visible-mobile">
	<nav id="menu2" class="hidden-mobile">
		<ul>
			<?php
				foreach($rows_newt as $row_newt){
			?>
				<li>
					<a align="center" href="<?php if($row_newt["newsType_id"] == 10) echo "video_list";else echo $href."news";?>.php?ntid=<?php echo $row_newt["newsType_id"];?>">
						<?php echo $row_newt["newsType_Cname"]; ?>
					</a>
				</li>
			<?php
				}
			?>
			<li>
				<a align="center" href="#my-page">關閉列表</a>
			</li>
		</ul>
	</nav>
</div>
<div id="popupBox" class="hidden-mobile hidden-tablet hidden-desktop">
	<div class="popupBox-close">
		<img src="images/mask_closebtn.png" onclick="hideDiv('popupBox');">
	</div>
	<?php /*if(isset($adv["18"])){echo $adv["18"];}*/?>
	<!-- 1CM_mobile_320x480_inter -->
	<div class="popupBox-Ad" align = "center">
		<div id='div-gpt-ad-1427868067692-0'>
		<script type='text/javascript'>
		googletag.cmd.push(function() { googletag.display('div-gpt-ad-1427868067692-0'); });
		</script>
		</div>
	</div>
</div>

		<div id="header">
			<div class="head">
				<div class="phone_icon mic mmenu"><a href="#menu2">MENU</a></div>
				<div class="phone_logo mic mlogo"><a href="<?php echo $href; ?>index.php">1cm life</a></div>
				<div class="phone_icon_fb ic fb"><a href="<?php echo $web_fb_url;?>">facebook</a></div>
				<div class="phone_icon_ig ic instagram"><a href="http://instagram.com/1cm.life">instagram</a></div>

				<div class="logo ic blogo"><a href="<?php echo $href; ?>index.php">1cm life</a></div>
				<div class="rigth_icon">
				  <ul>
					<li class="ic fb"><a href="<?php echo $web_fb_url;?>" target="_blank">FB</a></li>
					<li class="ic instagram"><a href="http://instagram.com/1cm.life" target="_blank">Instagram</a></li>
					<li class="ic email"><a href="#">E-mail</a></li>
					<li class="searchbar"><span class="ic search"><input name="" type="text" class="input_s" id="search" name="search" value="search"></span><p class="btn" id="search_btn" onClick="search_nv()"></p></li>
				  </ul>
				</div>
			</div>
		</div>
		<div class="clear_both"></div>
		<div id="menu_header">
			<div class="buall">
				<ul>
					<?php
						foreach($rows_newt as $row_newt){
					?>
						<li>
							<a <?php if($ntid == $row_newt["newsType_id"]) echo "class='selected'"; ?> href="<?php if($row_newt["newsType_id"] == 10) echo "video_list";else echo "news";?>.php?ntid=<?php echo $row_newt["newsType_id"];?>">
								<div class="name"><?php echo $row_newt["newsType_Cname"]; ?></div>
								<div class="arror"></div>
							</a>
						</li>
					<?php
						}
					?>
				</ul>
			</div>
		</div>
<div class="clear_both"></div>