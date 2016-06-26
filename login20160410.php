<?php
	// ***************************************************************************************************************	
	// Process Login
	// ***************************************************************************************************************
        require_once("inc/connection.php"); 
        
	// Check Log In Details	
  	if (isset($_POST['txtLoginPassword']))  {
	   $rsMember = loginAgent($_POST['txtLoginEmail'], $_POST['txtLoginPassword']);	   		
	   if ($rsMember != 0)  {		  
  		  // Logged in Successfully                          
                  $isLoggedIn = true;		  		  
		  $_SESSION['UA']['memberID'] = $rsMember["id"];
                  $_SESSION['UA']['firstName'] = $rsMember["firstname"];
                  $_SESSION['UA']['lastName'] = $rsMember["lastname"];
                  $_SESSION['UA']['passworddefault'] = $rsMember["passworddefault"];
                  $_SESSION['UA']['active'] = $rsMember["active"];
                  $_SESSION['UA']['logintime'] = time();
                  $name = $_SESSION['UA']['firstName'] . ' ' . $rsMember["lastname"];
                  $_SESSION['UA']['trackingrowid'] = $rowId = insertAgentTrackingRow($_SESSION['UA']['memberID'], $name, $_SESSION['UA']['logintime']);
                  $_SESSION['UA']['visited_properties'] = '';
	   }  else  {
		 // Error logging in.		
                $txtLoginEmail =  $_POST['txtLoginEmail'];
               $isLoggedIn = false;
		 $errMessage = "The agent email or password combination are incorrect OR agent not active. Please try again!";
	  }
	}		
	// ***************************************************************************************************************	
	
	$err = FALSE;	
	$title = "UA Agent Login Page";
	$page = "login";
	$keywords = "UA Agent Login Page";
	$description = "UA Agent Login Page";
        require_once("inc/head.php"); 
	$displayPages = true; 	
?>
<div id='divTopMostWindow' style='display:none;'>
    <div class='popupTitle'>Agent Login - Disclaimer</div><br>
    <p>
        By clicking the Accept button below, you acknowledge that to the extent permitted by law, all property details, brochures, floor plans, price lists, pictures, documents or information available on our website or any link are provided by third parties and passed on to you without any warranties, representations or conditions of any kind, either express or implied, with regard to the accuracy, completeness or reliability of the information contained.
    </p>
    <p>
        We are not liable for any direct, indirect, consequential, exemplary or punitive damages, losses or causes of action, or loss of profits, or any other type of damage, whether based in contract or tort (including negligence), strict liability or otherwise, related to the use of information or documents available on our website or the transmission of such information or documents to third parties.
    </p><br>
    <input id="accept-disclaimer" type="button" value='Accept' style='width:100px;'></input>
    <input id="reject-disclaimer" type="button" value='Decline' style='width:100px;'></input> 
</div>

<!-- content section -->
<div id="content" class="content-inside">
    <div id="col-left" class="opacity">  
        
<?php 
   if ($isLoggedIn)  { 
      //echo "<h1>Login</h1>";
      echo "<h4>You are now logged into the system with agent access. You will be redirected to agent area soon.</h4>";    
      die("<script>window.setTimeout(function(){window.location.href = '$site_path". "property-search';}, 1000);</script>");
   } else {
?>
<h1>Agent Login</h1>
    
    <div id="registration" class="main-contact"> 
        <form id="frmLogIn" name="frmLogIn" onsubmit="return false;">   
        <fieldset>            
            <p><span class="field-label">Email *</span>
              <span class="field">
                  <label for="txtLoginEmail">Your email</label>
                  <input id="txtLoginEmail" name="txtLoginEmail" type="text" required="required" class="text" value="<?php echo $txtLoginEmail; ?>" />
              </span>
            </p>
            
            <p><span class="field-label">Password *</span>
                <span class="field">
                <label for="txtLoginPassword">Your password</label>
                <input id="txtLoginPassword" name="txtLoginPassword" type="password" required="required" class="text" value="<?php if (isset($_SESSION['UA']['post']["frmStep2"])) echo $_SESSION['UA']['post']["txtLoginPassword"]; ?>" /></span>
            </p>
<?php
           if (isset($errMessage))  {
			   echo "<p><span class=\"field-label\"></span><span class=\"field\"><font color='red'>" . $errMessage . "</font></span></p>";   
		   }		   		               
?>      
            <span class="field-label"></span>  
            <span class="field">    
                <input type='button' id="btn-login" class="btn-next-form" value='Log In'></input> 
               <a href="<?php echo $site_path;?>password-forgot" class="sml">Forgotten your password?</a>
            </span>  
        </fieldset>
      </form>
    </div>
<?php  } ?>


   
</div>
<div id="col-right" class="opacity">   
<h2>Welcome to our Agent access area.</h2>


        </div> 
</div>
<?php include("inc/foot.php"); ?>
<script type="text/javascript" language="javascript">
$(document).ready(function() {	
	$("#frmLogIn label").inFieldLabels();
	//$('#RegisterUserForm').h5Validate();
	$('#frmLogIn').html5form({    
        messages : 'de', // Options 'en', 'es', 'it', 'de', 'fr', 'nl', 'be', 'br'
        responseDiv : '#response',
		//labels: 'hide',
		allBrowsers: true,
		method: 'POST'    
    });  
    
    $('#btn-login').on('click', function(e){
        e.preventDefault();
        var position = $('#col-left').position();
        var width = $('#col-left').width();
        $('#divTopMostWindow').css({"position" : "absolute", "left" : position.left + 50, "top" : position.top + 50, "width" : width});
        $('#divTopMostWindow').show();
    });   
    
    $('#accept-disclaimer').on('click', function(){
        $('#divTopMostWindow').hide();
        var email = $('#txtLoginEmail').val().trim();
        var password = $('#txtLoginPassword').val().trim();
        var location ="<?php echo $site_path . 'login';?>";
        alert(location);
        alert(email);
        alert(isValidEmailAddress(email));
        //$('#frmLogIn').submit();
    });
    
    $('#reject-disclaimer').on('click', function(){
        $('#divTopMostWindow').hide(); 
    });    
});

function RedirectUsingPost(location, datastring){
    var form = '';
    datastring.split("&").forEach(function(pair)
    {
    if(pair == "")
    {
      return;
    }
    var parts = pair.split("=");
    form += '<input type="hidden" name="'+parts[0]+'" value="'+parts[1]+'">';
    }
    );
    $('<form action="'+location+'" method="POST">'+form+'</form>').appendTo('body').submit();   
}

function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
};

</script>