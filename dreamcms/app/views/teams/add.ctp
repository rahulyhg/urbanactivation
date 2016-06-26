<?php echo $jQValidator->validator(); ?>
<?php
if (isset($javascript)) {
	echo $javascript->link('jquery.friendurl.min.js');	
}
?>
<script type="text/javascript" language="javascript">
$(function(){
	$('#TeamName').friendurl({id : 'TeamSeoPageName', transliterate: true});
});
function uploadFile(opt, variable, fld){
	// opt    :: option
	// fld    :: folder
	// values :: 
	//           0 = image (general)
	//           1 = image
	//           2 = image
	//           3 = audio file
	//           4 = media file
	var mywin = window.open("<?php echo Configure::read('Company.url');?>dreamcms/app/views/pages/upload.php?id=<?php echo $this->data['Team']['id']; ?>&opt="+opt+"&variable="+variable+"&fld="+fld,"uploadwindow","width=400,height=200");
	mywin.focus();
}
</script>
<div class="teams form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Team Member</div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('Team', array('class'=>'editForm', 'enctype'=>'multipart/form-data', 'type'=> 'file'));
		echo $this->Form->input('name');
		echo $this->Form->input('seo_page_name', array('class'=>'text','readonly'=>'true','style'=>'background-color: transparent;border: 0 none;', 'title'=>'This is a readonly field auto-populating with Search Engine friendly URLs.'));
		foreach ($options as $option){
			$categoryOptions[$option['TeamsCategory']['id']] = $option['TeamsCategory']['category'];
		}
		echo $this->Form->input('category_id', array('type' => 'select', 'escape' => false, 'options' => $categoryOptions));
		?>
        <div class="input select">
			<label for="TeamBranches">Branch</label>
        <?php
		//display services
		foreach ($branches_list as $branch_list){			
			echo '<div class="multiCheckbox">';
			echo '<input id="TeamBranches'.$branch_list['Branch']['id'].'" type="checkbox" value="'.$branch_list['Branch']['id'].'" name="data[Team][branches][]" />';
			echo '<label for="TeamBranches'.$branch_list['Branch']['id'].'">'.$branch_list['Branch']['title'].'</label>';
			echo '</div>';
		}?>
        </div>
		<?php
		echo $this->Form->input('shortDescription', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
		<script type="text/javascript">
			var ck_teamsShortDescription = CKEDITOR.replace( 'TeamShortDescription', { 
															toolbar: 'Basic',
															height: 150,
															resize_minHeight:150,
															resize_minWidth:800,
															resize_maxWidth:800
															} );
			CKFinder.setupCKEditor( ck_teamsShortDescription, '<?php echo $ckfinderPath ?>') ;
        </script>
 		<?php
		echo $this->Form->input('body', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
    	<script type="text/javascript">
			var ck_teamsBody = CKEDITOR.replace( 'TeamBody', { 
												toolbar: 'Full',
												height: 325,
												resize_minHeight:325,
												resize_minWidth:800,
												resize_maxWidth:800
												} );
			CKFinder.setupCKEditor( ck_teamsBody, '<?php echo $ckfinderPath ?>') ;
        </script>
   		<?php
		echo $this->Form->input('phone',array('after' => 'e.g. 3 9810 1111'));
		echo $this->Form->input('mobile',array('after' => 'e.g. 4 0455 1234'));
		echo $this->Form->input('email');
		echo $this->Form->input('role');
		echo $this->Form->input('qualifications', array('class'=>'textareaForm'));
		echo $this->Form->input('memberships', array('class'=>'textareaForm'));
		echo $this->Form->input('publications', array('class'=>'textareaForm'));
		//echo $this->Form->input('photo', array('type'=>'file', 'label'=>'Member Photo'));
		//Member Photo
		$jsString1 = "javascript:uploadFile('1', 'TeamPhoto', 'teams');document.getElementById('TeamPhoto_img').src='/dreamcms/app/webroot/uploads/teams/'+document.getElementById('TeamPhoto').value";
		 echo '<div class="input file">';
		 echo '<label for="TeamPhoto">Member Photo</label>';
		 echo '<input readonly="true" name="data[Team][photo]" id="TeamPhoto" class="pdf" value="'.$this->data['Team']['photo'].'">';
		 echo '<input name="uploadTeamPhoto" type="button" class="uploadButton" id="uploadTeamPhoto" onMouseUp="'.$jsString1.'" value="Upload File">';
		 $jsString2 = "javascript:document.getElementById('TeamPhoto').value=''; document.getElementById('TeamPhoto_img').src='/dreamcms/app/webroot/uploads/teams/blank.gif'";
		 echo '<input name="removeTeamPhoto" type="button" class="uploadButton" id="removeTeamPhoto" onMouseUp="'.$jsString2.'" value="Remove File" /><br /><em>Recommended image size: 105px x 97px</em>';
		 echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
		 echo '<img src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/uploads/teams/blank.gif"  id="TeamPhoto_img" name="TeamPhoto_img" height="100">';
		 echo '</div>';
		 echo '</div>';
		 //Member Photo code ends here
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
				$url = array('contoller'=>'faqs','action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>
        		</div>
            </div>
        </div>
	</div>  
</div>