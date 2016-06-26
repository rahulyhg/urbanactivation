<?php echo $jQValidator->validator(); ?>
<div class="userStatuses form">
<?php echo $this->Form->create('UserStatus');?>
	<fieldset>
		<legend><?php __('Edit User Status'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('UserStatus.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('UserStatus.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List User Statuses', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Users', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>