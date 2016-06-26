<div class="projects view">
	<h1><?php echo $project['Project']['title']; ?></h1>
    <p><?php echo $project['Project']['body']; ?></p>
</div>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT CASE STUDY', true), array('action' => 'edit', $project['Project']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE PROJECT', true), array('action' => 'delete', $project['Project']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $project['Project']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO PROJECTS', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD PROJECT', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS PROJECT?', true), array('action' => 'publish', $project['Project']['id']), null, sprintf(__('Are you sure you want to publish PROJECT # %s?', true), $project['Project']['id'])); ?>
</div>
