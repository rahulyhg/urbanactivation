<div class="propertiesSalesStatuses view">
<h2><?php  __('Properties SalesStatus');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $propertiesSalesStatus['PropertiesSalesStatus']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('SalesStatus'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $propertiesSalesStatus['PropertiesSalesStatus']['sales_status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Properties SalesStatus', true), array('action' => 'edit', $propertiesSalesStatus['PropertiesSalesStatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Properties SalesStatus', true), array('action' => 'delete', $propertiesSalesStatus['PropertiesSalesStatus']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $propertiesSalesStatus['PropertiesSalesStatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Properties SalesStatuses', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Properties SalesStatus', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
