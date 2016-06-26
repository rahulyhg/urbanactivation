<?php
	require_once("inc/connection.php"); 					    	
	
	// ***************************************************************************************************************	
	// Check Log In Details	
	// ***************************************************************************************************************
	if ($_SESSION['UA']['memberID'] == "")  {
	   header('location: '.$site_path.'login');	
	} else  {		
	   // Get Member Details	   
	   $rsMember = getAgentByID($_SESSION['UA']['memberID']);
  	   $rsMember = mysql_fetch_array($rsMember, MYSQL_ASSOC);		      
	   $txtMemberId = $rsMember['id'];   
	}	
	// ***************************************************************************************************************	
	// Check for Update
	// ***************************************************************************************************************
	if ((isset($_GET["status"])) && ($_GET["status"] == "success"))  {
	   $strMessage = "Your password has been changed.  Thank-you!";	
	}
	
	if ((isset($_GET["status"])) && ($_GET["status"] == "error"))  {
	   $strMessage = "Your current password is not correct.  Please try again!";	
	}	
	// ***************************************************************************************************************	
	
	$err = FALSE;	
	$title = "My Account - Change Password";
	$page = "account";
	$keywords = "UA, My Account Change Password";
	$description = "UA - Change My Password";
	require_once("inc/head.php"); 
	$displayPages = true;   
?>
<script type="text/javascript" src="<?php echo $site_path;?>js/password-strength.js"></script> <!--For password strength checking -->
<script type="text/javascript" language="javascript">
$(document).ready(function() {	
    $("#frmChange label").inFieldLabels();	
	$('#frmChange').html5form({    
        messages : 'de', // Options 'en', 'es', 'it', 'de', 'fr', 'nl', 'be', 'br'
        responseDiv : '#response',	
		allBrowsers: true,
		method: 'POST'    
    })		
});

function password_onchange()  {
	if (document.getElementById("txtPassword").value != "" && document.getElementById("txtPassword2").value != "")  {
       if (document.getElementById("txtPassword").value != document.getElementById("txtPassword2").value)  {
	      alert("The passwords do not match.  Please try again.");
		  document.getElementById("txtPassword").value = "";
		  document.getElementById("txtPassword2").value = "";	
		  
		  $("#frmChange label").inFieldLabels();
		  document.getElementById("spPasswordResult").innerHTML = "";
	   }
	}
}

</script>
<style>
#frmChange .short{
	color:#FF0000;
}

#frmChange .weak{
	color:#E66C2C;
}

#frmChange .good{
	color:#2D98F3;
}

#frmChange .strong{
	color:#006400;
}
</style>
<!-- content section -->
<div id="content" class="content-inside">
    <div id="col-left" class="opacity"> 
           <h1>Change Your Password</h1>
               <div id="registration" class="main-contact">
               
                  <form id="frmChange" name="frmChange" action="<?php echo $site_path;?>account-change-password-submit.php" method="post">
                  <fieldset> 
                  
                      <p><span class="field-label">Current Password *</span>
                          <span class="field">
                          <label for="txtCurrentPassword">Your current password</label>
                          <input id="txtCurrentPassword" name="txtCurrentPassword" type="password" required="required" class="text" value="<?php echo $txtCurrentPassword; ?>"  />                          
                          </span>
                      </p>
                      
                      <p><span class="field-label">New Password *</span>
                          <span class="field">
                          <label for="txtPassword">Your new password</label>
                          <input id="txtPassword" name="txtPassword" type="password" required="required" class="text" value="<?php echo $txtPassword; ?>" onchange="password_onchange()"  />
                          <span class="sml">Password Strength: <span id="spPasswordResult"></span></span>
                          </span>
                      </p>
                      
                      <p><span class="field-label">Confirm Password *</span>
                          <span class="field">
                          <label for="txtPassword2">Confirm new password</label>
                          <input id="txtPassword2" name="txtPassword2" type="password" required="required" class="text" value=""  onchange="password_onchange()" /></span>
                      </p>  

                      
                      
                      <span class="field-label"></span>
                          <span class="field">
                         <button id="btn-submit" type="submit"  class="btn-next-form" >Update</button></span>      
                      
                         <input type="hidden" id="txtMemberId" name="txtMemberId" value="<?php echo $txtMemberId; ?>">                                         
                </fieldset>
                </form>    
</div>
           <?php
    if ($strMessage != "")  {
		echo "<p><span class='field-label'></span><span class='field'>";
		echo $strMessage;
		echo "</span></p>";
	}
?>  
</div>
  <div id="col-right" class="opacity">   
<h2>Welcome to our Agent access area.</h2>


        </div>  
</div>
<?php include("inc/foot.php"); ?>