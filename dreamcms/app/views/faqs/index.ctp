<?php
if (isset($javascript)) {
	echo $javascript->link('scriptaculous/lib/prototype.js');
	echo $javascript->link('scriptaculous/src/scriptaculous.js');
}
?>
<div class="faqs index">
	<h1><?php __('faqs');?></h1>
    <div id="instruction-text" style="display: block;"><?php echo $instructionText; ?></div>
    <div id="order-status" style="display: none;"><?php echo $orderStatus; ?></div>
    <div style="clear:both;display:block;height:30px">
    	<?php
			$jsString = "javascript:location.href='?group='+this.value;";
			$categoryOptions[0] = '-------select group---------';
			foreach ($options as $option){
				$categoryOptions[$option['FaqsCategory']['id']] = $option['FaqsCategory']['category'];
			}
			if (!isset($_GET['group'])) {
				echo $this->Form->input('select_faqs_category_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString));
			} else {
				$groupValue = $_GET['group'];
				echo $this->Form->input('select_faqs_category_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString,'default' => $groupValue));
			}
		?>
    </div>
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
            <div style="width:55%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('title');?></div>
            </div>            
            <div style="width:120px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('category_id');?></div>
            </div>
            <div style="width:110px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('live');?></div>
            </div>
            <div style="width:110px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
        </div>
        <ul id="faqs">
        <?php 
		if($faqs){
		foreach ($faqs as $row):
			foreach ($options as $option){
				if($option['FaqsCategory']['id']==$row['Faq']['category_id']){
					$strCategoryName = $option['FaqsCategory']['category'];
				}
			} 		
			echo '<li id="faq_' . $row['Faq']['id'] . '" class="order-list"><div class="row-style">
					<div style="width:20px" id="record_row">
						<div id="record_detail">' .$row['Faq']['id'] .'</div>
					</div>
					<div style="width:50%" id="record_row">
						<div id="record_detail">' . $this->Html->link(__($row['Faq']['title'], true), array('action' => 'edit', $row['Faq']['id'])) . '</div>
					</div>					
					<div style="width:5%; cursor: move;" id="record_row">
						<div id="record_detail"><img border="0" src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/cursor.gif"></div>
					</div>
					<div style="width:115px" id="record_row">
						<div id="record_detail">'.$strCategoryName.'</div>
					</div>
					<div style="width:65px" id="record_row">
						<div id="record_detail">'.(($row['Faq']['live'] == 1)?'<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $row['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish FAQ # %s?', true), $row['Faq']['id'])).'</div>':'<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $row['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish FAQ # %s?', true), $row['Faq']['id'])).'</div>').'</div>
					</div>
					<div style="width:50px" id="record_row">'
						.(($row['Faq']['live'] == 0)? '<div id="record_option" class="imgPreview">'.$this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'view', $row['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'preview')).'</div>': "").
					'</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $row['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>
					</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $row['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $row['Faq']['id'])).'</div>
					</div>
				  </div></li>'; 
		endforeach; 
		?>
        </ul>
        <?php echo $ajax->sortable('faqs', array('url'=>'order', 'before'=>"Element.hide('order-status');", 'complete'=>"Element.show('order-status');")); ?>
		<?php
		/*$i = 0;
		foreach ($faqs as $faq):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}*/
		?>
            <!--<div id="record_wrap" <?php //echo $class;?>>
            	<div style="width:20px" id="record_row">
                	<div id="record_detail"><?php //echo $faq['Faq']['id']; ?>&nbsp;</div>
                </div>
                <div style="width:55%" id="record_row">
                    <div id="record_detail"><?php //echo $this->Html->link(__($faq['Faq']['title'], true), array('action' => 'edit', $faq['Faq']['id'])); ?>&nbsp;</div>
                </div>
                <div style="width:90px" id="record_row">
                    <div id="record_detail"><?php //echo $faq['Faq']['position']; ?>&nbsp;</div>
                </div>
                <div style="width:90px" id="record_row">
                    <div id="record_detail"><?php// if($faq['Faq']['live'] == 1){ echo 'Yes';}else{ echo 'No';} ?>&nbsp;</div>
                </div>
                <div style="width:50px" id="record_row">                	
                    <?php //if($faq['Faq']['live'] == 0){?><div id="record_option" class="imgPreview"><?php //if($faq['Faq']['live'] == 0){ echo $this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'view', $faq['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'preview'));}?></div><?php// } ?>  
                </div>              
                <div style="width:50px" id="record_row">
                        <div id="record_option" class="imgEdit"><?php //echo $this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $faq['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'edit')); ?></div>
                </div>
                <div style="width:50px" id="record_row">
                        <div id="record_option" class="imgDelete"><?php //echo $this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $faq['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $faq['Faq']['id'])); ?></div>
                </div>
            </div> -->
		<?php 
		//endforeach; 
		?>
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