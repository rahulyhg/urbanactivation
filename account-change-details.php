<?php             		
    // ***************************************************************************************************************	
	// Check Log In Details	
	// ***************************************************************************************************************   
	require_once("inc/connection.php");
	
	if ( (!isset($_SESSION['UA']['memberID'])) || ($_SESSION['UA']['memberID'] == "") )  {	  
	   header('location: '.$site_path.'login');	
	} else  {	
	   // Get Member Details	   
	   $rsMember = getAgentByID($_SESSION['UA']['memberID']);
  	   $rsMember = mysql_fetch_array($rsMember, MYSQL_ASSOC);	
	   
	   $txtTitle = $rsMember['title'];   
	   $txtFirstName = $rsMember['firstname'];   
	   $txtLastName = $rsMember['lastname'];   
	   $txtPhone = $rsMember['phone'];          
	   $txtEmail = $rsMember['email'];   
	   $txtAddress = $rsMember['address'];   
	   $txtSuburb = $rsMember['suburb'];   
	   $txtState = $rsMember['state'];   
	   $txtPostcode = $rsMember['postcode'];
           $txtOrganisationName = $rsMember['company'];	
	   $txtMemberId = $rsMember['id'];
	}
	// ***************************************************************************************************************		
	// Check for Update
	// ***************************************************************************************************************
	if ((isset($_GET["status"])) && ($_GET["status"] == "success"))  {
	   $strMessage = "Your details have been updated.  Thank-you!";	
	}
	// ***************************************************************************************************************
	
	$err = FALSE;	
	$title = "My Account - Change Details";
	$page = "account";
	$keywords = "UA, My Account Change Details";
	$description = "UA - Change My Details";
	require_once("inc/head.php"); 
	$displayPages = true; 
		
?>
<script type="text/javascript" language="javascript">
$(document).ready(function() {	
    $("#frmChange label").inFieldLabels();
	//$('#RegisterUserForm').h5Validate();
	$('#frmChange').html5form({    
        messages : 'de', // Options 'en', 'es', 'it', 'de', 'fr', 'nl', 'be', 'br'
        responseDiv : '#response',
		//labels: 'hide',
		allBrowsers: true,
		method: 'POST'    
    })
    
    $('.phone-number').keypress(function(e){
        var key = e.which;
         if ((key < 48 || key > 57) && !(key == 32 || key == 40 || key == 41 || key == 43 || key == 45 || key == 47) ){
             alert('Only Numbers between 0-9, +/-() and space allowed');
            $(this).focus();
            return false;
        }
    });
});

</script>
<!-- content section -->
<div id="content" class="content-inside">
    <div id="col-left" class="opacity">  
        
           <h1>Change Your Details</h1>
               <div id="registration" class="main-contact">
               
                  <form id="frmChange" name="frmChange" action="<?php echo $site_path;?>account-change-details-submit.php" method="post">
                  <fieldset>            
                      <p><span class="field-label">Title *</span>
                          <span class="field">                
                              <select name="txtTitle" id="txtTitle" required="required" style="width:50%">
                              <option value="">Select your title</option>
                               <option value="Dr"  <?php if ($txtTitle=='Dr') echo "selected=\"selected\""; ?>>Dr</option>
                                <option value="Prof"  <?php if ($txtTitle=='Prof') echo "selected=\"selected\""; ?>>Prof</option>
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
                      
                      <p><span class="field-label">Phone *</span>
                          <span class="field">
                          <label for="txtPhone">Your contact phone (10 digits with no spaces)</label>
                          <input class='phone-number' id="txtPhone" name="txtPhone" type="tel" required="required" value="<?php echo $txtPhone; ?>" /></span>
                      </p>
                      
                      <p><span class="field-label">Email *</span>
                          <span class="field">
                          <label for="txtEmail">Your email</label>
                          <input id="txtEmail" name="txtEmail" type="email" required="required" class="text" value="<?php echo $txtEmail; ?>" /></span>
                      </p>
                      
                      <p><span class="field-label">Company*</span>
                        <span class="field">
                        <label for="txtOrganisationName">Enter Company Name</label>
                        <input id="txtOrganisationName" name="txtOrganisationName" required="required" type="text" class="text" value="<?php echo $txtOrganisationName;?>" /></span>
                    </p>  
                      
                      <p><span class="field-label">Address</span>
                          <span class="field">
                          <label for="txtAddress">Your address</label>
                          <input id="txtAddress" name="txtAddress" type="text"  class="text" value="<?php echo $txtAddress; ?>" /></span>
                      </p>
                      
                      <p><span class="field-label">Suburb</span>
                          <span class="field">
                          <label for="txtSuburb">Your suburb</label>
                          <input id="txtSuburb" name="txtSuburb" type="text"  class="text" value="<?php echo $txtSuburb; ?>" /></span>
                      </p>
                      
                      <p><span class="field-label">State</span>
                          <span class="field">
                          <!--<label for="state">Your state</label>-->
                          <select name="txtState" id="txtState" style="width:50%" >
                              <option value="">Select state</option>
                              <option value="VIC"  <?php if ($txtState=='VIC') echo "selected=\"selected\""; ?>>VIC</option>
                              <option value="NSW" <?php if ($txtState=='NSW') echo "selected=\"selected\""; ?>>NSW</option>
                              <option value="QLD" <?php if ($txtState=='QLD') echo "selected=\"selected\""; ?>>QLD</option>
                              <option value="ACT" <?php if ($txtState=='ACT') echo "selected=\"selected\""; ?>>ACT</option>
                              <option value="NT" <?php if ($txtState=='NT') echo "selected=\"selected\""; ?>>NT</option>
                              <option value="WA" <?php if ($txtState=='WA') echo "selected=\"selected\""; ?>>WA</option>
                              <option value="SA" <?php if ($txtState=='SA') echo "selected=\"selected\""; ?>>SA</option>
                              <option value="TAS" <?php if ($txtState=='TAS') echo "selected=\"selected\""; ?>>TAS</option>
                              <option value="OTHER" <?php if ($txtState=='OTHER') echo "selected=\"selected\""; ?>>OTHER</option>
                        </select></span>
                      </p>
                      
                      <p><span class="field-label">Postcode</span>
                          <span class="field">
                          <label for="txtPostcode">Your postcode</label>
                          <input id="txtPostcode" name="txtPostcode" type="text"  class="text" value="<?php echo $txtPostcode; ?>" style="width: 50%;" pattern="\d{4}"/></span>
                      </p>
            
                      
<?php
    if ($strMessage != "")  {
		echo "<p><span class='field-label'></span><span class='field'><b>";
		echo $strMessage;
		echo "</b></span></p>";
	}
?>                               
                       <span class="field-label"></span>
                          <span class="field">
                      <button id="btn-submit" type="submit"  class="btn-next-form" >Update</button></span>      
                      
                      <input type="hidden" id="txtMemberId" name="txtMemberId" value="<?php echo $txtMemberId; ?>">                                         
                </fieldset>
                </form>

   
</div>
</div>
  <div id="col-right" class="opacity">   
<h2>Welcome to our Agent access area.</h2>


        </div>  
</div>
<?php include("inc/foot.php"); ?>