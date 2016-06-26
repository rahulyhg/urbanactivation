<?php
	$aboutLink = getSubPagesList(8,1); //getSubPagesList(CategoryID, Limit)
	$acquisitionLink = getSubPagesList(7,1);
	$faqLink = getSubPagesList(10,1);

//	$propValuationsLink = getSubPagesList(2,1);
//	$developmentAdvisoryLink = getSubPagesList(4,1);
//	$propertyDeveloperLink = getSubPagesList(8,1);
?>
<div id="nav">
    <div class="horizontalcssmenu">
        <ul id="cssmenu1">
            <?php if($agentLoggedIn === false){ ?>
            <li class="index"><a href="<?php echo $site_path;?>">HOME</a></li> 
			<!-- NRAS MENU-->                           
            <?php 	if(!is_null($acquisitionLink)){?>
			<li class="nras"><a href="<?php echo $site_path;?>pages<?php echo $acquisitionLink;?>">PROPERTY MANAGEMENT</a>
            	<ul>
                <?php
					$resAcquisitions = array();
					$acquisitionPages = getSubPagesList(7);
					while($resAcquisitions = mysql_fetch_array($acquisitionPages, MYSQL_ASSOC)){
						echo "<li><a href='".$site_path."pages".$resAcquisitions["PAGE_URL"]."'>".$resAcquisitions["PAGE_TITLE"]."</a></li>";
					}
				?>                              
                </ul>
            </li>
            <?php } 
            } ?> 
            
            <!-- PROPERTY MENU -->         
			<li class="properties"><a href="<?php echo $site_path;?>property-search">PROPERTY</a>
                <ul>
                    <li><a href="<?php echo $site_path;?>property-search">Property Search</a></li>
                    <?php
                    if($agentLoggedIn === false){  
                        // don't show where to begin and expand your portfolia links when agent is logged in
                    $resForSale = array();
                        $forSalePages = getSubPagesList(9);
                        while($resForSale = mysql_fetch_array($forSalePages, MYSQL_ASSOC)){
							echo "<li><a href='".$site_path."pages".$resForSale["PAGE_URL"]."'>".$resForSale["PAGE_TITLE"]."</a></li>";
                        }
                    }
                    ?>
                </ul>
           </li>          
           
			<!-- FAQs MENU-->         
			<!-- <li class="faqs"><a href="<?php echo $site_path;?>faqs">FAQ'S</a></li>-->
            
  			<!-- NEWS menu -->          
            <li class="news"><a href="<?php echo $site_path;?>news/latest-news">NEWS</a>
                <ul>
                <?php
					$resNewsCategories = array();
					$newsCategories = getNewsTypes();
					while($resNewsCategories = mysql_fetch_array($newsCategories, MYSQL_ASSOC)){
						echo "<li><a href='".$site_path."news/".strtolower(str_replace(" ","-",$resNewsCategories["category"]))."'>".$resNewsCategories["category"]."</a></li>";	
					}
				?>
                </ul>
            </li>
	 <?php if($agentLoggedIn === false){ ?>
            <!-- LINK MENU -->             
           <li class="links"><a href="<?php echo $site_path;?>links">LINKS</a></li>         
            
			<!-- ABOUT MENU -->              
            <?php 	if(!is_null($aboutLink)){?>
            <li class="about"><a href="<?php echo $site_path;?>pages<?php echo $aboutLink;?>">ABOUT</a>
                <ul>
                <?php
					$resAboutSubs = array();
					$aboutSubPages = getSubPagesList(8);
					while($resAboutSubs = mysql_fetch_array($aboutSubPages, MYSQL_ASSOC)){
						echo "<li><a href='".$site_path."pages".$resAboutSubs["PAGE_URL"]."'>".$resAboutSubs["PAGE_TITLE"]."</a></li>";
					}
				?>  
               
                </ul>
            </li> 
         <?php }} ?> 
           
			<!-- CONTACT MENU -->             
            <li class="contact"><a href="<?php echo $site_path;?>contact">CONTACT</a></li>
                        <!---------- Agent Menu ----------------> 
            <?php
            if( isset($_SESSION['UA']['memberID']) && isset($_SESSION['UA']['firstName'])){ 
            ?>
            <li class="links"><a style='color:blue;'>Hi &nbsp;<?php echo $_SESSION['UA']['firstName'];?> ! </a>
             <ul>
                    <li><a href="<?php echo $site_path;?>myaccount/change-details">Change Details</a></li>                    
                    <li><a href="<?php echo $site_path;?>myaccount/change-password">Change Password</a></li>   
                    <li><a href="<?php echo $site_path;?>logout">Logout</a></li>   
                </ul>
             </li>
           <?php }
            else{            
            ?>
            <li class="links"><a href="<?php echo $site_path;?>login">AGENT</a>
             <ul>
                    <li><a href="<?php echo $site_path;?>login">Login</a></li>                    
                    <li><a href="<?php echo $site_path;?>register">Register</a></li>   
                </ul>
             </li>
            <?php } ?>
        </ul>    
    </div> 
</div>