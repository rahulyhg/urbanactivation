<div class="branches view">
	<h2><?php echo $branch['Branch']['title']; ?></h2>
    <p>&nbsp;</p>
    <p><?php echo $branch['Branch']['body']; ?></p>
</div>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT BRANCH', true), array('action' => 'edit', $branch['Branch']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE BRANCH', true), array('action' => 'delete', $branch['Branch']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $branch['Branch']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO BRANCHES', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD NEW BRANCH', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS BRANCH?', true), array('action' => 'publish', $branch['Branch']['id']), null, sprintf(__('Are you sure you want to publish BRANCH # %s?', true), $branch['Branch']['id'])); ?>
</div>