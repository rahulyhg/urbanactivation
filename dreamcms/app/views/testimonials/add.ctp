<?php echo $jQValidator->validator(); ?>
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
	var mywin = window.open("<?php echo Configure::read('Company.url');?>dreamcms/app/views/pages/upload.php?id=<?php echo $this->data['Testimonial']['id']; ?>&opt="+opt+"&variable="+variable+"&fld="+fld,"uploadwindow","width=400,height=200");
	mywin.focus();
}
</script>
<div class="testimonials form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Testimonial</div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('Testimonial', array('class'=>'editForm'));
		echo $this->Form->input('person_company',array('type'=>'text','label'=> 'Person/Company'));
		echo $this->Form->input('description',array('type'=>'textarea','rows'=>'10','cols'=>'44'));
		
		$jsString1 = "javascript:uploadFile('1', 'TestimonialPhoto', 'testimonials');document.getElementById('TestimonialPhoto_img').src='".Configure::read("Company.url")."dreamcms/app/webroot/uploads/testimonials/'+document.getElementById('TestimonialPhoto').value";
		 echo '<div class="input file">';
		 echo '<label for="TestimonialPhoto">Photo</label>';
		 echo '<input readonly="true" name="data[Testimonial][photo]" id="TestimonialPhoto" class="pdf" value="'.$this->data['Testimonial']['photo'].'">';
		 echo '<input name="uploadTestimonialPhoto" type="button" class="uploadButton" id="uploadTestimonialPhoto" onMouseUp="'.$jsString1.'" value="Upload File">';
		 $jsString2 = "javascript:document.getElementById('TestimonialPhoto').value=''; document.getElementById('TestimonialPhoto_img').src='".Configure::read("Company.url")."dreamcms/app/webroot/uploads/testimonials/blank.gif'";
		 echo '<input name="removeTestimonialPhoto" type="button" class="uploadButton" id="removeTestimonialPhoto" onMouseUp="'.$jsString2.'" value="Remove File" />';
		 echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
		 echo '<img src="'.Configure::read("Company.url").'dreamcms/app/webroot/uploads/testimonials/blank.gif"  id="TestimonialPhoto_img" name="TestimonialPhoto_img" height="100">';
		 echo '</div>';
		 echo '</div>';
		
		echo $this->Form->input('position', array('type'=>'hidden', 'value'=>$maxPosition));
		echo $this->Form->input('live', array('type' => 'checkbox', 'label'=>'Push content Live?', 'class'=>'checkbox'));
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
				$url = array('contoller'=>'testimonials','action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>
        		</div>
            </div>
        </div>
	</div>  
</div>