<?php
class ImageGalleryHelper extends FormHelper { 
	var $helpers = array('Html','Javascript');
	
	function displayImageGallery($imgObject, $propertyId=0, $key=NULL) {
		$htmlOutput = "";
		// $img (images object[s] array)
// var_dump($imgObject["images"]);
		$arrayItem=0;
		foreach ($imgObject as $image){
// var_dump($image["Images"]);
			$basePath = WWW_ROOT."uploads/properties/";
			$folderPath = ($image["Images"]["property_id"]==0)?$image["Images"]["key"]:$image["Images"]["property_id"];
//echo $basePath.$folderPath."/thumbnails/".$image["Images"]["location"];
			if(file_exists($basePath.$folderPath."/thumbnails/".$image["Images"]["location"])) {
				$htmlOutput .= "<div id='image_".$image["Images"]["id"]."' style='border:1px solid #333; width:190px; float:left; margin:3px' align='center'>
									<input type='hidden' id='ImageId_".$image["Images"]["id"]."' name='ImageId[]' value='".$image["Images"]["id"]."'>
									<input type='hidden' id='ImageLocation_".$image["Images"]["id"]."' name='ImageLocation[]' value='".$image["Images"]["location"]."'>
									<div style='margin:2px'><!--".$image["Images"]["position"]."--><img src='".Configure::read('Company.url')."dreamcms/app/webroot/uploads/properties/".$folderPath."/thumbnails/".$image["Images"]["location"]."' height='51' alt='".$image["Images"]["location"]."' title='".$image["Images"]["location"]."'></div>
									<div style='margin:2px'><input type='button' name='remove[]' id='remove' value='Delete' onclick='unconfirmItem(".$image["Images"]["id"].")' style='width:auto'></div>
							   </div>";
			}
		}
		return $htmlOutput;	
	}
	
