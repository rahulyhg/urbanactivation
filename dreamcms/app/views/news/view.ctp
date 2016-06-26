<div class="news view">
    <h1><?php echo $news['News']['title']; ?></h1>
    <?php //echo $this->FormatEpochToDate->formatEpochToDate($news['News']['startDate']); ?>
    <!--<p>&nbsp;</p>
    <p><?php //echo $news['News']['shortDescription']; ?></p>-->
    <p><?php echo $news['News']['body']; ?></p>
</div>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT NEWS', true), array('action' => 'edit', $news['News']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE NEWS', true), array('action' => 'delete', $news['News']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $news['News']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO NEWS', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD NEWS', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS NEWS?', true), array('action' => 'publish', $news['News']['id']), null, sprintf(__('Are you sure you want to publish NEWS # %s?', true), $news['News']['id'])); ?>
</div>