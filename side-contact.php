<?php
//session_start();
//require_once("inc/connection.php");
if(isset($_SESSION['errStr']))
{
	$str='<div class="error">'.$_SESSION['errStr'].'</div>';
	unset($_SESSION['errStr']);
} elseif(isset($_SESSION['sent'])) {
	$success="<p style='color: #fff; font: 16px/18px Arial sans-serif;'>Thank you for your enquiry. We will be in touch with you shortly.</p>";
	
	$css='<style type="text/css">#RegisterUserForm{display:none;}</style>';
	
	unset($_SESSION['sent']);
} else {
	//do nothing
	$str='';$success='';
}
?>
<script type="text/javascript" src="<?php echo $site_path;?>captcha_ajax.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
    $("#RegisterUserForm label").inFieldLabels();
	//$('#RegisterUserForm').h5Validate();
	$('#RegisterUserForm').html5form({    
        messages : 'de', // Options 'en', 'es', 'it', 'de', 'fr', 'nl', 'be', 'br'
        responseDiv : '#response',
		//labels: 'hide',
		allBrowsers: true,
		method: 'POST'    
    })
});
</script>
<div class="expert-panel opacity" >

	<h2 style="font-size: 25px; line-height: 110%; padding-bottom: 15px;"><?php
		if($pageCategoryID > 0){
			//echo $pageCategory."SPEAK TO AN EXPERT";
			if($validPageID == 16) 
				echo "SEMINAR INFORMATION";
			else
				echo "SPEAK TO AN EXPERT";
		} elseif(count($property_details)>0) {
			echo "ENQUIRE ABOUT A PROPERTY";	
		} else {
			echo "SPEAK TO AN EXPERT";	
		}
	  ?>
	  </h2>


<div id="registration" class="side-form" >

      
		<?php if(strlen($str)>0){ ?>
            <p><?=$str;?></p>
        <?php } elseif (strlen($success)>0) {?>
            <p><?=$success.$css;?></p>
        <?php } else { //do nothing 
        } ?>
      <form id="RegisterUserForm" name="RegisterUserForm" action="<?php echo $site_path;?>side-contact-submit.php" method="post">
 		<fieldset>
         <p>
            <label for="name">Your name</label>
            <input id="name" name="name" type="text" required="required" class="text" value="" />
         </p>
        
         <p>
            <label for="tel">Your contact phone</label>
            <input id="tel" name="tel" type="tel" required="required" class="text" value="" />
         </p>
        
         <p>
            <label for="email">Your email</label>
            <input id="email" name="email" type="email" required="required" class="text" value="" />
         </p>
         <?php if($validPageID == 16) { ?>
         <p>
            <label for="seminar">Seminar location</label>
            <input id="seminar" name="seminar" type="text" required="required" class="text" value="" />
         </p>
         <?php } ?>
         <?php if(isset($msgBoxContent) && strlen($msgBoxContent)>0){
		 ?>
         <p>
         	<!--<label for="message">Message</label>-->
         	<textarea name="message" id="message" required="required" class="textarea">I would like to know more about <?php echo $msgBoxContent;?></textarea>
         </p>
         <?php } else { ?>
         <p>
         	<label for="message">Message</label>
         	<textarea name="message" id="message" required="required" class="textarea" style="height:29px"></textarea>
         </p>
         <?php } ?>
         <p>
         	<img id="imgCaptcha" src="<?php echo $site_path;?>captcha_image.php"  style="width: 90px; float: left; height: 29px; padding-right: 6px;"/><input id="txtCaptcha" name="txtCaptcha" type="text" required="required" value="" class="secure" maxlength="5" /><br clear="all"/><a href="javascript:getParam(document.RegisterUserForm,1)" class="sml" style="color: #fff;">Get another code</a>
         </p>   

         	<input type="hidden" name="enquiryType" value="<?php if($pageCategoryID == 16) {echo "Seminars";} elseif($pageCategoryID > 0){echo $pageCategory;}else{echo "Property";}?>" />
            <!--<button id="registerNew" type="submit">Submit</button>-->
            <button id="btn-contact"  type="submit" style="padding: 5px 53px;">Submit Enquiry</button>

 		</fieldset>

 	</form>

</div>
<br clear="all" />
<div style="text-align: center;margin: 0px 0px 0px 40px;">
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-504569fc0edf6126"></script>
<!-- AddThis Button END -->
</div>
</div>