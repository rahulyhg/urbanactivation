<?php
// ******************************** //
session_start();
//require_once("global.php");
$agentLoggedIn = false;
if( !empty($_SESSION['UA']['memberID']) && !empty($_SESSION['UA']['trackingrowid']) && !empty($_SESSION['UA']['logintime']) ){
            $agentLoggedIn = true;
}

if ($_SERVER["SERVER_NAME"]=="echo00"){
	// offline connection (local)
	$db_host     = "localhost";
	$db_user     = "root";
	$db_password = "beyond3d";
	$db_database = "urbanactivation";
	$site_path	 = "http://echo00/urbanactivation/";
//	$db_user     = "urbactv8_user";
//	$db_password = "X!uX1FAi1tGi";
//	$db_database = "urbactv8_webdev";
} 
else if ($_SERVER["SERVER_NAME"]=="localhost"){
	// offline connection (local)
	$db_host     = "localhost";
	$db_user     = "root";
	$db_password = "beyond3d";
	$db_database = "urbanactivation";
	$site_path	 = "http://localhost/urbanactivation/";
//	$db_user     = "urbactv8_user";
//	$db_password = "X!uX1FAi1tGi";
//	$db_database = "urbactv8_webdev";
} 
else {
	// online connection (client)
	$db_host     = "localhost";
	$db_user     = "urbactv8_user";
	$db_password = "X!uX1FAi1tGi";
	$db_database = "urbactv8_live";
	$site_path   = "http://www.urbanactivation.com.au/";
	//echo $_SERVER["SERVER_NAME"];
}

// connect to mysql server
//$db_selected = mysql_select_db('mainland_webdev', $link);
@$db = mysql_connect($db_host, $db_user, $db_password);
//Sets the client character set
mysql_set_charset('utf8',$db);

if (!$db) {
	echo "Error: Sorry, we are presently unable to connect to that information.  Please try again later.";
	exit;  
}

// link to database
mysql_select_db($db_database);



/**************************************************************************************************************
NEWS LISTING
**************************************************************************************************************/
function getAllNewsItems($id,$group,$archivedDate) {
	$curDate = time();
	if ((strlen($group)>0 && $id==0) || (strlen($group)>0)) { //news listings for Group
		//echo "In Group only. Group: [".$group."]";
		$sql = "SELECT nw.*,nc.category FROM `news` nw, `news_categories` nc WHERE nw.category_id = nc.id ";
		$sql .= (is_numeric($group)?" AND nc.id = ".$group:"");
		$sql .= " AND FROM_UNIXTIME(nw.startDate) <= FROM_UNIXTIME(".$curDate.") AND FROM_UNIXTIME(nw.archiveDate) > CURDATE() AND nw.live = 1 ORDER BY nw.startDate DESC";
	//} elseif ((strlen($archivedDate)>1 && $id>0) || (strlen($archivedDate)>1)) {//news listings for ArchivedNews
	} elseif (strlen($group)>0 && $archivedDate>0) {//news listings for ArchivedNews
		//echo "In Archived only";
		if($archivedDate==3){
			$monthLowerLimit = mktime(0,0,0,date("n"),date("j"),date("Y"));
		} else {
			$monthLowerLimit = mktime(0,0,0,date("n")-$archivedDate,date("j"),date("Y"));
		}
		if($archivedDate==6){
			$monthUpperLimit = mktime(0,0,0,date("n")-($archivedDate+6),date("j"),date("Y"));
		} elseif($archivedDate==3) {
			$monthUpperLimit = mktime(0,0,0,date("n")-6,date("j"),date("Y"));
		} else {
			$monthUpperLimit = mktime(0,0,0,date("n")-($archivedDate+12),date("j"),date("Y"));
		}
				
		switch ((int)$archivedDate) {			
			case 36:
				$sql = "Select nw.*,nc.category from `news` nw, `news_categories` nc where nw.category_id = nc.id AND (nw.archiveDate <=  ".$monthLowerLimit.") AND nw.live = 1 ORDER BY nw.startDate DESC;";
				//The below statement wouldn't work in MySQL server version prior to 5.0
				//$sql = "Select * from `news` where FROM_UNIXTIME(archiveDate) > DATE_SUB(CURDATE(), INTERVAL 12 MONTH) AND ((TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) <= -6) AND (TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -12)) AND live = 1 ORDER BY startDate DESC LIMIT 1;";
				break;
			default:
				$sql = "Select nw.*,nc.category from `news` nw, `news_categories` nc where nw.category_id = nc.id AND ((nw.archiveDate <=  ".$monthLowerLimit.") AND (nw.archiveDate >  ".$monthUpperLimit.")) AND nw.live = 1 ORDER BY nw.startDate DESC;";
				//The below statement wouldn't work in MySQL server version prior to 5.0
				//$sql = "Select * from `news` where FROM_UNIXTIME(archiveDate) > DATE_SUB(CURDATE(), INTERVAL 24 MONTH) AND ((TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) <= -12) AND (TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -24)) AND live = 1  ORDER BY startDate DESC LIMIT 1;";
				break;
		}
	} else {//generic news listings
		//echo "In generic";
		$month6Limit = mktime(0,0,0,date("n")-6,date("j"),date("Y"));
		$sql="SELECT nw.*,nc.category FROM `news` nw, `news_categories` nc WHERE nw.category_id = nc.id AND (nw.startDate >= ".$month6Limit.") AND nw.live = 1 AND FROM_UNIXTIME(nw.archiveDate) > FROM_UNIXTIME(".$curDate.") ORDER BY nw.startDate DESC;";
		//The below statement wouldn't work in MySQL server version prior to 5.0
		//$sql = "SELECT id,title FROM `news` WHERE (TIMESTAMPDIFF(MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -6) AND live = 1 AND FROM_UNIXTIME(archiveDate) > CURDATE() ORDER BY startDate DESC;";
	}
	//echo $sql;
	return mysql_query($sql);
}
//NewsDisplay
function getTopNewsForDisplay($id,$group,$archivedDate,$preview = NULL, $iLimit = NULL) {
	$curDate = time();
	if ((strlen($group)>0 && $id>0) || ($archivedDate>0 && $id>0)){ //news display for combo
		//echo "In Combo";
		$sql = "SELECT * FROM `news` WHERE id = ".$id;
		$sql .= (is_null($preview)) ? " AND live = 1;": " AND live = 0;";
	} elseif (strlen($group)>0 && $archivedDate==0) { 		
		$sql  = "SELECT nw.* FROM `news` nw, `news_categories` nc WHERE ";
		$sql .= (is_numeric($group))?" nw.category_id = nc.id AND nc.id = ".$group." AND ":(($group=='all')?"":"nw.category_id = nc.id AND nc.category = '".$group."' AND ");		
		$sql .= " (FROM_UNIXTIME(nw.startDate) <= FROM_UNIXTIME(".$curDate.")) ";
		$sql .= " AND (FROM_UNIXTIME(nw.archiveDate) > FROM_UNIXTIME(".$curDate.")) ";
		$sql .= (is_null($preview)) ? " AND nw.live = 1":" AND nw.live = 0";
		$sql .= (is_null($preview)) ? " ORDER BY nw.startDate DESC ":"";
		$sql .= (is_null($iLimit)) ? ";": " LIMIT ".$iLimit.";";
	} elseif (strlen($group)>0 && $archivedDate>0) {//news display for ArchivedNews
		//echo "In Archived only";
		if($archivedDate==3){
			$monthLowerLimit = mktime(0,0,0,date("n"),date("j"),date("Y"));
		} else {
			$monthLowerLimit = mktime(0,0,0,date("n")-$archivedDate,date("j"),date("Y"));
		}
		if($archivedDate==6){
			$monthUpperLimit = mktime(0,0,0,date("n")-($archivedDate+6),date("j"),date("Y"));
		} elseif($archivedDate==3) {
			$monthUpperLimit = mktime(0,0,0,date("n")-6,date("j"),date("Y"));
		} else {
			$monthUpperLimit = mktime(0,0,0,date("n")-($archivedDate+12),date("j"),date("Y"));
		}
		
		switch ((int)$archivedDate) {
			case 36:
				$sql = "Select * from `news` where (archiveDate <=  ".$monthLowerLimit.")";
				$sql .= (is_null($preview)) ? " AND live = 1":" AND live = 0";
				$sql .= (is_null($preview)) ? " ORDER BY startDate DESC ":"";
				$sql .= (is_null($iLimit)) ? ";": " LIMIT ".$iLimit.";";
				//The below statement wouldn't work in MySQL server version prior to 5.0
				//$sql = "Select * from `news` where FROM_UNIXTIME(archiveDate) > DATE_SUB(CURDATE(), INTERVAL 12 MONTH) AND ((TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) <= -6) AND (TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -12)) AND live = 1 ORDER BY startDate DESC LIMIT 1;";
				break;
			default:
				$sql = "Select * from `news` where ((archiveDate <=  ".$monthLowerLimit.") AND (archiveDate >  ".$monthUpperLimit."))";
				$sql .= ($group>0) ? " AND category_id = ".$group:" ";
				$sql .= (is_null($preview)) ? " AND live = 1":" AND live = 0";
				$sql .= (is_null($preview)) ? " ORDER BY startDate DESC ":"";
				$sql .= (is_null($iLimit)) ? ";": " LIMIT ".$iLimit.";";
				//The below statement wouldn't work in MySQL server version prior to 5.0
				//$sql = "Select * from `news` where FROM_UNIXTIME(archiveDate) > DATE_SUB(CURDATE(), INTERVAL 24 MONTH) AND ((TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) <= -12) AND (TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -24)) AND live = 1  ORDER BY startDate DESC LIMIT 1;";
				break;
		}
	} elseif ($id>0) {//individual news display
		//echo "In ID only";
		$sql = "SELECT * FROM `news` WHERE id = ".$id;
		$sql .= (is_null($preview)) ? " AND live = 1":" AND live = 0";
		$sql .= (is_null($preview)) ? " AND FROM_UNIXTIME(archiveDate) > FROM_UNIXTIME(".$curDate.") ORDER BY startDate DESC ":"";
		$sql .= (is_null($iLimit)) ? ";": " LIMIT ".$iLimit.";";
	} else {//generic news listings
		$month6Limit = mktime(0,0,0,date("n")-6,date("j"),date("Y"));
		$sql="SELECT * FROM `news` WHERE (startDate >= ".$month6Limit.") AND live = 1 AND FROM_UNIXTIME(archiveDate) > CURDATE() ORDER BY startDate DESC ".(is_null($iLimit)? ";":"LIMIT ".$iLimit." ;");
		//The below statement wouldn't work in MySQL server version prior to 5.0
		//$sql = "SELECT * FROM `news` WHERE (TIMESTAMPDIFF(MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -6) AND live = 1 AND FROM_UNIXTIME(archiveDate) > CURDATE() ORDER BY startDate DESC LIMIT 1";
	}
	//echo $sql;
	return mysql_query($sql);
}

