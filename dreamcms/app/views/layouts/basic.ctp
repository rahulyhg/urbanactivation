<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?php
	if (strlen($session->read('Auth.User.username'))>0) {
		echo $content_for_layout;
		//echo "Welcome <b>".$session->read('Auth.User.username').", </b>";   
		//echo $html->link('LOGOUT', array('controller' => 'users', 'action' => 'logout'));
		//echo "&nbsp; | &nbsp;";
	} 
?>
</body>
</html>
