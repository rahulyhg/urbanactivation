<?php echo $jQValidator->validator(); ?>
<div class="settings form">
<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Item</div>
        	</div>
    	</div>
		<?php 
			echo $this->Form->create('Setting', array('class'=>'editForm'));
			echo $this->Form->input('key');
			echo $this->Form->input('value');
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
				//$url = array('action'=>'index');				
				//echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$_SERVER['HTTP_REFERER']."'"));
				$url = array('action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>
        		</div>
            </div>
        </div>
	</div>
</div>