function getTopNewsForHome($iCatID = NULL, $iLimit = NULL){
	$month6Limit = mktime(0,0,0,date("n")-6,date("j"),date("Y"));
	$sql ="SELECT nw.*,nc.category FROM `news` nw, `news_categories` nc WHERE nw.category_id = nc.id AND (nw.startDate >= ".$month6Limit.") AND nw.live = 1 AND FROM_UNIXTIME(nw.archiveDate) > CURDATE()";
	$sql .= (is_null($iCatID))?"":" AND nw.category_id = ".$iCatID;
	$sql .= " ORDER BY startDate DESC ";
	$sql .=(!is_null($iLimit))?" LIMIT ".$iLimit.";":"";
	//echo $sql;
	return mysql_query($sql);
}
function getNewsTypeItem($id) {
	$sql = "SELECT * FROM `news_categories` WHERE id=".$id;
	return mysql_query($sql);
}

function getNewsTypes() {
	$sql = "SELECT Distinct(NC.category), NC.id FROM `news_categories` AS NC, `news` AS NW WHERE NC.id = NW.category_id AND NW.live = 1 AND FROM_UNIXTIME(NW.archiveDate) > CURDATE() Group By NC.category, NC.id ORDER BY NC.id;";
	return mysql_query($sql);
}

