<div class="projectsCategories view">
<h2><?php  __('Projects Category');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projectsCategory['ProjectsCategory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projectsCategory['ProjectsCategory']['category']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Projects Category', true), array('action' => 'edit', $projectsCategory['ProjectsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Projects Category', true), array('action' => 'delete', $projectsCategory['ProjectsCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $projectsCategory['ProjectsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects Categories', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Projects Category', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
