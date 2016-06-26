<?php
	$page = "disclaimer";
	$keywords = "page not found";
	$description = "Urban Activation Page not found";
	$title = "Urban Activation - Page not found";
	include("inc/head.php");
?>
<!-- content section -->
<div id="content" class="content-inside">
    <div id="col-left" class="opacity">
        <h1>Page Not Found</h1>
        <h2>Sorry, 404 Error</h2>
        <p>The page you looking for does not exist. Please try the following to find yourself in the right place:</p>
        <ul>
            <li><a href="<?php echo $site_path;?>">Click here to go to the home page &raquo;</a></li>
            <li>Check the URL and try again</li>
            <li>The page must be expired or must have been unpublished, go to homepage and follow the links on the navigation</li>
            <li>Please report this issue with the URL you are trying to access to: <a href="mailto:support@echo3.com.au">support@echo3.com.au</a></li>
        </ul>
    </div>

<?php include("side-contact.php"); ?>
</div>
<?php include("inc/foot.php"); ?>