function getTopArchivedDropDown(){
	$sql = "SELECT Distinct(NC.category), NC.id FROM `news_categories` AS NC RIGHT JOIN `news` AS NW ON NC.id = NW.category_id AND NW.live = 1 AND FROM_UNIXTIME(NW.archiveDate) > CURDATE() Group By NC.category, NC.id ORDER BY NC.id Limit 1;";
	return mysql_query($sql);
}
function getArchivedDropDown($iCatID){
	//$sql = "SELECT Distinct(DATE_FORMAT(FROM_UNIXTIME(archiveDate),'%M %Y')) AS ArcDDL FROM `news` WHERE(FROM_UNIXTIME(archiveDate) < CURDATE()) ORDER BY ID DESC";
	//echo "Get archived DDL";
	$month36Limit = mktime(0,0,0,date("n")-36,date("j"),date("Y"));
	$month24Limit = mktime(0,0,0,date("n")-24,date("j"),date("Y"));
	$month12Limit = mktime(0,0,0,date("n")-12,date("j"),date("Y"));
	$month6Limit = mktime(0,0,0,date("n")-6,date("j"),date("Y"));
	$month0To6Limit = mktime(0,0,0,date("n"),date("j"),date("Y"));
	$sql="Select Distinct CASE
    WHEN (archiveDate <= ".$month36Limit.") THEN 36
    WHEN ((archiveDate <= ".$month24Limit.") AND (archiveDate > ".$month36Limit.")) THEN 24
    WHEN ((archiveDate <= ".$month12Limit.") AND (archiveDate > ".$month24Limit.")) THEN 12
    WHEN ((archiveDate <= ".$month6Limit.") AND (archiveDate > ".$month12Limit.")) THEN 6
    WHEN ((archiveDate <= ".$month0To6Limit.") AND (archiveDate > ".$month6Limit.")) THEN 3
    ELSE 0
  END AS ValueToDisplay,
  CASE
    WHEN (archiveDate <= ".$month36Limit.") THEN 'Over 3 years'
    WHEN ((archiveDate <= ".$month24Limit.") AND (archiveDate > ".$month36Limit.")) THEN 'Over 2 years'
    WHEN ((archiveDate <= ".$month12Limit.") AND (archiveDate > ".$month24Limit.")) THEN 'Over 1 year'
    WHEN ((archiveDate <= ".$month6Limit.") AND (archiveDate > ".$month12Limit.")) THEN 'Over 6 months'
    WHEN ((archiveDate <= ".$month0To6Limit.") AND (archiveDate > ".$month6Limit.")) THEN 'Less than 6 months'
    ELSE 'No Comparison'
  END AS TextToDisplay
FROM `news` WHERE live = 1 AND category_id = ".$iCatID." GROUP by ValueToDisplay, TextToDisplay Order by ValueToDisplay ASC ";
	//The below statement wouldn't work in MySQL server version prior to 5.0
	/*$sql="Select Distinct CASE
    WHEN (TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) <= -36) THEN 36
    WHEN ((TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) <= -24) AND (TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -36)) THEN 24
    WHEN ((TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) <= -12) AND (TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -24)) THEN 12
    WHEN ((TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) <= -6) AND (TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -12)) THEN 6
    ELSE 0
  END AS ValueToDisplay,
  CASE
    WHEN (TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) <= -36) THEN 'Over 3 years'
    WHEN ((TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) <= -24) AND (TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -36)) THEN 'Over 2 years'
    WHEN ((TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) <= -12) AND (TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -24)) THEN 'Over 1 year'
    WHEN ((TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) <= -6) AND (TIMESTAMPDIFF( MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -12)) THEN 'Over 6 months'
    ELSE 'No Comparison'
  END AS TextToDisplay
FROM `news` WHERE live = 1 GROUP by ValueToDisplay, TextToDisplay Order by ValueToDisplay ASC;";*/
	//echo $sql;
	return mysql_query($sql);
}

function getNewsArticles($iLmt = NULL) {
	//$sql = "SELECT * FROM `news` WHERE live=1 AND startDate<=".date("U")." and archiveDate>=".date("U")." ORDER BY startDate DESC ";
	$month6Limit = mktime(0,0,0,date("n")-6,date("j"),date("Y"));
	$sql="SELECT * FROM `news` WHERE (startDate >= ".$month6Limit.") AND live = 1 AND FROM_UNIXTIME(archiveDate) > CURDATE() ORDER BY startDate DESC ";
	//The below statement wouldn't work in MySQL server version prior to 5.0
	//$sql = "SELECT * FROM news WHERE (TIMESTAMPDIFF(MONTH, CURDATE(), FROM_UNIXTIME(startDate)) > -6) AND live = 1 AND FROM_UNIXTIME(archiveDate) > CURDATE() ORDER BY startDate DESC ";
	$sql .= (is_null($iLmt)) ? "" : "LIMIT 0, ".$iLmt; 
	return mysql_query($sql);
}

