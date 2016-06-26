<?php
	$title = "Contact Urban Activation";
	$page = "contact"; /* this name must match css to display active menu */
	require_once("inc/head.php"); 
	
	//contact form specific changes
	if($_SESSION['errStr'])
	{
		$str='<div class="error">'.$_SESSION['errStr'].'</div>';
		unset($_SESSION['errStr']);
	} elseif($_SESSION['sent']) {
		$success="<p style='color: #444; font: 16px/18px Arial sans-serif;'>Thank you for your enquiry. We will be in touch with you shortly.</p>";
		
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
  <!-- content section -->

<div id="content" class="content-inside">
    <div id="col-left" class="opacity">    
      <h2>CONTACT URBAN ACTIVATION</h2>
      <div id="address1" style="float: left; margin-right: 50px;">
        Level 1, 122 Toorak Road<br />
South Yarra VIC Australia 3141
      </div>
<div id="address2" style="float: left;"><i class='icon-phone'></i> <strong>T</strong> 1300 750 000<br />
      <strong>F</strong> 03 9820 8262</div>
       
<div style="clear:both;"></div>


<a name="enquiry" id="enquiry"></a><h2>Online enquiry</h2>
        	<?php if(strlen($str)>0){ ?>
<p><?=$str;?></p>
            <?php } elseif (strlen($success)>0) {?>
                <p><?=$success.$css;?></p>
            <?php } else { //do nothing 
            } ?>
        		<div id="registration" class="main-contact">
            		<form id="RegisterUserForm" name="RegisterUserForm" action="<?php echo $site_path;?>contact-submit.php" method="post">
                	<fieldset>
                    
                   
                   	  <p><span class="field-label">Name*</span></p>
                      <div style="float: left;">
                        <span class="field" style=" width: 90%;">
                        	<label for="fname">Your name</label>
                        	<input id="fname" name="fname" type="text" required="required" class="text" value="" />
                        </span>
                    </div>
                    
                    
                   <!--<span class="field-label">Surname*</span>-->
<div style="float: left; width: 50%;">
                        <span class="field" style=" width: 90%;">
                        <label for="last">Your surname</label>
                        <input id="last" name="last" type="text" required="required" class="text" value="" /></span>
                    </div>
                    
                    <p><span class="field-label">Phone*</span>
                        <span class="field">
                        <label for="tel">Your contact phone</label>
                        <input id="tel" name="tel" type="tel" required="required" class="text" value="" /></span>
                    </p>
                    
                    <p><span class="field-label">Email*</span>
                        <span class="field">
                        <label for="email">Your email</label>
                        <input id="email" name="email" type="email" required="required" class="text" value="" /></span>
                    </p>
                    <!--<p><span class="field-label">Address</span>
                        <span class="field">
                        <label for="addr">Your address</label>
                        <input id="addr" name="addr" type="text"  class="text" value="" /></span>
                    </p>
                    <p><span class="field-label">Suburb</span>
                        <span class="field">
                        <label for="suburb">Your suburb</label>
                        <input id="suburb" name="suburb" type="text"  class="text" value="" /></span>
                    </p>-->
                    <p><span class="field-label">State</span>
                        <span class="field">
                    
<select name="state" id="state" >
                        	<option value="">Select state</option>
                            <option value="VIC" selected>VIC</option>
                            <option value="NSW">NSW</option>
                            <option value="QLD">QLD</option>
                            <option value="ACT">ACT</option>
                            <option value="NT">NT</option>
                            <option value="WA">WA</option>
                            <option value="SA">SA</option>
                            <option value="TAS">TAS</option>
                            <option value="OTHER">OTHER</option>
                        </select></span>
                    </p>
                   <!-- 
                    <p><span class="field-label">Postcode</span>
                        <span class="field">
                        <label for="postcode">Your postcode</label>
                        <input id="postcode" name="postcode" type="text"  class="text" value="" style="width: 40%;"/></span>
                    </p>
                    
                    <p><span class="field-label">Preferred Contact*</span>
                        <span class="field">
   
                        <select name="contact" id="contact" required="required">
                        	<option value="" selected="selected">Preferred contact</option>
                            <option value="No preference">No preference</option>
                            <option value="Phone">Phone</option>
                            <option value="Email">Email</option>
                            <option value="Post">Post</option>
                        </select></span>
                    </p> -->
                                        <p><span class="field-label">How did you find us?</span>
                        <span class="field">
                    	<!--<label for="find">How did you find us?</label>-->
                        <select name="how" id="how">
                        	<option value="" selected="selected">How did you find us?</option>
                            <option value="Friend">Friend</option>
                            <option value="Google">Google</option>
                            <option value="Twitter">Twitter</option>
                            <option value="LinkedIn">Linked In</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Newspaper">Newspaper</option>
                            <option value="Other">Other</option>
                        </select></span>
                    </p>
                    <p><span class="field-label">Enquiry Type</span>
                        <span class="field">
                    	<!--<label for="enquiryType">Enquiry type</label>-->
                        <select name="enquiryType" id="enquiryType">
                        	<option value="" selected="selected">Enquiry type</option>
						  	<?php
                            $resPageCategories = array();
                            $pageCategories = getPageCategories();
                            while($resPageCategories  = mysql_fetch_array($pageCategories, MYSQL_ASSOC)){
                                //if($resPageCategories["id"] != 1 && $resPageCategories["id"] != 6){
                                    echo "<option value='".$resPageCategories["category"]."'>".$resPageCategories["category"]."</option>";
                                //}
                            }
                          	?>
                            <option value="Other">Other</option>
                       </select></span>
                    </p>
                                        

                    
<p><span class="field-label">Enquiry Details</span>
                        <span class="field">
                        <label for="message">Enquiry Details</label>
                        <textarea name="message" id="message"  class="textarea"></textarea></span>
                    </p>
                    
                    <p><span class="field-label">Security Code*</span>
                        <span class="field">
                        <img id="imgCaptcha" src="<?php echo $site_path;?>captcha_image.php"  style="width: 90px; float: left; height: 29px; padding-right: 6px;"/><input id="txtCaptcha" name="txtCaptcha" type="text" required="required" value="" class="secure" maxlength="5" /><br clear="all"/><a href="javascript:getParam(document.RegisterUserForm,1)" class="sml">Get another code</a>
                     </span></p> 
                     <span class="field-label"></span>
                        <span class="field">
                    <button id="btn-contact" type="submit" style="float: left; margin-right: 10px; padding: 5px 50px;">Submit Enquiry</button></span>
				</fieldset>
			</form>
    </div>
</div>
	<div id="col-right" class="opacity" >
    
    <iframe width="285" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com.au/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=15+Claremont+Street,+South+Yarra&amp;aq=&amp;sll=-36.605471,145.469483&amp;sspn=7.450331,16.907959&amp;ie=UTF8&amp;hq=&amp;hnear=15+Claremont+St,+South+Yarra+Victoria+3141&amp;t=m&amp;ll=-37.837988,144.993782&amp;spn=0.016946,0.024376&amp;z=14&amp;iwloc=A&amp;output=embed&iwloc=near"></iframe><br /><small><a href="http://maps.google.com.au/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=15+Claremont+Street,+South+Yarra&amp;aq=&amp;sll=-36.605471,145.469483&amp;sspn=7.450331,16.907959&amp;ie=UTF8&amp;hq=&amp;hnear=15+Claremont+St,+South+Yarra+Victoria+3141&amp;t=m&amp;ll=-37.837988,144.993782&amp;spn=0.016946,0.024376&amp;z=14&amp;iwloc=A" style="text-align:left">View Larger Map</a></small>
       

    </div>

</div>
<?php include("inc/foot.php"); ?>