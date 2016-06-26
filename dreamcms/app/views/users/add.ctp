<?php echo $jQValidator->validator(); ?>
<div class="users form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Users</div>
        	</div>
    	</div>
	<?php 
		echo $this->Form->create('User', array('class'=>'editForm'));		
		echo $this->Form->input('name');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('email');
		foreach ($options as $option){
			$categoryOptions[$option['Groups']['id']] = $option['Groups']['group'];
		}
		echo $this->Form->input('group_id', array('type' => 'select', 'escape' => false, 'options' => $categoryOptions));
		foreach ($us_options as $us_options){
			$usCategoryOptions[$us_options['UserStatuses']['id']] = $us_options['UserStatuses']['status'];
		}
		echo $this->Form->input('status_id', array('type' => 'select', 'escape' => false, 'options' => $usCategoryOptions));
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
				$url = array('contoller'=>'news','action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
			?>
            	</div>
       		</div>
		</div>
	</div>
</div>