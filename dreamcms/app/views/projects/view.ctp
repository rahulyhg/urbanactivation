<div class="projects view">
	<h2><?php echo $project['Project']['title']; ?></h2>
    <em><?php echo $project['Project']['created']; ?></em>
    <p><?php echo $project['Project']['shortDescription']; ?></p>
</div>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT PROJECT', true), array('action' => 'edit', $project['Project']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE PROJECT', true), array('action' => 'delete', $project['Project']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $project['Project']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO PROJECTS', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD PROJECT', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS PROJECT?', true), array('action' => 'publish', $project['Project']['id']), null, sprintf(__('Are you sure you want to publish PROJECTS # %s?', true), $project['Project']['id'])); ?>
</div>
