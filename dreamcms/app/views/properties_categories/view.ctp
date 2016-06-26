<div class="propertiesCategories view">
<h2><?php  __('Properties Category');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $propertiesCategory['PropertiesCategory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $propertiesCategory['PropertiesCategory']['category']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Properties Category', true), array('action' => 'edit', $propertiesCategory['PropertiesCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Properties Category', true), array('action' => 'delete', $propertiesCategory['PropertiesCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $propertiesCategory['PropertiesCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Properties Categories', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Properties Category', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
