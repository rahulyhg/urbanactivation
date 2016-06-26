<?php
	session_start(); //need to create sesion for quick form on LHS
	if(isset($_REQUEST["seo_url"])){
		include("inc/connection.php"); 
		$validPageCat = $_REQUEST["cat"];
		$validPageTitle = $_REQUEST["seo_url"];
		$validPageID = getPageIDFromPageTitle($validPageCat,$validPageTitle);
		if($validPageID>0){
			$pageCategory = "";
			$sub_pages = array();
			$page_list = array();
			//retrieve sub pages list
			$result1 = getAllSubPages($validPageID);
			while($row1=mysql_fetch_array($result1, MYSQL_ASSOC))	{ 
				$sub_pages["id"][]     		= $row1["id"];
				$sub_pages["title"][]     	= $row1["title"];
				$sub_pages["seo_url"][]		= $row1["seo_page_name"];
				$sub_pages["seo_cat_name"][]= $row1["seo_cat_name"];
				$sub_pages["cat_id"][]		= $row1["cat_id"];
				$sub_pages["category"][]	= $row1["category"];
			}
			
			//retrieve page content
			$result2 = getCurrentPageContent($validPageID);
			while($row2=mysql_fetch_array($result2, MYSQL_ASSOC))	{ 
				$page_list["id"]      		= $row2["id"];
				$page_list["title"]     	= $row2["title"];
				$page_list["tagline"]     	= $row2["tagline"];
				$page_list["metaTitle"]    	= $row2["metaTitle"];
				$page_list["keywords"]  	= $row2["metaKeywords"];
				$page_list["description"]  	= $row2["metaDescription"];
				$page_list["photo"]  		= $row2["photo"];
				$page_list["body"] 			= str_replace("<img", "<img id='mobile-image-hide'", $row2["body"]); //$row2["body"];				
				$page_list["cName"] 		= $row2["seo_cat_name"];
				$pageCategoryID				= $row2["category_id"];//required for quick contact form
				$pageCategory				= $row2["category"];//required for quick contact form
			}
			
			$page = "pages";
			$title = $page_list["metaTitle"];
			$keywords = $page_list["keywords"];
			$description = $page_list["description"];
			require_once("inc/head.php"); 	
?>
            <!-- content section -->
            
            <div id="content" class="content-inside">
                <div id="col-left" class="opacity">                
					<?php include("inc/page-menu.php"); ?>

                    <h1><?php echo $page_list["title"];?></h1>
                    <p><?php echo $page_list["body"]; ?></p>
                </div>
                 <?php include("side-contact.php");?>  
 </div>               
<?php include("inc/foot.php");
		} else {
			header('location: '.$site_path.'404.php');
		}
	} else {
		header('location: '.$site_path.'404.php');
	}
?>