function getNewsItemsForTeamMember($team_id = NULL){
	$month6Limit = mktime(0,0,0,date("n")-6,date("j"),date("Y"));
	$sql="SELECT nw.*,nc.category FROM `news` nw, `news_categories` nc WHERE nw.category_id = nc.id AND (nw.startDate >= ".$month6Limit.") AND nw.live = 1 AND FROM_UNIXTIME(nw.archiveDate) > CURDATE() ";
	$sql .= (is_null($team_id)) ? "" : " AND ((nw.teams LIKE '".$team_id.",%') OR (nw.teams LIKE '%,".$team_id.",%') OR (nw.teams LIKE '%,".$team_id."') OR (nw.teams = '".$team_id."'))"; 
	$sql .= " ORDER BY nw.startDate DESC;";
	//echo $sql;
	return mysql_query($sql);
}
function getNewsItemsForBranches($branch_id = NULL, $iLmt = NULL){
	$month6Limit = mktime(0,0,0,date("n")-6,date("j"),date("Y"));
	$sql="SELECT nw.*,nc.category FROM `news` nw, `news_categories` nc WHERE nw.category_id = nc.id AND (nw.startDate >= ".$month6Limit.") AND nw.live = 1 AND FROM_UNIXTIME(nw.archiveDate) > CURDATE() ";
	$sql .= (is_null($branch_id)) ? "" : " AND ((nw.branches LIKE '".$branch_id.",%') OR (nw.branches LIKE '%,".$branch_id.",%') OR (nw.branches LIKE '%,".$branch_id."') OR (nw.branches = '".$branch_id."'))"; 
	$sql .= " ORDER BY nw.startDate DESC ";
	$sql .= (is_null($iLmt))?"":" LIMIT ".$iLmt;
	//echo $sql;
	return mysql_query($sql);
}
function getArchivedNewsItemsForTeamMember($team_id = NULL,$iLmt = NULL){
	$month6Limit = mktime(0,0,0,date("n")-6,date("j"),date("Y"));
	$sql="SELECT nw.*,nc.category FROM `news` nw, `news_categories` nc WHERE nw.category_id = nc.id AND (nw.archiveDate <= ".$month6Limit.") AND nw.live = 1 ";
	$sql .= (is_null($team_id)) ? "" : " AND ((nw.teams LIKE '".$team_id.",%') OR (nw.teams LIKE '%,".$team_id.",%') OR (nw.teams LIKE '%,".$team_id."') OR (nw.teams = '".$team_id."'))"; 
	$sql .= " ORDER BY nw.archiveDate DESC ";
	$sql .= (is_null($iLmt)) ? "" : "LIMIT 0, ".$iLmt; 
	//echo $sql;
	return mysql_query($sql);
}
function getNewsIDFromNewsTitle($pageTitle){
	$sql = "SELECT n.id FROM `news` n WHERE LOWER(n.seo_page_name) = '".strtolower($pageTitle)."' AND n.live=1";
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return (int)$row["id"];	
		} else {
			return 0;	
		}
	}		
}
function getNewsCatIDFromNewsTitle($category){
	$sql = "SELECT nc.id FROM `news_categories` nc WHERE LOWER(nc.category) = '".str_replace("-"," ",strtolower($category))."'";
	//echo $sql;
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return (int)$row["id"];
		} else {
			return 0;	
		}
	}		
}
/**************************************************************************************************************
FAQs SQL FUNCTIONS
**************************************************************************************************************/
function getFaq($id = NULL, $group = NULL, $orderBy= NULL) {
	$sql = "SELECT * FROM `faqs` WHERE live = 1 ";
	$sql .= (is_null($id))? "" : " AND id=".$id;
	$sql .= (is_null($group))? "" : " AND category_id = ".$group;
	$sql .= (is_null($orderBy))? "" : " ORDER BY position ".$orderBy;
	return mysql_query($sql);
}
function getFaqCategories() {
	$sql = "SELECT `faqs_categories`.`id`,`faqs_categories`.`category` FROM `faqs_categories` WHERE `faqs_categories`.`id` IN (SELECT `faqs`.`category_id` from `faqs`);";
	return mysql_query($sql);
}
/**************************************************************************************************************
TESTIMONIALS SQL FUNCTIONS
**************************************************************************************************************/
function getAllTestimonials(){
	$sql = "SELECT * FROM `testimonials` WHERE `testimonials`.`live` = 1 ORDER BY `testimonials`.`position` ASC;";
	return mysql_query($sql);	
}
function getTopTestimonialForHome(){
	$sql = "SELECT * FROM `testimonials` WHERE `testimonials`.`live` = 1 ORDER BY `testimonials`.`position` ASC LIMIT 1;";
	return mysql_query($sql);		
}
/**************************************************************************************************************
TEAMS SQL FUNCTIONS
**************************************************************************************************************/
function getTeamsCategories() {
	$sql = "SELECT `teams_categories`.`id`,`teams_categories`.`category`,`teams_categories`.`seo_page_name` FROM `teams_categories` WHERE `teams_categories`.`id` IN (SELECT `teams`.`category_id` from `teams` WHERE `teams`.`live` = 1) ORDER BY category ASC;";
	return mysql_query($sql);
}
function getAllTeams(){
	$sql = "SELECT t.*,tc.seo_page_name AS categoryName FROM `teams` t, `teams_categories` tc WHERE t.live = 1 AND t.category_id = tc.id ORDER BY t.position ASC;";
	return mysql_query($sql);	
}
function getAllTeamsPerCategory($category_id){
	$sql = "SELECT t.*,tc.seo_page_name AS categoryName FROM `teams` t,`teams_categories` tc WHERE t.live = 1 AND t.category_id = tc.id AND t.category_id = ".$category_id." ORDER BY t.position ASC;";
	return mysql_query($sql);		
}
function getTeamDetailsFromID($teamID){
	$sql = "SELECT * FROM `teams` t WHERE t.live = 1 AND t.id = ".$teamID;
	return mysql_query($sql);
}
function getTeamIDFromTeamName($teamName){
	$sql = "SELECT t.id FROM `teams` t WHERE t.live = 1 AND t.seo_page_name = '".strtolower(trim($teamName))."'";
	$res = mysql_query($sql);
	while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return (int)$row["id"];	
		} else {
			return 0;	
		}
	}
}
function getTeamCatIDFromCatTitle($catTitle){
	$sql = "SELECT tc.id FROM `teams_categories` tc WHERE LOWER(tc.seo_page_name) = '".strtolower($catTitle)."'";
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return (int)$row["id"];	
		} else {
			return 0;	
		}
	}
}
function getKeyTeamMembersForPage($pageId){
	$sql = "SELECT Distinct(t.id),t.name,t.photo,t.seo_page_name,tc.category FROM `teams` t, `teams_categories` tc WHERE t.category_id = tc.id AND (t.capabilities LIKE '".$pageId.",%') OR (t.capabilities LIKE '%,".$pageId.",%') OR (t.capabilities LIKE '%,".$pageId."') OR (t.capabilities = ".$pageId.") GROUP By t.id ORDER BY t.position;";
	return mysql_query($sql);	
}
function getKeyTeamMembersForBranches($branchId){
	$sql = "SELECT Distinct(t.id),t.name,t.shortDescription, t.photo, t.seo_page_name,tc.category, tc.seo_page_name AS seoCatName FROM `teams` t, `teams_categories` tc WHERE t.live = 1 AND t.category_id = tc.id AND ((t.branches LIKE '".$branchId.",%') OR (t.branches LIKE '%,".$branchId.",%') OR (t.branches LIKE '%,".$branchId."') OR (t.branches = ".$branchId.")) GROUP By t.id ORDER BY t.position;";
	return mysql_query($sql);	
}
/**************************************************************************************************************
PAGES SQL FUNCTIONS
**************************************************************************************************************/
function getSubPagesList($category_id = NULL, $iLimit = NULL){
	if(!is_null($category_id)){
		$sql = "SELECT p.id As 'PAGE_ID', p.title AS 'PAGE_TITLE', CONCAT ('/',RTrim(pc.seo_cat_name),'/',RTrim(p.seo_page_name)) AS 'PAGE_URL', pc.category AS 'CAT_NAME'
	FROM `pages` p LEFT JOIN `pages_categories` pc ON pc.id = p.category_id WHERE p.live = 1 AND p.category_id = ".$category_id." ORDER BY p.position ";
		$sql.= ((is_null($iLimit))?"":" LIMIT ".$iLimit." ;");
		if(is_null($iLimit)){
			return mysql_query($sql);
		} else {
			$res = mysql_query($sql);
			while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
				if($row){
					return trim($row["PAGE_URL"]);
				} else {
					return NULL;
				}
			}	
		}
	} else {
		return NULL;
	}
}
function getAllSubPages($id){
	$sql = "SELECT p.id, p.title, p.seo_page_name,pc.seo_cat_name,pc.id AS cat_id,pc.category FROM `pages` p, `pages_categories` pc WHERE p.category_id = pc.id AND p.live = 1 ";
	$sql .= (is_null($id))? "" : " AND p.category_id = (SELECT page.category_id FROM `pages` page WHERE page.id =".$id.")";
	$sql .= " ORDER BY p.position;";
	//echo $sql;
	return mysql_query($sql);	
}
function getCurrentPageContent($id){
	$sql = "SELECT p.id,p.title,p.tagline,p.metaTitle,p.metaKeywords,p.metaDescription,p.photo,p.body,p.category_id, pc.category, pc.seo_cat_name FROM `pages` p, `pages_categories` pc WHERE pc.id = p.category_id AND p.live = 1 AND p.id =".$id;
	return mysql_query($sql);	
}
function getPageCategories($iCategories = NULL){
	$sql = "SELECT DISTINCT pc.id, pc.category FROM `pages` p, `pages_categories` pc WHERE p.category_id = pc.id AND p.live = 1 ";
	$sql .= (is_null($iCategories))?"":" AND p.category_id IN (".$iCategories.") ";
	$sql .= " GROUP BY pc.id, pc.category ORDER BY p.position;";
	return mysql_query($sql);
}
function getSubPagesMenu($iCatId){
	$sql = "SELECT p.id,p.title,p.seo_page_name FROM `pages` p WHERE p.live = 1 AND p.category_id =".$iCatId." ORDER BY p.position";
	return mysql_query($sql);
}
function getPageIDFromPageTitle($pageSEOCatName = NULL,$pageSEOURL){
	$sql = "SELECT p.id FROM `pages` p, `pages_categories` pc WHERE p.category_id = pc.id ";
	$sql .= (!is_null($pageSEOCatName))? " AND pc.seo_cat_name = '".strtolower(trim($pageSEOCatName))."' ":"";
	$sql .= (!is_null($pageSEOURL))? "AND LOWER(p.seo_page_name) = '".strtolower(trim($pageSEOURL))."'":"";
	$sql .= " ORDER BY p.position;";
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return (int)$row["id"];	
		} else {
			return 0;	
		}
	}		
}
function getServicesListingById($service_id){
	$sql = "SELECT p.title,p.seo_page_name FROM `pages` p WHERE p.id = ".$service_id;	
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return $row["title"]."|".$row["seo_page_name"];	
		} else {
			return "";	
		}
	}
}
function getServicesPageStatusById($service_id){
	$sql = "SELECT p.live FROM `pages` p WHERE p.id = ".$service_id;	
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			if((int)$row["live"]==1){
				return true;
			} else {
				return false;	
			}
		} else {
			return false;	
		}
	}	
}
function getServicePanelContent($iCatID = NULL, $iLmt = NULL){
	$sql = "SELECT p.id,p.title,p.seo_page_name, p.shortDescription FROM `pages` p WHERE p.live = 1 ";
	$sql .= (is_null($iCatID))? "":" AND p.category_id = ".$iCatID;
	$sql .= (is_null($iLmt))?" ORDER BY p.position":" ORDER BY p.position LIMIT 1,".$iLmt;
	//echo $sql;
	return mysql_query($sql);
}
/**************************************************************************************************************
BRANCHES SQL FUNCTIONS
**************************************************************************************************************/
function getBranchesMenu($iLmt = NULL){
	$sql = "SELECT b.* FROM `branches` b WHERE b.live = 1 ORDER BY b.position ";
	$sql .= (is_null($iLmt))? "":" Limit ".$iLmt;
	return mysql_query($sql);
}
function getBranches($id = NULL){
	$sql = "SELECT b.* FROM `branches` b WHERE b.live = 1 ";
	$sql .= (is_null($id))? "":" AND b.id =".$id;
	$sql .=  " ORDER BY b.position;";
	//echo $sql;
	return mysql_query($sql);
}
function getBranchIDFromBranchTitle($pageSEOURL){
	$sql = "SELECT b.id FROM `branches` b WHERE b.live = 1 ";
	$sql .= (!is_null($pageSEOURL))? "AND LOWER(b.seo_page_name) = '".strtolower(trim($pageSEOURL))."'":"";
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return (int)$row["id"];	
		} else {
			return 0;	
		}
	}		
}
function getBranchTitleById($branch_id){
	$sql = "SELECT b.title FROM `branches` b WHERE b.id = ".$branch_id;	
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return $row["title"];	
		} else {
			return "";	
		}
	}
}
function getBranchesForTeamMember($teamID){
	$sql = "SELECT t.branches FROM `teams` t WHERE t.id = ".$teamID;
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			$sqlBranch = "SELECT b.* FROM `branches` b WHERE b.id IN (".trim($row["branches"]).") ORDER BY b.position ASC;";
			//echo $sqlBranch;
			return mysql_query($sqlBranch);
		} else {
			return "";	
		}
	}
}