	/*function displayHeader($var) {
		if($var){
			$htmlOutput = "<div id='header-wrap'>
								<div id='header-client-name'>".Configure::read('Company.name')." Website Administration</div>
								<div id='header-client-logo'><img src='".Configure::read('Company.url')."images/logo.jpg' width='168' height='51' alt='".Configure::read('Company.url')."' class='cust_logo'></div>
						   </div>";
			return $htmlOutput;	
		}
	}
	
	function displayWebsiteModules($var,$userType) {
		if($var){
			$htmlOutput = "";	
			$siteMenu = 	"<div class='menu-module'>
								<h2>Website Modules</h2>
								<div id='menu-link'>
									<a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php' title='home'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='home' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/home.gif' alt='home' /><span>home</span></a>
								</div>
								<!--<div id='menu-link'>
									<a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php/branches/' title='branches'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='branches' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/branches.gif' alt='branches' /><span>branches</span></a>
								</div>
								<div id='menu-link'>
									<a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php/faqs/' title='faqs'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='faqs' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/faqs.gif' alt='gallery' /><span>faqs</span></a>
								</div>
								<div id='menu-link'>
									<a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php/images/' title='gallery'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='gallery' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/gallery.gif' alt='gallery' /><span>gallery</span></a>
								</div>
								<div id='menu-link'>
									<a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php/links/' title='links'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='links' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/web.gif' alt='links' /><span>links</span></a>
								</div>-->
								<div id='menu-link'>
									<a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php/news/' title='news items'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='news items' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/news.gif' alt='news items' /><span>news items</span></a>
								</div>
								<div id='menu-link'>
									<a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php/webpages/' title='pages'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='pages' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/pages.gif' alt='pages' /><span>pages</span></a>
								</div>
								<div id='menu-link'>
									<a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php/testimonials/' title='testimonials'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='testimonials' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/testimonials.gif' alt='testimonials' /><span>testimonials</span></a>
								</div>
								<!--<div id='menu-link'>
									<a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php/teams/' title='teams'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='teams' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/teams.gif' alt='teams' /><span>teams</span></a>
								</div>-->
							</div>";
			$adminMenuStart = "<div class='menu-module'><div class='squarebox'><div class='squareboxgradientcaption' style='height:20px; cursor: pointer;' onclick='togglePannelAnimatedStatus(this.nextSibling,50,50)'><div style='float: left;color: #999;font: bold 13px/18px arial,sans-serif;'>ADMIN MODULES</div><div style='float: right; vertical-align: middle'><img src='".Configure::read('Company.url')."dreamcms/app/webroot/img/expand.gif' width='13' height='14' border='0' alt='Show/Hide' title='Show/Hide' /></div></div><div class='squareboxcontent' style='display: none;'><ul>";
								//<h2>ADMIN Modules</h2>";		
			$adminCategoryMenu = "<li><a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php/news_categories/' title='news categories'>News Categories</a></li>
								  <li><a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php/pages_categories/' title='pages categories'>Pages Categories</a></li>";
			$userAccessMenu =	"<li><a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php/users/' title='users'>Users</a></li>
                    			 <li><a class='menu_item' href='".Configure::read('Company.url')."dreamcms/index.php/groups/' title='user groups'>User Groups</a></li>";					  
			$adminMenuEnd = "</ul></div></div></div>";
			$genericMenu =	"<div class='menu-modules'>
								<div class='squarebox'><div class='squareboxgradientcaption' style='height:20px; cursor: pointer;' onclick='togglePannelAnimatedStatus(this.nextSibling,50,50)'><div style='float: left;color: #999;font: bold 13px/18px arial,sans-serif;'>QUICK LINKS</div><div style='float: right; vertical-align: middle; padding: 0px 10px 0px 0px;'><img src='".Configure::read('Company.url')."dreamcms/app/webroot/img/expand.gif' width='13' height='14' border='0' alt='Show/Hide' title='Show/Hide' /></div></div><div class='squareboxcontent' style='display: none;'>
								<div id='menu-link'>
									<a href='". Configure::read('Company.url')."' target='_blank' class='menu_item'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='website' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/web.gif' alt='website' /><span>Website</span></a>
								</div>
								<div id='menu-link'>                
									<a href='http://www.echo3.com.au/login.php' target='_blank' class='menu_item'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='email campaign' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/email.gif' alt='email campaign' /><span>Email Campaign</span></a>
								</div>
								<div id='menu-link'>
									<a href='http://www.google.com' target='_blank' class='menu_item'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='google' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/google.gif' alt='google' /><span>Google</span></a>
								</div>
								<div id='menu-link'>
									<a href='http://www.youtube.com' target='_blank' class='menu_item'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='youtube' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/youtube.gif' alt='youtube' /><span>YouTube</span></a>
								</div>
								<div id='menu-link'>
									<a href='http://www.facebook.com' target='_blank' class='menu_item'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='facebook' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/facebook.gif' alt='facebook' /><span>Facebook</span></a>
								</div>
								<div id='menu-link'>
									<a href='http://www.twitter.com' target='_blank' class='menu_item'><img class='menu_toggle' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/button_up.gif' alt='twitter' /><img class='menu_logo' src='".Configure::read('Company.url')."dreamcms/app/webroot/img/nav/twitter.gif' alt='twitter' /><span>Twitter</span></a>
								</div>
						   </div></div></div>";
			
			if ((int)$userType==1){ //admin
				$htmlOutput = $siteMenu.$adminMenuStart.$adminCategoryMenu.$userAccessMenu.$adminMenuEnd.$genericMenu;
			} 
			if ((int)$userType==2){	//content-users		
				$htmlOutput = $siteMenu.$adminMenuStart.$adminCategoryMenu.$adminMenuEnd.$genericMenu;
			}
			if ((int)$userType==3){	//editors			
				$htmlOutput = $siteMenu.$genericMenu;
			}
			return $htmlOutput;	
		}
	}
	
	function displayQuickLinks($var) {
		if($var){
			$htmlOutput = "";
			return $htmlOutput;	
		}
	}
	
	function displayQuickSearch($var, $url){
		if ($var){
			$htmlOutput = "<div id='quick-search'><strong>Quick search:</strong>&nbsp;
							<a href='".$url."?sel=A'>A</a> 
							<a href='".$url."?sel=B'>B</a> 
							<a href='".$url."?sel=C'>C</a> 
							<a href='".$url."?sel=D'>D</a> 
							<a href='".$url."?sel=E'>E</a> 
							<a href='".$url."?sel=F'>F</a> 
							<a href='".$url."?sel=G'>G</a> 
							<a href='".$url."?sel=H'>H</a> 
							<a href='".$url."?sel=I'>I</a> 
							<a href='".$url."?sel=J'>J</a> 
							<a href='".$url."?sel=K'>K</a> 
							<a href='".$url."?sel=L'>L</a> 
							<a href='".$url."?sel=M'>M</a> 
							<a href='".$url."?sel=N'>N</a> 
							<a href='".$url."?sel=O'>O</a> 
							<a href='".$url."?sel=P'>P</a> 
							<a href='".$url."?sel=Q'>Q</a> 
							<a href='".$url."?sel=R'>R</a> 
							<a href='".$url."?sel=S'>S</a> 
							<a href='".$url."?sel=T'>T</a> 
							<a href='".$url."?sel=U'>U</a> 
							<a href='".$url."?sel=V'>V</a> 
							<a href='".$url."?sel=W'>W</a> 
							<a href='".$url."?sel=X'>X</a> 
							<a href='".$url."?sel=Y'>Y</a> 
							<a href='".$url."?sel=Z'>Z</a> | 
							<a href='".$url."?sel=all'>all</a> |
							<a href='".$url."?sel=other'>other</a>&nbsp;
						   </div>";
			return $htmlOutput;	
		}
	}
		
	function displaySearchBox($var){
		if($var){
			$jsString = "javascript:location.href='?search='+document.getElementById('search').value;";
			$htmlOutput = "<div class='menu-tab'>
							<input type='text' id='search'>&nbsp;
							<a onclick=".$jsString." href='javascript:void(0)'>search</a>
						   </div>";
			return $htmlOutput;	
		}
	}
	
	function displayNoRecordDetails($var){
		if($var){
			$htmlOutput = 	"<div id='record_wrap'>
								<div style='width:100%' id='record_row'>
									<div id='record_detail'>There are no records in your current selection or current search criteria or filtering options.</div>
								</div>
							</div>";
			return $htmlOutput;	
		}
	}*/
}
?>