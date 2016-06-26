<?php
	include("../../../../inc/connection.php");  // link to website connection string

//	var_dump($_REQUEST);
	$galleryID = (int)getGalleryIDByTitle(trim($_REQUEST["cat"]));
	$images = $_REQUEST["images"];
	$image_array = explode(",",$images);

	$gallery_result = getGalleryCategories();
	$galleryTitle = ""; $galleryBody = "";
	$gallery = array();
	while($row = mysql_fetch_array($gallery_result, MYSQL_ASSOC)){
		if($galleryID==0) $galleryID = $row["cat_id"]; 	// default value if not set
		$gallery["id"][]	= $row["cat_id"];	
		$gallery["name"][]	= $row["name"];	
		$gallery["url"][]	= $row["seo_page_name"];
	}

	$sql = "select * from images where categorie_id=".$galleryID." and product_id=0";

	$res = mysql_query($sql);
	$image = array();
	while($row=mysql_fetch_array($res, MYSQL_ASSOC)) {
		if(!in_array((string)$row["id"], $image_array)) {
			$image["id"][]		= $row["id"];
			$image["file"][]	= $row["location"];
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Images</title>
<link rel="stylesheet" type="text/css" href="<?php echo $site_path; ?>dreamcms/app/webroot/css/dreamcms-general.css" />
<script type="text/javascript" src="<?php echo $site_path; ?>dreamcms/app/webroot/js/jquery.1.6.2.min.js"></script>
</head>
<body style="min-width:500px">
<script type="text/javascript" language="javascript">
	function updateImageList(i) {
		if(confirm('Add this image to the list?')) {
			$('#images').val($('#images').val() + ',' + i);	// add the element to the list
			$('#image_'+i).remove();						// remove the element from screen view
		}
	}
	
	function reloadParentPage() {
		parent.$('#ProductImages').val($('#images').val());	// copy the updated image list to the parent page element
		parent.reloadImageList();							// load image content on parent page to update the images to display
		top.tb_remove();									// close the thickbox frame
	}
</script>
<div>
    <form action="index.php" class="editForm" enctype="multipart/form-data" id="imageForm" method="post" accept-charset="utf-8">
        <div style="margin:20px 0">
            <select id="cat" name="cat" onchange="document.getElementById('imageForm').submit();">
<?php	for($g=0;$g<count($gallery["url"]);$g++) {
			echo  "<option value='".$gallery["url"][$g]."' ".(((integer)$gallery["id"][$g]==$galleryID)?"selected ": "").">".$gallery["name"][$g]."</option>";
		} ?>
            </select>&nbsp;&nbsp;
            <input type="button" id="update" name="update" value=" Update Changes " onclick="reloadParentPage()" />&nbsp;&nbsp;
            <input type="button" id="cancel" name="cancel" value="  Cancel  " onclick="javascript:top.tb_remove();" />
        </div>
        <div style="clear:both">
<?php	for($i=0;$i<count($image["id"]);$i++) {
			echo "<div id='image_".$image["id"][$i]."' style='border:1px solid #333; width:190px; float:left; margin:3px' align='center' class='imageBox'>";
			echo "<div style='margin:2px'><img src='".$site_path."dreamcms/app/webroot/img/thumbnails/".$image["file"][$i]."' height='51px' title='".$image["file"][$i]."' /></div>";
			echo "<div style='margin:2px'><input type='button' name='remove[]' id='remove' value='  Add  ' onclick='updateImageList(".$image["id"][$i].")' style='width:auto'></div>";
			echo "</div>";
		} 
		if(count($image["id"])==0) {
			echo "<div style='margin:20px 0 0 20px; float:left; color:#DD0000'>There are no images in this gallery to select...</div>";
		} ?>
        </div>
        <input type="hidden" name="images" id="images" value="<?php echo $images; ?>" />
    </form>
</div>
</body>
</html>