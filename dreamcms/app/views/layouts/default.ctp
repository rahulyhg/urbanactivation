<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php if(isset($title_for_layout)){ echo $title_for_layout; }else{ echo "Website Administration";}?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<?php echo $this->Html->css('dreamcms-general.css'); ?>
    <?php echo $this->Html->script('jquery.1.6.2.min.js'); ?>
    <?php echo $this->Html->script('animatedCollapsiblePanel.js'); ?>
    <script language="javascript" type="text/javascript">
		$(document).ready(function(){
			$(".slideOutTrigger").click(function(){
				$(".slideOutPanel").toggle("fast");
				$(this).toggleClass("active");
				<?php if(isset($helpURL)){?>
					$('.slideOutPanelFrame').attr('src','http://www.echothree.com.au/dreamcms/app/views/pages/help.php?modules=1,3,4,5,6,8,9#<?php echo $helpURL;?>');
				<?php } else { ?>
					$('.slideOutPanelFrame').attr('src','http://www.echothree.com.au/dreamcms/app/views/pages/help.php?modules=1,3,4,5,6,8,9');
				<?php } ?>
				return false;
			});
		});
	</script>
</head>
<body>
<div id="top-strip">
	<div id="top-strip-text">
		<?php
			if (strlen($session->read('Auth.User.username'))>0) {
				echo "Welcome <b>".$session->read('Auth.User.username').", </b>";   
				echo $html->link('LOGOUT', array('controller' => 'users', 'action' => 'logout'));
				echo "&nbsp; | &nbsp;";
			} 
		?>
			<a href="mailto:support@echo3.com.au">CONTACT US</a>
	</div>
