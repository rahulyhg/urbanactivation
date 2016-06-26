<?php
echo $this->Html->css('paginateStyles.css');
if (isset($javascript)) {
	echo $javascript->link('jquery.paginate.min.js');
}
?>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$('#paging_container').pajinate({
			num_page_links_to_display : 4,
			items_per_page : <?php echo $pageLimit;?>	
		});
	});
</script>
<div class="properties index">
	<h1><?php __('properties');?></h1>
    <?php if($sortable){?><div id="instruction-text" style="display: block;"><?php echo $instructionText; ?></div><?php } ?>
    <div id="order-status" style="display: none;"><?php echo $orderStatus; ?></div>
    <div style="clear:both;display:block;height:30px">
    	<?php
			$jsString = "javascript:location.href='?group='+this.value;";
			$categoryOptions[0] = '-------select group---------';
			foreach ($options as $option){
				$categoryOptions[$option['PropertiesCategory']['id']] = $option['PropertiesCategory']['category'];
			}
			if (!isset($_GET['group'])) {
				echo $this->Form->input('select_properties_category_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString));
			} else {
				$groupValue = $_GET['group'];
				echo $this->Form->input('select_properties_category_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString,'default' => $groupValue));
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
	<div class="clear"></div>
    <div id="records">
        <div id="record_header_wrap">
            <div style="width:5%;" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('id');?></div>
            </div>
            <div style="width:25%;" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('title');?></div>
            </div>            
            <div style="width:10%;" id="record_header">
                <div class="record_detail_header" id="record_detail">Type</div>
            </div>
            <div style="width:10%;" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('category_id');?></div>
            </div>
            <div style="width:10%;" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('live');?></div>
            </div>
           <div style="width:10%;" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('featured');?></div>
            </div>
            <div style="width:10%;" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
        </div>        
        <div id="paging_container" class="container">        
            <ul id="properties" class="content">
		<?php
		if($properties){
			$i = 0;
			foreach ($properties as $property):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				foreach ($options as $option){
					if($option['PropertiesCategory']['id']==$property['Property']['category_id']){
						$strCategoryName = $option['PropertiesCategory']['category'];
					}
				} 
                                $typeImg = 'agents.gif';
                                $titleAccess = 'Agent';
                                switch ($property['Property']['access_type']) {
                                    case 0: {$typeImg = 'agents.gif'; $titleAccess='Agent Only'; }break;
                                    case 1: {$typeImg = 'public.gif'; $titleAccess='Public Only';}break;
                                    default: {$typeImg = 'all.gif';  $titleAccess='Both agent and public'; }break;
                                }
                                
		?>
        		<div id="record_wrap" <?php echo $class;?>>
					<div style="width:5%;" id="record_row">
                        <div id="record_detail"><?php echo $property['Property']['id']; ?>&nbsp;</div>
                    </div>
            		<div style="width:25%;" id="record_row">
						<div id="record_detail"><?php echo $this->Html->link(__($property['Property']['title'], true), array('action' => 'edit', $property['Property']['id']));?></div>
					</div>
                            <div style="width:10%;" id="record_row">
						<div id="record_detail"><?php echo $html->image($typeImg, array('id'=>'propertaccess','alt'=>'property access', 'title' => $titleAccess));?></div>
			</div>
					<div style="width:10%;" id="record_row">
						<div id="record_detail"><?php echo $strCategoryName;?></div>
					</div>
					<div style="width:10%;" id="record_row">
						<div id="record_detail"><?php if($property['Property']['live'] == 1){ echo '<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $property['Property']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish Property # %s?', true), $property['Property']['id'])).'</div>';} else { echo '<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $property['Property']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish Property # %s?', true), $property['Property']['id'])).'</div>';} ?></div>
					</div>
					<div style="width:10%;" id="record_row">
						<div id="record_detail"><?php if($property['Property']['featured'] == 1){ echo '<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unmark featured')), array('action' => 'unmarkFeatured', $property['Property']['id']), array('escape' => false,'id'=>'record','title'=>'unmark featured'), sprintf(__('Are you sure you want to unmark %s as featured?', true), $property['Property']['id'])).'</div>';} else { echo '<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'featured','alt'=>'featured')), array('action' => 'markFeatured', $property['Property']['id']), array('escape' => false,'id'=>'record','title'=>'featured'), sprintf(__('Are you sure you want to mark %s as featured?', true), $property['Property']['id'])).'</div>';}?></div>
					</div>
					<div style="width:10%;" id="record_row">
						<?php if($property['Property']['live'] == 0){ echo '<div id="record_option" class="imgPreview">'.$this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'view', $property['Property']['id']), array('escape' => false,'id'=>'record','title'=>'preview')).'</div>';}?>
					</div>
					<div style="width:10%;" id="record_row">
						<div id="record_option" class="imgEdit"><?php echo $this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $property['Property']['id']), array('escape' => false,'id'=>'record','title'=>'edit'));?></div>
					</div>
					<div style="width:10%;" id="record_row">
						<div id="record_option" class="imgDelete"><?php echo $this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $property['Property']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $property['Property']['id']));?></div>
					</div>
				  </div>
        <?php 
			endforeach; 
		?>
            </ul>
            <br clear="all" />
            <div class="info_text"></div><br clear="all" />
            <div class="page_navigation"></div>
        </div>
		<?php
        } else {
            echo $this->CustomDisplayFunctions->displayNoRecordDetails(true);
        }
        ?>
    </div>
</div></div>