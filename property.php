<?php
	include("inc/connection.php");
        include './utility.php';
	$page = "property";
	$err = false; $msgBoxContent = "";
	$errString = "Sorry, the property you are looking for does not exist. Please try another property search.";
	$bulletImages = ""; //preparing the bullets for mobile image gallery
	//$agentLoggedIn = false;
        if(isset($_GET['url'])){
		$pID = getPropertyIDByURL($_GET['url']);
                // update tracking
                if( $agentLoggedIn === true ){
                    if( !isPropertAlreadyVisitedInSession($_SESSION['UA']['visited_properties'], $pID) ){
                    $_SESSION['UA']['visited_properties'] = $_SESSION['UA']['visited_properties'] . $pID . ',';
                    updatePropertyTrackingID($_SESSION['UA']['trackingrowid'], $pID);
                    }
                }
		if($pID>0){
			//property exist
			$property = array();$property_details = array();$property_mob_images=array();$property_images=array();
			$property = getPropertyDetails($pID,4);
			while($property_details_row = mysql_fetch_array($property,MYSQL_ASSOC)){
				$property_details['title'] = $property_details_row['title'];
				$property_details['titleSeo'] = $property_details_row['titleSeo'];
				$property_details['propURL'] = $property_details_row['seo_page_name'];
				$property_details['address'] = $property_details_row['address'];
				$property_details['suburb'] = $property_details_row['suburb'];
				$property_details['state'] = $property_details_row['state'];
				$property_details['keyFeatures'] = $property_details_row['keyFeatures'];
				$property_details['inspections'] = $property_details_row['inspections'];
				if($property_details_row['nras']==1) $property_details['keyFeatures'] .= "<ul><li>NRAS approved property</li></ul>";
				$property_details['body'] = $property_details_row['body'];
				$property_details['displayPrice'] = $property_details_row['displayPrice'];
				$property_details['price'] = $property_details_row['price'];
				$property_details['priceRangeMax'] = $property_details_row['priceRangeMax'];
				$property_details['priceRangeMin'] = $property_details_row['priceRangeMin'];                               
				$property_details['googleMap'] = $property_details_row['googleMap'];
				$property_details['floorPlan'] = $property_details_row['floorPlan'];
				$property_details['brochure'] = trim($property_details_row['brochure']);
				$property_details['bedrooms'] = $property_details_row['numBedrooms'];
				$property_details['bathrooms'] = $property_details_row['numBathrooms'];
				$property_details['carparks'] = $property_details_row['numParking'];
				$property_details['featureImage'] = getPropFeatureImageURL($property_details_row['id']);
				$property_images = getPropAllImagesURL($property_details_row['id'],0);
				$property_mob_images = getPropAllImagesURL($property_details_row['id'],1);
				$msgBoxContent = $property_details_row['title']; //.", ".$property_details_row['suburb']." ".$property_details_row['state'];	
                                // New Fields
                                $property_details['commission_rate'] = $property_details_row['commission_rate'];
                                $property_details['expected_completion_date'] = $property_details_row['expected_completion_date'];
                                $property_details['notes'] = $property_details_row['notes'];
                                $property_details['numofunits'] = $property_details_row['numofunits'];
                                $property_details['numoffloors'] = $property_details_row['numoffloors'];
                                // all docs
                                $property_details['priceList'] = $property_details_row['priceList'];
                                $property_details['contract'] = $property_details_row['contract'];
                                $property_details['reservationform'] = $property_details_row['reservationform'];
                                //$property_details['councilwater'] = $property_details_row['councilwater'];
                                $property_details['depreciation'] = $property_details_row['depreciation'];
                                $property_details['specialdoc'] = $property_details_row['specialdoc'];                                                    
                                $property_details['stratafee'] = $property_details_row['stratafee'];
                                // sort order
                                $property_details['sortingorder'] = $property_details_row['sortingorder']; 
                                $property_details['agent'] = $property_details_row['agent']; 
                                $property_details['agentcontact'] = $property_details_row['agentcontact']; 
                                $property_details['status'] = $property_details_row['status']; 
                                
			}
			$back_link = $_SERVER['HTTP_REFERER'];
		} else {
			$err = true;	
		}				
	} else {
		//no property url given
		$err = true;
	}

	
	$keywords = "Urban Activation";
	$description = "Urban Activation - Property for Sale";
	$title = $property_details['titleSeo'];
	include("inc/head.php");
	
	if ($_SERVER["SERVER_NAME"]=="echo00"){
?>	

    	<link rel="stylesheet" type="text/css" href="<?php echo $site_path;?>css/colorbox-local.css" />
<?php } else { ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $site_path;?>css/colorbox.css" />
<?php } ?>
  <!------------- PDF Viewer ------------->
