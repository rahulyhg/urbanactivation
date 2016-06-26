<?php echo $jQValidator->validator(); ?>
<?php echo $this->Html->css('thickbox.css'); ?>
<?php echo $this->Html->script('thickbox.js'); ?>
<?php
if (isset($javascript)) {
	echo $javascript->link('jquery.friendurl.min.js');
	echo $javascript->link('jquery.textareaCounter.plugin.js');	
	echo $javascript->link('jquery.tooltip.js');

	echo $javascript->link('jquery-ui-1.8.21.custom.min.js');
	echo $javascript->link('jquery.ui.sortable.js');
        echo $javascript->link('multiDocsDynamicAdd.js');
}
?>
<script type="text/javascript">
	$(function(){
            Date.format = 'dd/mm/yyyy';
            $('#ExpectedCompletionDate').datePicker({startDate:'01/01/2015'});
		$("#PropertyAddForm *").tooltip();
	//	$("#PropertyTags").tagit();
		$('#copy').click(function(){
			var con = true;
			if($('#PropertyTitleSeo').val()!=''){
				con = confirm('Are you sure you would like to over write current "Seo Title"?');
			}
			if (con){
				$('#PropertyTitleSeo').val($('#PropertyTitle').val());
				$('#PropertyTitleSeo').focus();
			}
		});
		var options3 = {
			'maxCharacterSize': 65,
			'originalStyle': 'originalTextareaInfo',
			'warningStyle' : 'warningTextareaInfo',
			'warningNumber': 10,
			'displayFormat' : '#input characters | #left characters left'
		};
		$('#PropertyTitleSeo').textareaCount(options3);
	
		$('#images').sortable({
			opacity: 0.6,
			cursor: 'move',
			update: function() {
				$.post('<?php echo $this->Html->url(array('controller' => 'images','action' => 'order'));?>', $('#images').sortable("serialize", {key: 'images[]'}))
				.success(function() { $('#order-status').fadeIn() })
				.error(function() { alert("error"); })
			}
		});
		$('#images').disableSelection(function() { $('#order-status').fadeOut() });
		$('#PropertyTitle').friendurl({id : 'PropertySeoPageName', transliterate: true});
	});	

	function updateForm() {
		// update ajax call to update image list
		$('#images').load('<?php echo $this->Html->url(array('controller' => 'images','action' => 'view_images', $randomSeed));?>', function() {  // , 'key' => $randomSeed
			$('#order-status').text('PROPERTIES IMAGE(S) successfully uploaded');
			$('#order-status').fadeIn();
		});
	}

	function updateCancel(k) {
		var undefined;
		// update ajax call to remove strayed images
		if(k === undefined) { // delete after upload (cancel from upload tool)
			$('#afterSubmit').load('<?php echo $this->Html->url(array('controller' => 'images','action' => 'delete'));?>');
		} else { // deleting after not submitting the form
			$('#afterSubmit').load('<?php echo $this->Html->url(array('controller' => 'images','action' => 'delete', $randomSeed));?>', function() {  // , 'key' => $randomSeed
			});
		}
		$('#order-status').text('NOTE: Image uploade cancelled by user');
		$('#order-status').fadeIn();
	}

	function unconfirmItem(i) {
		// update ajax call to mark item to delete
		if(confirm("Are you sure you wish to remove this item?")) {
			$('#images').load('<?php echo $this->Html->url(array('controller' => 'images','action' => 'delete_image'));?>/'+i+'/<?php echo $randomSeed; ?>');
			$('#order-status').text('PROPERTIES IMAGE successfully removed');
		} else {
			$('#order-status').text('NOTE: Image deletion cancelled by user');
		}
		$('#order-status').fadeIn();
	}
</script>
<script type="text/javascript" language="javascript">
function uploadFile(opt, variable, fld){
	// opt    :: option
	// fld    :: folder
	// values :: 
	//           0 = image (general)
	//           1 = image
	//           2 = image
	//           3 = audio file
	//           4 = media file
	//           5 = pdf file
	var mywin = window.open("<?php echo Configure::read('Company.url');?>dreamcms/app/views/pages/upload.php?id=<?php echo $this->data['Property']['id']; ?>&opt="+opt+"&variable="+variable+"&fld="+fld,"uploadwindow","width=400,height=200");
	mywin.focus();
}
</script>
<style>
	.charleft{
		padding: 0px 0px 0px 190px;
		font-style:italic;
		font-size: 0.9em;	
	}
