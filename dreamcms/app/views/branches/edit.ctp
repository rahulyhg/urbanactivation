<?php echo $jQValidator->validator(); ?>
<?php
if (isset($javascript)) {
	echo $javascript->link('jquery.friendurl.min.js');
	echo $javascript->link('jquery.textareaCounter.plugin.js');	
	echo $javascript->link('jquery.dimensions.js');
	echo $javascript->link('jquery.tooltip.js');
	echo $javascript->link('jquery.ui.min.js');
	echo $javascript->link('jquery.tagit.js');
	echo $this->Html->css('http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css');
	echo $this->Html->css('jquery.tagit.css');
	echo $this->Html->css('tagit.ui-zendesk.css');
}
?>
<script type="text/javascript">
$(function(){
	$('#BranchTitle').friendurl({id : 'BranchSeoPageName', transliterate: true});
	$("#BranchEditForm *").tooltip();
	$("#BranchTags").tagit();
	var options2 = {
		'maxCharacterSize': 200,
		'originalStyle': 'originalTextareaInfo',
		'warningStyle' : 'warningTextareaInfo',
		'warningNumber': 40,
		'displayFormat' : '#input characters | #left characters left | #words words'
	};
	$('#BranchMetaDescription').textareaCount(options2);
});
</script>
<style>
	.charleft{
		padding: 0px 0px 0px 190px;
		font-style:italic;
		font-size: 0.9em;	
	}
</style>
<div class="branches form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Page</div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('Branch', array('class'=>'editForm'));
		echo $this->Form->input('id');
		echo $this->Form->input('title', array('class'=>'text', 'title'=>'Enter the Title for the Page.'));
		echo $this->Form->input('seo_page_name', array('class'=>'text','readonly'=>'true','style'=>'background-color: transparent;border: 0 none;', 'title'=>'This is a readonly field auto-populating with Search Engine friendly URLs.'));
		/*foreach ($options as $option){
			$categoryOptions[$option['PagesCategory']['id']] = $option['PagesCategory']['category'];
		}
		echo $this->Form->input('category_id', array('type' => 'select', 'escape' => false, 'options' => $categoryOptions, 'title'=>'Select the Category for this Page.'));
		echo $this->Form->input('tags', array('type'=>'text', 'title'=>'Enter tags.'));*/
		?>
		<!-- Build your tags here. This is just an example of static tags. For dynamic tags from DB add your logic and run the HTML in a Loop-->
        <!--<div id="availableTags">
        	<em>Click to add available tags: 
        	<a href="#" onclick="javascript:$('#BranchTags').tagit('createTag', 'Text');return false;">Text</a>, 
            <a href="#" onclick="javascript:$('#BranchTags').tagit('createTag', 'Sample Tag');return false;">Sample Tag</a>,
            <a href="#" onclick="javascript:$('#BranchTags').tagit('createTag', 'Keyword');return false;">Keyword</a>,
            <a href="#" onclick="javascript:$('#BranchTags').tagit('createTag', 'Add Me');return false;">Add Me!</a>,
            <a href="#" onclick="javascript:$('#BranchTags').tagit('createTag', 'This is cool.');return false;">This is cool.</a>
        	</em><br /><br />
            <em>You can also add new tags by typing one word and hit either 'Enter' or 'Space bar' or 'Click mouse elsewhere'<br />For multiple Words start and finish with <b>double quotes</b> and hit enter, e.g. <b>"</b>two words<b>"</b></em><br /><br />
            <em>To remove one tag select the x next to the tag, to remove all select: <a href="#" onclick="javascript:$('#BranchTags').tagit('removeAll');return false;">Remove All</a></em>
        </div>-->
		<?php
        echo $this->Form->input('metaKeywords', array('type'=>'textarea','rows'=>'3','cols'=>'61','class'=>'text', 'title'=>'Enter Page keywords for Search Engines.'));
		echo $this->Form->input('metaDescription',array('type'=>'textarea','rows'=>'3','cols'=>'61', 'class'=>'nrmlTextArea','title'=>'Enter Page description for Search Engines.'));
		echo $this->Form->input('body', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
        <script type="text/javascript">
			var ck_branchesBody = CKEDITOR.replace( 'BranchBody', { 
												toolbar: 'Full',
												height: 325,
												resize_minHeight:325,
												resize_minWidth:800,
												resize_maxWidth:800
												} );
			CKFinder.setupCKEditor( ck_branchesBody, '<?php echo $ckfinderPath ?>') ;
        </script>
   		
        <?php
        echo $this->Form->input('phone', array('title'=>'Enter Phone Number.','after' => 'e.g. 3 9810 1111'));
		echo $this->Form->input('fax', array('title'=>'Enter Fax Number.','after' => 'e.g. 3 9810 1111'));
		echo $this->Form->input('email', array('title'=>'Enter Email address.'));
		echo $this->Form->input('map', array('type'=>'text','class'=>'text', 'title'=>'Enter Google map address.'));
		echo $this->Form->input('address1', array('type'=>'text','class'=>'text', 'title'=>'Enter Address Line 1.'));
		echo $this->Form->input('address2', array('type'=>'text','class'=>'text', 'title'=>'Enter Address Line 2.'));
		echo $this->Form->input('postal1', array('type'=>'text','class'=>'text', 'title'=>'Enter Postal Address 1.'));
		echo $this->Form->input('postal2', array('type'=>'text','class'=>'text', 'title'=>'Enter Postal Address 2.'));
		?>
        <div class="input select">
			<label for="BranchPages">Services</label>
        <?php
		$explodedServicesID = explode(',',$this->data['Branch']['pages']);	
		//var_dump($explodedServicesID);
		foreach ($services_list as $service_list){
			$checked = '';	
			$serviceOptions[$service_list['Pages']['id']] = $service_list['Pages']['title'];
			for($i=0;$i<count($explodedServicesID);$i++){
				if($service_list['Pages']['id']==(int)$explodedServicesID[$i]){
					//echo "ServicesID:".(int)$explodedServicesID[$i]." is Checked\n";
					$checked = 'checked';
					break;
				}				
			}		
			echo '<div class="multiCheckbox">';
			echo '<input id="BranchPages'.$service_list['Pages']['id'].'" type="checkbox" value="'.$service_list['Pages']['id'].'" name="data[Branch][pages][]" '.$checked.' />';
			echo '<label for="BranchPages'.$service_list['Pages']['id'].'">'.$service_list['Pages']['title'].'</label>';
			echo '</div>';
		}?>
        </div>
        <?php
		echo $this->Form->input('position',array('type'=>'hidden'));
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
				//$url = array('action'=>'index');
				$url = $_SERVER['HTTP_REFERER'];
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>
        		</div>
            </div>
        </div>
	</div>  
</div>