function getBranchesForServices($serviceID){
	$sql = "SELECT Distinct(b.id),b.title,b.seo_page_name FROM `branches` b WHERE b.live = 1 AND ((b.pages LIKE '".$serviceID.",%') OR (b.pages LIKE '%,".$serviceID.",%') OR (b.pages LIKE '%,".$serviceID."') OR (b.pages = ".$serviceID.")) GROUP By b.id ORDER BY b.title ASC;";
	return mysql_query($sql);	
}
/**************************************************************************************************************
Gallery SQL FUNCTIONS
**************************************************************************************************************/
function getGalleryCategories($iLmt = NULL){
	$sql = "SELECT Distinct g.id, gc.name, gc.seo_page_name FROM `images` g, `categories` gc WHERE gc.id = g.categorie_id and g.live = 1 Group By gc.id;";
	$sql .= (is_null($iLmt))? "":" Limit ".$iLmt;
	return mysql_query($sql);
}
function getGalleryIDByTitle($pageSEOURL){
	$sql = "SELECT gc.id FROM `categories` gc  ";
	$sql .= (!is_null($pageSEOURL))? "WHERE LOWER(gc.seo_page_name) = '".strtolower(trim($pageSEOURL))."'":"";
	//echo $sql;
	$res1 = mysql_query($sql);
	while($row1=@mysql_fetch_array($res1, MYSQL_ASSOC)){
		if($row1){
			return (int)$row1["id"];	
		} else {
			return 0;	
		}
	}	
}
function getGalleryImagesCount($iCatId = NULL){
	$sql = "SELECT count(id) as total FROM `images` WHERE live=1 ";
	$sql .= (is_null($iCatId))?"":" AND categorie_id = ".$iCatId;
	$res2 = mysql_query($sql);
	$row2 = mysql_fetch_array($res2, MYSQL_ASSOC);
	return $row2["total"];
}
function getGalleryImages($group = NULL, $iStart = NULL, $iEnd = NULL) {
	$sql = "SELECT * FROM `images` WHERE live = 1 ";
	$sql .= (is_null($group))? "" : " AND categorie_id = ".$group;
	$sql .= (is_null($iStart) && is_null($iEnd))? " ORDER BY id DESC LIMIT 12;" : " ORDER BY id DESC LIMIT ".$iStart.",".$iEnd;
	//echo $sql;
	return mysql_query($sql);
}
/**************************************************************************************************************
LINKS SQL FUNCTIONS
**************************************************************************************************************/
function getLinkCategories() {
	$sql = "SELECT l.id, l.category FROM `links_categories` l WHERE l.id IN (SELECT `links`.`category_id` from `links`) ORDER BY l.category ASC;";
	return mysql_query($sql);
}
function getUsefulLinks($id = NULL, $group = NULL, $orderBy= NULL) {
	$sql = "SELECT * FROM `links` WHERE live = 1 ";
	$sql .= (is_null($id))? "" : " AND id=".$id;
	$sql .= (is_null($group))? "" : " AND category_id = ".$group;
	$sql .= (is_null($orderBy))? "" : " ORDER BY position ".$orderBy;
	return mysql_query($sql);
}
/**************************************************************************************************************
PROJECTS SQL FUNCTIONS
**************************************************************************************************************/
function getProjectCategories(){
	$sql = "SELECT Distinct prc.id, prc.category FROM `projects_categories` prc, `projects` pr WHERE prc.id = pr.category_id and pr.live = 1 Group By prc.id;";
	return mysql_query($sql);	
}
function getFeatureProjects(){
	$sql = "SELECT pr.id,pr.title,pr.seo_page_name,pr.shortDescription,pr.featureImage,prc.category,prl.location FROM `projects` pr, `projects_locations` prl, `projects_categories` prc WHERE pr.category_id = prc.id AND pr.location_id = prl.id AND pr.live = 1 AND pr.featured = 1;";
	return mysql_query($sql);	
}
function getProjectDetailsByID($id){
	$sql = "SELECT pr.*,prl.location,prc.category FROM `projects` pr,`projects_locations` prl, `projects_categories` prc WHERE pr.category_id = prc.id AND pr.location_id = prl.id AND pr.id = ".(int)$id." AND pr.live = 1;";
	return mysql_query($sql);		
}
function getProjectsByCategoryID($cat_id){
	$sql = "SELECT pr.id,pr.title,pr.seo_page_name,pr.shortDescription,pr.featureImage,prc.category,prl.location FROM `projects` pr, `projects_locations` prl, `projects_categories` prc WHERE pr.category_id = prc.id AND pr.location_id = prl.id AND pr.category_id = ".(int)$cat_id." AND pr.live = 1;";
	//echo $sql;
	return mysql_query($sql);	
}
function getProjectsCategoryIdByTitle($pageTitle){
	$sql = "SELECT prc.id FROM `projects_categories` prc WHERE LOWER(prc.category) = '".strtolower($pageTitle)."'";
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return (int)$row["id"];	
		} else {
			return 0;	
		}
	}
}
function getProjectIdByTitle($pageTitle){
	$sql = "SELECT pr.id FROM `projects` pr WHERE LOWER(pr.seo_page_name) = '".strtolower($pageTitle)."' AND pr.live = 1 ";
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return (int)$row["id"];	
		} else {
			return 0;	
		}
	}
}
/**************************************************************************************************************
PROPERTIES SQL FUNCTIONS
**************************************************************************************************************/
function getProperties($id=NULL,$cat_id=NULL,$reg_id=NULL,$type_id=NULL,$sale_status_id=NULL,$status_id=NULL,$featured=NULL){
	if(is_null($id) && is_null($cat_id) && is_null($reg_id) && is_null($type_id) && is_null($sale_status_id) && is_null($status_id) && is_null($featured)){
		$sql="SELECT p.*,pc.category,pr.region,pt.type,ss.sales_status,s.status FROM `properties` p, `properties_categories` pc, `properties_regions` pr, `properties_types` pt, `properties_sales_statuses` ss, `properties_statuses` s WHERE p.live = 1 AND p.category_id = pc.id AND p.region_id = pr.id AND p.type_id = pt.id AND p.sales_status_id = ss.id AND p.status_id = s.id ORDER BY p.id DESC";
		//echo $sql;
		return mysql_query($sql);
	} elseif(is_null($id) && isset($cat_id) && is_null($reg_id) && is_null($type_id) && is_null($sale_status_id) && is_null($status_id) && is_null($featured)) {
		$sql="SELECT p.*,pc.category,pr.region,pt.type,ss.sales_status,s.status FROM `properties` p, `properties_categories` pc, `properties_regions` pr, `properties_types` pt, `properties_sales_statuses` ss, `properties_statuses` s WHERE p.live = 1 AND p.category_id = pc.id AND p.region_id = pr.id AND p.type_id = pt.id AND p.sales_status_id = ss.id AND p.status_id = s.id AND pc.id = ".$cat_id." ORDER BY p.id DESC";
		//echo $sql;
		return mysql_query($sql);
	} elseif(is_null($id) && isset($cat_id) && isset($reg_id) && is_null($type_id) && is_null($sale_status_id) && is_null($status_id) && is_null($featured)) {
		$sql="SELECT p.*,pc.category,pr.region,pt.type,ss.sales_status,s.status FROM `properties` p, `properties_categories` pc, `properties_regions` pr, `properties_types` pt, `properties_sales_statuses` ss, `properties_statuses` s WHERE p.live = 1 AND p.category_id = pc.id AND p.region_id = pr.id AND p.type_id = pt.id AND p.sales_status_id = ss.id AND p.status_id = s.id AND pc.id = ".$cat_id." AND pr.id = ".$reg_id." ORDER BY p.id DESC";
		//echo $sql;
		return mysql_query($sql);
	} else {
		return "";	
	}
}