</style>
<div class="properties form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Property</div>
        	</div>
    	</div>
<?php 	
// check other documents directory exist, if not create it
$propertyDirName = substr( md5(uniqid(mt_rand(), true)), 0, 8);
$dirAbsPath = WWW_ROOT . "uploads/otherdocs/$propertyDirName";
if(file_exists($dirAbsPath) === false){
    mkdir($dirAbsPath);
}
// check if documents directory exists
$dirUploadPropDocs = WWW_ROOT . "uploads/$propertyDirName";
if(file_exists($dirUploadPropDocs) === false){
    mkdir($dirUploadPropDocs);
}

echo $this->Form->create('Property', array('class'=>'editForm', 'enctype'=>'multipart/form-data', 'type'=> 'file')); ?>
        <input type='hidden' id='txtPropertyDirName' name='txtPropertyDirName' value='<?php echo $propertyDirName;?>' />
     	<div style="position:relative; top: -35px;left:195px;height: 0;padding:0px; margin: 0;">
		<?php
            echo $this->Form->button('Submit', array('type'=>'submit'));
            //echo $this->Form->button('Reset', array('type'=>'reset'));
            $url = array('action'=>'index');
			echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"updateCancel('".$randomSeed."'); window.setTimeout('window.location=\'".$this->Html->url($url)."\'', 3000)")); 
        ?>	
        </div>	
            
