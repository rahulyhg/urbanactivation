<?php
	$page = "properties";
	$keywords = "Urban Activation, Investment Properties, property for sale, apartments, off the plan";
	$description = "Urban Activation - Property List, Investment Properties";
	$title = "Urban Activation - Properties List | Investment Properties";
	$err = false;
	$errString = "Sorry, no properties for sale were found for your search query. Please try again.";
	include("inc/connection.php");
	if(isset($_GET['region'])){
		$reg_id = getPropRegIDByRegURL(trim($_GET['region']));
		if($reg_id>0){
			$properties_result = getProperties(NULL,4,$reg_id,NULL,NULL,NULL,NULL);
		} else {
			$err = false;	
		}
	} else {
		$properties_result = getProperties(NULL,4,NULL,NULL,NULL,NULL,NULL);
	}
	if(count($properties_result)<=0) $err = true;
	$properties = array();$property_details = array();
	include("inc/head.php");
?>
    <div id="content" class="content-inside">
    	<div id="col-left">
        <div class="panel opacity">
        <div id="property-list-head">
          <div style="float:left;"><h1>Property Search</h1></div>
  
        	<div id="prop-tabs" style="float:right;">
                <ul class="nav">
                    <li class="nav-one"><a href="#properties-list" class="current">For Sale</a></li>
                    <li class="nav-two"><a href="#prop-on-map">Show on Map</a></li>
            	</ul>   
        <?php
			if ($err) {
				echo "<div id='property-list' class='err-pic'>$errString</div>";
			} else {				
				while($properties = mysql_fetch_array($properties_result, MYSQL_ASSOC)){
					$property_details['id'][]			= $properties['id'];
					$property_details['title'][]		= $properties['title'];
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
				if(count($property_details['id'])>0){?>
                </div></div><div style="clear:both;">
                <div class="list-wrap">
                	<div id="properties-list">
                		<div id="paging_container" class="container">
                            <div id="results">
                                <div class="info_text"></div>
                                <div class="page_navigation"></div> 
                            </div>       
                            <div id="properties" class="content">
		<?php				$mapsScript = "";
							for($i=0;$i<count($property_details['id']);$i++){
								echo "<!-- start individual property listing -->
									<div id='property-list'>
									<div id='property-list-img'><a href='".$site_path."property/".$property_details['url'][$i]."'><img src='".$site_path."dreamcms/app/webroot/uploads/properties/".(strlen($property_details['thumbnailURL'][$i]>0)?$property_details['thumbnailURL'][$i]:"blank.jpg")."' style='width: 100%;height:160px;'/></a></div>
										<div id='property-list-body'><div id='property-list-title'>".$property_details['title'][$i]."<!--, ".$property_details['suburb'][$i]." ".$property_details['state'][$i]."--></div>
										<div id='property-list-txt'>".$property_details['shortDesc'][$i]."</div></div>
										
										   
										<div id='property-list-links'>
											<div id='property-list-more'>
												<div class='btn-more'>
													<a href='".$site_path."property/".$property_details['url'][$i]."'>MORE </a>
												</div>
											</div>
											<div id='property-list-price'>".(($property_details['dispPrice'][$i]==1 && strlen($property_details['price'][$i])>0)? $property_details['price'][$i] :"")."</div>
										</div>    
									</div>
									<!-- end individual property listing -->";
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
											content: contentStructure(\"".$property_details['title'][$i]."\", \"".$property_details['shortDesc'][$i]."\", \"".$site_path."dreamcms/app/webroot/uploads/properties/".(strlen($property_details['thumbnailURL'][$i]>0)?$propety_details['thumbnailURL'][$i]:"blank.jpg")."\", \"".$site_path."property/".$property_details['url'][$i]."\", \"".(((int)$property_details['sales_stat_id'][$i]==7)?"True":"False")."\")
										});
										markerBounds.extend(propertyMarker[".$i."].getPosition());
										";
									}
							}
							?>
                    		</div>
                            <br clear="all" />
                            <div class="info_text" style="display:none;"></div>
                            <div class="page_navigation" style="display:none;"></div>
                		</div>
					</div>
                    <div id="prop-on-map" class="hide">
                    	<!-- Google Maps Listing Starts Here -->
                        <div id="map_canvas" style="width:630px; height:400px; margin-bottom:15px; border:1px solid #DDDDDD;"></div>               
                        <!-- Google Maps Listing Ends Here -->
                    </div>
                </div>
			</div>
		<?php	} else {
					echo "<div id='property-list' class='err-pic'>$errString</div>";
				}
			}
		?>
    </div>
    </div>
<?php include("side-contact.php"); ?>
</div>
<?php include("map.php");?>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		
		//pagination
		$('#paging_container').pajinate({
			num_page_links_to_display : 2,
			items_per_page : 10	
		});
		//content tabs
		$("#prop-tabs").organicTabs();
	});
</script>
<?php include("inc/foot.php"); ?>