<div class="webpages view">
	<h2><?php echo $page['Webpage']['title']; ?></h2>
    <p>&nbsp;</p>
    <p><?php echo $page['Webpage']['body']; ?></p>
</div>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT PAGE', true), array('action' => 'edit', $page['Webpage']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE PAGE', true), array('action' => 'delete', $page['Webpage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $page['Webpage']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO PAGES', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD NEW PAGE', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS PAGE?', true), array('action' => 'publish', $page['Webpage']['id']), null, sprintf(__('Are you sure you want to publish PAGE # %s?', true), $page['Webpage']['id'])); ?>
</div>