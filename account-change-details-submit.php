<?php
   require_once("inc/connection.php"); 
   
   // Update Member Details
   updateAgentDetails($_POST['txtMemberId'], $_POST['txtTitle'], $_POST['txtFirstName'], $_POST['txtLastName'], $_POST['txtPhone'],  
           $_POST['txtEmail'], $_POST['txtAddress'], $_POST['txtSuburb'], $_POST['txtState'], $_POST['txtPostcode'], $_POST['txtOrganisationName']);
   
   if( !empty($_SESSION['UA']['memberID']) ){
       $_SESSION['UA']['firstName'] = $_POST['txtFirstName'];
       $_SESSION['UA']['lastName'] = $_POST['txtLastName'];       
   }
   
   header('Location: '.$site_path . 'myaccount/change-details/success?status=success');
?>