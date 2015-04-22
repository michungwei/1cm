	<!--右邊區塊right-->
		<div id="rightbar">
			<!--按讚-->
			<!--<div class="graybox">
				<a href="https://www.facebook.com/pages/1cm/761735067202346">
				<div class="addfb">
					<div class="ic slogo">1cm life</div>
					<p><font color="black">加入粉絲團</font></p>
				</div>
				</a>
				<div class="addlike">
					<div class="fb-like" data-href="https://www.facebook.com/1cmLife" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>
				</div>
			</div>-->
			<!--ad-->
			<div class="subtitle-advtiseR hidden-mobile">
				<p class="title hidden-tablet">按下讚與我們一起探索知識的無窮！</p>
				<p class="title visible-tablet">按下讚探索知識的無窮！</p>
				<iframe class="visible-tablet" src="//www.facebook.com/plugins/like.php?href=https://www.facebook.com/1cmlifemag&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="margin-left:30%; border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>

				<iframe class="top-right-fb-like-button fb_iframe_widget hidden-tablet" src="//www.facebook.com/plugins/like.php?href=<?php echo $web_fb_url;?>&amp;locale=en_US&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
			</div>
			<div class="ad">
			<?php if(isset($adv["18"])){echo $adv["18"];}?>
			</div>
			<!--1cm人氣排行-->
			<div class="popular">
			<p><span class="ic slogo02"></span>人氣排行</p>
			 <div class="plist scroll-pane">
			  <ul>
				<?php
					foreach( $rows_hotnews as $row_hotnews )
					{
				?>
						<li><a href="news_detail.php?nid=<?php echo $row_hotnews["news_id"];?>"><?php echo $row_hotnews["news_title"];?></a></li>
				<?php
					}
				?>
			  </ul>
			  </div>
			</div>
			<!--ad-->
			<!--<div class="subtitle-advtiseR hidden-mobile">
				<p class="title hidden-tablet">按下讚與我們一起探索知識的無窮！</p>
				<p class="title visible-tablet">按下讚探索知識的無窮！</p>
				<iframe class="visible-tablet" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="margin-left:30%; border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>

				<iframe class="top-right-fb-like-button fb_iframe_widget hidden-tablet" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;locale=en_US&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
			</div>-->
			<div class="ad"><a href="http://instagram.com/1cm.life"><img src="images/banner/is300x90.png"></a></div>
			<!--newbox-->
			<?php
				foreach($rows_rnews as $row_rnews){
			?>
				<div class="newbox">
					<div class="n_pic">
						<a href="news_detail.php?nid=<?php echo $row_rnews["news_id"];?>">
							<img src="<?php echo $web_path_news,"s",$row_rnews["news_banner"];?>" width="300" height="168">
						</a>
					</div>
					<div class="n_data">
						<ul>
							<li class="n_title01"><a href="news_detail.php?nid=<?php echo $row_rnews["news_id"];?>"><?php echo $row_rnews["news_title"];?></a></li>			
							<!--<li class="n_word"><?php/* echo tc_left(strip_tags($row_news["news_content"]),85) */?></li>-->
							<li class="n_time"><span class="ic day"></span><span class="mic mday"></span>
								<?php 
									echo "20";
									echo date("y/m/d",strtotime($row_rnews["news_createtime"]));
									echo "&nbsp;&nbsp;";
									//echo $row_rnews["admin_cname"];
								?>
							</li>
						</ul>
					</div>
				</div>
			<?php
				}
			?>
			<div class="ad">
			<?php if(isset($adv["13"])){echo $adv["13"];}?>
			</div>
		<!--rightbar EDN-->
		</div>