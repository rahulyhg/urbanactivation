<?php
	// ***************************************************************************************************************	
	// Process Logout
	// ***************************************************************************************************************
	require_once("inc/connection.php"); 	
	unset($_SESSION['UA']['memberID']);	
        unset($_SESSION['UA']['firstName']);
        unset($_SESSION['UA']['lastName']);
        unset($_SESSION['UA']['passworddefault']);
        unset($_SESSION['UA']['active']);
        unset($_SESSION['UA']['logintime']);
        unset($_SESSION['UA']['trackingrowid']);
        unset($_SESSION['UA']['visited_properties']);
	// ***************************************************************************************************************	
	
	$err = FALSE;	
	$title = "UA Agent Logout Page";
	$page = "Logout";
	$keywords = "UA, Logout ";
	$description = "UA Agent Logout Page";
	require_once("inc/head.php"); 
	$displayPages = true; 	      	
		
?>
<!-- content section -->
<div id="content" class="content-inside">
    <div id="col-left" class="opacity"> 
           <h1>Logout</h1>
           <h4>You are now logged out of the system. You will be redirected to home page soon.</h4> 
           <?php
            die("<script>window.setTimeout(function(){window.location.href = '$site_path" ."index.php';}, 2000);</script>");
           ?>
</div>
<div id="col-right" class="opacity">   
<h2> </h2>


        </div> 
</div>

<?php include("inc/foot.php"); ?>