<link rel="stylesheet" type="text/css" href="<?php echo $site_path;?>css/wowslider.css" />    
<script type="text/javascript" src="<?php echo $site_path;?>js/jquery.colorbox-min.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo $site_path;?>css/jquery-ui.css" ></link>
<script type="text/javascript" src="<?php echo $site_path;?>js/jquery-ui.min.js"></script>
<style>
 .ui-button{   
    display:none;    
}
</style> 

<script type="text/javascript"> 
    $(function() {        
        $(".overlayPDFViewer").click(function (){
        var pdfFilePath = $(this).attr('pdfFilePath');
        var fileName = pdfFilePath.split('/').pop()      
        var w = window.innerWidth -100;
        var h = window.innerHeight - 50;
        var docw = w - 50;
        var doch = h;
        $("#dialogPDFViewer").dialog({
                    modal: true,
                    title: fileName,
                    width: w,
                    height: h,
                    position: {
                my: "center",
                at: "center",
                of: $('#property')
            },
                    buttons: {
                        Close: function () {
                            $(this).dialog('close');
                        }
                    },
                    open: function () {
                        var object = "<object data=\"" + pdfFilePath + "\" type=\"application/pdf\" width=\'" + docw + "\' height=\'" + doch +"\'>";
                        object += "If you are unable to view file, download <a target = \"_blank\" href = \"http://get.adobe.com/reader/\">Adobe PDF Reader</a> to view the file.";
                        object += "</object>";                       
                        $("#dialogPDFViewer").html(object);
                    }
                });
            });
        });
    </script>
     
    <!-------------------END pdf viewer code ------------------>
    <link rel="stylesheet" type="text/css" href="<?php echo $site_path;?>css/wowslider.css" />    
    <script src="<?php echo $site_path;?>js/jquery.colorbox-min.js" type="text/javascript"></script>
    <div id="content" class="content-inside">
    	<div id="col-left" >
        <div class="panel opacity">
        <?php
			if($err){
				echo $errString;	
			} else {
				if(count($property_details)>0){
					//logic for brochure URL
					if(isset($_COOKIE['BrochureContact'])) {
						if(strlen($property_details['brochure'])>0){
							$brochureURL = $site_path."dreamcms/app/webroot/uploads/$pID/brochures/".trim($property_details['brochure']);	
						} else {
							$brochureURL = $site_path."brochure/".trim($property_details['propURL']);
						}
					} else {
						if(strlen($property_details['brochure'])>0){
							$pdf = $site_path."dreamcms/app/webroot/uploads/$pID/brochures/".trim($property_details['brochure']);	
						} else {
							$pdf = $site_path."brochure/".trim($property_details['propURL']);
						}
						$brochureURL = $site_path."brochure-contact.php?pdf=".trim($pdf);
					}
					echo "<!-- start individual property -->
						<div id='property'>
								<div id='property-title'><h1>".$property_details['title']."</h1></div>
                                                                <div id='property-price'>".(($property_details['displayPrice']==1)? $property_details['price'] :"")."</div>
								</div>	
								<!-- start images  -->								
								<div id='property-pics'>
									<div id='normalGallery'><a class='propImages' href='".((strlen($property_details['featureImage'])>0)?$site_path."dreamcms/app/webroot/uploads/properties/".$property_details['featureImage']:'')."' title='".$property_details['title']."'><img src='".((strlen($property_details['featureImage'])>0)?$site_path."dreamcms/app/webroot/uploads/properties/".$property_details['featureImage']:'')."' width='705px' height='400px' border='0'/></a>";
								if(count($property_images['id'])>0){
									echo "<!-- Elastislide Carousel -->
										  <div id='carousel' class='es-carousel-wrapper'><div class='es-carousel'><ul>";
									for($img=0;$img<count($property_images['id']);$img++){
										echo "<li id='tgal' style='background: none; width: auto;'><a class='propImages' href='".$site_path."dreamcms/app/webroot/uploads/properties/".$property_images['files'][$img]."' title='".$property_images['desc'][$img]."'><img src='".$site_path."dreamcms/app/webroot/uploads/properties/".$property_images['thumbs'][$img]."' height='85' class='thumb' border='0'/></a></li>";
									}
									echo "</ul></div></div>";
								}
								echo "</div>";
								if(count($property_mob_images['id'])>0){
									echo "<div id='mobileGallery'>";
									echo "<!-- Start WOWSlider.com BODY section -->
										  <div id='wowslider-container1'>
											<div class='ws_images'><ul>";
									for($image=0;$image<count($property_mob_images['id']);$image++){
										echo "<li><img src='".$site_path."dreamcms/app/webroot/uploads/properties/".$property_mob_images['files'][$image]."' alt='".$property_mob_images['desc'][$image]."' title='".$property_mob_images['desc'][$image]."' id='wows1_".$image."'/></li>";
									}
									echo    "</ul></div>
											<div class='ws_bullets'><div>
										  </div></div>
										  <!-- Generated by WOWSlider.com v2.4 -->
										  <div class='ws_shadow'></div>
										  </div></div>";
								}
											
					echo		"</div>
					
              
					<!-- end images  -->";
				} else {
					echo $errString;	
				}
			}
		?> 
        </div>