// $propertAceessType (0, 1, 2 ) Agent, Public and Both respectively

function getPropertiesForSearch($catID,$key,$typeID,$minPrice,$maxPrice,$propStatID, $aceessType = 1, $limit=NULL,$bedrooms='all',$bathrooms='all', $parking='all'){
	$sql="SELECT p.*,pt.type,ss.sales_status, s.status FROM `properties` p, `properties_types` pt, `properties_categories` pc, `properties_statuses` s, `properties_sales_statuses` ss WHERE p.live = 1 AND (p.access_type = 2 || p.access_type = $aceessType) AND p.type_id = pt.id AND p.category_id = pc.id AND p.status_id = s.id AND p.sales_status_id = ss.id ";
	$sql .= (is_numeric($catID)?" AND pc.id = ".$catID:"");
	$sql .= (trim($key)!='all'?" AND p.seo_page_name LIKE '%".mysql_real_escape_string($key)."%'":"");
	$sql .= ($typeID!=0?" AND pt.id = ".$typeID : "");
	$sql .= ($minPrice!=0? " AND p.priceRangeMin >= ".$minPrice : " AND p.priceRangeMin >=0 ");
	$sql .= ($maxPrice!=0? " AND p.priceRangeMax <= ".$maxPrice : "");
	$sql .= ($propStatID!=0?" AND s.id = ".$propStatID : "");
	$sql .= ($bedrooms!='all')?" AND numBedrooms = ".$bedrooms : "";
	$sql .= ($bathrooms!='all')?" AND numBathrooms = ".$bathrooms : "";
	$sql .= ($parking!='all')?" AND numParking = ".$parking : "";
	$sql .= " ORDER BY p.featured DESC, p.id DESC";
	$sql .= (is_null($limit))?"":" LIMIT ".$limit;
	//echo $sql;
	return mysql_query($sql);
}

