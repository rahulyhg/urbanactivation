<div class="properties view">
	<h2><?php echo $property['Property']['title']; ?></h2>
    <em><?php echo $property['Property']['created']; ?></em>
    <p><?php echo $property['Property']['shortDescription']; ?></p>
</div>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT PROPERTY', true), array('action' => 'edit', $property['Property']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE PROPERTY', true), array('action' => 'delete', $property['Property']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $property['Property']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO PROPERTIES', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD PROPERTY', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS PROPERTY?', true), array('action' => 'publish', $property['Property']['id']), null, sprintf(__('Are you sure you want to publish PROPERTIES # %s?', true), $property['Property']['id'])); ?>
</div>
