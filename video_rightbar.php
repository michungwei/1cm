	<!--右邊區塊right-->
	<div id="rightbar">
		<!--按讚-->
		<div class="subtitle-advtiseR hidden-mobile">
				<p class="title hidden-tablet">按下讚與我們一起探索知識的無窮！</p>
				<p class="title visible-tablet">按下讚探索知識的無窮！</p>
				<iframe class="visible-tablet" src="//www.facebook.com/plugins/like.php?href=<?php echo $web_fb_url;?>&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="margin-left:30%; border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>

				<iframe class="top-right-fb-like-button fb_iframe_widget hidden-tablet" src="//www.facebook.com/plugins/like.php?href=<?php echo $web_fb_url;?>&amp;locale=en_US&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
			</div>
		<!--ad-->
		<div class="ad">
		<?php if(isset($adv["18"])){echo $adv["18"];}?>
		</div>
	</div>
	<div class="clear_both"></div>