function getPropFeatureThumbnailURL($pID){
	$sql = "SELECT i.location FROM `images` i WHERE i.property_id = ".$pID." ORDER BY i.position Limit 1;";
	$res = mysql_query($sql);
	while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return $pID."/thumbnails/".trim($row['location']);
		} else {
			return "blank.jpg";	
		}
	}
}

function getPropFeatureImageURL($pID){
	$sql = "SELECT i.location FROM `images` i WHERE i.property_id = ".$pID." ORDER BY i.position Limit 1;";
	$res = mysql_query($sql);
	while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return $pID."/files/".trim($row['location']);
		} else {
			return "blank.jpg";	
		}
	}
}

function getPropAllImagesURL($pID,$source){
	//$source could be 1 for Mobile and 0 for Desktop
	$propImages = array();
	$sql1 = "SELECT Count(id) AS NumRows FROM `images` i WHERE i.property_id = ".$pID." ORDER BY i.position;";
	$res1 = mysql_query($sql1);
	while($row1 = mysql_fetch_array($res1, MYSQL_ASSOC)){
		if($row1){
			$sql2 = "SELECT i.id,i.location,i.description FROM `images` i WHERE i.property_id = ".$pID." ORDER BY i.position ";
			$sql2 .= (($source==1)?"":"LIMIT 1,".$row1['NumRows'].";");
			$res2 = mysql_query($sql2);
			while($row2 = mysql_fetch_array($res2, MYSQL_ASSOC)){
				if($row2){
					$propImages['id'][] = $row2['id'];
					$propImages['desc'][] = $row2['description'];
					$propImages['thumbs'][] = $pID."/thumbnails/".trim($row2['location']);
					$propImages['files'][] = $pID."/files/".trim($row2['location']);
				}
			}
		}
	}
	if(count($propImages)>0){
		return $propImages;
	} else {
		return "blank.jpg";		
	}
}

function getPropertyDetails($id,$cat_id=NULL){
	//find by id
	//$sql = "SELECT p.*,pc.category,pr.region,pt.type FROM `properties` p, `properties_categories` pc, `properties_regions` pr, `properties_types` pt WHERE p.live = 1 AND p.category_id = pc.id AND p.region_id = pr.id AND p.type_id = pt.id AND p.id = ".(int)$id;
        $sql = "SELECT p.*,pc.category,pr.region,pt.type, ps.status FROM `properties` p, `properties_categories` pc, `properties_regions` pr, `properties_types` pt, `properties_statuses` ps WHERE p.live = 1 AND p.category_id = pc.id AND p.region_id = pr.id AND p.status_id = ps.id AND p.type_id = pt.id AND p.id = ".(int)$id;
        
	$sql .= (is_null($cat_id)?"":" AND pc.id = ".$cat_id);
	//echo $sql;
	return mysql_query($sql);
}
function getPropertyIDByURL($url){
	$sql = "SELECT p.id FROM `properties` p WHERE p.seo_page_name = '".mysql_real_escape_string($url)."' AND p.live = 1";
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return (int)$row["id"];
		} else {
			return 0;
		}
	}
}
function getPropRegIDByRegURL($url){
	$sql = "SELECT pr.id FROM `properties_regions` pr WHERE pr.seo_page_name = '".mysql_real_escape_string($url)."'";
	$res = mysql_query($sql);
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)){
		if($row){
			return (int)$row["id"];
		} else {
			return 0;
		}
	}
}

function getPropertyTypes(){
	$sql = "SELECT pt .* FROM`properties_types` pt,`properties` p WHERE pt.id = p.type_id AND p.live = 1 GROUP BY pt.id ORDER BY pt.type ASC;";
	//echo $sql;
	return mysql_query($sql);	
}

function getPropertyStatuses(){
	$sql = "SELECT ps .* FROM`properties_statuses` ps,`properties` p WHERE ps.id = p.status_id AND p.live = 1 GROUP BY ps.id ORDER BY ps.status ASC;";
	//echo $sql;
	return mysql_query($sql);	
}
/**************************************************************************************************************
GENERIC SQL FUNCTIONS
**************************************************************************************************************/
function getLinkGroups() {
	$sql = "SELECT * FROM link_category ORDER BY link_category ASC";
	return mysql_query($sql);
}

function getLinks($iGrp) {
	$sql = "SELECT * FROM link WHERE link_category_id = ".$iGrp." ORDER BY link_title ASC";
	return mysql_query($sql);
}

function getImageCount($iGrps) {
	if(is_array($iGrps)) {
		$w = "(";
		foreach($iGrps as $k => $v)
			$w .= "link_category_id=".$k. " or ";
		$w = substr($w, 0, (strlen($w)-4)).")";
	} else	{
		$w = "link_category_id=".$iGrps;
	}
	$sql = "SELECT count(id) as total FROM images WHERE ".$w." and live=1";
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res, MYSQL_ASSOC);
	return $row["total"];
}

