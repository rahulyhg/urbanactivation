<div id="login">
	<h1>Welcome to the <strong><?php echo Configure::read('Company.name');?></strong> website administration</h1>
	Please enter a valid username and password to enter.<br><br>
	<table width="450" border="0" cellpadding="8" cellspacing="0" >
		<tr ><td colspan="2"></td><tr>
		<tr>
			<?php
				echo $this->Session->flash();    
				echo $this->Session->flash('auth');
				if  ($session->check('Message.auth')) $session->flash('auth');
				echo $form->create('User', array('action' => 'login'));
				echo $form->input('username', array('between'=>': '));
				echo "<br />";
				echo $form->input('password', array('between'=>': '));
				echo "<br />";
				echo $form->end('Login');
			?>
		</tr>
	</table>
</div>
<?php echo $this->element('sql_dump'); ?>
