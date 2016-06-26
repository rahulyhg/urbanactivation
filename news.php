<?php	
	$err = FALSE;
	$errMessage = "The latest news you are trying to access does not exist. Please click on the left navigation options for more information.";	
	$title = "Latest News - ".(isset($_REQUEST["title"])?str_replace("-"," ",ucwords($_REQUEST["title"]))." - ":"")." Urban Activation";
	$page = "news";
	require_once("inc/head.php"); ?>
    <style type="text/css" media="all">
		.shareButtons {float: right;left: 520px;position: absolute;top: 19px;width: 250px;}
		.fb_share_size_Small { position: relative; top: -6px; }
	</style>
    <!-- content section -->
    <div id="content" class="content-inside">
    	<div id="col-left" class="opacity">
<h2>LATEST NEWS</h2>
    	<?php
		if(isset($_REQUEST["title"]) && isset($_REQUEST["cat"])){
			$validCatID = (int)getNewsCatIDFromNewsTitle(trim($_REQUEST["cat"]));
			if($validCatID>0){
				$newsID = (int)getNewsIDFromNewsTitle(trim($_REQUEST["title"]));
				if($newsID>0){
					$news_result = getTopNewsForDisplay($newsID, 1, 0, NULL, NULL);
					$news = array();
					while($news = mysql_fetch_array($news_result, MYSQL_ASSOC)){
						$nID 		= $news["id"];
						$nTitle 	= $news["title"];
						$nContent	= str_replace("<img", "<img id='mobile-image-hide'", $news["body"]);
					}
					if(isset($nID)){
						echo "<h1>".$nTitle."</h1>";
						echo "<span class='shareButtons'><iframe src='//www.facebook.com/plugins/like.php?href=http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."%2F&amp;send=false&amp;layout=button_count&amp;width=120&amp;show_faces=false&amp;action=recommend&amp;colorscheme=light&amp;font=tahoma&amp;height=21' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:120px; height:21px;' allowTransparency='true'></iframe>&nbsp;<a href='https://twitter.com/share' class='twitter-share-button' data-via='UrbanPropertyAu' data-related='UrbanPropertyAu' data-count='none'>Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='//platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','twitter-wjs');</script></span>";
						echo $nContent;
						echo "<p><a href='javascript: window.history.go(-1);' title='Go Back'  class='sml'>&laquo; GO BACK</a><p>";
					} else {
						echo "<h2>Error!!</h2>"	;
						echo $errMessage;
					}
				} else {
					echo "<h2>Error!!</h2>"	;
					echo $errMessage;
				}
			} else {
				echo "<h2>Error!!</h2>"	;
				echo $errMessage;
			}
		} elseif(!isset($_REQUEST["title"]) && isset($_REQUEST["cat"])){
			$validCatID = (int)getNewsCatIDFromNewsTitle(trim($_REQUEST["cat"]));
			if($validCatID>0){
				$news_result = getAllNewsItems(0,$validCatID,0);
				$news = array();
				while($news = mysql_fetch_array($news_result, MYSQL_ASSOC)){
					$news_list["id"][] 			= $news["id"];
					$news_list["title"][] 		= $news["title"];
					$news_list["shortDesc"][] 	= $news["shortDescription"];
					$news_list["url"][] 		= $news["seo_page_name"];
					$news_list["cat"][] 		= $news["category"];
				}
				if(isset($news_list["id"])){
					for($n=0;$n<count($news_list["id"]);$n++){
						echo "<a href='".$site_path."news/".strtolower(str_replace(" ","-",$news_list["cat"][$n]))."/".$news_list["url"][$n]."' title='".$news_list["title"][$n]."'><div class='arrow'></div></a>";
						echo "<h3>".$news_list["title"][$n]."</h3>";
						echo $news_list["shortDesc"][$n];
						echo "<br><a href='".$site_path."news/".strtolower(str_replace(" ","-",$news_list["cat"][$n]))."/".$news_list["url"][$n]."' title='".$news_list["title"][$n]."' class='sml'>READ MORE &raquo;</a><hr>";
					}
					echo "<p>&nbsp;</p><p><a href='".$site_path."archived-news' class='sml'>VIEW ARCHIVED NEWS &raquo;</a></p>";
				} else {
					echo "<h2>Error!!</h2>"	;
					echo $errMessage;
				}
			} else {
				echo "<h2>Error!!</h2>"	;
				echo $errMessage;	
			}		
		} else {
			$news_result = getAllNewsItems(0,1,0);
			$news = array();
			while($news = mysql_fetch_array($news_result, MYSQL_ASSOC)){
				$news_list["id"][] 			= $news["id"];
				$news_list["title"][] 		= $news["title"];
				$news_list["shortDesc"][] 	= $news["shortDescription"];
				$news_list["url"][] 		= $news["seo_page_name"];
				$news_list["cat"][] 		= $news["category"];
			}
			if(isset($news_list["id"])){
				for($n=0;$n<count($news_list["id"]);$n++){
					echo "<a href='".$site_path."news/".strtolower(str_replace(" ","-",$news_list["cat"][$n]))."/".$news_list["url"][$n]."' title='".$news_list["title"][$n]."'><div class='arrow'></div></a>";
					echo "<h3>".$news_list["title"][$n]."</h3>";
					
					echo $news_list["shortDesc"][$n];
					
					echo "<br><a href='".$site_path."news/".strtolower(str_replace(" ","-",$news_list["cat"][$n]))."/".$news_list["url"][$n]."' title='".$news_list["title"][$n]."' class='sml'>READ MORE &raquo;</a><hr>";
				}
				echo "<p>&nbsp;</p><p><a href='".$site_path."archived-news' class='sml'>VIEW ARCHIVED NEWS &raquo;</a></p>";
			} else {
				echo "<h2>Error!!</h2>"	;
				echo $errMessage;
			}
		}
		?>
  		</div>
<div id="col-right" class="opacity">   

            <?php include("inc/news-menu.php");?>

        </div>     
        
	</div>
<?php include("inc/foot.php"); ?>