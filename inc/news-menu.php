<div class="side-nav"><?php
	/*$top5news = array();
	$result1 = getTopNewsForDisplay(0, 1, 0, NULL, 5);
	while($row1=mysql_fetch_array($result1, MYSQL_ASSOC))	{ 
		$top5news["id"][]     		= $row1["id"];
		$top5news["title"][]     	= $row1["title"];
		$top5news["seo_url"][]		= $row1["seo_page_name"];
	}
	if(count($top5news["id"])>0){
		echo "<ul>";
		for($p=0; $p<count($top5news["id"]); $p++){
			echo "<li><a href='".$site_path."latest-news/".$top5news["seo_url"][$p]."'>".$top5news["title"][$p]."</a></li>";
		}
		echo "</ul>";
	}*/
	//echo "<p><a href='".$site_path."archived-news'>View Archived News &gt;&gt;</a></p>";
	//the below code is for a generic menu on all News type pages
	echo "<ul>";
	$resNewsMenus = array();
	$newsMenus = getNewsTypes();
	while($resNewsMenus = mysql_fetch_array($newsMenus, MYSQL_ASSOC)){
		//if(strtolower($resNewsMenus["id"])!=4){
			echo "<li><i class='icon-chevron-right'></i> <a href='".$site_path."news/".strtolower(str_replace(" ","-",$resNewsMenus["category"]))."'>".$resNewsMenus["category"]."</a></li>";	
		//}
	}
	echo "</ul>";
?></div>