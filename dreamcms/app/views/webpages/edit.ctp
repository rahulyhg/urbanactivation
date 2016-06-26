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
	//$('#WebpageTitle').friendurl({id : 'WebpageSeoPageName', transliterate: true});
	$("#WebpageEditForm *").tooltip();
	$("#WebpageTags").tagit();
	var options2 = {
		'maxCharacterSize': 200,
		'originalStyle': 'originalTextareaInfo',
		'warningStyle' : 'warningTextareaInfo',
		'warningNumber': 40,
		'displayFormat' : '#input characters | #left characters left | #words words'
	};
	$('#WebpageMetaDescription').textareaCount(options2);
	$('#copy').click(function(){
		var con = true;
		if($('#WebpageMetaTitle').val()!=''){
			con = confirm('Are you sure you would like to over write current "Meta Title"?');
		}
		if (con){
			$('#WebpageMetaTitle').val($('#WebpageTitle').val());
		}
	});
	$('#copy_seo').click(function(){
		if($('#WebpageTitle').val()!=''){
			con = confirm('Warning: changing this SEO Title may affect links within the site, proceed?');
			if (con == true){
				$('#WebpageSeoPageName').val($('#WebpageSeoPageNameCopy').val());
			}
		}
	});
	var options3 = {
		'maxCharacterSize': 65,
		'originalStyle': 'originalTextareaInfo',
		'warningStyle' : 'warningTextareaInfo',
		'warningNumber': 10,
		'displayFormat' : '#input characters | #left characters left'
	};
	$('#WebpageMetaTitle').textareaCount(options3);
	$('#WebpageTitle').friendurl({id : 'WebpageSeoPageNameCopy'});
	
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
	var mywin = window.open("<?php echo Configure::read('Company.url');?>dreamcms/app/views/pages/upload.php?id=<?php echo $this->data['Webpage']['id']; ?>&opt="+opt+"&variable="+variable+"&fld="+fld,"uploadwindow","width=400,height=200");
	mywin.focus();
}
</script>
<style>
	.charleft{
		padding: 0px 0px 0px 190px;
		font-style:italic;
		font-size: 0.9em;	
	}
