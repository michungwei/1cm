<!----vbox02---->
			<div class="vedio02">
			<?php
			$i = 0;
			foreach($rows_news_top as $row_news)
			{
				if($i < 3)
				{
			?>
					<?php
					if($i == 0)
					{
					?>
					<!----vbox01左---->
					<div class="vbox01">
						<a href="video_detail.php?nid=<?php echo $row_news["news_id"];?>">
							<div class="vdata">
								<ul>
								  <li class="vtitle"><?php echo tc_left(strip_tags($row_news["news_title"]),20);?></li>
								  <li class="n_time"><span class="ic day_while"></span>												  
								  <?php 
									echo "20";
									echo date("y/m/d",strtotime($row_news["news_createtime"]));
									echo "&nbsp;&nbsp;";
									echo $row_news["admin_cname"];
									?></li>
								</ul>
							</div>
							<div class="vblack"></div>
							<div class="vpic"><img src="<?php echo $web_path_news,"sl",$row_news["news_banner"];?>" width="428" height="400"></div>
						</a>
					</div>
					<!----vbox02右---->
					<div class="vbox02">
					<?php
					}
					?>
					
					<?php
					if($i == 1 || $i == 2)
					{
					?>
						<!--vbox03_300x200-->
						<div class="vbox03">
							<a href="video_detail.php?nid=<?php echo $row_news["news_id"];?>">
								<div class="vdata">
									<ul>
									  <li class="vtitle"><?php echo tc_left(strip_tags($row_news["news_title"]),20);?></li>
									  <li class="n_time"><span class="ic day_while"></span>												  
									  <?php 
										echo "20";
										echo date("y/m/d",strtotime($row_news["news_createtime"]));
										echo "&nbsp;&nbsp;";
										echo $row_news["admin_cname"];
										?></li>
									</ul>
								</div>
								<div class="vblack"></div>
								<div class="vpic"><img src="<?php echo $web_path_news,"s",$row_news["news_banner"];?>" width="300" height="200"></div>
							</a>
						</div>

					<?php
					}
					?>
					
			<?php
				}
				$i++;
			}
			?>
					</div>
			</div>
			<div class="clear_both"></div>