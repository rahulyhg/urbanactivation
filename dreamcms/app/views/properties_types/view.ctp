<div class="propertiesTypes view">
<h2><?php  __('Properties Type');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $propertiesType['PropertiesType']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $propertiesType['PropertiesType']['type']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Properties Type', true), array('action' => 'edit', $propertiesType['PropertiesType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Properties Type', true), array('action' => 'delete', $propertiesType['PropertiesType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $propertiesType['PropertiesType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Properties Types', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Properties Type', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
