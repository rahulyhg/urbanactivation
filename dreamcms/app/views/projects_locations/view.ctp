<div class="projectsLocations view">
<h2><?php  __('Projects Location');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projectsLocation['ProjectsLocation']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Location'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $projectsLocation['ProjectsLocation']['location']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Projects Location', true), array('action' => 'edit', $projectsLocation['ProjectsLocation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Projects Location', true), array('action' => 'delete', $projectsLocation['ProjectsLocation']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $projectsLocation['ProjectsLocation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects Locations', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Projects Location', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
