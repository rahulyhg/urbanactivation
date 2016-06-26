<?php echo $jQValidator->validator(); ?>
<?php
if (isset($javascript)) {
	echo $javascript->link('jquery.friendurl.min.js');
}
?>
<script type="text/javascript">
$(function(){
	$('#PropertiesStatusStatus').friendurl({id : 'PropertiesStatusSeoPageName', transliterate: true});
});
</script>
<div class="propertiesStatuses form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo $this->data['PropertiesStatus']['id']; ?></div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('PropertiesStatus', array('class'=>'editForm'));
		echo $this->Form->input('id');
		echo $this->Form->input('status');
		echo $this->Form->input('seo_page_name', array('class'=>'text','readonly'=>'true','style'=>'background-color: transparent;border: 0 none;', 'title'=>'This is a readonly field auto-populating with Search Engine friendly URLs.'));
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