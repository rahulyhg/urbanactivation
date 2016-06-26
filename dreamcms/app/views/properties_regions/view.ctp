<div class="propertiesRegions view">
<h2><?php  __('Properties Region');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $propertiesRegion['PropertiesRegion']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Region'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $propertiesRegion['PropertiesRegion']['region']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Properties Region', true), array('action' => 'edit', $propertiesRegion['PropertiesRegion']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Properties Region', true), array('action' => 'delete', $propertiesRegion['PropertiesRegion']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $propertiesRegion['PropertiesRegion']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Properties Regions', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Properties Region', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
