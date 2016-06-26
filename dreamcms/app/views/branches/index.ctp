<?php
if (isset($javascript)) {
	echo $javascript->link('scriptaculous/lib/prototype.js');
	echo $javascript->link('scriptaculous/src/scriptaculous.js');
}
?>
<div class="branches index">
	<h1><?php __('branches');?></h1>
    <div id="instruction-text" style="display: block;"><?php echo $instructionText; ?></div>
    <div id="order-status" style="display: none;"><?php echo $orderStatus; ?></div>
    <?php echo $this->CustomDisplayFunctions->displayQuickSearch(true,NULL); ?>
    <div id="wrap-tabs">
		<?php echo $this->CustomDisplayFunctions->displaySearchBox(true); ?>
        <div class="menu-tab">
            <span class="tab"><?php echo $this->Html->link(__('add new', true), array('action' => 'add')); ?></span>			
        </div>
        <div class="menu-tab">
            <span class="tab-hi">display all </span>
        </div>
    </div>
	<div id="clear"></div>
    <div id="records">
        <div id="record_header_wrap">
            <div style="width:20px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('id');?></div>
            </div>
            <div style="width:70%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('title');?></div>
            </div>
            <div style="width:110px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('live');?></div>
            </div>
            <div style="width:110px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
        </div>
        <ul id="branches">
		<?php
		if($branches){
			$i = 0;
			foreach ($branches as $branch):		
				echo '<li id="branch_' . $branch['Branch']['id'] . '" class="order-list"><div class="branch-style">
					<div style="width:20px" id="record_row">
						<div id="record_detail">' .$branch['Branch']['id'] .'</div>
					</div>
					<div style="width:64%" id="record_row">
						<div id="record_detail">' . $this->Html->link(__($branch['Branch']['title'], true), array('action' => 'edit', $branch['Branch']['id'])) . '</div>
					</div>					
					<div style="width:5%; cursor: move;" id="record_row">
						<div id="record_detail"><img border="0" src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/cursor.gif"></div>
					</div>
					<div style="width:65px" id="record_row">
						<div id="record_detail">'.(($branch['Branch']['live'] == 1)?'<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $branch['Branch']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish Branch # %s?', true), $branch['Branch']['id'])).'</div>':'<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $branch['Branch']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish Branch # %s?', true), $branch['Branch']['id'])).'</div>').'</div>
					</div>
					<div style="width:50px" id="record_row">'
						.(($branch['Branch']['live'] == 0)? '<div id="record_option" class="imgPreview">'.$this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'view', $branch['Branch']['id']), array('escape' => false,'id'=>'record','title'=>'preview')).'</div>': "").
					'</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $branch['Branch']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>
					</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $branch['Branch']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $branch['Branch']['id'])).'</div>
					</div>
				  </div></li>'; 
			endforeach; 
		?>
		</ul>
        <?php echo $ajax->sortable('branches', array('url'=>'order', 'before'=>"Element.hide('order-status');", 'complete'=>"Element.show('order-status');")); ?>
		
		<div id="clear"></div><br />
        <div class="paging">
        <?php
         echo $this->Paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
         ));
        ?>
            <div id="clear"></div>	
            <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
            | <?php echo $this->Paginator->numbers();?> |
            <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
        </div>
		<?php
        } else {
            echo $this->CustomDisplayFunctions->displayNoRecordDetails(true);
        }
        ?>
    </div>
</div>