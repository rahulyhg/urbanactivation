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
	<h1><?php __('Properties Analytics');?></h1>
       <div style="float:left;"><?php echo $this->Html->link($html->image("export-xls.gif", array('id'=>'excel', 'alt'=>'Export Analytics')), array('action' => 'export_excel'), array('escape' => false,'id'=>'record','title'=>'Export Analytics')); ?> </div>
       <br><br>
	<div id="clear"></div>
    <div id="records">
        <div id="record_header_wrap">
            <div style="width:5%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('id');?></div>
            </div>  
            <div style="width:10%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('agentId');?></div>
            </div>            
            <div style="width:20%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('agent');?></div>
            </div>
            <div style="width:20%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('loginTime');?></div>
            </div>
           <div style="width:5%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('visits');?></div>
            </div>
            <div style="width:30%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Properties');?></div>
            </div>
            <div style="width:5%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Delete');?></div>
            </div>
            
        </div>        
        <ul id="links">
		<?php
		if($propertiesanalytics){
                  
			$i = 0;
			foreach ($propertiesanalytics as $analytic){
        		echo '<li id="member_' . $analytic['PropertiesAnalytic']['id'] . '" class="order-list"><div class="row-style">';
			
                        echo '<div style="width:5%" id="record_row">';                        
                        echo  '<div id="record_detail">' .$analytic['PropertiesAnalytic']['id'] .'</div>';                       
			echo 		'</div>';
                        
                        echo '<div style="width:10%" id="record_row">';                        
                        echo  '<div id="record_detail">' .$analytic['PropertiesAnalytic']['agentId'] .'</div>';                       
			echo 		'</div>';
                        
                        echo '<div style="width:20%" id="record_row">';                        
                        echo  '<div id="record_detail">' . $analytic['PropertiesAnalytic']['agent'] .'</div>';                       
			echo 		'</div>';
                        
                        echo '<div style="width:20%" id="record_row">';                        
                        echo  '<div id="record_detail">' . date('Y-m-d H:i:s',$analytic['PropertiesAnalytic']['loginTime']) .'</div>';                       
			echo 		'</div>';
                        
                        echo '<div style="width:5%" id="record_row">';                        
                        echo  '<div id="record_detail">' .$analytic['PropertiesAnalytic']['visits'] .'</div>';                       
			echo 		'</div>';
                        
                        echo '<div style="width:30%" id="record_row">';                        
                        echo  '<div id="record_detail">';
                       if(count($visitedPages[$i]) > 0){
                            echo '<select style="width:90%;height:25px;">';
                            foreach($visitedPages[$i] as $pageName){
                                echo "<option value='$pageName'>$pageName</option>";
                            }
                            echo '</select>';
                        }
                       
                        echo '</div>';                       
			echo 		'</div>';
                        
                        echo		'<div style="width:5%" id="record_row">
						<div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $analytic['PropertiesAnalytic']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $analytic['PropertiesAnalytic']['id'])).'</div>
					</div>';
                
                
			
		echo		  '</div></li>'; 
                $i = $i + 1;
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
            //echo $this->CustomDisplayFunctions->displayNoRecordDetails(true);
        }
        ?>
    </div>
</div>