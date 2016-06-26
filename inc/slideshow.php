<?php 
	// select the featured properties to display on the home page
	$err = false;	// if set to 'true' then the deafult properties will always display
	$properties_result = getPropertiesForSearch(NULL, 'all', 0, 0, 0, 0, 1, '0, 5');
	$properties = array(); $property_details = array();
	if(count($properties_result)<=0) {
		$err = true;
	} else {
		while($properties = mysql_fetch_array($properties_result, MYSQL_ASSOC)){
			$property_details['id'][]			= $properties['id'];
			$property_details['title'][]		= $properties['title'];
			//$property_details['category_id'][]	= $properties['category_id'];
			$property_details['url'][]			= $properties['seo_page_name'];
			$property_details['img'][]			= getPropFeatureImageURL($properties['id']);
			//$property_details['suburb'][]		= $properties['suburb'];
			//$property_details['state'][]		= $properties['state'];
			//$property_details['shortDesc'][]	= $properties['shortDescription'];
			//$property_details['dispPrice'][]	= $properties['displayPrice'];
			//$property_details['price'][]		= $properties['price'];
			//$property_details['rent'][]			= $properties['rent'];
			//$property_details['minPrice'][]		= $properties['priceRangeMin'];
			//$property_details['maxPrice'][]		= $properties['priceRangeMax'];
			//$property_details['beds'][]			= $properties['numBedrooms'];
			//$property_details['baths'][]		= $properties['numBathrooms'];
			//$property_details['parking'][]		= $properties['numParking'];
			//$property_details['googleMap'][]	= $properties['googleMap'];
			//$property_details['GMLat'][]		= $properties['GMLat'];
			//$property_details['GMLng'][]		= $properties['GMLng'];
			//$property_details['sales_stat_id'][]= $properties['sales_status_id'];
			//$property_details['thumbnailURL'][]	= getPropFeatureThumbnailURL($properties['id']);
		}
	}
?>
<!-- Slideshow Cycle http://jquery.malsup.com/cycle/-->
<script type="text/javascript" src="<?php echo $site_path;?>js/jquery.cycle.all.js"></script>


<script type="text/javascript">


$(function() {
        $('#bigPhoto').cycle({ 
		random: 1,
       delay: 2000,
	   speed: 1000,
       fx: 'scrollRight',
	   //fx: 'fade',
	   pager:  '#ss-nav',
		slideExpr: 'img',
	   after:     function() {
            $('#caption').html(this.alt);
        }
    
    });
}); 

</script>

<style type="text/css">
/*Slideshow Text*/
	

#bigPhoto {z-index: 1;
			position: relative;
			width: 705px;
			height: 360px;
			overflow: hidden; }
	
			
#bigPhoto img {
				display: block;
				width: 705px;
				height: 360px; }
				
.slideshow a { display: block; width: 705; height: 360; top: 0; left: 0 }
#caption {color: #fff;
	font-size: 14px;
	margin: 330px 0 0 0px;
	padding: 5px 20px 3px 20px;
	position: absolute;

	z-index: 50;
	text-align: left;
	width: auto;
	height: 22px;
	background-color: #000; opacity: .8;
	text-transform:uppercase;
	min-width: 285px;}
	
#ss-nav {  z-index: 200; position: absolute; bottom: 10px; right: 35px }
#ss-nav a { float: left; margin: 0 4px; padding: 0px 2px; border-radius: 10px; color: #555; background: #555; text-decoration: none; font-size: 9px; line-height: 11px; }
#ss-nav a.activeSlide { color: #fff; background: #fff; }
#ss-nav a:focus { outline: none; }		

</style>
<div id="caption"></div>
		
		<div id="bigPhoto" class="slideshow">
        <div id="ss-nav"></div>
<?php	if($err) {	// display default properties (error in sql) ?>
            <a href="<?php echo $site_path;?>property/yarra-house-south-yarra"><img src="<?php echo $site_path;?>images/yarra.jpg" width="705" height="360" border="0" alt="Yarra House, South Yarra" ></a>			
            <a href="<?php echo $site_path;?>property/indigo-ripponlea"><img src="<?php echo $site_path;?>images/indigo.jpg" width="705" height="360" border="0" alt="Indigo, Ripponlea" ></a>
            <a href="<?php echo $site_path;?>property/the-clifton-prahran"><img src="<?php echo $site_path;?>images/clifton.jpg" width="705" height="360" border="0" alt="The Clifton, Prahran" ></a>		
<?php	} else {	// display featured properties
			for($i=0;$i<count($property_details['id']);$i++){
				echo "<a href='".$site_path."property/".$property_details['url'][$i]."'><img src='".$site_path."dreamcms/app/webroot/uploads/properties/".$property_details['img'][$i]."' width='705px' height='360px' border='0' alt='".$property_details['title'][$i]."'></a>";
			}
		} ?>
		</div>
        
        