</div>
<div id="panel">
	<!-- header -->
	<div id="header-wrap">
		<div id="header-client-name"><?php echo Configure::read('Company.name');?> Website Administration</div>
		<div id="header-client-logo"><img src="<?php echo Configure::read('Company.url');?>images/ua-logo-print.gif" height="60" alt="<?php if (isset($client_name_for_layout)){ echo $client_name_for_layout; }else{ echo "Echo3";} ?>" class="cust_logo"></div>
	</div>
	<!-- content -->
	<div id="contentLeft">
		<div class="menu-module">
			<h2>Website Modules</h2>
			<div id="menu-link">
				<a class="menu_item" href="<?php echo Configure::read('Company.url');?>dreamcms/index.php" title="home"><img class="menu_toggle" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif" alt="home" /><img class="menu_logo" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/home.gif" alt="home" /><span>home</span></a>
			</div>
           <div id='menu-link'>
                <a class='menu_item' href='<?php echo Configure::read('Company.url');?>dreamcms/index.php/agents/' title='agents'><img class='menu_toggle' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif' alt='agents' /><img class='menu_logo' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/agents.gif' alt='agents' /><span>agents</span></a>
            </div>
            <div id='menu-link'>
                <a class='menu_item' href='<?php echo Configure::read('Company.url');?>dreamcms/index.php/propertiesAnalytics/' title='Analytics'><img class='menu_toggle' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif' alt='analytics' /><img class='menu_logo' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/analytics.gif' alt='analytics' /><span>analytics</span></a>
            </div>
            <div id='menu-link'>
                <a class='menu_item' href='<?php echo Configure::read('Company.url');?>dreamcms/index.php/news/' title='news items'><img class='menu_toggle' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif' alt='news items' /><img class='menu_logo' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/news.gif' alt='news items' /><span>news items</span></a>
            </div>
            <div id='menu-link'>
                <a class='menu_item' href='<?php echo Configure::read('Company.url');?>dreamcms/index.php/webpages/' title='pages'><img class='menu_toggle' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif' alt='pages' /><img class='menu_logo' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/pages.gif' alt='pages' /><span>pages</span></a>
            </div>
            <div id='menu-link'>
                <a class='menu_item' href='<?php echo Configure::read('Company.url');?>dreamcms/index.php/properties/' title='pages'><img class='menu_toggle' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif' alt='properties' /><img class='menu_logo' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/properties.gif' alt='properties' /><span>properties</span></a>
            </div>
            <div id='menu-link'>
                <a class='menu_item' href='<?php echo Configure::read('Company.url');?>dreamcms/index.php/faqs/' title='faqs'><img class='menu_toggle' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif' alt='faqs' /><img class='menu_logo' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/faqs.gif' alt='gallery' /><span>faqs</span></a>
            </div>
            <div id='menu-link'>
                <a class='menu_item' href='<?php echo Configure::read('Company.url');?>dreamcms/index.php/links/' title='links'><img class='menu_toggle' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif' alt='links' /><img class='menu_logo' src='<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/web.gif' alt='links' /><span>links</span></a>
            </div>
            <div id="menu-link">
				<a class="menu_item" href="<?php echo Configure::read('Company.url');?>dreamcms/index.php/testimonials/" title="testimonials"><img class="menu_toggle" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif" alt="testimonials" /><img class="menu_logo" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/testimonials.gif" alt="testimonials" /><span>testimonials</span></a>
			</div>
		</div>
        <?php if ($session->read('Auth.User.group_id')!=3) {?>
      	 	<div class="menu-module" style="background-image: url('<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/settings.gif') no-repeat;"><div class="squarebox"><div class="squareboxgradientcaption" style="height:20px; cursor: pointer;" onclick="togglePannelAnimatedStatus(this.nextSibling,50,50)"><div style="float: left;color: #999;font: bold 13px/18px arial,sans-serif;">ADMIN MODULES</div><div style="float: right; vertical-align: middle"><img src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/expand.gif" width="13" height="14" border="0" alt="Show/Hide" title="Show/Hide" /></div></div><div class="squareboxcontent" style="display: none;">
                <?php if ($session->read('Auth.User.group_id')!=3) {?>
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.url');?>dreamcms/index.php/news_categories/" title="news categories">News Categories</a></li>
                    <li><a class='menu_item' href='<?php echo Configure::read('Company.url');?>dreamcms/index.php/faqs_categories/' title='faqs categories'>Faqs Categories</a></li>
                    <li><a class='menu_item' href='<?php echo Configure::read('Company.url');?>dreamcms/index.php/links_categories/' title='links categories'>Links Categories</a></li>
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.url');?>dreamcms/index.php/pages_categories/" title="page categories">Page Categories</a></li>
	                <?php if ($session->read('Auth.User.group_id')<2) {?>
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.url');?>dreamcms/index.php/properties_categories/" title="property categories">Property Categories</a></li>
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.url');?>dreamcms/index.php/settings/" title="settings">Settings</a></li>
	                <?php } ?>
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.url');?>dreamcms/index.php/properties_regions/" title="property regions">Property Regions</a></li>
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.url');?>dreamcms/index.php/properties_sales_statuses/" title="property sale status">Property Sale Statuses</a></li>
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.url');?>dreamcms/index.php/properties_statuses/" title="property status">Property Statuses</a></li>
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.url');?>dreamcms/index.php/properties_types/" title="property types">Property Types</a></li>
                   	<li><a class="menu_item" href="<?php echo Configure::read('Company.url');?>dreamcms/index.php/users/" title="users">Users</a></li>
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.url');?>dreamcms/index.php/groups/" title="user groups">User Groups</a></li>
                    
                <?php } ?>
                </ul>
			</div></div>
        </div>
        <?php } ?>
		<div class="menu-modules">
			<div class="squarebox"><div class="squareboxgradientcaption" style="height:20px; cursor: pointer;" onclick="togglePannelAnimatedStatus(this.nextSibling,50,50)"><div style="float: left;color: #999;font: bold 13px/18px arial,sans-serif;">QUICK LINKS</div><div style="float: right; vertical-align: middle; padding: 0px 10px 0px 0px;"><img src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/expand.gif" width="13" height="14" border="0" alt="Show/Hide" title="Show/Hide" /></div></div><div class="squareboxcontent" style="display: none;">
			<div id="menu-link">
				<a href="<?php echo Configure::read('Company.url');?>" target="_blank" class="menu_item"><img class="menu_toggle" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif" alt="website" /><img class="menu_logo" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/web.gif" alt="website" /><span>Website</span></a>
            </div>
            <div id="menu-link">                
				<a href="http://www.echo3.com.au/login.php" target="_blank" class="menu_item"><img class="menu_toggle" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif" alt="email campaign" /><img class="menu_logo" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/email.gif" alt="email campaign" /><span>Email Campaign</span></a>
			</div>
            <div id="menu-link">
				<a href="http://www.google.com" target="_blank" class="menu_item"><img class="menu_toggle" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif" alt="google" /><img class="menu_logo" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/google.gif" alt="google" /><span>Google</span></a>
			</div>
            <div id="menu-link">
				<a href="http://www.youtube.com" target="_blank" class="menu_item"><img class="menu_toggle" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif" alt="youtube" /><img class="menu_logo" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/youtube.gif" alt="youtube" /><span>YouTube</span></a>
			</div>
            <div id="menu-link">
				<a href="http://www.facebook.com" target="_blank" class="menu_item"><img class="menu_toggle" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif" alt="facebook" /><img class="menu_logo" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/facebook.gif" alt="facebook" /><span>Facebook</span></a>
			</div>
            <div id="menu-link">
				<a href="https://twitter.com/UrbanActivate" target="_blank" class="menu_item"><img class="menu_toggle" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/button_up.gif" alt="twitter" /><img class="menu_logo" src="<?php echo Configure::read('Company.url');?>dreamcms/app/webroot/img/nav/twitter.gif" alt="twitter" /><span>Twitter</span></a>
			</div>
		</div></div></div>
	</div>
	<div id="contentRight">
		<?php 
			if (!isset($content_for_layout)){ 
				echo "<h1>administration</h1><p><strong>Welcome to the website administration.</strong></p><p>Use the menu options on the left hand side of the screen to view and manage your website's content. </p><p>Any questions? Please do not hesitate to contact us at <a href='mailto:support@echo3.com.au'>echo 3</a>!</p>";
			} else {
				echo $content_for_layout;
			}
		?>
	</div>
</div>
<div id="footer">&copy; 2011 - <?php echo date('Y'); ?> <a href="http://www.echo3.com.au" target="_blank">echo3</a></div>
<?php echo $this->element('sql_dump'); ?>
<div class="slideOutPanel">
	<iframe src="http://www.echothree.com.au/dreamcms/app/views/pages/help.php?modules=1,3,4,5,6,8,9#<?php echo $helpURL;?>" class="slideOutPanelFrame"></iframe>
	<div style="clear:both;"></div>
</div>
<a class="slideOutTrigger" href="#">help</a>
</body>
</html>