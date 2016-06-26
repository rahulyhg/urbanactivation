<?php echo $jQValidator->validator(); ?>
<?php
if (isset($javascript)) {
	echo $javascript->link('jquery.friendurl.min.js');
}
?>
<script type="text/javascript">
$(function(){
	$('#ProjectTitle').friendurl({id : 'ProjectSeoPageName', transliterate: true});
});
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
	var mywin = window.open("<?php echo Configure::read('Company.url');?>dreamcms/app/views/pages/upload.php?id=<?php echo $this->data['Project']['id']; ?>&opt="+opt+"&variable="+variable+"&fld="+fld,"uploadwindow","width=400,height=200");
	mywin.focus();
}
</script>
<div class="projects form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Project</div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('Project', array('class'=>'editForm', 'enctype'=>'multipart/form-data', 'type'=> 'file'));
		echo $this->Form->input('title',array('class'=>'text'));
		echo $this->Form->input('seo_page_name', array('class'=>'text','readonly'=>'true', 'style' => 'background-color:transparent;border: 0px;'));
		foreach ($options as $option){
			$categoryOptions[$option['ProjectsCategory']['id']] = $option['ProjectsCategory']['category'];
		}
		echo $this->Form->input('category_id', array('type' => 'select', 'escape' => false, 'options' => $categoryOptions));
		foreach ($locOptions as $locOption){
			$locationOptions[$locOption['ProjectsLocation']['id']] = $locOption['ProjectsLocation']['location'];
		}
		echo $this->Form->input('location_id', array('type' => 'select', 'escape' => false, 'options' => $locationOptions));
		echo $this->Form->input('shortDescription', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
		<script type="text/javascript">
			var ck_projectsShortDescription = CKEDITOR.replace( 'ProjectShortDescription', { 
															toolbar: 'Basic',
															enterMode : CKEDITOR.ENTER_BR,
															shiftEnterMode: CKEDITOR.ENTER_P,
															height: 150,
															resize_minHeight:150,
															resize_minWidth:800,
															resize_maxWidth:800
															} );
			CKFinder.setupCKEditor( ck_projectsShortDescription, '<?php echo $ckfinderPath ?>') ;
        </script>
 		<?php
		echo $this->Form->input('body', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
    	<script type="text/javascript">
			var ck_projectsBody = CKEDITOR.replace( 'ProjectBody', { 
												toolbar: 'Full',
												height: 325,
												resize_minHeight:325,
												resize_minWidth:800,
												resize_maxWidth:800
												} );
			CKFinder.setupCKEditor( ck_projectsBody, '<?php echo $ckfinderPath ?>') ;
        </script>
        <?php
   		//feature image
			 //echo $this->Form->input('photo', array('type'=>'file', 'label'=>'Member Photo'));
			 $jsString1 = "javascript:uploadFile('1', 'ProjectFeatureImage', 'projects');document.getElementById('ProjectFeatureImage_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/uploads/projects/'+document.getElementById('ProjectFeatureImage').value";
			 echo '<div class="input file">';
			 echo '<label for="ProjectFeatureImage">Feature Project Image:</label>';
			 echo '<input name="data[Project][featureImageText]" id="ProjectFeatureImageText" class="pdf" value="Enter image text" onclick = "this.select();" /><br />';
			 echo '<input readonly="true" name="data[Project][featureImage]" id="ProjectFeatureImage" class="pdf" value="">';
			 echo '<input name="uploadProjectFeatureImage" type="button" class="uploadButton" id="uploadProjectFeatureImage" onMouseUp="'.$jsString1.'" value="Upload File">';
			 $jsString2 = "javascript:document.getElementById('ProjectFeatureImage').value=''; document.getElementById('ProjectFeatureImage_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/img/blank.gif'";
			 echo '<input name="removeProjectFeatureImage" type="button" class="uploadButton" id="removeProjectFeatureImage" onMouseUp="'.$jsString2.'" value="Remove File" />';
			 echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			 echo '<img src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/blank.gif" id="ProjectFeatureImage_img" name="ProjectFeatureImage_img" height="100">';
			 echo '</div>';
			 echo '</div>';
		
		//option image 1
			 //echo $this->Form->input('photo', array('type'=>'file', 'label'=>'Member Photo'));
			 $jsString1 = "javascript:uploadFile('1', 'ProjectOptionalImage1', 'projects');document.getElementById('ProjectOptionalImage1_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/uploads/projects/'+document.getElementById('ProjectOptionalImage1').value";
			 echo '<div class="input file">';
			 echo '<label for="ProjectOptionalImage1">Optional Project Image 1:</label>';
			 echo '<input name="data[Project][image1Text]" id="ProjectImage1Text" class="pdf" value="Enter image text" onclick = "this.select();" /><br />';
			 echo '<input readonly="true" name="data[Project][optionalImage1]" id="ProjectOptionalImage1" class="pdf" value="">';
			 echo '<input name="uploadProjectOptionalImage1" type="button" class="uploadButton" id="uploadProjectOptionalImage1" onMouseUp="'.$jsString1.'" value="Upload File">';
			 $jsString2 = "javascript:document.getElementById('ProjectOptionalImage1').value=''; document.getElementById('ProjectOptionalImage1_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/img/blank.gif'";
			 echo '<input name="removeProjectOptionalImage1" type="button" class="uploadButton" id="removeProjectOptionalImage1" onMouseUp="'.$jsString2.'" value="Remove File" />';
			 echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			 echo '<img src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/blank.gif" id="ProjectOptionalImage1_img" name="ProjectOptionalImage1_img" height="100">';
			 echo '</div>';
			 echo '</div>';
			 		
		//optional image 2
			 //echo $this->Form->input('photo', array('type'=>'file', 'label'=>'Member Photo'));
			 $jsString1 = "javascript:uploadFile('1', 'ProjectOptionalImage2', 'projects');document.getElementById('ProjectOptionalImage2_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/uploads/projects/'+document.getElementById('ProjectOptionalImage2').value";
			 echo '<div class="input file">';
			 echo '<label for="ProjectOptionalImage2">Optional Project Image 2:</label>';
			 echo '<input name="data[Project][image2Text]" id="ProjectImage2Text" class="pdf" value="Enter image text" onclick = "this.select();" /><br />';
			 echo '<input readonly="true" name="data[Project][optionalImage2]" id="ProjectOptionalImage2" class="pdf" value="">';
			 echo '<input name="uploadProjectOptionalImage2" type="button" class="uploadButton" id="uploadProjectOptionalImage2" onMouseUp="'.$jsString1.'" value="Upload File">';
			 $jsString2 = "javascript:document.getElementById('ProjectOptionalImage2').value=''; document.getElementById('ProjectOptionalImage2_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/img/blank.gif'";
			 echo '<input name="removeProjectOptionalImage2" type="button" class="uploadButton" id="removeProjectOptionalImage2" onMouseUp="'.$jsString2.'" value="Remove File" />';
			 echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			 echo '<img src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/blank.gif" id="ProjectOptionalImage2_img" name="ProjectOptionalImage2_img" height="100">';
			 echo '</div>';
			 echo '</div>';
		
		//optional image 3
			 //echo $this->Form->input('photo', array('type'=>'file', 'label'=>'Member Photo'));
			 $jsString1 = "javascript:uploadFile('1', 'ProjectOptionalImage3', 'projects');document.getElementById('ProjectOptionalImage3_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/uploads/projects/'+document.getElementById('ProjectOptionalImage3').value";
			 echo '<div class="input file">';
			 echo '<label for="ProjectOptionalImage3">Optional Project Image 3:</label>';
			 echo '<input name="data[Project][image3Text]" id="ProjectImage3Text" class="pdf" value="Enter image text" onclick = "this.select();" /><br />';
			 echo '<input readonly="true" name="data[Project][optionalImage3]" id="ProjectOptionalImage3" class="pdf" value="">';
			 echo '<input name="uploadProjectOptionalImage3" type="button" class="uploadButton" id="uploadProjectOptionalImage3" onMouseUp="'.$jsString1.'" value="Upload File">';
			 $jsString2 = "javascript:document.getElementById('ProjectOptionalImage3').value=''; document.getElementById('ProjectOptionalImage3_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/img/blank.gif'";
			 echo '<input name="removeProjectOptionalImage3" type="button" class="uploadButton" id="removeProjectOptionalImage3" onMouseUp="'.$jsString2.'" value="Remove File" />';
			 echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			 echo '<img src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/blank.gif" id="ProjectOptionalImage3_img" name="ProjectOptionalImage3_img" height="100">';
			 echo '</div>';
			 echo '</div>';
			 
		echo $this->Form->input('featured', array('type' => 'checkbox', 'label'=>'Featured Project?', 'class'=>'checkbox'));
		echo $this->Form->input('live', array('type' => 'checkbox', 'label'=>'Push content Live?', 'class'=>'checkbox'));
		echo $this->Form->input('position', array('type'=>'hidden', 'value'=>$maxPosition));
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
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>
        		</div>
            </div>
        </div>
	</div>
</div>