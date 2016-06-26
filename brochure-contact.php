<?php
session_start();
require_once("inc/global.php");

$str='';$success='';
if($_SESSION['errStr'])
{
	$str='<div class="error">'.$_SESSION['errStr'].'</div>';
	unset($_SESSION['errStr']);
} elseif($_SESSION['sent'] && $_SESSION['pdf']) {
	$success="<p style='color: #444; font: 16px/18px '>Thank you for your enquiry. We will be in touch with you shortly.</p>
<p><a href='".trim($_SESSION['pdf'])."' onclick='javascript:parent.$.fn.colorbox.close();parent.location.reload();' target='_blank'>Click here to view your requested brochure.</a></p>";
	
	$css='<style type="text/css">#RegisterUserForm{display:none;}</style>';
	
	unset($_SESSION['sent']);
	unset($_SESSION['pdf']);
	setcookie("BrochureContact", "TRUE", time()+60*60*24*30);
} else {
	//do nothing
}
?>
<html>
<head>
<title>Brochure Contact Form - Urban Activation</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link rel="stylesheet" type="text/css" href="<?php echo $site_path;?>css/brochure-form.css" media="all" >
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $site_path;?>js/side-contact-form.js"></script>
<script type="text/javascript" src="<?php echo $site_path;?>js/jquery.html5form-1.5-min.js"></script>
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
</head>
<body>
<div id="form-container">
<div id="registration" class="side-form">
  
	<h2>Request Brochure Access</h2>
    <p >Submitting this form is a once only requirement to get access to all of our property brochures.</p>     
		<?php if(strlen($str)>0){ ?>
            <p><?=$str;?></p>
        <?php } elseif (strlen($success)>0) {?>
            <p><?=$success.$css;?></p>
        <?php } else { //do nothing 
        } ?>
      <form id="RegisterUserForm" name="RegisterUserForm" action="<?php echo $site_path;?>brochure-contact-submit.php" method="post">
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
        
         <p>
         	<label for="message">Message</label>
         	<textarea name="message" id="message" required="required" class="textarea"></textarea>
         </p>
         <p>
         	<img id="imgCaptcha" src="<?php echo $site_path;?>captcha_image.php"  style="width: 90px; float: left; height: 29px; padding-right: 6px;"/><input id="txtCaptcha" name="txtCaptcha" type="text" required="required" value="" class="secure" maxlength="5" /><br clear="all"/><a href="javascript:getParam(document.RegisterUserForm,1)" class="sml">Get another code</a>
         </p>   

         	<input type="hidden" name="pdf" value="<?php if(strlen($_GET['pdf'])>0){echo trim($_GET['pdf']);}?>" />
            <!--<button id="registerNew" type="submit">Submit</button>-->
            <button id="btn-submit" type="submit" style="float: right; margin-right: 10px; padding: 5px 73px 5px 73px;">Submit</button>
 		</fieldset>
 	</form>
</div>
</div>
</body>
</html>