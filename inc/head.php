<?php 
	session_start();
	header('Content-type: text/html;charset=utf-8');
	if($page!="pages" && $page!="property" && $page!="rent" && $page!="properties" && $page!="rentals"){
            include_once ("connection.php");
	} else {
		if($page=="pages" && $page!="property" && $page!="rent" && $page!="properties" && $page!="rentals") $page = $validPageCat;
	}
	if(!isset($keywords)){
		$keywords = "Urban Activation, Investment Property, NRAS, Sales,";
	}
	if(!isset($description)){
		$description = "Urban Activation - Investment Property for sale";
	}
	if(!isset($title)){
		$title = "Urban Activation | Investment Property | Property Sales";
	}
	include("property-search-settings.php");
        
       
        if(empty($agentLoggedIn)){
            $agentLoggedIn = false;
            if( !empty($_SESSION['UA']['memberID']) && !empty($_SESSION['UA']['trackingrowid']) && !empty($_SESSION['UA']['logintime']) ){
                        $agentLoggedIn = true;
            }
        }
        
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta name="keywords" content="<?php echo $keywords;?>">
<meta name="description" content="<?php echo $description;?>">
<meta name="author" content="www.echo3.com.au" >
<meta name="robots" content="all" >
<meta name="google-site-verification" content="IGnB5afif0EXWBd5NkmTcrJ_1RURBB6BoPxVitFAzS0" >
<link rel="shortcut icon" href="/favicon.ico" >
<link rel="apple-touch-icon" href="/apple-icon.png" >
<meta name = "viewport" content = "user-scalable=0, initial-scale=1.0, maximum-scale=1.0, width=device-width" >
<meta name="apple-mobile-web-app-capable" content="yes">
<META HTTP-EQUIV='CACHE-CONTROL' CONTENT='MAX-AGE=864000, must-revalidate' >
<link href="<?php echo $site_path;?>css/ua.css?1.0" rel="stylesheet" type="text/css" media="all">
<link href="<?php echo $site_path;?>css/print.css" rel="stylesheet" type="text/css" media="print">
<link href="<?php echo $site_path;?>css/horizontalmenu.css" rel="stylesheet" type="text/css" media="all">

<link href='http://fonts.googleapis.com/css?family=Sintony:400,700' rel='stylesheet' type='text/css' media="all">
<link rel="stylesheet" href="<?php echo $site_path;?>css/contact-form.css" type="text/css" media="all" />
<link href="<?php echo $site_path;?>css/font-awesome.css" rel="stylesheet" type="text/css" media="all">
<?php if($page=="properties" || $page=="rentals"){?>
<link rel="stylesheet" type="text/css" href="<?php echo $site_path;?>css/paginateStyles.css" media="all" /> 
<link rel="stylesheet" type="text/css" href="<?php echo $site_path;?>css/organicTabs.css" media="all" />  
<?php } 
	if($page=="property" || $page=="rent"){?>
	<link rel="stylesheet" type="text/css" href="<?php echo $site_path;?>css/elastislide.css" />
    <noscript>
		<style>
            .es-carousel ul{
                display:block;
            }
        </style>
    </noscript>
<?php } ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $site_path;?>js/side-contact-form.js"></script>
<script type="text/javascript" src="<?php echo $site_path;?>js/jquery.html5form-1.5-min.js"></script>
<?php if($page=="properties" || $page=="rentals"){?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo $site_path;?>js/jquery.paginate.min.js"></script>
<script type="text/javascript" src="<?php echo $site_path;?>js/organictabs.jquery.js"></script>
<?php } if($page=="property" || $page=="rent"){?>

<script type="text/javascript" src="<?php echo $site_path;?>js/jquery.elastislide.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo $site_path;?>js/csshorizontalmenu.js">
/* CSS Horizontal List Menu- by JavaScript Kit (www.javascriptkit.com)
Menu interface credits: http://www.dynamicdrive.com/style/csslibrary/item/glossy-vertical-menu/ 
This notice must stay intact for usage
Visit JavaScript Kit at http://www.javascriptkit.com/ for this script and 100s more */
</script>


<script type="text/javascript" src="<?php echo $site_path;?>js/jquery.friendurl.min.js"></script>
<script type="text/javascript" language="javascript">
	$(function(){
		$('#key').friendurl({id : 'ft', transliterate: true});
	});
</script>
<!-- google analytics new code -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40273317-1', 'urbanactivation.com.au');
  ga('send', 'pageview');

</script>


<!-- The Adaptive Images JavaScript http://http://adaptive-images.com/ -->
<script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>
<script type="text/javascript" src="<?php echo $site_path;?>js/bootstrap-collapse.js"></script>
<!--[if IE 8]>
<style> #mobileGallery { display: none; visibility: hidden; }
</style>
<![endif]-->

<!--[if IE 7]>
<style> #mobileGallery { display: none; visibility: hidden; } </style>
<![endif]-->

</head>
<body id="<?php echo $page; ?>" <?php if($page=="properties" || $page=="rentals"){?>class="<?php echo str_replace("/","",$_SERVER['REQUEST_URI']);?>" <?php } ?>>
    <script src="<?php echo $site_path;?>js/jquery.backstretch.min.js"></script>
	<script>
        $.backstretch([
          "<?php echo $site_path;?>images/bg1.jpg",
          "<?php echo $site_path;?>images/bg2.jpg",
          "<?php echo $site_path;?>images/bg3.jpg"
        ], {
            fade: 2000,
            duration: 10000
        });
    </script>
<div class="wrapper">
  <!-- header section -->
<div id="head-wrapper">

<div id="logo"><a href="<?php echo $site_path;?>index.php"><img src="<?php echo $site_path;?>images/ua-logo.png" title="Urban Activation" alt="Urban Activation" width="290" height="90"></a></div>
<div id="logo-print"><img src="<?php echo $site_path;?>images/ua-logo-print.gif" width="200" height="80" alt="Urban Activation"></div>
<div id="phone"><ul><li>1300 750 000</li>
 <?php       
 $logoTxt = 'Property Management in Melbourne';
 if($agentLoggedIn === true){
    $logoTxt = 'Sales Portal' ;
 }
 echo "<li style='font-size: 16px; font-weight: 400; color: #ccc;'>$logoTxt</li></ul></div>";
 ?>
<div style="clear: both; height: 0;" ></div>

 <!-- .btn-nav is used as the toggle for collapsed nav content -->
 <a class="btn-nav" data-toggle="collapse" data-target=".nav-collapse" title="Menu">

      <span class="sml" style="float: right; text-align:right; padding: 5px 0 0 0; margin: 0;">MENU</span>
    </a>
     <!-- Everything you want hidden at 700px or less, place within nav-collapse -->
        
     <div class="nav-collapse">
    <?php include("inc/nav.php"); ?>
    </div><!--end nav collapse -->
    <div style="clear: both; height: 0;"></div> 
  	
	<?php 
	if($page!="rentals" && $page!="rent"){
		include("inc/search.php"); 
	} else {
		include("inc/rental-search.php"); 
	}?>
</div>
<div style="clear: both; height: 0;" ></div>