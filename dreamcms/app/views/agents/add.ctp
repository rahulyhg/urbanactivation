<?php echo $jQValidator->validator(); ?>
<?php
if (isset($javascript)) {
	echo $javascript->link('jquery.friendurl.min.js');
	echo $this->Html->css('thickbox.css'); 
	echo $this->Html->script('thickbox.js');
	echo $javascript->link('jquery-ui-1.8.21.custom.min.js');
	echo $javascript->link('jquery.ui.sortable.js');
}
?>

<script language="javascript" type="text/javascript">

$(function()
{
    Date.format = 'dd/mm/yyyy';
    $('#Expirydate').datePicker({startDate:'01/01/2015'});
});

</script>
<div class="Agents form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Agent</div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('Agent', array('class'=>'editForm', 'enctype'=>'multipart/form-data', 'type'=> 'file'));
		
		$titles = array('Mr'=>'Mr', 'Mrs'=>'Mrs', 'Miss'=>'Miss', 'Ms'=>'Ms');
                $states = array('VIC' => 'VIC', 'NSW' => 'NSW', 'QLD' => 'QLD', 'ACT' => 'ACT', 'NT' => 'NT', 'WA' => 'WA', 'SA' => 'SA', 'TAS' => 'TAS');
		echo $this->Form->input('title', array('type' => 'select', 'escape' => false, 'options' => $titles));
		
		echo $this->Form->input('firstname',array('class'=>'text', 'label' => 'First Name *'));
		echo $this->Form->input('lastname',array('class'=>'text', 'label' => 'Last Name *'));		
		echo $this->Form->input('phone',array('class'=>'text','style'=>'width:30%;', 'label' => 'Phone *'));	
                echo $this->Form->input('mobile',array('class'=>'text','style'=>'width:30%;'));	
		echo $this->Form->input('email',array('class'=>'text', 'label' => 'Email *'));
                echo $this->Form->input('company', array('class'=>'text', 'style'=>'width:20%;', 'label' => 'Company *'));
		echo $this->Form->input('address',array('class'=>'text'));	
		echo $this->Form->input('suburb',array('class'=>'text'));	
		echo $this->Form->input('state',array('type' => 'select', 'options' => $states, 'style'=>'width:20%;'));	
		echo $this->Form->input('postcode',array('class'=>'text','style'=>'width:20%;'));				
                echo $this->Form->input('password',array('class'=>'text','style'=>'width:20%;'));        
		echo $this->Form->input('active', array('type' => 'checkbox', 'label'=>'Active'));
		
		?>
        <div id="record_wrap">

            <div class="record_row_data" id="record_row">
                <div id="record_data" class="btn-grp end">
		<?php 
				echo $this->Form->button('Submit', array('type'=>'submit'));		
				$url = array('action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>
        		</div>
            </div>
        </div>
	</div>
</div>