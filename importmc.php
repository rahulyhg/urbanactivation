<?php include("inc/connection.php"); 
	$readArray = array(
	"PropertyID", 
	"Title", 
	"ShortDescription", 
	"Description", 
	"Description2",
	"Address", 
	"Suburb", 
	"State", 
	"Postcode", 
	"Post", 
	"GoogleMap", 
	"Brochure", 
	"PriceList", 
	"FloorPlan", 
	"CategoryID",
	"TypeID", 
	"PropertyStatus", 
	"ImageMain", 
	"ExpressionInterest", 
	"Bedrooms",
	"CarSpaces",
	"Bathrooms",
	"PriceMin", 
	"PriceMax", 
	"Priority", 
	"Sold", 
	"SeqNo", 
	"GMLat", 
	"GMLng", 
	"PriceDisplay", 
	"cityID", 
	"citySeo", 
	"seo", 
	"SalesDoc" ) ;

	$sqlArray = array();
	$filename = "mcvicproperties.txt";
	$handle = fopen($filename, "r");
	$contents = fread($handle, filesize($filename));
//echo($contents);
	$contentArray = explode("\t", $contents);
	fclose($handle);
	
//var_dump($contentArray);
//echo $contentArray[0];
	for($c=0; $c<count($contentArray); $c+=33) {
		for($rA=0; $rA<33; $rA++) {
			$sqlArray[$readArray[$rA]][] = $contentArray[($c+$rA)];
			//echo ($c+$rA). " :: ". $contentArray[($c+$rA)]." :: <br>";
		}
	}
	
var_dump($sqlArray);
	$writeArray = array();
	

?>
