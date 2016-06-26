<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php if(isset($title_for_layout)){ echo $title_for_layout; }else{ echo "Website Administration";}?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta name="keywords" content="Urban Activation, Investment Property, NRAS, Sales,">
<meta name="description" content="Urban Activation - Investment Property for sale">
<meta name="author" content="www.echo3.com.au" >
<meta name="robots" content="all" >
<meta name="google-site-verification" content="IGnB5afif0EXWBd5NkmTcrJ_1RURBB6BoPxVitFAzS0" >
<link rel="shortcut icon" href="/favicon.ico" >
<link rel="apple-touch-icon" href="/apple-icon.png" >
<meta name = "viewport" content = "user-scalable=0, initial-scale=1.0, maximum-scale=1.0, width=device-width" >
<meta name="apple-mobile-web-app-capable" content="yes">
<META HTTP-EQUIV='CACHE-CONTROL' CONTENT='MAX-AGE=864000, must-revalidate' >
<?php echo $this->Html->css('front-end.css');?>
<link href="<?php echo Configure::read('Company.url');?>css/print.css" rel="stylesheet" type="text/css" media="print">
<link href="<?php echo Configure::read('Company.url');?>css/horizontalmenu.css" rel="stylesheet" type="text/css" media="all">

<link href='http://fonts.googleapis.com/css?family=Sintony:400,700' rel='stylesheet' type='text/css' media="all">
<link rel="stylesheet" href="<?php echo Configure::read('Company.url');?>css/contact-form.css" type="text/css" media="all" />
<link href="<?php echo Configure::read('Company.url');?>css/font-awesome.css" rel="stylesheet" type="text/css" media="all">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo Configure::read('Company.url');?>js/side-contact-form.js"></script>
<script type="text/javascript" src="<?php echo Configure::read('Company.url');?>js/jquery.html5form-1.5-min.js"></script>
<script type="text/javascript" src="<?php echo Configure::read('Company.url');?>js/csshorizontalmenu.js">
/* CSS Horizontal List Menu- by JavaScript Kit (www.javascriptkit.com)
Menu interface credits: http://www.dynamicdrive.com/style/csslibrary/item/glossy-vertical-menu/ 
This notice must stay intact for usage
Visit JavaScript Kit at http://www.javascriptkit.com/ for this script and 100s more */
</script>


<script type="text/javascript" src="<?php echo Configure::read('Company.url');?>js/jquery.friendurl.min.js"></script>
<script type="text/javascript" language="javascript">
	$(function(){
		$('#key').friendurl({id : 'ft', transliterate: true});
	});
</script>

<!-- The Adaptive Images JavaScript http://http://adaptive-images.com/ -->
<script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>
<script type="text/javascript" src="<?php echo Configure::read('Company.url');?>js/bootstrap-collapse.js"></script>
<!--[if IE 8]>
<style> #mobileGallery { display: none; visibility: hidden; }
</style>
<![endif]-->

<!--[if IE 7]>
<style> #mobileGallery { display: none; visibility: hidden; } </style>
<![endif]-->

