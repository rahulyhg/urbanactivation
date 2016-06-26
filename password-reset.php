<?php
	$title = "UA - Reset Password";
	$page = "password";
	$keywords = "UA, Reset Password ";
	$description = "UA - Reset Password";
	
	require_once("inc/connection.php");
        // Check for Member Id and Token
	if (isset($_POST['hidMemberId']))  {
		// Reset Password	
		//$result = updateMemberPassword($_POST['hidMemberId'], $_POST['txtEmail'], $_POST['hidToken'], crypt($_POST['txtPassword']));		
		$result = updateAgentPassword($_POST['hidMemberId'], $_POST['txtEmail'], $_POST['hidToken'], $_POST['txtPassword']);
			
		if ($result == 1)  {
                echo "<h3>Your password has been reset. You will be redirected to login page soon!</h3>";
                die("<script>window.setTimeout(function(){window.location.href = '$site_path/login';}, 2000);</script>");
                exit();
		} else  {
		   echo "<h3>There was a problem resetting your password. You will be redirected to forgot password page soon. Please try restting password again. </h3>";
                   die("<script>window.setTimeout(function(){window.location.href = '$site_path/password-forgot';}, 2000);</script>");
		}
	} elseif (!isset($_GET['id']) || (!isset($_GET['token'])))  {
	   // Invalid Page Access		  
	   header('location: '.$site_path.'404.php');	  
	} else  {
	   // Display Reset Password Form	
	   $memberToken = getAgentToken($_GET['id']);
	   if ($memberToken != 	$_GET['token'])  {
		  header('location: '.$site_path.'404.php');	 
	   }
        }
	   
	require_once("inc/head.php");	
?>
<script type="text/javascript" src="<?php echo $site_path;?>js/password-strength.js"></script> <!--For password strength checking -->
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

function password_onchange()  {
	if (document.getElementById("txtPassword").value != "" && document.getElementById("txtPassword2").value != "")  {
       if (document.getElementById("txtPassword").value != document.getElementById("txtPassword2").value)  {
	      alert("The passwords do not match.  Please try again.");
		  document.getElementById("txtPassword").value = "";
		  document.getElementById("txtPassword2").value = "";	
		  
		  $("#frmPassword label").inFieldLabels();
		  document.getElementById("spPasswordResult").innerHTML = "";
	   }
	}
}
</script>
<style>
#frmPassword .short{
	color:#FF0000;
}

#frmPassword .weak{
	color:#E66C2C;
}

#frmPassword .good{
	color:#2D98F3;
}

#frmPassword .strong{
	color:#006400;
}
</style>
<!-- content section -->
<div id="content" class="content-inside">
    <div id="col-left" class="opacity"> 

<h1>Reset Password</h1>
    <h3>Please fill out your details to reset your password.</h3>
    
    <div id="registration" class="package">
        <form id="frmPassword" name="frmPassword" action="<?php echo $site_path;?>password-reset" method="post">
        <fieldset> 
           <p><span class="field-label">Email *</span>
              <span class="field">
                  <label for="txtEmail">Your email</label>
                  <input id="txtEmail" name="txtEmail" type="text" required="required" class="text"/>
              </span>
            </p>       
            <p><span class="field-label">Password *</span>
              <span class="field">
                  <label for="txtPassword">Your password</label>
                  <input id="txtPassword" name="txtPassword" type="password" required="required" class="text"  onchange="password_onchange()" />
                  Password Strength: <span id="spPasswordResult"></span>
              </span>
            </p>      
            <p><span class="field-label">Confirm Password *</span>
              <span class="field">
                  <label for="txtPassword2">Confirm Password</label>
                  <input id="txtPassword2" name="txtPassword2" type="password" required="required" class="text"  onchange="password_onchange()" />
              </span>
            </p>          
           <span class="field-label"></span>  
           <span class="field">    
              <button id="btn-submit" type="submit" class="btn-next-form">Reset <i class='icon-chevron-right'></i></button>            
           </span>         
           <input type="hidden" id="hidMemberId"  name="hidMemberId" value="<?php echo $_GET['id']; ?>" />  
           <input type="hidden" id="hidToken"  name="hidToken" value="<?php echo $_GET['token']; ?>" />   
        </fieldset>
      </form>
    </div>
</div>
<div id="col-right" class="opacity">   
<h2>Welcome to our Agent access area.</h2>


        </div> 
</div>
 
<?php include("inc/foot.php"); ?>                    