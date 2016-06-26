<div class="side-nav"><?php
if(count($sub_pages["id"])>0){
	echo "<h2>".strtoupper($sub_pages["category"][0])."</h2>";
	echo "<ul>";
	if($sub_pages["cat_id"][0]==6) echo "<li><a href='".$site_path."contact'>Contact</a></li>";
	for($p=0; $p<count($sub_pages["id"]); $p++){
		echo "<li><i class='icon-chevron-right'></i> <a href='".$site_path."pages/".$sub_pages["seo_cat_name"][$p]."/".$sub_pages["seo_url"][$p]."'>".$sub_pages["title"][$p]."</a></li>";
	}
	/*if($sub_pages["cat_id"][0]==1) echo "<li><a href='".$site_path."testimonials'>Testimonials</a></li>";*/
	echo "</ul>";
}
?></div>