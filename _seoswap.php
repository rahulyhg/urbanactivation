<?php
	include("inc/connection.php");
	$sql = "select id, titleSeo, seo_page_name from properties";
	echo $sql;
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		$sql2 = "update properties set titleSeo='".$row["seo_page_name"]."', seo_page_name='".$row["titleSeo"]."' where id = ".$row["id"];
		echo $sql2;
		$res2 = mysql_query($sql2);
	}
?>

