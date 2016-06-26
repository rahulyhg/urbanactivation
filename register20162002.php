<?php
        require_once './utility.php';         
        $err = FALSE;	
	$title = "UA Agent Registration Request";
	$page = "register";
	$keywords = "UA Agent Registration Request ";
	$description = "UA Agent Registration Request";
        require_once("inc/head.php"); 
	 
        // ***************************************************************************************************************
	// Register Memeber
	// ***************************************************************************************************************			
	// Check New agent registration for unique email	
	if ( isset($_POST['txtEmail']) )  {
            require_once 'inc/connection.php';
		if (isUniqueAgentEmail($_POST['txtEmail']))   {                       
                   date_default_timezone_set('Australia/Victoria');
                   $joiningDate = date('Y-m-d H:i:s');
                    // Email address is unique.	
                   // crypt password
                   //$cryptedPwd = crypt($_POST['txtPassword']);
                   $password = generateUniquePassword();
		   $agentID = createAgent($_POST['txtTitle'], $_POST['txtFirstName'], $_POST['txtLastName'], $password, $_POST['txtPhone'],
                           $_POST['txtEmail'], $_POST['txtOrganisationName'], $joiningDate);
                   if( empty($agentID) ){
                       echo "<h1>Fatal Error: $agentID</h1>";
                       exit();
                   }                   
                   // email agent and admin for new request
                   include_once './emailUA.php';
                   emailNewMembershipRequest($agentID, $_POST['txtFirstName'], $_POST['txtLastName'], $_POST['txtEmail']);
		} else  {			
                // Email address is not unique.
		   $errMsg2 = "We already have an agent account using the provided email address.  Please try again.";
               $txtTitle = $_POST['txtTitle'];    
               $txtFirstName = $_POST['txtFirstName'];   
	       $txtLastName = $_POST['txtLastName'];   
	       $txtPhone = $_POST['txtPhone']; 
	       $txtEmail = $_POST['txtEmail'];
	       $txtOrganisationName = $_POST['txtOrganisationName'];
                }		  
               /*$txtTitle = $_POST['txtTitle'];    
               $txtFirstName = $_POST['txtFirstName'];   
	       $txtLastName = $_POST['txtLastName'];   
	       $txtPhone = $_POST['txtPhone']; 
	       $txtEmail = $_POST['txtEmail'];
	       $txtOrganisationName = $_POST['txtOrganisationName'];*/
	       }		
			
	// ***************************************************************************************************************
	//$displayPages = true; 	
?>
<script language="javascript" type="text/javascript" src="../js/validate.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function() {	
    $("#frmRegister label").inFieldLabels();
	//$('#RegisterUserForm').h5Validate();
	$('#frmRegister').html5form({    
        messages : 'de', // Options 'en', 'es', 'it', 'de', 'fr', 'nl', 'be', 'br'
        responseDiv : '#response',
		//labels: 'hide',
		allBrowsers: true,
		method: 'POST'    
    });
    
    $('.phone-number').keypress(function(e){
        var key = e.which;
        // 43 +
        // 32 space
        // / 47
        // - 45
        // ( 40
        // 41 )     
         if ((key < 48 || key > 57) && !(key == 32 || key == 40 || key == 41 || key == 43 || key == 45 || key == 47) ){
            alert('Only Numbers between 0-9, +/-() and space allowed');
            $(this).focus();
            return false;
        }
    });
});

function disableForm()  {	
   document.getElementById("btn-submit").disabled = true;	
   document.getElementById("btn-submit").innerHTML = "Submitting your registration ...";
}

function validateForm(){
	// set page form element
	var form = document.detailForm;
	// set flag to TRUE: default all fields correct
	var flag = true;
	// set element flag to -1: default (field not required validation)
	var ef = -1;	
	// check each field in the form
	for(i=0; i<form.elements.length; i++) {
		
		ef=0; // presumed valid
		
		// check any field listed
		switch (form.elements[i].id) {
			case 'txtTitle':
			case 'txtFirstName':
			case 'txtLastName':						
                        case 'txtPhone':
                        case 'txtOrganisationName':
                        case 'txtSuburb':
                        case 'txtStAddress':
				if(trim(form.elements[i].value)=='') ef=1;
				break;

			case 'txtCaptcha':
				if(trim(form.elements[i].value).length!=5) ef=1;
				break;

			case 'txtEmail':
				var re = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
				if(trim(form.elements[i].value)=='' || !form.elements[i].value.match(re)) ef=1;
				break;			
		}

		if(ef==1) {	// error on field
			form.elements[i].style.backgroundColor = '#DDDDDD';
                        form.elements[i].focus();
			flag = false;	// error on form
		} else if(ef==0) {	// reset field if validated
			form.elements[i].style.backgroundColor = '#FFFFFF';
		}
	}
	
	if(!flag){	
            alert("Invalid information entered, please complete the highlighted fields (*)."); 
        }
        
        if(flag == true){
            disableForm();
        }
		
	return flag;
}

