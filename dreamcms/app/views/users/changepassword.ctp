<?php echo $jQValidator->validator(); ?>
<div class="users form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo $this->data['User']['id']; ?></div>
        	</div>
    	</div>
	<?php 
		echo $this->Form->create('User', array('class'=>'editForm'));
		echo $this->Form->input('id');
		echo $this->Form->input('name',  array('type' => 'hidden'));
		echo $this->Form->input('username', array('type' => 'hidden'));
		echo "<div class='input'><label>Username</label><label>";
		echo $this->data['User']['username'];
		echo "</label></div>";
		echo $this->Form->input('password', array('value' => '', 'onclick' => '$(this).select()'));
		echo $this->Form->input('email',  array('type' => 'hidden'));
		foreach ($options as $option){
			$categoryOptions[$option['Groups']['id']] = $option['Groups']['group'];
		}
		echo $this->Form->input('group_id', array('type' => 'hidden'));
		
		echo $this->Form->input('status_id',  array('type' => 'hidden'));
		/*echo $this->Form->input('group_id');
		echo $this->Form->input('status_id');*/
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
				$url = array('contoller'=>'users','action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>
        		</div>
            </div>
        </div>
	</div>
</div>