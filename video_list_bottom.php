
		<div class="infinte_list">
			<!--mobilebox-->
			<div class="mobilebox">
			  <!--mad-->
			  <div class="mad">
				<a href="#">
				  <img src="images/banner/622x98.gif" width="622" height="98" />
				</a>
			  </div>
			  <!--twobo-->
			  <div class="twobox">
				<?php
				  $i = 0;
				  foreach($rows_news as $row_news){
					if($i < 6)
					{
				?>
					<div class="box220 listbox <?php if($i == 0) echo 'mright';?>">
					  <!--newbox-->
					  <div class="newbox">
						<div class="n_pic">
						  <a href="video_detail.php?nid=<?php echo $row_news["news_id"];?>">
							<img src="<?php echo $web_path_news,"sl",$row_news["news_banner"];?>" width="220" height="180">
						  </a>
						</div>
						<div class="n_data">
						  <ul>
							<li class="n_title">
								<a href="video_detail.php?nid=<?php echo $row_news["news_id"];?>">
									<?php echo tc_left(strip_tags($row_news["news_title"]), 30); ?>
								</a>
							</li>
							<li class="n_time"><span class="mic mday"></span>
								<?php 
									echo "20";
									echo date("y/m/d",strtotime($row_news["news_createtime"]));
									echo "&nbsp;&nbsp;";
									echo $row_news["admin_cname"];
								?>
							</li>
						  </ul>
						</div>
					  </div>
					</div>
				<?php
					}
					$i++;
				  }
				?>
			  </div>
			</div>
			<!----vedio03---->
			<div class="vedio03">
				<?php
					$i = 0;
					foreach($rows_news as $row_news)
					{
				?>
						<!----vnews---->
						<div class="vnews02 <?php if($i % 3 < 2) echo 'mr mr02';?>">
							<!--newbox-->
							<div class="newbox">
								<div class="n_pic">
									<a href="video_detail.php?nid=<?php echo $row_news["news_id"];?>">
										<img src="<?php echo $web_path_news,"s",$row_news["news_banner"];?>" width="340" height="240">
									</a>
								</div>
								<div class="n_data">
									<ul>
										<li class="n_title01"><a href="video_detail.php?nid=<?php echo $row_news["news_id"];?>"><?php echo tc_left(strip_tags($row_news["news_title"]),30);?></a></li>			
										<li class="n_word"><?php echo tc_left(strip_tags($row_news["news_content"]),70);?></li>
										<li class="more"><a href="video_detail.php?nid=<?php echo $row_news["news_id"];?>">Learn more<span class="ic arror"></span></a></li>
										<li class="n_time"><span class="ic day"></span><span class="mic mday"></span>
											<?php 
												echo "20";
												echo date("y/m/d",strtotime($row_news["news_createtime"]));
												echo "&nbsp;&nbsp;";
												echo $row_news["admin_cname"];
											?>
											<span class="sharefb">  
												<div class="fb-share-button" data-href="http://1cm.life/video_detail.php?nid=<?php echo $row_news["news_id"]; ?>" data-layout="button"></div>
												<div class="fb-like" data-href="http://1cm.life/video_detail.php?nid=<?php echo $row_news["news_id"]; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
											</span>
										</li>
			
									</ul>
								</div>
							</div>
						</div>
					<?php
						$i++;
					}
					?>
			</div>
		</div>