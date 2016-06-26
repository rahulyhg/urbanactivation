<?php 
	$err = FALSE;
	$errMessage = "The archived News you are trying to access does not exist. Please click on the left navigation options for more infomration.";	
	$title = "Archived News - Urban Activation";
	$page = "archived-news";
	require_once("inc/head.php");
	
	//page variables
	//if number of news categories > 1 then 
	$group = "";
	$archived_display = true;
	$validNewsId = 0;
	$archivedDate = 0;
	$noArchiveNews = false;
	$newsList = false;
	
	//Get Archived News Groups
	if($archived_display) {
		$archived_list = array();
		$result = getArchivedDropDown(1);
		while($row=mysql_fetch_array($result, MYSQL_ASSOC))	{
			$archived_list["value"][] = $row["ValueToDisplay"];
			$archived_list["text"][] = $row["TextToDisplay"];
		}
	}
	
	if (!isset($_GET['arc'])) {
		//If not isset -> set with dumy value 
		if(isset($archived_list["value"][1])){
			$archivedDate = $archived_list["value"][1];
		} else {
			$noArchiveNews = true;	
		}
	} else {
		$archivedDate = $_GET['arc'];
	}
	
	//check for XSS attacks
	$isXSS = false;
	if (strlen($archivedDate)>0) {
		if (!is_numeric($archivedDate) || $archivedDate%3!=0) { 
			$isXSS = true;	
		}
	}
	
	if ($isXSS==true) {
?>
		<script type="text/javascript" language="javascript">
			window.location='<?php echo $site_path;?>archived-news';	
		</script>
<?php
	}
	
	//echo "Title:[".$_GET["title"]."], Arc Date: [".$archivedDate."]";
	if(isset($_REQUEST["title"]) && $archivedDate>0){
		$validNewsId = getNewsIDFromNewsTitle(strtolower($_REQUEST["title"]));
		//echo "Inside Individual News Item: [".$validNewsId."] and Group: [".$group."]";
		if($validNewsId>0){
			//display news content
			$news_content = array();
			$result1 = getTopNewsForDisplay($validNewsId,1,$archivedDate,NULL, NULL);
			while($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)){
				$news_content["id"]		= $row1["id"];
				$news_content["title"]	= $row1["title"];
				$news_content["body"]	= $row1["body"];
			}
			
		}
	}
	if ($archivedDate>0 && !isset($_REQUEST["title"])){
		//dispplay blog listings from the news category
		//echo "Inside NewsID: [".$validNewsId."] AND ArchivedDate: [".$archivedDate."]";
		$news_content = array();
		$result2 = getTopNewsForDisplay($validNewsId,1,$archivedDate,NULL, NULL);
		while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)){
			$news_content["id"][]		= $row2["id"];
			$news_content["title"][]	= $row2["title"];
			$news_content["shortDesc"][]= $row2["shortDescription"];
			$news_content["url"][] 		= $row2["seo_page_name"];
			$newsList = true;
		}
	}
	
?>
<div id="content" class="content-inside">
<?php if($noArchiveNews == false) { ?>
    <div id="col-left" class="opacity">
        <h2>ARCHIVED NEWS</h2>
       
		<?php
			if($newsList){
				if(count($news_content["id"])>0){
					for($bl = 0; $bl < count($news_content["id"]); $bl ++){
						echo "<h3>".$news_content["title"][$bl]."</h3>";
						echo $news_content["shortDesc"][$bl];
						echo "<br><a href='".$site_path."archived-news/".$archivedDate."/".$news_content["url"][$bl]."' title='".$news_content["title"][$bl]."' class='sml'>READ MORE &raquo;</a><hr>";
					}
				} else {
					echo "There are currently no archived news to display. Please check back later.";
				}
			} else {
				if(isset($news_content["id"])){
					echo "<h1>".$news_content["title"]."</h1>";
					echo $news_content["body"];					
					echo "<p><a href='javascript: window.history.go(-1);' title='Go Back' class='sml'>&laquo; GO BACK</a><p>";
				} else {
					echo "There are currently no archived news to display. Please check back later.";
				}	
			}
        ?>
    </div>

<div id="col-right" class="opacity">    
     <?php  if($archived_display) {?>
                    <select name="arc" onChange="location.href='<?php echo $site_path;?>archived-news/'+this.value;" class="dropDownList">
        <?php		for($n=0; $n<count($archived_list["value"]); $n++) {
                        if ($archived_list["value"][$n] != 0){	
                            $selText = "";
                            if($archived_list["value"][$n] == (int)$_GET["arc"]){$selText="selected";}
                            echo "<option value=\"".$archived_list["value"][$n]."\"" .$selText. " >".$archived_list["text"][$n]."</option>";
                        }
                    }
        ?>
                    </select>
        <?php 
                }
        ?>
        <br /><br />
        <a href="<?php echo $site_path;?>news"class="sml" >&laquo; RETURN TO LATEST NEWS</a>
    
    
<?php 
	} else { ?>
		<div id="col-left"><h2>ARCHIVED NEWS</h2><p>There are currently no archived news to display. Please check back later.</p></div>
        <div id="col-right" class="opacity"><a href="<?php echo $site_path;?>news"class="sml" >&laquo; RETURN TO LATEST NEWS</a></div>
<?php
	}?>
    </div>
<?php include("inc/foot.php"); ?>