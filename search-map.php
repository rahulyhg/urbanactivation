<?php 
	$page = "properties";
	$keywords = "Urban Activation, property listings, property search, property map";
	$description = "Urban Activation - Property Search Map";
	$title = "Urban Activation - Property Search Map";
	$err = false;
	$errString = "Sorry, no properties were found for your search query. Please try again.";
	@include("inc/connection.php");

	$property_idArray = explode("-",$_REQUEST["id"]);
	foreach($property_idArray as $id) {
		$properties_result = getPropertyDetails($id);
		if($properties = mysql_fetch_array($properties_result, MYSQL_ASSOC)){

				$property_details['id'][]			= $properties['id'];
				$property_details['title'][]		= $properties['title'];
				$property_details['category_id'][]	= $properties['category_id'];
				$property_details['url'][]			= $properties['seo_page_name'];
				$property_details['suburb'][]		= $properties['suburb'];
				$property_details['state'][]		= $properties['state'];
				$property_details['shortDesc'][]	= preg_replace('/(&.+?)+(;)/i', '', $properties['shortDescription']); // remove any html replaced characters eg:  &lgt;
//				$property_details['dispPrice'][]	= $properties['displayPrice'];
//				$property_details['price'][]		= $properties['price'];
//				$property_details['rent'][]			= $properties['rent'];
//				$property_details['minPrice'][]		= $properties['priceRangeMin'];
//				$property_details['maxPrice'][]		= $properties['priceRangeMax'];
//				$property_details['beds'][]			= $properties['numBedrooms'];
//				$property_details['baths'][]		= $properties['numBathrooms'];
//				$property_details['parking'][]		= $properties['numParking'];
//				$property_details['googleMap'][]	= $properties['googleMap'];
				$property_details['GMLat'][]		= $properties['GMLat'];
				$property_details['GMLng'][]		= $properties['GMLng'];
				$property_details['sales_stat_id'][]= $properties['sales_status_id'];
				$property_details['thumbnailURL'][]	= getPropFeatureThumbnailURL($properties['id']);

		}
	} 
	
	$mapsScript = "";
	for($i=0;$i<count($property_details['id']);$i++){
		if($property_details['GMLat'][$i]!=0 && $property_details['GMLng'][$i]!=0){
			$mapsScript = $mapsScript."
			propertyMarker[".$i."] = new google.maps.Marker({
				position: new google.maps.LatLng(".$property_details['GMLat'][$i].", ".$property_details['GMLng'][$i]."),
				map: map,
				icon: house".(((int)$property_details['sales_stat_id'][$i]==7)?"Sold":"")."Image,
				shadow: houseShadow,
				title: '".$property_details['title'][$i]."',
				zIndex: ".$i."
			});
			google.maps.event.addListener(propertyMarker[".$i."], 'click', function() {
				".((count($property_details['id'])>1)?"infowindow[document.selectedInfoWindow].close();":"")."
				infowindow[".$i."].open(map,propertyMarker[".$i."]);
				document.selectedInfoWindow = ".$i.";
			});
			infowindow[".$i."] = new google.maps.InfoWindow({
				content: contentStructure(\"".$property_details['title'][$i]."\", \"".$property_details['shortDesc'][$i]."\", \"".$site_path."dreamcms/app/webroot/uploads/properties/".(strlen($property_details['thumbnailURL'][$i]>0)?$property_details['thumbnailURL'][$i]:"blank.jpg")."\", \"".((int)$property_details['category_id'][$i]==4?"property/":"rental/").$property_details['url'][$i]."\", \"".(((int)$property_details['sales_stat_id'][$i]==7)?"True":"False")."\")
			});
			markerBounds.extend(propertyMarker[".$i."].getPosition());
			";
		} 
		// parent.$.fn.colorbox.close('cancel_cf')
		//content: contentStructure(\"".$property_details['title'][$i]."\", \"".$property_details['shortDesc'][$i]."\", \"".$site_path."dreamcms/app/webroot/uploads/properties/".(strlen($property_details['thumbnailURL'][$i]>0)?$propety_details['thumbnailURL'][$i]:"blank.jpg")."\", \"".$site_path.((int)$property_details['category_id'][$i]==4?"property/":"rental/").$property_details['url'][$i]."\", \"".(((int)$property_details['sales_stat_id'][$i]==7)?"True":"False")."\")
	}
?>
<!DOCTYPE html>
<html>
  <head>
	<title><?php echo $title; ?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta name="keywords" content="<?php echo $keywords;?>">
	<meta name="description" content="<?php echo $description;?>">
	<meta name="author" content="www.echo3.com.au" >
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
	<link href="<?php echo $site_path;?>css/map.css" rel="stylesheet" type="text/css" media="all">
	<link href='http://fonts.googleapis.com/css?family=Sintony:400,700' rel='stylesheet' type='text/css' media="all">
    <style>
      html, body, #map-canvas {
        margin: 0;
        padding: 0;
        height: 100%;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<?php //include("map.php");?>

    <script>
		document.selectedInfoWindow = 1;
		var map;
//		function closeForm(option) {
//			//alert(option);
//			parent.$.fn.colorbox.close(option);
//		}

		function initialize() {
			var latlng = new google.maps.LatLng(-25.324167,135.791016); // center of Australia
			var mapOptions = {
			zoom: 10,
			center: latlng,
			mapTypeControl: true,
			mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
			navigationControl: true,
			navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
			mapTypeId: google.maps.MapTypeId.ROADMAP};

			/*var mapOptions = {
				zoom: 8,
				center: new google.maps.LatLng(-34.397, 150.644),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};*/
			map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		  
			var houseImage = new google.maps.MarkerImage('<?=$site_path?>images/house.png',
				new google.maps.Size(50,50),
				new google.maps.Point(0,0),
				new google.maps.Point(50,50)
			);
			
			var houseSoldImage = new google.maps.MarkerImage('<?=$site_path?>images/house_sold.png',
				new google.maps.Size(50,50),
				new google.maps.Point(0,0),
				new google.maps.Point(50,50)
			);
	
			var houseShadow = new google.maps.MarkerImage('<?=$site_path?>images/house_shadow.png',
				new google.maps.Size(70,50),
				new google.maps.Point(0,0),
				new google.maps.Point(60, 50)
			);

			var propertyMarker = new Array();
			var infowindow  = new Array();
			var markerBounds = new google.maps.LatLngBounds(); // create map boundaries
			
			<?php echo $mapsScript;?>
			
			map.fitBounds(markerBounds); // set map center and zoom to fit
	
			google.maps.event.addListener(map, 'tilesloaded', function() {
				if (map.getZoom()>15) map.setZoom(15); // pan out for best map view
				google.maps.event.clearListeners(map, 'tilesloaded');  // do not reuse listerner
			});
						
			google.maps.event.addListener(map, 'click', function() {
				infowindow[document.selectedInfoWindow].close();
				map.panToBounds(markerBounds); // set map center and zoom to fit
			});
	
			//function contentStructure(title, desc, image, pid, sold) {
			function contentStructure(title, desc, image, seo, sold) {
				c = '<div id="content" style="width:280px; height:180px; overflow:hidden">'+
					'<h2 id="firstHeading" class="firstHeading">'+title+'</h2>'+
					'<div id="bodyContent; overflow:hidden; width:340px">'+
					'<p style="white-space:normal; overflow:hidden">'+
						'<img src="'+image+'" align="left" style="width:90px; margin-right:10px" />';
				if(sold=="True") c = c +	'<strong style="color:#DD0000">SOLD</strong><br>';
				c = c + desc+'... <a href="javascript:void(0);" onClick="parent.$.fn.colorbox.close(\''+seo+'\')" title="'+title+'">more...</a></p>'+
					'</div>'+
					'</div>';
				return (c);
			}
		}
		
		google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>

<?php /*
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta name="keywords" content="<?php echo $keywords;?>">
<meta name="description" content="<?php echo $description;?>">
<meta name="author" content="www.echo3.com.au" >
<meta name="robots" content="all" >
<meta name="google-site-verification" content="IGnB5afif0EXWBd5NkmTcrJ_1RURBB6BoPxVitFAzS0" >
<link rel="shortcut icon" href="/favicon.ico" >
<link rel="apple-touch-icon" href="/apple-icon.png" >
<meta name = "viewport" content = "user-scalable=0, initial-scale=1.0, maximum-scale=1.0, width=device-width" >
<meta name="apple-mobile-web-app-capable" content="yes">
<META HTTP-EQUIV='CACHE-CONTROL' CONTENT='MAX-AGE=864000, must-revalidate' >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
</head>
<body>
<?php
			$property_idArray = explode("-",$_REQUEST["id"]);
			foreach($property_idArray as $id) {
				$properties_result = getPropertyDetails($id);
				if($properties = mysql_fetch_array($properties_result, MYSQL_ASSOC)){

						$property_details['id'][]			= $properties['id'];
						$property_details['title'][]		= $properties['title'];
						$property_details['category_id'][]	= $properties['category_id'];
						$property_details['url'][]			= $properties['seo_page_name'];
						$property_details['suburb'][]		= $properties['suburb'];
						$property_details['state'][]		= $properties['state'];
						$property_details['shortDesc'][]	= $properties['shortDescription'];
						$property_details['dispPrice'][]	= $properties['displayPrice'];
						$property_details['price'][]		= $properties['price'];
						$property_details['rent'][]			= $properties['rent'];
						$property_details['minPrice'][]		= $properties['priceRangeMin'];
						$property_details['maxPrice'][]		= $properties['priceRangeMax'];
						$property_details['beds'][]			= $properties['numBedrooms'];
						$property_details['baths'][]		= $properties['numBathrooms'];
						$property_details['parking'][]		= $properties['numParking'];
						$property_details['googleMap'][]	= $properties['googleMap'];
						$property_details['GMLat'][]		= $properties['GMLat'];
						$property_details['GMLng'][]		= $properties['GMLng'];
						$property_details['sales_stat_id'][]= $properties['sales_status_id'];
						$property_details['thumbnailURL'][]	= getPropFeatureThumbnailURL($properties['id']);

				}
			} 
			
			$mapsScript = "";
			for($i=0;$i<count($property_details['id']);$i++){
				if($property_details['GMLat'][$i]!=0 && $property_details['GMLng'][$i]!=0){
					$mapsScript = $mapsScript."
					propertyMarker[".$i."] = new google.maps.Marker({
						position: new google.maps.LatLng(".$property_details['GMLat'][$i].", ".$property_details['GMLng'][$i]."),
						map: map,
						icon: house".(((int)$property_details['sales_stat_id'][$i]==7)?"Sold":"")."Image,
						shadow: houseShadow,
						title: '".$property_details['title'][$i]."',
						zIndex: ".$i."
					});
					google.maps.event.addListener(propertyMarker[".$i."], 'click', function() {
						infowindow[document.selectedInfoWindow].close();
						infowindow[".$i."].open(map,propertyMarker[".$i."]);
						document.selectedInfoWindow = ".$i.";
					});
					infowindow[".$i."] = new google.maps.InfoWindow({
						content: contentStructure(\"".$property_details['title'][$i]."\", \"".$property_details['shortDesc'][$i]."\", \"".$site_path."dreamcms/app/webroot/uploads/properties/".(strlen($property_details['thumbnailURL'][$i]>0)?$propety_details['thumbnailURL'][$i]:"blank.jpg")."\", \"".$site_path.((int)$property_details['category_id'][$i]==4?"property/":"rental/").$property_details['url'][$i]."\", \"".(((int)$property_details['sales_stat_id'][$i]==7)?"True":"False")."\")
					});
					markerBounds.extend(propertyMarker[".$i."].getPosition());
					";
				}
			}
?>
  
            <!-- Google Maps Listing Starts Here -->
            <!--<style> img { max-width: none; height: auto }</style>-->
            <div id="map_canvas" style="width:703px; height:400px; margin-bottom:15px; border:1px solid #DDDDDD;"></div>               
            <!-- Google Maps Listing Ends Here -->

	<?php include("map.php");?>
</body>
</html>  */ ?>