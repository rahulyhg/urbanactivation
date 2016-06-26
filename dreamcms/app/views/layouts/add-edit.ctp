<!DOCTYPE html>
<!--DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title_for_layout?></title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <?php echo $this->Html->charset(); ?>
    <?php echo $this->Html->css('dreamcms-general.css'); ?>
	<?php echo $this->Html->css('datePicker.css'); ?>
	<!-- Include external files and scripts here (See HTML helper for more info.) -->	
	<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
    <?php echo $this->Html->script('ckfinder/ckfinder'); ?> 
    <?php echo $javascript->link(array('jquery.1.6.2.min.js','date.js', 'jquery.datePicker.js', 'jquery.callout.min.js')); ?>
    <?php echo $this->Html->script('animatedCollapsiblePanel.js'); ?>
    <script language="javascript" type="text/javascript">
		$(document).ready(function(){
			$(".slideOutTrigger").click(function(){
				$(".slideOutPanel").toggle("fast");
				$(this).toggleClass("active");
				<?php if(isset($helpURL)){?>
					$('.slideOutPanelFrame').attr('src','http://www.echothree.com.au/dreamcms/app/views/pages/help.php?modules=4,6,8#<?php echo $helpURL;?>');
				<?php } else { ?>
					$('.slideOutPanelFrame').attr('src','http://www.echothree.com.au/dreamcms/app/views/pages/help.php?modules=4,6,8');
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
			} 
		?>
			&nbsp; | &nbsp;<a href="mailto:support@echo3.com.au">CONTACT US</a>
	</div>
</div>
<div id="panel">
	<!-- header -->
	<?php echo $this->CustomDisplayFunctions->displayHeader(true); ?>
	<!-- content -->
	<div id="contentLeft">
		<?php echo $this->CustomDisplayFunctions->displayWebsiteModules(true,$session->read('Auth.User.group_id')); ?>
	</div>
	<div id="contentRight">
    	<h1><?php __($moduleHeading);?></h1>
		<?php 
			if (!isset($content_for_layout)){ 
				echo "<p>Use the menu options on the left hand side of the screen to view and manage your website's content. </p>
			<p>Any questions? Please do not hesitate to contact us at <a href='mailto:support@echo3.com.au'>echo 3</a>!</p>";
			} else { 
				echo $this->CustomDisplayFunctions->displayQuickSearch(false,NULL);?>
            	<div id="wrap-tabs">
					<?php echo $this->CustomDisplayFunctions->displaySearchBox(false); ?>
                    <div class="menu-tab">
                        <span class="tab"><?php echo $this->Html->link(__('add new', true), array('action' => 'add')); ?></span>			
                    </div>
                    <div class="menu-tab">
                        <span class="tab"><?php echo $this->Html->link(__('display all', true), array('action' => 'index')); ?></span>
                    </div>
                </div>	
                <div id="clear"></div>	
		<?php	echo $content_for_layout;
			}	?>
	</div>
</div>
<div id="footer">&copy; 2011 - <?php echo date('Y'); ?> <a href="http://www.echo3.com.au" target="_blank">echo3</a></div>
<?php echo $this->element('sql_dump'); ?>
<div class="slideOutPanel">
	<iframe src="http://www.echothree.com.au/dreamcms/app/views/pages/help.php?modules=4,6,8#<?php echo $helpURL;?>" class="slideOutPanelFrame"></iframe>
	<div style="clear:both;"></div>
</div>
<a class="slideOutTrigger" href="#">help</a>
</body>
</html>