<?php	echo $this->Form->input('title',array('class'=>'text', 'after'=>"<div class='note' style='padding-left:195px'>This description will be displayed in the search results and is the page name.</div>",'label' => 'Title *'));
		echo $this->Form->input('seo_page_name', array('class'=>'text','readonly'=>'true', 'style' => 'background-color:transparent;border: 0px;'));
        echo $this->Form->input('titleSeo', array('after'=>'<input id="copy" style="width: 100px;left: 75%;position: relative;top: -46px;" type="button" value="Copy from Title" />', 'class'=>'text', 'title'=>'Enter the Page Title for Search Engines. We recommend it to be 65 characters long for best results.'));

	// property access type	
        $accessTypes = array('0' => 'Agent', '1' => 'Public', '2' => 'Both');
        echo $this->Form->input('access_type', array('type' => 'select', 'escape' => false, 'options' => $accessTypes, 'label' => 'Access Type *'));
        
        foreach ($options as $option){
			$categoryOptions[$option['PropertiesCategory']['id']] = $option['PropertiesCategory']['category'];
		}
		echo $this->Form->input('category_id', array('type' => 'select', 'escape' => false, 'options' => $categoryOptions));

		echo $this->Form->input('address',array('class'=>'text'));
		echo $this->Form->input('suburb',array('class'=>'text'));
		foreach ($optionsState as $stateAbbreviation => $stateName){
			$stateOptions[$stateAbbreviation] = $stateName;
		}
		echo $this->Form->input('city',array('class'=>'text'));
		echo $this->Form->input('state', array('type' => 'select', 'escape' => false, 'options' => $stateOptions));
		echo $this->Form->input('postcode',array('class'=>'text', 'style' => 'width: 120px;'));

		echo $this->Form->input('GMLat',array('type'=>'hidden', 'value'=>'0'));
		echo $this->Form->input('GMLong',array('type'=>'hidden', 'value'=>'0'));

		foreach ($optionsRegion as $option){
			$regionOptions[$option['PropertiesRegion']['id']] = $option['PropertiesRegion']['region'];
		}
		echo $this->Form->input('region_id', array('type' => 'select', 'escape' => false, 'options' => $regionOptions));
		foreach ($optionsType as $option){
			$typeOptions[$option['PropertiesType']['id']] = $option['PropertiesType']['type'];
		}
		echo $this->Form->input('googleMap',array('type'=>'textarea', 'label'=>'Google Map Code', 'style'=>'width:400px; height:100px', 'after'=>"<div class='note' style='padding-left:195px'>Using the ‘embed code’ – if required modify width=`290` and height=`250`</div>"));
		echo $this->Form->input('type_id', array('type' => 'select', 'escape' => false, 'options' => $typeOptions));
		foreach ($optionsStatus as $option){
			$statusOptions[$option['PropertiesStatus']['id']] = $option['PropertiesStatus']['status'];
		}
                echo $this->Form->input('numofunits',array('class'=>'text', 'style' => 'width: 60px;', 'label' => 'Number of Units'));
                echo $this->Form->input('numoffloors',array('class'=>'text', 'style' => 'width: 60px;', 'label' => 'Number of Floors'));
                echo $this->Form->input('completiondate', array('class'=>'dateField','id' => 'ExpectedCompletionDate', 'readonly' => 'true', 'label' => 'Expected Completion Date*'));
		echo $this->Form->input('status_id', array('type' => 'select', 'escape' => false, 'options' => $statusOptions));
		foreach ($optionsSalesStatus as $option){
			$salesStatusOptions[$option['PropertiesSalesStatuses']['id']] = $option['PropertiesSalesStatuses']['sales_status'];
		}
		echo $this->Form->input('sales_status_id', array('type' => 'select', 'escape' => false, 'options' => $salesStatusOptions));

		echo $this->Form->input('price',array('class'=>'text', 'label'=>'Sale Price', 'style' => 'width: 120px;', 'value'=> '0.00', "after"=>"<span class='note'>e.g. $100,000 to $120,000, Contact Agent, POA or From $2 Million</span>"));
		echo $this->Form->input('rent' ,array('class'=>'text', 'label'=>'Weekly Rental', 'style' => 'width: 120px;', 'value'=> '0.00', "after"=>"<span class='note'>Estimated weekly rental price only</span>"));
		echo $this->Form->input('displayPrice', array('type' => 'checkbox', 'label'=>'Display Sale Price?', 'class'=>'checkbox'));
		echo $this->Form->input('priceRangeMin' ,array('class'=>'text', 'label'=>'Price Range (Minimum)', 'style' => 'width: 120px;', 'value'=> '0.00', "after"=>"<span class='note'>Field must be numeric as it's used from searching purposes, not displayed on site</span>"));
		echo $this->Form->input('priceRangeMax' ,array('class'=>'text', 'label'=>'Price Range (Maximum)', 'style' => 'width: 120px;', 'value'=> '0.00', "after"=>"<span class='note'>Field must be numeric as it's used from searching purposes, not displayed on site</span>"));
		echo $this->Form->input('commission_rate',array('class'=>'text', 'style' => 'width: 120px;', 'value'=> '0.00', 'label' => 'Commission Rate(Excluding GST)'));
                echo $this->Form->input('agent',array('class'=>'text', 'style' => 'width: 240px;'));
                echo $this->Form->input('agentcontact',array('class'=>'text', 'style' => 'width: 120px;', 'label' => 'Agent Contact'));
                foreach ($optionsBedrooms as $beds => $bedDesc){
			$bedroomOptions[$beds] = $bedDesc;
		}
		echo $this->Form->input('numBedrooms', array('type' => 'select', 'multiple' => true, 'label'=>'Number of Bedrooms', 'escape' => false, 'options' => $bedroomOptions, 'style' => 'width: 120px;height:50px', "after"=>"<span class='note'>Use 'CTRL' and left mouse button for multiple selections</span>"));
		foreach ($optionsBathrooms as $baths => $bathDesc){
			$bathroomOptions[$baths] = $bathDesc;
		}
		echo $this->Form->input('numBathrooms', array('type' => 'select', 'multiple' => true, 'label'=>'Number of Bathrooms', 'escape' => false, 'options' => $bathroomOptions, 'style' => 'width: 120px;height:50px', "after"=>"<span class='note'>Use 'CTRL' and left mouse button for multiple selections</span>"));
		foreach ($optionsParking as $parks => $parkDesc){
			$parkingOptions[$parks] = $parkDesc;
		}
		echo $this->Form->input('numParking', array('type' => 'select', 'multiple' => true, 'label'=>'Number of Parking Spaces', 'escape' => false, 'options' => $parkingOptions, 'style' => 'width: 120px;height:50px', "after"=>"<span class='note'>Use 'CTRL' and left mouse button for multiple selections</span>"));