</head>
<body id="news" >
    <div id="top-strip">
        <div id="top-strip-text">
            <?php
                if (strlen($session->read('Auth.User.username'))>0) {
                    echo "Welcome <b>".$session->read('Auth.User.username').", </b>";   
                    echo $html->link('LOGOUT', array('controller' => 'users', 'action' => 'logout'));
                } 
            ?>
                &nbsp; | &nbsp;<a href="#">CONTACT US</a>
        </div>
    </div>
    <script src="<?php echo Configure::read('Company.url');?>js/jquery.backstretch.min.js"></script>
	<script>
        $.backstretch([
          "<?php echo Configure::read('Company.url');?>images/bg1.jpg",
          "<?php echo Configure::read('Company.url');?>images/bg2.jpg",
          "<?php echo Configure::read('Company.url');?>images/bg3.jpg"
        ], {
            fade: 2000,
            duration: 10000
        });
    </script>
    <div class="wrapper">
    	<!-- header section -->
	    <div id="head-wrapper">
            <div id="logo"><a href="#"><img src="http://www.urbanactivation.com.au/images/ua-logo.png" title="Urban Activation" alt="Urban Activation" width="290" height="90"></a></div>
            <div id="logo-print"><img src="http://www.urbanactivation.com.au/images/ua-logo-print.gif" width="200" height="80" alt="Urban Activation"></div>
            <div id="phone">
            	<ul>
                	<li>1300 750 000</li>
		            <li style="font-size: 16px; font-weight: 400; color: #ccc;">Victoria's best researched properties</li>
                </ul>
            </div>
            <div style="clear: both; height: 0;" ></div>

            <!-- Everything you want hidden at 700px or less, place within nav-collapse -->
            <div class="nav-collapse">
	            <div id="nav">
    		        <div class="horizontalcssmenu">
            			<ul id="cssmenu1">
			                <li class="index"><a href="#">HOME</a></li> 
                            <!-- PROPERTY MENU -->         
                            <li class="properties"><a href="#">PROPERTY</a></li>          
                            <!-- NRAS MENU-->                           
                            <li class="nras"><a href="#">NRAS</a></li>
                            <!-- FAQs MENU-->         
                            <!--<li class="faqs"><a href="#">FAQ'S</a></li>    -->
                            <!-- NEWS menu -->          
                            <li class="news"><a href="#">NEWS</a></li>
                            <!-- LINK MENU -->             
                            <!-- <li class="links"><a href="#">LINKS</a></li>  -->           
                            <!-- ABOUT MENU -->              
                            <li class="about"><a href="#">ABOUT</a></li> 
                            <!-- CONTACT MENU -->             
                            <li class="contact"><a href="#">CONTACT</a></li>
	                    </ul>    
                    </div> 
                </div>
            </div><!--end nav collapse -->
            <div style="clear: both; height: 0;"></div> 
        
            <div class="search-box">
            	<h1>Search for Investment Property</h1>
	            <div id="search-fields">
    		        <div id="search-left" style="float: left; width: 85%;">
                    <!--Keyword -->
                    <input type="text" id="key" name="key" value="Keyword search" maxlength="25" style="width:220px; margin-bottom:3px;" onclick="javascript:this.select()" /> 
                    <!--State -->
                    <select name="pt" id="pt" style="width:180px; margin-bottom:3px;">
	                    <option value="0" selected>All property types</option>
                    </select> 
                    <!--Price Range -->
                    <select name="prl" id="prl" style="width:116px;">
                        <option value="0" selected>Min price </option>
                    </select>
		            <select name="prh" id="prh" style="width:117px; margin-left:1px;">
                        <option value="0" selected>Max price </option>
                    </select>
                    <!--Status -->
                    <select name="prs" id="prs" style="width:180px;">
                    	<option value="0" selected>All property statuses</option>
					</select>
                    <input type="hidden" name="ft" id="ft" value="all" />
                    <!--<input type="hidden" name="tp" id="tp" value="any" />
                    <input type="hidden" name="ct" id="ct" value="all" />
                    <input type="hidden" name="sb" id="sb" value="all" />-->
                    <div style="float:left"><a href="javascript:void(0);" onclick="document.getElementById('advanced_search').style.display=''">ADVANCED SEARCH &raquo;</a></div>
                        <div id="advanced_search" style='display:none'>
                            <select name="bed" id="bed" style="width:200px; margin-left:1px;">
                                <option value="all">All bedroom types</option>
                            </select>
                            <select name="bth" id="bth" style="width:200px; margin-left:1px;">
                                <option value="all">All bathroom types</option>
                            </select>
                            <select name="prk" id="prk" style="width:200px; margin-left:1px;">
                                <option value="all">All car park types</option>
                            </select>
	                    </div>
			        </div>
                    <!--Submit button -->
                    <div id="search-submit" style="float: left; width: 10%; padding: 0 20px;">
                        <input name="search"  type="text" value="search" id="btn-submit" title="Search Properties" />
                    </div>
			    </div>
		    </div>
        </div>
        <div style="clear: both; height: 0;" ></div>    <style type="text/css" media="all">
                .shareButtons {float: right;left: 520px;position: absolute;top: 19px;width: 250px;}
                .fb_share_size_Small { position: relative; top: -6px; }
            </style>
            <!-- content section -->
            <div id="content" class="content-inside">
                <div id="col-left" class="opacity">
                    <h3><?php echo $moduleHeading; ?></h3>
                    <p><?php echo $content_for_layout; ?></p>
                    <a href='#' title='Go Back'  class='sml'>&laquo; GO BACK</a><p>
                </div>
            </div>
            <div id="col-right" class="opacity">   
	            <div class="side-nav"><ul><li><i class='icon-chevron-right'></i> <a href='#'>Latest News</a></li></ul></div>
            </div>     
        </div>
        <div style="clear: both; height: 0;" ></div>

        <!-- footer section -->
        <div id="footer">
            <a href="#">&copy; 2013 Urban Activation</a> |
            <a href="tel:1300750000">1300 750 000</a> | <a href="#">Disclaimer</a> | <a href="#">Contact</a> | <a href="#" target="_blank">Web</a>
        </div>
    </div>
</body>
</html>

