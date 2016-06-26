<div class="propertiesStatuses view">
<h2><?php  __('Properties Status');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $propertiesStatus['PropertiesStatus']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $propertiesStatus['PropertiesStatus']['status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Properties Status', true), array('action' => 'edit', $propertiesStatus['PropertiesStatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Properties Status', true), array('action' => 'delete', $propertiesStatus['PropertiesStatus']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $propertiesStatus['PropertiesStatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Properties Statuses', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Properties Status', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
