<?php
if (isset($javascript)) {
	echo $javascript->link('scriptaculous/lib/prototype.js');
	echo $javascript->link('scriptaculous/src/scriptaculous.js');
}
?>
<div class="links index">
	<h1><?php __('links');?></h1>
    <div id="instruction-text" style="display: block;"><?php echo $instructionText; ?></div>
    <div id="order-status" style="display: none;"><?php echo $orderStatus; ?></div>
    <div style="clear:both;display:block;height:30px">
    	<?php
			$jsString = "javascript:location.href='?group='+this.value;";
			$categoryOptions[0] = '-------select link category--------';
			foreach ($options as $option){
				$categoryOptions[$option['LinksCategory']['id']] = $option['LinksCategory']['category'];
			}
			if (!isset($_GET['group'])) {
				echo $this->Form->input('select_links_category_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString));
			} else {
				$groupValue = $_GET['group'];
				echo $this->Form->input('select_links_category_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString,'default' => $groupValue));
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
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('name');?></div>
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
        <ul id="links">
		<?php
		if($links){
			foreach ($links as $link):
				foreach ($options as $option){
					if($option['LinksCategory']['id']==$link['Link']['category_id']){
						$strCategoryName = $option['LinksCategory']['category'];
					}
				} 	
				
				echo '<li id="link_' . $link['Link']['id'] . '" class="order-list"><div class="row-style">
					<div style="width:20px" id="record_row">
						<div id="record_detail">' .$link['Link']['id'] .'</div>
					</div>
					<div style="width:50%" id="record_row">
						<div id="record_detail">' . $this->Html->link(__($link['Link']['name'], true), array('action' => 'edit', $link['Link']['id'])) . '</div>
					</div>
					<div style="width:5%; cursor: move;" id="record_row">
						<div id="record_detail"><img border="0" src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/cursor.gif"></div>
					</div>
					<div style="width:115px" id="record_row">
						<div id="record_detail">'.$strCategoryName.'</div>
					</div>
					<div style="width:65px" id="record_row">
						<div id="record_detail">'.(($link['Link']['live'] == 1)?'<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $link['Link']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish TEAM MEMBER # %s?', true), $link['Link']['id'])).'</div>':'<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $link['Link']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish TEAM MEMBER # %s?', true), $link['Link']['id'])).'</div>').'</div>
					</div>
					<div style="width:50px" id="record_row">'
						.(($link['Link']['live'] == 0)? '<div id="record_option" class="imgPreview">'.$this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'view', $link['Link']['id']), array('escape' => false,'id'=>'record','title'=>'preview')).'</div>': "").
					'</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $link['Link']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>
					</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $link['Link']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $link['Link']['id'])).'</div>
					</div>
				  </div></li>'; 
				  
			endforeach;
		?>
        </ul>
        <?php echo $ajax->sortable('links', array('url'=>'order', 'before'=>"Element.hide('order-status');", 'complete'=>"Element.show('order-status');")); ?>
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
        
        