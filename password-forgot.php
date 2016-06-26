<?php
	$title = "UA Reset Password";
	$page = "password";
	$keywords = "UA, Reset Password ";
	$description = "UA - Reset Password";
	require_once("inc/head.php");		
        require_once("./emailUA.php");
        $emailSent = false;

    // Check for Email Address
	if (isset($_POST['txtEmail']))  {		
		$rsMembers = getAgentByEmail($_POST['txtEmail']);
		while ($rsMember = mysql_fetch_array($rsMembers, MYSQL_ASSOC)) {			
		    $memberId = $rsMember["id"];
			$firstName = $rsMember["firstname"];
			$memberEmail = $rsMember["email"];
			$resetToken = md5($_POST['txtEmail'].time);			
			setAgentToken($memberId, $resetToken);
			
		    emailMembershipReset($memberId, $firstName, $resetToken, $memberEmail);
                    $emailSent = true;                   
		}
                // email address doesn't exist
                if($emailSent == false){
                     $strError = "email address is not registered with UA, Please try again!";
                }
                $txtEmail = $_POST['txtEmail'];
	}  		
?>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
    $("#frmPassword label").inFieldLabels();
	//$('#RegisterUserForm').h5Validate();
	$('#frmPassword').html5form({    
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
        <?php if($emailSent == false){ echo $strError . '<br>';?>
<h1>Reset Password</h1>
<h3>Please fill out your email address below and we'll email you a link to create a new password.</h3>
        <?php } else{ ?>
    <h3>An email has been sent to you with details on how to reset your password.</h3>
        <?php } ?>
<div id="registration" class="package">
    <form id="frmPassword" name="frmPassword" action="<?php echo $site_path;?>password-forgot" method="post">
        <fieldset> 
           <p><span class="field-label">Email *</span>
              <span class="field">
                  <label for="txtEmail">Your email</label>
                  <input id="txtEmail" name="txtEmail" type="text" required="required" value="<?php echo $txtEmail;?>" class="text"/>
              </span>
            </p>           
           <span class="field-label"></span>  
           <span class="field">    
              <button id="btn-submit" type="submit" class="btn-next-form">Send Email <i class='icon-chevron-right'></i></button>            
           </span>             
        </fieldset>
      </form>
    </div>
</div>
<div id="col-right" class="opacity">   
<h2>Welcome to our Agent access area.</h2>


        </div> 
</div>

<?php include("inc/foot.php"); ?>                    