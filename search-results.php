<?php
	$page = "properties";
	$keywords = "Urban Activation, property listings, property search";
	$description = "Urban Activation - Property Search";
	$title = "Urban Activation - Property Search";
	$err = false;
	$errString = "Sorry, no properties were found for your search query. Please try again.";
	include("inc/connection.php");
	if(isset($_GET['ft'])) $ft = mysql_real_escape_string(trim($_GET['ft']));
	if(isset($_GET['pt'])) $pt = (int)$_GET['pt'];
	if(isset($_GET['prl'])) $prl = (float)($_GET['prl'] * 1000);//to match db values
	if(isset($_GET['prh'])) $prh = (float)($_GET['prh'] * 1000);//to match db values
	if(isset($_GET['prs'])) $prs = (int)$_GET['prs'];
	if($prh < $prl) { 
		if($prl==2500000 && $prh==0){
		} else {
			$swap = $prl; $prl = $prh; $prh = $swap; 
		}
	}
	$advancedSearch = false;
// var_dump($_REQUEST);
	// all advanced search items must exist in order to expand and display the advanced search.
	// if they do exist but are all set to 'all' then do not expand the advanced search
	// if the values are not valid then do not display either.
	if(isset($_GET['bed']) && isset($_GET['bth']) && isset($_GET['prk']) && (!(substr($_GET['bed'],0,3)=='all' && substr($_GET['bth'],0,3)=='all' && substr($_GET['prk'],0,3)=='all'))) {
		$advancedSearch = true;
		$bed = explode(",",$_GET['bed']);
		if($bed[0]=='all') { 
			unset($bed); 							// clear any (all) other array elements
			$bed[0] = 'all';						// present only one value
			$advancedSearch = $advancedSearch; 
		} else {
			for($so=0; ($so<count($bed) && $advancedSearch); $so++)	{
				if(!is_numeric($bed[$so]))			// validate all numerical values
				{ $advancedSearch = false;} 		// any value not numeric cancles the advanced search option
			}
		}

		$bth = explode(",",$_GET['bth']);
		if($bth[0]=='all') { 
			unset($bth); 							// clear any (all) other array elements
			$bth[0] = 'all';						// present only one value
			$advancedSearch = $advancedSearch; 
		} else {
			for($so=0; ($so<count($bth) && $advancedSearch); $so++)	{
				if(!is_numeric($bth[$so]))			// validate all numerical values
				{ $advancedSearch = false;} 		// any value not numeric cancles the advanced search option
			}
		}

		$prk = explode(",",$_GET['prk']);
		if($prk[0]=='all') { 
			unset($prk); 							// clear any (all) other array elements
			$prk[0] = 'all';						// present only one value
			$advancedSearch = $advancedSearch; 
		} else {
			for($so=0; ($so<count($prk) && $advancedSearch); $so++)	{
				if(!is_numeric($prk[$so]))			// validate all numerical values
				{ $advancedSearch = false;} 		// any value not numeric cancles the advanced search option
			}
		}
//		$bth = $_GET['bth'];
//		if($bth=='all') 
//			{ $advancedSearch = $advancedSearch; }	// no change to status
//		elseif(is_numeric($_GET['bth'])) 
//			{ $bth = (int)$_GET['bth']; } 
//		else 
//			{ $advancedSearch = false; } 

//		$prk = $_GET['prk'];
//		if($prk=='all') 
//			{ $advancedSearch = $advancedSearch; }	// no change to status
//		elseif(is_numeric($_GET['prk'])) 
//			{ $prk = (int)$_GET['prk']; } 
//		else 
//			{ $advancedSearch = false;} 
	}
        $accessType = 1;        
        if( $agentLoggedIn === true ){
            // agent area
            $accessType = 0;
        }
	$properties_result = getPropertiesForSearch(4,$ft,$pt,$prl,$prh,$prs, $accessType); //(!$advancedSearch)?getPropertiesForSearch(4,$ft,$pt,$prl,$prh,$prs):getPropertiesForSearch(4,$ft,$pt,$prl,$prh,$prs,$bed,$bth,$prk);
	if(count($properties_result)<=0) $err = true;
	$properties = array();$property_details = array();
	if($prl > 0 || $prh > 0) { $prl = $prl/1000; $prh = $prh/1000; }//revert to normal values for ddl
	
        include("inc/head.php");

	if ($_SERVER["SERVER_NAME"]=="echo00"){ ?>	
    	<link rel="stylesheet" type="text/css" href="<?php echo $site_path;?>css/colorbox-local.css" />
<?php } else { ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $site_path;?>css/colorbox.css" />
<?php } ?>	
    <!--<link rel="stylesheet" type="text/css" href="<?php //echo $site_path;?>css/wowslider.css" />-->    
    <script src="<?php echo $site_path;?>js/jquery.colorbox-min.js" type="text/javascript"></script>
    <div id="content" class="content-inside">
    	<div id="col-left">
        <div class="panel opacity">
	<?php	if ($err) {
				echo "<div id='property-list' class='err-pic'>$errString</div>";
			} else {				
				while($properties = mysql_fetch_array($properties_result, MYSQL_ASSOC)){
					$displayProperty = true;
					if($advancedSearch) {
						$propBeds = explode(",", $properties['numBedrooms']);
						//var_dump($propBeds); echo " :: Bed ".count(array_intersect($bed, $propBeds)); //echo "<br>";
						if($bed[0]!='all' && count(array_intersect($bed, $propBeds))==0) $displayProperty = false;
						$propBths = explode(",", $properties['numBathrooms']);
						//var_dump($propBths); echo " :: Bth ".count(array_intersect($bth, $propBths)); //echo "<br>";
						if($bth[0]!='all' && count(array_intersect($bth, $propBths))==0) $displayProperty = false;
						$propPrks = explode(",", $properties['numParking']);
						//var_dump($propPrks); echo " :: Prk ".count(array_intersect($prk, $propPrks)); echo "<br>";
						if($prk[0]!='all' && count(array_intersect($prk, $propPrks))==0) $displayProperty = false;
					}
					if($displayProperty) {
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
						$property_details["map"][]			= $properties['id'];
					}
				} 
				if(isset($property_details["map"][0])) $property_map_queryString = implode("-",$property_details["map"]); ?>
				
  
        <div id="property-list-head">
            <div style="float:left;"><h1>Property Search</h1></div>
            <div id="prop-tabs">
                <ul class="nav">
                    <!--<li class="nav-one"><a href="#properties-list" class="current">For Sale</a></li>-->
                    <?php if(strlen($property_map_queryString)>0) { ?><li class="nav-two"><a href="<?php echo $site_path."property-map/".$property_map_queryString; ?>" class='iframe'>Show on Map</a></li><?php } ?>
                </ul>   
            </div>
        </div>
       <div style="clear:both;">
                <div class="list-wrap">
        <?php	if(count($property_details['id'])>0){ ?>
                	<div id="properties-list" style="position:relative; z-index:3; "><!-- set to ablsolute for map -->
                		<div id="paging_container" class="container" style="position: relative; z-index:3;">
                            <div id="results">
                                <div class="info_text" style="position:relative; top:3px"></div>
                                <div class="page_navigation"></div> 
                            </div>   
                                          <div style="clear:both;"></div>    
                            <div id="properties" class="content">
		<?php				$mapsScript = "";
							for($i=0;$i<count($property_details['id']);$i++){
								echo "<!-- start individual property listing -->
								
									<div id='property-list'>
										<div id='property-list-img'><a href='".$site_path.((int)$property_details['category_id'][$i]==4?"property/":"rental/").$property_details['url'][$i]."'><img src='".$site_path."dreamcms/app/webroot/uploads/properties/".(strlen($property_details['thumbnailURL'][$i]>0)?$property_details['thumbnailURL'][$i]:"blank.jpg")."' style='width: 100%;height:160px;' /></a></div>
										<div id='property-list-body'><div id='property-list-title'>".$property_details['title'][$i]."<!--, ".$property_details['suburb'][$i]." ".$property_details['state'][$i]."--></div>
										<div id='property-list-txt'>".$property_details['shortDesc'][$i]."</div></div>
										<div id='property-list-links'>
											<div id='property-list-price'>".(($property_details['category_id'][$i]==4)?(($property_details['dispPrice'][$i]==1)?$property_details['price'][$i]:""):(($property_details['rent'][$i]>1)?"$".number_format($property_details['rent'][$i])." pw":""))."</div>
											<div id='property-list-more'>
												<div class='btn-more'>
													<a href='".$site_path.((int)$property_details['category_id'][$i]==4?"property/":"rental/").$property_details['url'][$i]."'>MORE <i class='icon-arrow-right'></i></a>
												</div>
											</div>
										</div>    
									</div>
									<!-- end individual property listing -->";
									/*if($property_details['GMLat'][$i]!=0 && $property_details['GMLng'][$i]!=0){
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
									}*/
							}
							// add blank box for odd count
							if(count($property_details['id'])%2==1) {
								echo "<div style='width:50%;height:337px;float:left;overflow:hidden;background-color:#333333'>&nbsp;</div>";
							}
							?>
                    		</div>
                            <br clear="all" />
                            <div style="width:100%; height:30px"></div>
                            <div class="info_text" style="background-color:white; position:relative; top:-25px; margin-left:20px"></div>
   	                        <div class="page_navigation" style="background-color:white; float:right; position:relative; top:-28px"></div>
                		</div>
	                    <div style="position: absolute; z-index:1; height:102px; border:none;">&nbsp;</div>
                        <!--<div style="position: absolute; z-index:1; background-color:white; width:705px; height:102px; border:none;">&nbsp;</div>-->
					</div>
<?php                    /*<div id="prop-on-map" style="position: absolute; z-index:1; display:none;">
                    	<!-- Google Maps Listing Starts Here -->
                        <style> img { max-width: none; height: auto }</style>
                        <div id="map_canvas" style="width:703px; height:400px; margin-bottom:15px; border:1px solid #DDDDDD;"></div>               
                        <!-- Google Maps Listing Ends Here -->
                    </div>
		<?php*/	} else {
					echo "<div id='list-wrap' class='err-pic'>$errString</div>";
				}
			}
		?>
                </div>
			</div>
    	</div>
    </div>
<?php include("side-contact.php"); ?>
</div>
<?php //include("map.php");?>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		//pagination
		$('#paging_container').pajinate({
			num_page_links_to_display : 4,
			items_per_page : 10	
		});
		//content tabs
		//$("#prop-tabs").organicTabs();
		//$("#prop-on-map").css('display', 'none');

		$('.iframe').colorbox({iframe:true, width:"800px", height:"600px"});		//width:"18%", height:"54%"});		// updated as it scalling caused issues on smaller devices such as iPad.
		var cboxClose = $.fn.colorbox.close;
		$.fn.colorbox.close = function(option){ 
			//alert(option);
			//if(!option=="undefined"){
			cboxClose(); // always close, regardless of selection
			if (typeof option != 'undefined') // Any scope
				window.location = '<?php echo $site_path ?>'+option;

		}
	});
	
</script>
<?php include("inc/foot.php"); ?>