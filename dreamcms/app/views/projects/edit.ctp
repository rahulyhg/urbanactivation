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
        		<div id="record_detail">Edit Item: <?php echo $this->data['Project']['id']; ?></div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('Project', array('class'=>'editForm', 'enctype'=>'multipart/form-data', 'type'=> 'file'));
		?>
        <div style="position:relative; top: -13px;left:160px;width:300px;margin:-11px;padding:0px">
		<?php
            echo $this->Form->button('Submit', array('type'=>'submit'));
            $url = array('action'=>'index');
            echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
        ?>	
        </div>	
        <?php
        echo $this->Form->input('id');
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
		if(strlen($this->data['Project']['featureImage'])<=0){
			 //echo $this->Form->input('photo', array('type'=>'file', 'label'=>'Member Photo'));
			 $jsString1 = "javascript:uploadFile('1', 'ProjectFeatureImage', 'projects');document.getElementById('ProjectFeatureImage_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/uploads/projects/'+document.getElementById('ProjectFeatureImage').value";
			 echo '<div class="input file">';
			 echo '<label for="ProjectFeatureImage">Feature Project Image:</label>';
			 echo '<input name="data[Project][featureImageText]" id="ProjectFeatureImageText" class="pdf" value="'.((strlen($this->data['Project']['featureImageText'])==0)?'Enter image text':$this->data['Project']['featureImageText']).'" onclick = "this.select();" /><br />';
			 echo '<input readonly="true" name="data[Project][featureImage]" id="ProjectFeatureImage" class="pdf" value="'.$this->data['Project']['featureImage'].'">';
			 echo '<input name="uploadProjectFeatureImage" type="button" class="uploadButton" id="uploadProjectFeatureImage" onMouseUp="'.$jsString1.'" value="Upload File">';
			 $jsString2 = "javascript:document.getElementById('ProjectFeatureImage').value=''; document.getElementById('ProjectFeatureImage_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/img/blank.gif'";
			 echo '<input name="removeProjectFeatureImage" type="button" class="uploadButton" id="removeProjectFeatureImage" onMouseUp="'.$jsString2.'" value="Remove File" />';
			 echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			 echo '<img src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/blank.gif" id="ProjectFeatureImage_img" name="ProjectFeatureImage_img" height="100">';
			 echo '</div>';
			 echo '</div>';
		} else { ?>
			<div class="input">
            	<label for="ProjectFeatureImage">Feature Project Image:</label>     
                <input type="text" id="ProjectFeatureImageText" maxlength="255" onclick="this.select();" name="data[Project][featureImageText]" value="<?php echo $this->data['Project']['featureImageText'];?>" /><br />
            	<img src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/uploads/projects/<?php echo $this->data['Project']['featureImage'];?>" height="100" style="margin: 10px 0px 0px 1px;"/>
				<?php echo $this->Html->link($html->image("delete.gif",array('id'=>'deletefile','alt'=>'delete file', 'border' => 0)), array('action' => 'deletefile', $this->data['Project']['id'].'/featureImage'), array('escape' => false,'id'=>'record','title'=>'delete file'), sprintf(__('Are you sure you want to delete the feature image?', true)));?>
             </div>
		<?php
        }
		//option image 1
		if(strlen($this->data['Project']['optionalImage1'])<=0){
			 //echo $this->Form->input('photo', array('type'=>'file', 'label'=>'Member Photo'));
			 $jsString1 = "javascript:uploadFile('1', 'ProjectOptionalImage1', 'projects');document.getElementById('ProjectOptionalImage1_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/uploads/projects/'+document.getElementById('ProjectOptionalImage1').value";
			 echo '<div class="input file">';
			 echo '<label for="ProjectOptionalImage1">Optional Project Image 1:</label>';
			 echo '<input name="data[Project][image1Text]" id="ProjectImage1Text" class="pdf" value="'.((strlen($this->data['Project']['image1Text'])==0 || is_null($this->data['Project']['image1Text']))?'Enter image text':$this->data['Project']['image1Text']).'" onclick = "this.select();" /><br />';
			 echo '<input readonly="true" name="data[Project][optionalImage1]" id="ProjectOptionalImage1" class="pdf" value="'.$this->data['Project']['optionalImage1'].'">';
			 echo '<input name="uploadProjectOptionalImage1" type="button" class="uploadButton" id="uploadProjectOptionalImage1" onMouseUp="'.$jsString1.'" value="Upload File">';
			 $jsString2 = "javascript:document.getElementById('ProjectOptionalImage1').value=''; document.getElementById('ProjectOptionalImage1_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/img/blank.gif'";
			 echo '<input name="removeProjectOptionalImage1" type="button" class="uploadButton" id="removeProjectOptionalImage1" onMouseUp="'.$jsString2.'" value="Remove File" />';
			 echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			 echo '<img src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/blank.gif" id="ProjectOptionalImage1_img" name="ProjectOptionalImage1_img" height="100">';
			 echo '</div>';
			 echo '</div>';
		} else { ?>
			<div class="input">
            	<label for="ProjectFeatureImage">Optional Project Image 1:</label>                
                <input type="text" id="ProjectImage1Text" maxlength="255" onclick="this.select();" name="data[Project][image1Text]" value="<?php echo $this->data['Project']['image1Text'];?>" /><br />
            	<img src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/uploads/projects/<?php echo $this->data['Project']['optionalImage1'];?>" height="100" style="margin: 10px 0px 0px 1px;"/>
				<?php echo $this->Html->link($html->image("delete.gif",array('id'=>'deletefile','alt'=>'delete file', 'border' => 0)), array('action' => 'deletefile', $this->data['Project']['id'].'/optionalImage1'), array('escape' => false,'id'=>'record','title'=>'delete file'), sprintf(__('Are you sure you want to delete this image?', true)));?>
             </div>
		<?php
        }
		
		//optional image 2
		if(strlen($this->data['Project']['optionalImage2'])<=0){
			 //echo $this->Form->input('photo', array('type'=>'file', 'label'=>'Member Photo'));
			 $jsString1 = "javascript:uploadFile('1', 'ProjectOptionalImage2', 'projects');document.getElementById('ProjectOptionalImage2_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/uploads/projects/'+document.getElementById('ProjectOptionalImage2').value";
			 echo '<div class="input file">';
			 echo '<label for="ProjectOptionalImage2">Optional Project Image 2:</label>';
			 echo '<input name="data[Project][image2Text]" id="ProjectImage2Text" class="pdf" value="'.((strlen($this->data['Project']['image2Text'])==0)?'Enter image text':$this->data['Project']['image2Text']).'" onclick = "this.select();" /><br />';
			 echo '<input readonly="true" name="data[Project][optionalImage2]" id="ProjectOptionalImage2" class="pdf" value="'.$this->data['Project']['optionalImage2'].'">';
			 echo '<input name="uploadProjectOptionalImage2" type="button" class="uploadButton" id="uploadProjectOptionalImage2" onMouseUp="'.$jsString1.'" value="Upload File">';
			 $jsString2 = "javascript:document.getElementById('ProjectOptionalImage2').value=''; document.getElementById('ProjectOptionalImage2_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/img/blank.gif'";
			 echo '<input name="removeProjectOptionalImage2" type="button" class="uploadButton" id="removeProjectOptionalImage2" onMouseUp="'.$jsString2.'" value="Remove File" />';
			 echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			 echo '<img src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/blank.gif" id="ProjectOptionalImage2_img" name="ProjectOptionalImage2_img" height="100">';
			 echo '</div>';
			 echo '</div>';
		} else { ?>
			<div class="input">
            	<label for="ProjectFeatureImage">Optional Project Image 1:</label>
                <input type="text" id="ProjectImage2Text" maxlength="255" onclick="this.select();" name="data[Project][image2Text]" value="<?php echo $this->data['Project']['image2Text'];?>" /><br />
                <img src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/uploads/projects/<?php echo $this->data['Project']['optionalImage2'];?>" height="100" style="margin: 10px 0px 0px 1px;"/>
				<?php echo $this->Html->link($html->image("delete.gif",array('id'=>'deletefile','alt'=>'delete file', 'border' => 0)), array('action' => 'deletefile', $this->data['Project']['id'].'/optionalImage2'),array('escape' => false,'id'=>'record','title'=>'delete file'), sprintf(__('Are you sure you want to delete this image?', true)));?>
             </div>
		<?php
        }
		
		//optional image 3
		if(strlen($this->data['Project']['optionalImage3'])<=0){
			 //echo $this->Form->input('photo', array('type'=>'file', 'label'=>'Member Photo'));
			 $jsString1 = "javascript:uploadFile('1', 'ProjectOptionalImage3', 'projects');document.getElementById('ProjectOptionalImage3_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/uploads/projects/'+document.getElementById('ProjectOptionalImage3').value";
			 echo '<div class="input file">';
			 echo '<label for="ProjectOptionalImage3">Optional Project Image 3:</label>';
			 echo '<input name="data[Project][image3Text]" id="ProjectImage3Text" class="pdf" value="'.((strlen($this->data['Project']['image3Text'])==0)?'Enter image text':$this->data['Project']['image3Text']).'" onclick = "this.select();" /><br />';
			 echo '<input readonly="true" name="data[Project][optionalImage3]" id="ProjectOptionalImage3" class="pdf" value="'.$this->data['Project']['optionalImage3'].'">';
			 echo '<input name="uploadProjectOptionalImage3" type="button" class="uploadButton" id="uploadProjectOptionalImage3" onMouseUp="'.$jsString1.'" value="Upload File">';
			 $jsString2 = "javascript:document.getElementById('ProjectOptionalImage3').value=''; document.getElementById('ProjectOptionalImage3_img').src='". Configure::read('Company.url') ."dreamcms/app/webroot/img/blank.gif'";
			 echo '<input name="removeProjectOptionalImage3" type="button" class="uploadButton" id="removeProjectOptionalImage3" onMouseUp="'.$jsString2.'" value="Remove File" />';
			 echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			 echo '<img src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/blank.gif" id="ProjectOptionalImage3_img" name="ProjectOptionalImage3_img" height="100">';
			 echo '</div>';
			 echo '</div>';
		} else { ?>
			<div class="input">
            	<label for="ProjectFeatureImage">Optional Project Image 3:</label>
                <input type="text" id="ProjectImage3Text" maxlength="255" onclick="this.select();" name="data[Project][image3Text]" value="<?php echo $this->data['Project']['image3Text'];?>" /><br />
                <img src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/uploads/projects/<?php echo $this->data['Project']['optionalImage3'];?>" height="100" style="margin: 10px 0px 0px 1px;"/>
				<?php echo $this->Html->link($html->image("delete.gif",array('id'=>'deletefile','alt'=>'delete file', 'border' => 0)), array('action' => 'deletefile', $this->data['Project']['id'].'/optionalImage3'), array('escape' => false,'id'=>'record','title'=>'delete file'), sprintf(__('Are you sure you want to delete this image?', true)));?>
             </div>
		<?php
        }
		echo $this->Form->input('featured', array('type' => 'checkbox', 'label'=>'Featured Project?', 'class'=>'checkbox'));
		echo $this->Form->input('live', array('type' => 'checkbox', 'label'=>'Push content Live?', 'class'=>'checkbox'));
		echo $this->Form->input('position',array('type'=>'hidden'));
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