//		foreach ($locOptions as $locOption){
//			$locationOptions[$locOption['PropertiesLocation']['id']] = $locOption['PropertiesLocation']['location'];
//		}
//		echo $this->Form->input('location_id', array('type' => 'select', 'escape' => false, 'options' => $locationOptions));
		echo $this->Form->input('shortDescription', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass, 'label' => 'Short Description *'));
		?>
		<script type="text/javascript">
			var ck_propertiesShortDescription = CKEDITOR.replace( 'PropertyShortDescription', { 
															toolbar: 'Basic',
															enterMode : CKEDITOR.ENTER_BR,
															shiftEnterMode: CKEDITOR.ENTER_P,
															height: 50,
															resize_minHeight:120,
															resize_minWidth:800,
															resize_maxWidth:800
															} );
			CKFinder.setupCKEditor( ck_propertiesShortDescription, '<?php echo $ckfinderPath ?>') ;
        </script>
 		<?php
		echo $this->Form->input('body', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass, 'label' => 'Body *'));
		?>
    	<script type="text/javascript">
			var ck_propertiesBody = CKEDITOR.replace( 'PropertyBody', { 
												toolbar: 'Full',
												height: 325,
												resize_minHeight:325,
												resize_minWidth:800,
												resize_maxWidth:800
												} );
			CKFinder.setupCKEditor( ck_propertiesBody, '<?php echo $ckfinderPath ?>') ;
        </script>
        <?php
		echo $this->Form->input('keyFeatures', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
    	<script type="text/javascript">
			var ck_propertiesKeyFeatures = CKEDITOR.replace( 'PropertyKeyFeatures', { 
												toolbar: 'Full',
												height: 325,
												resize_minHeight:325,
												resize_minWidth:800,
												resize_maxWidth:800
												} );
			CKFinder.setupCKEditor( ck_propertiesKeyFeatures, '<?php echo $ckfinderPath ?>') ;
        </script>
        
<?php 
        // upoload images
		echo $this->Form->input('randomSeed',array('type'=>'hidden', 'value'=>$randomSeed));
		echo  "<div align='center' style='background-color:#f2f2f2; height:40px; clear:both'><br>";  // convert link to button!
		echo $this->Html->link('Upload Images',Configure::read('Company.url').'dreamcms/app/views/uploads/?KeepThis=true&height=570&width=850&id=0&key='.$randomSeed.'&df=properties&fld=property_id&TB_iframe=true', array('class'=>'thickbox', 'title'=>'Multi File Uploader', 'style'=>'color:#FFFFFF; background-color:#0000DD; border:1px #000000 solid; padding:5px;'));  // &modal=true
		echo  "</div>";
?>
		<div id="order-status" <?php if(sizeof(@$optionsImages)) { echo("style=\"display: none;\""); } else { $orderStatus="NO PROPERTY IMAGES loaded."; }  ?>><?php echo $orderStatus; ?></div>
		<div>
        	<div id="images">
<?php	//echo $this->ImageGallery->displayImageGallery($optionsImages); ?>
	        </div>
		</div>
        <div id="afterSubmit"><!-- used for additional action, unseen --></div>
<?php

		echo $this->Form->input('nras', array('type' => 'checkbox', 'label'=>'NRAS Property?', 'class'=>'checkbox'));
		//echo $this->Form->input('floorArea',array('class'=>'text', 'label'=>'Floor Area (m<sup>2</sup>)', 'style' => 'width: 120px;', 'value'=> '0.00'));
		//echo $this->Form->input('landSize' ,array('class'=>'text', 'label'=>'Land Size (m<sup>2</sup>)', 'style' => 'width: 120px;', 'value'=> '0.00'));
		echo $this->Form->input('inspections',array('type'=>'textarea', 'style'=>'width:400px; height:100px'));
                
                  // show other docs list from db
/*
		// upload brochure
		$jsString1 = "javascript:uploadFile('5', 'PropertyBrochure', 'brochures');";
		echo '<div class="input text">';
		echo '<label for="PropertyBrochure">Brochure</label>';
		echo '<input readonly="true" name="data[Property][brochure]" id="PropertyBrochure" class="pdf" value="'.$this->data['Property']['brochure'].'">';
		echo '<input name="uploadPropertyBrochure" type="button" class="uploadButton" id="uploadPropertyBrochure" onMouseUp="'.$jsString1.'" value="Upload File">';
		$jsString2 = "javascript:document.getElementById('PropertyBrochure').value='';";
		echo '<input name="removePropertyBrochure" type="button" class="uploadButton" id="removePropertyBrochure" onMouseUp="'.$jsString2.'" value="Remove File" /><em>&nbsp;&nbsp;Must be a PDF document</em>';
		echo '</div>';

		// upload floor plans
		$jsString1 = "javascript:uploadFile('5', 'PropertyFloorPlan', 'floorplans');";
		echo '<div class="input text">';
		echo '<label for="PropertyFloorPlan">Floor Plan</label>';
		echo '<input readonly="true" name="data[Property][floorPlan]" id="PropertyFloorPlan" class="pdf" value="'.$this->data['Property']['floorPlan'].'">';
		echo '<input name="uploadPropertyFloorPlan" type="button" class="uploadButton" id="uploadPropertyFloorPlan" onMouseUp="'.$jsString1.'" value="Upload File">';
		$jsString2 = "javascript:document.getElementById('PropertyFloorPlan').value='';";
		echo '<input name="removePropertyFloorPlan" type="button" class="uploadButton" id="removePropertyFloorPlan" onMouseUp="'.$jsString2.'" value="Remove File" /><em>&nbsp;&nbsp;Must be a PDF document</em>';
		echo '</div>';*/
                $uploadFields = array('Brochure' => 'brochure', 'Floor Plan' => 'floorPlan', 'Contract' => 'contract', 
                    'Reservation Form' => 'reservationform', 'Price List' => 'priceList', 'Outgoings' => 'stratafee', 'Depreciation' => 'depreciation',
                    'Special Conditions' => 'specialdoc');
                // check if directory exists, if not create it
                foreach($uploadFields as $label => $field){
                $id =  'Property' . ucwords($field);
                $folderName = $propertyDirName . '/' .strtolower($field) . 's';
                // check if documents directory exists, if not create it
                $dirUploadPropDocs = WWW_ROOT . "uploads/" . $folderName;
                if(file_exists($dirUploadPropDocs) === false){
                mkdir($dirUploadPropDocs);
                }
                $uploadID = 'upload' .  $id;
                $removeID = 'remove' .  $id;
                $dbValue = $this->data['Property']["$field"];
                
                $jsString1 = "javascript:uploadFile('5', '$id', '$folderName');";
		echo '<div class="input text">'; 
                echo "<label for='$id'>$label</label>";
                echo "<input readonly='true' name='data[Property][$field]' id='$id' class='pdf' value='$dbValue'>";
		echo "<input name='$uploadID' type='button' class='uploadButton' id='$uploadID' onMouseUp=\"" . $jsString1. "\" value='Upload File'>";
		$jsString2 = "javascript:document.getElementById('$id').value='';";
		echo "<input name='$removeID' type='button' class='uploadButton' id='$removeID' onMouseUp=\"" .$jsString2. "\" value='Remove File' /><span class='note' >Must be a PDF document</span>";
		echo '</div>';
                }   
                
                // show other docs list from db
                include_once 'multiDocsDynamicAdd.php';
		
		echo $this->Form->input('featured', array('type' => 'checkbox', 'label'=>'Featured Property?', 'class'=>'checkbox'));
		echo $this->Form->input('live', array('type' => 'checkbox', 'label'=>'Push content Live? *', 'class'=>'checkbox'));
		echo $this->Form->input('position', array('type'=>'hidden', 'value'=>$maxPosition, 'label' => 'Position *'));
		?>
        <div id="record_wrap">
            <div class="record_row_desc" id="record_row">
                <div id="record_detail">&nbsp;</div>
            </div>
            <div class="record_row_data" id="record_row">
                <div id="record_data">
		<?php 
				echo $this->Form->button('Submit', array('type'=>'submit'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));
				$url = array('action'=>'index');
				// force delay on cancel to remove all images and directories, with no delay the server does not have enough time to make the physical change
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"updateCancel('".$randomSeed."'); window.setTimeout('window.location=\'".$this->Html->url($url)."\'', 3000)")); 
		?>
        		</div>
            </div>
        </div>
        
	</div>
</div>