function getImages($iGrps, $iPge = 1, $iIPP = NULL) {
	if(is_array($iGrps)) {
		$w = "(";
		foreach($iGrps as $k => $v)
			$w .= "link_category_id=".$k. " or ";
		$w = substr($w, 0, (strlen($w)-4)).")";
	} else	{
		$w = "link_category_id=".$iGrps;
	}
	
	$sql = "SELECT * FROM images WHERE ".$w." and live=1 ORDER BY image_date DESC";
	if(!is_null($iIPP)) $sql .= " LIMIT ".(($iPge-1)*$iIPP).", ".$iIPP;
	return mysql_query($sql);
}

function hasImages($iGrp) {
	$sql = "SELECT count(id) as total FROM images WHERE link_category_id = ".$iGrp." and live=1";
	return (getUniqueResult($sql, "total")>0) ? true : false;
}

// functions GENERAL
// return only one result from DB (1 field)
function getUniqueResult($sql, $sField) {
	@$result = mysql_query($sql);
	@$row=mysql_fetch_array($result, MYSQL_ASSOC);
	return ($row["$sField"]);
}
/**************************************************************************************************************



SETTINGS SQL FUNCTIONS



**************************************************************************************************************/
function getSetting($setting){

	$sql = "SELECT * FROM settings WHERE `key` = '$setting'";
	return mysql_query($sql);	
}


function getSettingValue($key){

	$sql = "SELECT * FROM settings WHERE `key` = '$key';";

	$result = mysql_query($sql);

        $settingObj = mysql_fetch_object($result);     

        return $settingObj->value;
}

/**************************************************************************************************************
AGENT FUNCTIONS
**************************************************************************************************************/

function isUniqueAgentEmail($iEmail)  {

$sql = "SELECT email FROM agents WHERE email = '$iEmail';";	
$rsMembers = mysql_query($sql);
$rows = mysql_num_rows($rsMembers);	

    if ($rows > 0)  {		
    return (false);	
    } else  {
    return (true);
    }
}

function createAgent($iTitle, $iFirstName, $iLastName, $iPassword, $iPhone, $iEmail, $iCompName, $iJoiningDate)  {

    $iFirstName = mysql_real_escape_string($iFirstName);
    $iLastName = mysql_real_escape_string($iLastName);
    $iCompName = mysql_real_escape_string($iCompName);
    
    $sql = "INSERT INTO agents (title, firstname, lastname, password, phone, email, company, joiningdate, active, newrequest, passworddefault)"

            . "VALUES ('$iTitle','$iFirstName','$iLastName', '$iPassword', '$iPhone', '$iEmail', '$iCompName', '$iJoiningDate', 0, 1, 1);";	

    //echo $sql;	
    $rsMember = mysql_query($sql);
        return (mysql_insert_id());			
}

function loginAgent($iEmail, $iPassword)  {

        $sql = "SELECT * FROM agents WHERE active = 1 AND  email = '$iEmail' and password = '$iPassword';";
        //echo $sql;
	$res = mysql_query($sql);
	while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
	    if($row ){
                        return $row;
		} else {
			return 0;	
		}
	}
}

function getAgentByID($iId)  {

    $sql = "SELECT * FROM agents WHERE id = '$iId'";
    $res = mysql_query($sql);
    return ($res);				

}

function updateAgentDetails($iId, $iTitle, $iFirstName, $iLastName, $iPhone, $iEmail, $iAddress, $iSuburb, $iState, $iPostcode,
        $iCompName)  {

    $iFirstName = mysql_real_escape_string($iFirstName);
    $iLastName = mysql_real_escape_string($iLastName);
    $iAddress = mysql_real_escape_string($iAddress);
    $iSuburb = mysql_real_escape_string($iSuburb);
    $iCompName = mysql_real_escape_string($iCompName);
    
    $sql = "UPDATE agents SET title = '$iTitle', firstname = '$iFirstName', lastname='$iLastName', phone = '$iPhone', email = '$iEmail', address = '$iAddress', suburb = '$iSuburb', state = '$iState', postcode = '$iPostcode', company = '$iCompName' WHERE id = $iId";
    //echo $sql;

    $rsMember = mysql_query($sql);		
}

function changeMemberPassword($iId, $iPassword)  {			
	   $sql = "UPDATE agents SET password = '$iPassword' WHERE id = $iId";	

	   //echo $sql;	

	   $rsMember = mysql_query($sql);
}

function getAgentByEmail($iEmail)  {

    $sql = "SELECT * FROM agents WHERE email = '$iEmail';";
	//echo $sql;
    $res = mysql_query($sql);
    return ($res);			

}

function setAgentToken($iId, $iToken)  {

    $sql = "UPDATE agents SET token = '$iToken' WHERE id = $iId";	
    $rsMember = mysql_query($sql);
}

function updateAgentPassword($iId, $iEmail, $iToken, $iPassword)  {

	$sql = "SELECT * FROM  agents WHERE id = $iId AND email = '$iEmail' AND token = '$iToken '";	

	$rsMember = mysql_query($sql);	

	if (mysql_num_rows($rsMember) > 0)  {				

	   $sql = "UPDATE agents SET password = '$iPassword', token = '' WHERE id = $iId AND email = '$iEmail' AND token = '$iToken'";

	   //echo $sql;	

	   $rsMember = mysql_query($sql);
	   return (1);				

	}        
        else  {
        return (0);	

	}
        
  }
  
  function getAgentToken($iId)  {

    $sql = "SELECT token FROM agents WHERE id = $iId";
    $rsMembers = mysql_query($sql);
	while($rsMember=mysql_fetch_array($rsMembers, MYSQL_ASSOC)){
		if($rsMember){
			return $rsMember["token"];	
		} else {
			return "";	
		}
	}		
}

function insertAgentTrackingRow($agentID, $agentName, $loginTime, $totalVisited = 0){
    $query = "INSERT INTO `properties_analytics` (agentId, agent, loginTime, visits, visited_properties_ids) VALUES($agentID, '$agentName', $loginTime, 0, '');";
    mysql_query($query);
    return mysql_insert_id();
}

function updatePropertyTrackingID($rowID, $propID){
    $propIDText =  $propID . ',';
    $query = "UPDATE `properties_analytics` SET visited_properties_ids = CONCAT(visited_properties_ids, '$propIDText'), visits = visits + 1 WHERE id=$rowID;";
    //echo $query;
    mysql_query($query);
}

function getMiscellaneousDocs($pID, $sortOrder){
    $query = "select * from properties_multidocs where pid=$pID AND fieldname='otherdocs' ORDER BY $sortOrder;";
    //echo $query;
    return ( mysql_query($query) );
}
?>