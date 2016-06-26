<?php
   require_once("inc/connection.php"); 
      
   $rsMember = getAgentByID($_POST['txtMemberId']);
   $rsMember = mysql_fetch_array($rsMember, MYSQL_ASSOC);
     
   
   if ($rsMember["password"] != $_POST['txtCurrentPassword'])  {  
	   // Invalid Current Password
	  header('Location: '.$site_path . 'myaccount/change-password/error?status=error');
   } else  {   
      // Update Member Password
      $result = changeMemberPassword($_POST['txtMemberId'], $_POST['txtPassword']);	
      header('Location: '.$site_path . 'myaccount/change-password/success?status=success');
   }      
?>