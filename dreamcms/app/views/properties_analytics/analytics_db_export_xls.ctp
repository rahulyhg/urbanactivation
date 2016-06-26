<?php
date_default_timezone_set('Australia/Victoria');
$timeReportGenerated = date('d M Y ga');
header ("Expires: Mon, 28 Oct 2015 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"UA_PropertiesAnalytics-$timeReportGenerated.xls" );
header ("Content-Description: Generated Report" );

?>