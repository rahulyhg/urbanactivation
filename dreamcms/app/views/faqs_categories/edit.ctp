<?php echo $jQValidator->validator(); ?>
<?php
if (isset($javascript)) {
	echo $javascript->link('jquery.friendurl.min.js');
}
?>
<script type="text/javascript">
$(function(){
	$('#FaqsCategoryCategory').friendurl({id : 'FaqsCategorySeoPageName', transliterate: true});
});
</script>
<div class="faqsCategories form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo $this->data['FaqsCategory']['id']; ?></div>
        	</div>
    	</div>
	<?php 
		echo $this->Form->create('FaqsCategory', array('class'=>'editForm'));
		echo $this->Form->input('id');
		echo $this->Form->input('category');
		echo $this->Form->input('seo_page_name', array('class'=>'text','readonly'=>'true','type'=>'hidden'));
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