<div style="clear: both; height: 0;" ></div>
<!-- features panel -->   
<div id="property-features" class="features-panel opacity" style="width: 285px; padding: 10px!important; margin: 20px 10px 0 0;">
<?php 
//if(count($property_images['id'])>0){
	//$renderBedrooms		= (is_null($property_details['bedrooms']))?											false:true;
	$renderBedrooms		= (is_null($property_details['bedrooms'])  || $property_details['bedrooms']=='0')?		false:true;
	$renderBathrooms	= (is_null($property_details['bathrooms']) || $property_details['bathrooms']=='0')?		false:true;
	$renderCarparks		= (is_null($property_details['carparks'])  || $property_details['carparks']=='0')?		false:true;
	//if($property_details['bedrooms']==0) $property_details['bedrooms']= "Studio";

if( strlen($property_details['keyFeatures'])>0 ){
            echo "<div id='prop-key-features'><h4>Property Features</h4><p> {$property_details['address']}, {$property_details['suburb']} {$property_details['state']}";
            	if($agentLoggedIn === true){
					echo "<div id='prop-details'>";
            		if( $property_details['numofunits'] >  0){
                	echo "<div class='units' title='Units'> {$property_details['numofunits']} Units</div>";
            }
            		if( $property_details['numoffloors'] >  0){
                	echo "<div class='floors' title='Floors'> {$property_details['numoffloors']} Floors</div>";
				
            }
					echo "</div>";
           			 if( !empty($property_details['status']) ){
                	echo "<div class='status'>{$property_details['status']}</div>";
            }
            		if( !empty($property_details['commission_rate']) ){
					$rate = $property_details['commission_rate'] + 0;
					if($rate > 0){
               		echo "<div class='commission'><strong>Commission Rate</strong> (Excluding GST): $rate%</div>";
					}
           }
		   
           }  
           if( !empty($property_details['expected_completion_date']) ){
			   // format mysql date to php date time
			   $phpDateTime = strtotime($property_details['expected_completion_date']);
			   $yy = date('Y', $phpDateTime);
			   $mmyyFormat = date('m-Y', $phpDateTime);
               if($yy > 2000){
			   echo "<div class='completion'><strong>Expected completion date: </strong>$mmyyFormat</div>";
			  }			   
           }
           
		   echo "</div>";
		   
           
            echo "<div id='prop-details'>".
            (($renderBedrooms)?"<div class='beds' title='Bedrooms'> ".updatePropertyDetails($property_details['bedrooms'], true, "Studio")." </div>":"").
            (($renderBathrooms)?"<div class='baths' title='Bathrooms'> ".updatePropertyDetails($property_details['bathrooms'])." </div>":"").
            (($renderCarparks)?"<div class='garage' title='Carparks'> ".updatePropertyDetails($property_details['carparks'])." </div>":"")."</div>
            ".$property_details['keyFeatures']."</p>";
			
        
				if( strlen($property_details['inspections'])>0 ){
   				echo "<div id='prop-key-features'><h4>Inspection Times</h4><p>".str_replace("\n", "<br />", $property_details['inspections'])."</p></div>"; 
		
				}
			//echo "</div>";	
}
//echo "</div>";		

