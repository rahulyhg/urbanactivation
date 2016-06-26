<?php	
	$title = "Property Management | Apartments | Townhouses | Melbourne | Urban Activation";
	$page = "index";
	require_once("inc/head.php"); ?>
    


  <!-- content section -->

<div id="content">


<div id="slideshow">
<div class="panel opacity"></div>
<div class="panel-txt">
<h1> Featured Properties for Sale</h1>
<?php include("inc/slideshow.php"); ?>
</div>
</div>

<?php include("side-contact.php"); ?>

<div style="clear: both; height: 0;" ></div>
<div class="news-panel opacity" style="margin: 20px 10px 0 0;">
<h2>LATEST NEWS</h2>
<?php
	$isLatestNews = false;
	$latestNews = array();
	$resultNews = getTopNewsForHome(NULL,1);
	while($latestNews = mysql_fetch_array($resultNews, MYSQL_ASSOC)){
		echo "<p><strong><a href='".$site_path."news/".strtolower(str_replace(" ","-",$latestNews["category"]))."/".$latestNews["seo_page_name"]."'>".$latestNews["title"]."</a></strong><br />".$latestNews["shortDescription"]."</p>";
		echo "<div >
  				<ul><li><a href='".$site_path."news/".strtolower(str_replace(" ","-",$latestNews["category"]))."/".$latestNews["seo_page_name"]."'>READ MORE</a></li></ul></div>";
		$isLatestNews = true;
	} 
	if(!$isLatestNews){
		echo "<p>There are no News articles currently. Please check back later.</p>";	
	}
?>

<h2>QUICK LINKS</h2>
<a href="<?php echo $site_path;?>/dreamcms/app/webroot/files/files/UA Tenancy Application Form 1_1.pdf" target="_blank">Tenancy Application Form &raquo;</a><br />
<a href="<?php echo $site_path;?>/dreamcms/app/webroot/files/files/UA Notice to Vacate 1_1.pdf" target="_blank">Notice to Vacate &raquo;</a>

</div>
<div class="col panel opacity" style="width: 665px; margin-right: 0; min-height: 380px;">
<div class="arrow-txt">
<h2>PROFESSIONAL PROPERTY MANAGEMENT</h2>
<p>Whether you have one or more properties you want them to be managed as if they were your own. A professional Property Manager is assigned to your property and will get to know your property as intimately as you do, sometimes more so. Maximise return and maintain the property....</p>
</div>
<a href="<?php echo $site_path;?>pages/property-management/overview"><div class="arrow">
</div></a>

<div class="arrow-txt" style="border: none;">
<h2>WHAT MAKES URBAN ACTIVATION DIFFERENT?</h2>
<p>Urban Activation is a Melbourne based property management company sourcing quality rental properties across Melbourne. We specialise in apartments, townhouses and studios, and have access to selected new developments as they settle...</p>
</div>
<a href="<?php echo $site_path;?>pages/about/about-urban-activation"><div class="arrow">
</div></a>

<div class="arrow-txt">
<h2>INVESTMENT PROPERTIES</h2>
<p>Urban Activation has alliances with a selected property developers in Melbourne, which in turn enables us to have access to apartments as they settle. We also have some apartments for sale...</p>
</div>
<a href="<?php echo $site_path;?>property-search/0/0/0/0/all"><div class="arrow">
</div></a>


</div>

</div>
<?php include("inc/foot.php"); ?>