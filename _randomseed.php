<?php
	include("inc/connection.php");
	$sql = "select id from images group by id";
	echo $sql;
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		
	}
?>

