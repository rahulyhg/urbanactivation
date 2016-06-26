<?php	
	$err = FALSE;
	$errMessage = "The link article you are trying to access does not exist. Please click on the left navigation options for more information.";	
	$title = "Urban Activation - Useful Links";
	$page = "links";
	require_once("inc/head.php");
	
	//retrieve Link categories
	$categories = array();
	$result = getLinkCategories();
	while($row=mysql_fetch_array($result, MYSQL_ASSOC))	{
		$categories["id"][]			= $row["id"];
		$categories["category"][] 	= $row["category"];
	}	
?>
    <style type="text/css" media="all">
		.shareButtons {float: right;left: 520px;position: absolute;top: 19px;width: 150px;}
		.fb_share_size_Small { position: relative; top: -6px; }
	</style>
    <script language="javascript" type="text/javascript" src="<?php echo $site_path;?>js/framework.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $site_path;?>js/jquery.ui.core.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo $site_path;?>js/jquery.ui.widget.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo $site_path;?>js/jquery.accordian.js"></script>
    <script> 
        $(function() {
        <?php
            $count = 0;
            foreach($categories["category"] as $cats){ ?>		
                $( "#accordion-<?php echo $count+1;?>" ).accordion({
                    autoHeight: false,
                    active: 0, 
                    collapsible: true
                });
        <?php
                $count = $count + 1;
            }
        ?>	
    
        });
    </script> 

    <!-- content section -->
    <div id="content">
    	<div id="col-left" class="opacity">
        	<h2>Useful Links</h2>

            <ul id="portfolio">
			<?php
                $i = 0;
                $count = count($categories["category"]);
                foreach($categories["category"] as $cat){
            ?>					
                <li class='<?php echo strtolower(str_replace(' ','-',$cat));?>' id='<?php echo $i;?>' <?php if($i==0){ echo "style='display: list-item;padding-left:0px;background:none;'";} else { echo "style='display: none;padding-left:0px;background:none;'";}?>>		
                    <div id="accordion-<?php echo $i+1;?>">
                <?php
                    //retrieve Links
                    $result = getUsefulLinks(NULL,$categories["id"][$i],"ASC");
                    while($rowLinks=mysql_fetch_array($result, MYSQL_ASSOC))	{
                ?>			
                       <h3><a href="#" style="color: #888888; padding: 0px; line-height: 180%;"><?php echo $rowLinks["name"];?></a> <i class="icon-caret-down"></i></h3>
                      
                <?php    echo "<div>";   
                        if(strlen($rowLinks["logo"])>0){
                            echo   "<img src='".$site_path."dreamcms/app/webroot/uploads/links/".$rowLinks["logo"]."' alt='".$rowLinks["name"]."' width='200' style='float:right; margin: 0px 10px 10px 0px; padding: 0px;' />";
                        }
                        echo "<a href='http://".$rowLinks["url"]."' target='_blank' title='".$rowLinks["name"]."'>".$rowLinks["url"]."</a>";
                        echo $rowLinks["description"];
                        echo "<p>&nbsp;</p>";
                        echo "<br clear='all' />"; 
                        echo "</div>";
                    }
                ?>
                    </div>
                </li>
            <?php
                    $i++;
                }
            ?>
            </ul>
  		</div>
 <div id="col-right" class="opacity">                   
 <ul id="filter">
			<?php 
                $i = 0;
                $count = count($categories["category"]);
                foreach($categories["category"] as $cat){
                    echo "<li ".(($i==0)?"class='current'":"")."><a href='#'>".$cat."</a></li>";
                    $i++;		
                }
            ?>
            </ul>
        </div>
		
	</div>
<?php include("inc/foot.php"); ?>