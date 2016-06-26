<?php 
	if (!isset($content_for_layout)){ 	
		echo "<h1>administration</h1><p><strong>Welcome to the website administration.</strong></p>
			<p>Use the menu options on the left hand side of the screen to view and manage your website's content. </p>
			<p>Any questions? Please do not hesitate to contact us at <a href='mailto:support@echo3.com.au'>echo 3</a>!</p>";
	} else {
		echo $content_for_layout;
	}
?>