//}
?>
</div>

<!-- description panel -->   
<div id="property-desc" class="col panel opacity" style="width: 360px; padding: 10px!important; margin-right: 0;">
<?php 
if(count($property_images['id'])>0){
echo "<div id='property-desc'>".$property_details['body']."</div>       
        								";
}

function updatePropertyDetails($s, $r=false, $t=NULL) {
	// $r is olny applicable to bedrooms replacing the '0' value with text
	// $t is the text to replace with (if $r is true)
	$pos = strrpos($s, ",");
	if($pos !== false) $s = substr_replace($s, " or ", $pos, 1);
	$s = str_replace(",", ", ", $s);
	if($t) $s = str_replace("0", $t, $s);
	return $s;
	//str_replace("0", "Studio", (str_replace(",", ", ",(strrev((str_replace(",", " or ",(strrev($property_details['bedrooms'])),1)))))));
}
?>
   </div>          
        </div><!-- end left section --> 

<!-- start right section -->

<?php 
if($agentLoggedIn === false){ 
include("side-contact.php");
}
?>

<!-- google map and links panel -->
<div id="property-links" class="col panel opacity" style="width: 285px; margin-right: 0;padding: 10px 20px!important; ">
<?php 
if(count($property_images['id'])>0){
echo "<div id='property-buttons'>";
if($agentLoggedIn === true){
  echo "<a href='#' class='overlayPDFViewer' pdfFilePath='".$site_path."dreamcms/app/webroot/uploads/$pID/brochures/".$property_details['brochure']."'><i class='icon-book'></i> Property Brochure</a><br/>";  
}
else{
echo "<a ".((isset($_COOKIE['BrochureContact']))?"target='_blank'":"class='iframe'")." href='".$brochureURL."'><i class='icon-book'></i> Property Brochure</a><br>"; 									
}
echo ((strlen($property_details['floorPlan'])>0)?"<a href='#' class='overlayPDFViewer' pdfFilePath='".$site_path."dreamcms/app/webroot/uploads/$pID/floorplans/".$property_details['floorPlan']."'><i class='icon-home'></i> Floor Plans</a>
<br>":"");
// agent specific documents
if($agentLoggedIn === true){
echo ((strlen($property_details['contract'])>0)?"<a href='#' class='overlayPDFViewer' pdfFilePath='".$site_path."dreamcms/app/webroot/uploads/$pID/contracts/".$property_details['contract']."'><i class='icon-pencil'></i> Contract</a><br>":"");
echo ((strlen($property_details['reservationform'])>0)?"<a href='#' class='overlayPDFViewer' pdfFilePath='".$site_path."dreamcms/app/webroot/uploads/$pID/reservationforms/".$property_details['reservationform']."'><i class='icon-list'></i> Reservation Form</a><br>":"");
echo ((strlen($property_details['priceList'])>0)?"<a href='#' class='overlayPDFViewer' pdfFilePath='".$site_path."dreamcms/app/webroot/uploads/$pID/pricelists/".$property_details['priceList']."'><i class='icon-money'></i> Price List</a><br>":"");
echo ((strlen($property_details['stratafee'])>0)?"<a href='#' class='overlayPDFViewer' pdfFilePath='".$site_path."dreamcms/app/webroot/uploads/$pID/stratafees/".$property_details['stratafee']."'><i class='icon-share'></i> Outgoings</a><br>":"");
//echo ((strlen($property_details['councilwater'])>0)?"<a href='#' class='overlayPDFViewer' pdfFilePath='".$site_path."dreamcms/app/webroot/uploads/councilwaters/".$property_details['councilwater']."'><i class='icon-tint'></i> Council & Water</a><br>":"");
echo ((strlen($property_details['depreciation'])>0)?"<a href='#' class='overlayPDFViewer' pdfFilePath='".$site_path."dreamcms/app/webroot/uploads/$pID/depreciations/".$property_details['depreciation']."'><i class='icon-bar-chart'></i> Depreciation</a><br>":"");
echo ((strlen($property_details['specialdoc'])>0)?"<a href='#' class='overlayPDFViewer' pdfFilePath='".$site_path."dreamcms/app/webroot/uploads/$pID/specialdocs/".$property_details['specialdoc']."'><i class='icon-file'></i> Special Document</a><br>":"");


}
//echo "<a href='#' onclick='javascript:window.print();'><i class='icon-print'></i> Print Page</a>";
echo '</div>'; // End all documents links

/*if( !empty($property_details['agent']) ){
echo "<div class='agent'><h4>Contact Agent</h4><p>{$property_details['agent']}<br>{$property_details['agentcontact']}</p></div>";
}
echo "				
<div id='property-address'><h4>Property Location</h4>
<p>".$property_details['address'].", ".$property_details['suburb']." ".$property_details['state']."</p></div>

<div id='google-map'>".str_replace("<iframe width=\"425\" height=\"350\"","<iframe width=\"290\" height=\"254\"",$property_details['googleMap'])."</div>
";*/

}
?>   

<!--</div>-->

<?php 
if($agentLoggedIn === true){ 
// Miscellaneous documents
$sortOrder = $property_details['sortingorder']; 
if(empty($sortOrder)){$sortOrder ='position';}
$otherDocsRows = getMiscellaneousDocs($pID, $sortOrder);
$docsCount = 0;
$rootPath = rtrim($site_path, '/');
while($row = mysql_fetch_array($otherDocsRows, MYSQL_ASSOC)){
    if($docsCount == 0){
        //echo "<div id='property-links' class='col panel opacity' style='width: 285px; padding: 10px 20px!important; '>";
        echo '<table class="misDocsTable" style="width:100%;font-size:11px;">';
        echo '<tr><th>Document</th><th>Size (KB)</th><th>Date Uploaded</th></tr>';
    }
    $ext = strtolower(end(explode(".", $row['filename'])));
    if($ext == 'pdf'){
    echo "<tr><td><a href='#' class='overlayPDFViewer' pdfFilePath='$rootPath/dreamcms/app/webroot/uploads/otherdocs/$pID/{$row['filename']}'>{$row['displayname']}</a></td>";
    }
    else{
      echo "<tr><td><a href='$rootPath/dreamcms/app/webroot/uploads/otherdocs/$pID/{$row['filename']}' download>{$row['displayname']}</a></td>";  
    }
    echo "<td>{$row['filesize']}</td>";
    echo "<td>{$row['dateuploaded']}</td>";
    echo '</tr>';
    ++$docsCount;
}

if($docsCount > 0){
    echo '</table><br>';
}
}

//echo '<div id="property-links" class="col panel opacity" style="width: 285px; margin-right: 0;padding: 10px 20px!important;">';


if( !empty($property_details['agent']) ){
echo "<div class='agent'><h4>Contact Agent</h4><p>{$property_details['agent']}<br>{$property_details['agentcontact']}</p></div>";
}
echo "				
<div id='property-address'><h4>Property Location</h4>
<p>".$property_details['address'].", ".$property_details['suburb']." ".$property_details['state']."</p></div>

<div id='google-map'>".str_replace("<iframe width=\"425\" height=\"350\"","<iframe width=\"290\" height=\"254\"",$property_details['googleMap'])."</div>
";
echo "<br><a href='#' onclick='javascript:window.print();'><i class='icon-print'></i> Print Page</a>";
echo '</div>';
if($agentLoggedIn === true){
include('side-contact.php');
}

?>
    </div>
   <div id="dialogPDFViewer" style="display: none"> </div>
    <script type="text/javascript">	
		//Examples of how to assign the ColorBox event to elements
		$('.propImages').colorbox({rel:'propImages'});
		$('.iframe').colorbox({iframe:true, width:"300px", height:"590px"});		//width:"18%", height:"54%"});		// updated as it scalling caused issues on smaller devices such as iPad.
		$('#carousel').elastislide({
			imageW 		: 115,
			minItems	: 3,
			border		: 0
		});		
	</script>
    <script src="<?php echo $site_path;?>js/wowslider.js" type="text/javascript"></script>  
    <script src="<?php echo $site_path;?>js/wowslider.script.js" type="text/javascript"></script>
<?php include("inc/foot.php"); ?>