</style>
<div class="webpages form">
	<div id="record">
    	<div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo $this->data['Webpage']['id']; ?></div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('Webpage', array('class'=>'editForm','enctype'=>'multipart/form-data', 'type'=> 'file'));
		echo $this->Form->input('id');
		echo $this->Form->input('title', array('class'=>'text', 'title'=>'Enter the Title for the Page.', 'after'=>'<input id="copy_seo" style="width: 100px;" type="button" value="Copy to Seo Title" />'));
		echo $this->Form->input('seo_page_name', array('class'=>'text','readonly'=>'true','style'=>'background-color: transparent;border: 0 none;', 'title'=>'This is a readonly field auto-populating with Search Engine friendly URLs.'));
		echo $this->Form->input('seo_page_name_copy', array('type'=>'hidden','readonly'=>'true','value'=>$this->data['Webpage']['seo_page_name']));
		foreach ($options as $option){
			$categoryOptions[$option['PagesCategory']['id']] = $option['PagesCategory']['category'];
		}
		echo $this->Form->input('category_id', array('type' => 'select', 'escape' => false, 'options' => $categoryOptions, 'title'=>'Select the Category for this Page.'));
		//echo $this->Form->input('tags', array('type'=>'text', 'title'=>'Enter tags.'));
		?>
		<!-- Build your tags here. This is just an example of static tags. For dynamic tags from DB add your logic and run the HTML in a Loop-->
        <!--<div id="availableTags">
        	<em>Click to add available tags: 
        	<a href="#" onclick="javascript:$('#WebpageTags').tagit('createTag', 'Text');return false;">Text</a>, 
            <a href="#" onclick="javascript:$('#WebpageTags').tagit('createTag', 'Sample Tag');return false;">Sample Tag</a>,
            <a href="#" onclick="javascript:$('#WebpageTags').tagit('createTag', 'Keyword');return false;">Keyword</a>,
            <a href="#" onclick="javascript:$('#WebpageTags').tagit('createTag', 'Add Me');return false;">Add Me!</a>,
            <a href="#" onclick="javascript:$('#WebpageTags').tagit('createTag', 'This is cool.');return false;">This is cool.</a>
        	</em><br /><br />
            <em>You can also add new tags by typing one word and hit either 'Enter' or 'Space bar' or 'Click mouse elsewhere'<br />For multiple Words start and finish with <b>double quotes</b> and hit enter, e.g. <b>"</b>two words<b>"</b></em><br /><br />
            <em>To remove one tag select the x next to the tag, to remove all select: <a href="#" onclick="javascript:$('#WebpageTags').tagit('removeAll');return false;">Remove All</a></em>
        </div>-->
		<?php
        echo $this->Form->input('metaTitle', array('class'=>'text', 'after'=>'<input id="copy" style="width: 100px;left: 75%;position: relative;top: -50px;" type="button" value="Copy from Title" />', 'title'=>'Enter the Page Title for Search Engines. We recommend it to be 65 characters long for best results.'));
        echo $this->Form->input('metaKeywords', array('type'=>'textarea','rows'=>'3','cols'=>'61','class'=>'text', 'title'=>'Enter Page keywords for Search Engines.'));
		echo $this->Form->input('metaDescription',array('type'=>'textarea','rows'=>'3','cols'=>'61', 'class'=>'nrmlTextArea','title'=>'Enter Page description for Search Engines.'));
		//echo $this->Form->input('tagline', array('class'=>'text', 'title'=>'Enter the Tagline for the Page.', 'maxlength' => '100'));
		echo $this->Form->input('shortDescription', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
		<script type="text/javascript">
			var ck_webpagesShortDescription = CKEDITOR.replace( 'WebpageShortDescription', { 
															toolbar: 'Basic',
															enterMode : CKEDITOR.ENTER_BR,
															shiftEnterMode: CKEDITOR.ENTER_P,
															height: 150,
															resize_minHeight:150,
															resize_minWidth:800,
															resize_maxWidth:800
															} );
			CKFinder.setupCKEditor( ck_webpagesShortDescription, '<?php echo $ckfinderPath ?>') ;
        </script>
 		<?php
        echo $this->Form->input('body', array('between'=>'<br />','type' => 'textarea', 'escape' => false, 'class' => $ckeditorClass));
		?>
        <script type="text/javascript">
			var ck_webpagesBody = CKEDITOR.replace( 'WebpageBody', { 
												toolbar: 'Full',
												height: 325,
												resize_minHeight:325,
												resize_minWidth:800,
												resize_maxWidth:800
												} );
			CKFinder.setupCKEditor( ck_webpagesBody, '<?php echo $ckfinderPath ?>') ;
        </script>
   		
        <?php
		/*if(strlen($this->data['Webpage']['photo'])<=0){
			//Page Photo
			$jsString1 = "javascript:uploadFile('1', 'WebpagePhoto', 'pages');document.getElementById('WebpagePhoto_img').src='".Configure::read('Company.url')."dreamcms/app/webroot/uploads/pages/'+document.getElementById('WebpagePhoto').value";
			 echo '<div class="input file">';
			 echo '<label for="WebpagePhoto">Left Panel Photo</label>';
			 echo '<input readonly="true" name="data[Webpage][photo]" id="WebpagePhoto" class="pdf" value="'.$this->data['Webpage']['photo'].'">';
			 echo '<input name="uploadWebpagePhoto" type="button" class="uploadButton" id="uploadWebpagePhoto" onMouseUp="'.$jsString1.'" value="Upload File">';
			 $jsString2 = "javascript:document.getElementById('WebpagePhoto').value=''; document.getElementById('WebpagePhoto_img').src='".Configure::read('Company.url')."dreamcms/app/webroot/uploads/teams/blank.gif'";
			 echo '<input name="removeWebpagePhoto" type="button" class="uploadButton" id="removeWebpagePhoto" onMouseUp="'.$jsString2.'" value="Remove File" /><br /><em>Recommended image size: 218px x 134px</em>';
			 echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			 echo '<img src="'.Configure::read('Company.url').'dreamcms/app/webroot/uploads/pages/blank.gif"  id="WebpagePhoto_img" name="WebpagePhoto_img" height="100">';
			 echo '</div>';
			 echo '</div>';
			 //Page Photo code ends here
		} else { ?>
			<div class="input">
            	<label for="WebpagePhoto">Left Panel Photo</label>
            	<img src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/uploads/pages/<?php echo $this->data['Webpage']['photo'];?>" height="100"/>
				<?php echo $this->Html->link($html->image("delete.gif",array('id'=>'deletefile','alt'=>'delete file', 'border' => 0)), array('action' => 'deletefile', $this->data['Webpage']['id']), array('escape' => false,'id'=>'record','title'=>'delete file'), sprintf(__('Are you sure you want to delete this file?', true)));?><br clear='all'><span style='margin: 0px 0px 0px 187px;'><em>Recommended image size: 218px x 134px</em></span>
             </div>
        <?php
		}*/
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