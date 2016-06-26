<div class="users index">
	<h1><?php __('users');?></h1>
    <div style="clear:both;display:block;height:30px">
    	<?php
			$jsString = "javascript:location.href='?group='+this.value;";
			$categoryOptions[0] = '-------select group---------';
			foreach ($options as $option){
				$categoryOptions[$option['Groups']['id']] = $option['Groups']['group'];
			}
			if (!isset($_GET['group'])) {
				echo $this->Form->input('select_group_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString));
			} else {
				$groupValue = $_GET['group'];
				echo $this->Form->input('select_group_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString,'default' => $groupValue));
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
            <div style="width:13%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('name');?></div>
            </div>
            <div style="width:13%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('username');?></div>
            </div>
            <div style="width:30%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('email');?></div>
            </div>
            <div style="width:15%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('group_id');?></div>
            </div>
            <div style="width:10%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('status_id');?></div>
            </div>
            <div style="width:10%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
		</div>
		<?php
		if($users){
			$i = 0;
			foreach ($users as $user):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				
				foreach ($options as $option){
					if($option['Groups']['id']==$user['User']['group_id']){
						$strCategoryName = $option['Groups']['group'];
					}
				}
        ?>
            <div id="record_wrap" <?php echo $class;?>>
                <div style="width:20px" id="record_row">
                    <div id="record_detail"><?php echo $user['User']['id']; ?>&nbsp;</div>
                </div>
                <div style="width:13%" id="record_row">
                    <div id="record_detail"><?php echo $user['User']['name']; ?>&nbsp;</div>
                </div>
                <div style="width:13%" id="record_row">
                    <div id="record_detail"><?php echo $user['User']['username']; ?>&nbsp;</div>
                </div>
                <div style="width:30%" id="record_row">
                    <div id="record_detail"><?php echo $user['User']['email']; ?>&nbsp;</div>
                </div>
                <div style="width:15%" id="record_row">
                    <div id="record_detail"><?php echo $strCategoryName; ?>&nbsp;</div>
                </div>
                <div style="width:10%" id="record_row">
                    <div id="record_detail"><?php if($user['User']['status_id'] == 1){ echo "Active";} else { echo "Inactive";} ?>&nbsp;</div>
                </div>
                <div style="width:40px" id="record_row">
                    <div id="record_option" class="imgEdit"><?php echo $this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $user['User']['id']), array('escape' => false,'id'=>'record','title'=>'edit')); ?></div>
                </div>
                <div style="width:40px" id="record_row">
                    <div id="record_option" class="imgChangepassword"><?php echo $this->Html->link($html->image("changepassword.gif",array('id'=>'changepassword','alt'=>'change password')), array('action' => 'changepassword', $user['User']['id']), array('escape' => false,'id'=>'record','title'=>'change password')); ?></div>
                </div>
                <div style="width:40px" id="record_row">
                    <?php /*if ($user['User']['group_id']!=1){*/?><div id="record_option" class="imgDelete"><?php echo $this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $user['User']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?></div><?php /*}*/ ?>
                </div>
            </div>
    <?php endforeach; ?>
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