</script>
<style>
#frmRegister .short{
	color:#FF0000;
}

#frmRegister .weak{
	color:#E66C2C;
}

#frmRegister .good{
	color:#2D98F3;
}

#frmRegister .strong{
	color:#006400;
}
</style>
<!-- content section -->
<div id="content" class="content-inside">
    <div id="col-left" class="opacity">     
<?php
    if ($agentID != "")  {
       echo "<h4>Thank-you for registration request. You will receive login details via email once approved by UA admin.</h4>";	
	} else  { 
?> 

<h1>Agent Registration Request Form</h1>  
<h3>Please complete the registration form below.</h3>
        <?php } ?>

    <div id="registration" class="main-contact">

        <form id="frmRegister" name="frmRegister" action="<?php echo $site_path;?>register" method="post" onsubmit="return validateForm();">
        <fieldset>                                       
            <p><span class="field-label">Title *</span>
                <span class="field">                
                <select name="txtTitle" id="txtTitle" required="required" style="width:50%" >
                    <option value="">Select your title</option>                  
                    <option value="Mr"  <?php if ($txtTitle=='Mr') echo "selected=\"selected\""; ?>>Mr</option>
                    <option value="Mrs" <?php if ($txtTitle=='Mrs') echo "selected=\"selected\""; ?>>Mrs</option>
                    <option value="Miss" <?php if ($txtTitle=='Miss') echo "selected=\"selected\""; ?>>Miss</option>
                    <option value="Ms" <?php if ($txtTitle=='Ms') echo "selected=\"selected\""; ?>>Ms</option>                    
              </select></span>
            </p>
                     
            <p><span class="field-label">Name *</span>
              <span class="field">
                  <label for="txtFirstName">Your name</label>
                  <input id="txtFirstName" name="txtFirstName" type="text" required="required" class="text" value="<?php echo $txtFirstName; ?>"  />
              </span>
            </p>
            
            <p><span class="field-label">Surname *</span>
                <span class="field">
                <label for="txtLastName">Your surname</label>
                <input id="txtLastName" name="txtLastName" type="text" required="required" class="text" value="<?php echo $txtLastName; ?>"  /></span>
            </p>                      
            
            <p><span class="field-label">Email *</span>
                <span class="field">
                <label for="txtEmail">Your email</label>
                <input id="txtEmail" name="txtEmail" type="email" required="required" class="text" value="<?php echo $txtEmail; ?>" /></span>
            </p>  
            
            <p><span class="field-label">Phone *</span>
                <span class="field">
                <label for="txtPhone">Your contact number (10 digits with no spaces)</label>
                <input class='phone-number' id="txtPhone" name="txtPhone" type="tel" required="required" value="<?php echo $txtPhone; ?>"  /></span>
            </p>    
                        
            
            <p><span class="field-label">Company *</span>
                <span class="field">
                <label for="txtOrganisationName">Enter Company Name</label>
                <input id="txtOrganisationName" name="txtOrganisationName" type="text" class="text" required="required" value="<?php echo $txtOrganisationName;?>" /></span>
            </p> 
           
<?php        	  
	  if (isset($errMsg2))  {
			   echo "<p><span class=\"field-label\"></span><span class=\"field\"><font color='red'>" . $errMsg2 . "</font></span></p>";   
		   }  
?> 
  
             <span class="field-label"></span>
          <span class="field"><button id="btn-submit" class="btn-next-form" name ='requestbutton' type="submit" value='requestnow'>Request Now</button></span>
             
      </fieldset>
      </form>      
 </div>
</div>
  <div id="col-right" class="opacity">   
<h2>Welcome to our Agent access area.</h2>


        </div>    

</div>
<?php include("inc/foot.php"); ?>