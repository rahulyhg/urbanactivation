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
<div class="members index">
	<h1><?php __('agents');?></h1>
    <div style="float:right;"><?php echo $this->CustomDisplayFunctions->displayQuickSearch(true,NULL); ?></div>
    
    <div id="wrap-tabs" style="clear: both;">
        
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
            <div style="width:5%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('id');?></div>
            </div>
            <div style="width:7%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Send');?></div>
            </div> 
            
            <div style="width:13%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('name');?></div>
            </div>
            
            <div style="width:20%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('email');?></div>
            </div> 
            <div style="width:20%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('company');?></div>
            </div>
             <div style="width:10%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('phone');?></div>
            </div>
            
            <div style="width:10%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Status');?></div>
            </div>
            
            <div style="width:5%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('active');?></div>
            </div>
             
            <div style="width:5%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Edit');?></div>
            </div>
            <div style="width:5%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Delete');?></div>
            </div>
            
        </div>        
        <ul id="links">
		<?php
		if($agents){
			$i = 0;
			foreach ($agents as $agent){						
        		echo '<li id="member_' . $agent['Agent']['id'] . '" class="order-list"><div class="row-style">';
			echo '<div style="width:5%" id="record_row">';
                        if($agent['Agent']['newrequest'] == 1){
                          echo 	'<div id="record_detail"><span style="color:blue;">' . $agent['Agent']['id'] .'</span></div>';  
                        }
                        else{
                        echo 			'<div id="record_detail">' .$agent['Agent']['id'] .'</div>';
                        }
			echo 		'</div>';
                         echo '<div style="width:7%" id="record_row">
						<div id="record_option" class="imgSendEmail">'.$this->Html->link($html->image("send-email.gif",array('id'=>'sendemail','alt'=>'Send Email')), array('action' => 'sendemail', $agent['Agent']['id']), array('escape' => false,'id'=>'record','title'=>'Send Email')).'</div>
                            </div>';
			echo		'<div style="width:13%" id="record_row">
						<div id="record_detail">' . $this->Html->link(__($agent['Agent']['firstname'] . " " . $agent['Agent']['lastname'], true), array('action' => 'edit', $agent['Agent']['id'])) . '</div>
					</div>';
                      
                        echo		'<div style="width:20%" id="record_row">
						<div id="record_detail">' . $this->Html->link(__($agent['Agent']['email'], true), array('action' => 'edit', $agent['Agent']['id'])) . '</div>					
					</div>';		
                        echo '<div style="width:20%" id="record_row">
						<div id="record_detail">' . $this->Html->link(__($agent['Agent']['company'], true), array('action' => 'edit', $agent['Agent']['id'])) . '</div>					
			      </div>';
                        echo '<div style="width:10%" id="record_row">
						<div id="record_detail">' . $this->Html->link(__($agent['Agent']['phone'], true), array('action' => 'edit', $agent['Agent']['id'])) . '</div>					
			      </div>';
                
                if($agent['Agent']['newrequest'] == 1){
                    echo "<div style='width:10%' id='record_row'><div id='record_detail'><span style='color:blue;'>Pending</span></div></div>";
                }
                else{
                echo 	"<div style='width:10%' id='record_row'><div id='record_detail'>Approved</div></div>";
                }
                
                echo '<div style="width:5%" id="record_row"><div id="record_detail">';
                                         if($agent['Agent']['active'] == 1){ 
                                             echo '<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $agent['Agent']['id']), array('escape' => false,'id'=>'record','title'=>'de-activate'), sprintf(__('Are you sure you want to deactivate Agent # %s?', true), $agent['Agent']['id'])).'</div>';                                             
                                             }
                                             else{ 
                                                 echo '<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $agent['Agent']['id']), array('escape' => false,'id'=>'record','title'=>'activate'), sprintf(__('Are you sure you want to activate agent # %s?', true), $agent['Agent']['id'])).'</div>';                                             
                                             } 
                        echo '</div></div>';
                        
                                        
		 echo '<div style="width:5%" id="record_row">
						<div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $agent['Agent']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>
					</div>';
		echo		'<div style="width:5%" id="record_row">
						<div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $agent['Agent']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $agent['Agent']['id'])).'</div>
					</div>';
                
                
			
		echo		  '</div></li>'; 
                        } 
		?>
        </ul>
        
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