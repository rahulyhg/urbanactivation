<?php
// populate exisiting otherdocs with label
// sortding order
$sortingorder = array('position' => 'Order of display', 'filesize' => 'File Size', 'displayname' => 'Display Name', 'dateuploaded' => 'Date Uploaded');
echo "<div id='otherdocs_div' class='input text'>"; 
echo "<h3>Upload Miscellaneous Documents</h3>"; 
echo $this->Form->input('sortingorder', array('type' => 'select', 'escape' => false, 'options' => $sortingorder, 'label' => 'Choose Sort Order'));

echo $this->Form->button('Add New Document', array('type'=>'button', 'id' => 'add_new_document', 'name' => 'add_new_document', 'style' => ''));
echo $this->Form->button('Remove Document', array('type'=>'button', 'id' => 'remove_last_document', 'name' => 'remove_last_document', 'style' => ''));

//echo "<input type='button' name='add_new_document' id='add_new_document' value='Add Document'>&nbsp;&nbsp;";
//echo "<input type='button' name='remove_last_document' id='remove_last_document' value='Remove Document'>&nbsp;&nbsp;";
      
//echo "&nbsp;&nbsp;<br>Upload miscellaneous documents - first text field is the editable display name.<br><br>";
$savedPositionList = ''; 
$position = 0;
$maxPosition = 0; // required because we can order records in filesize, display name, so position will not always be in ascending order
if(empty($otherDocs) === false){
    $folderName = "otherdocs/$propertyDirName";
    foreach($otherDocs as $rows){
       foreach($rows as $row){
       $position = $row['position'];
       $fileSize = $row['filesize'];
       $dateUploaded = $row['dateuploaded'];
       if( (int)$position > (int)$maxPosition ){
           $maxPosition = (int)$position;
       }
       $savedPositionList .= $position . ',';
       $htmlId = 'PropertyOtherDoc_' . $position; 
       $uploadID = 'upload' .  $htmlId;
       $removeID = 'remove' .  $htmlId;
       $jsString1 = "javascript:uploadFile('5', '$htmlId', '$folderName');";
       
       echo "<div class='input text required divOtherDoc' id='otherdoc_div_$position' name ='otherdoc_div_$position'>";
       //echo "<label for='$htmlId'>$label</label>";
       echo "<input placeholder='document display name' name='{$htmlId}_displayname' id='{$htmlId}_displayname' value='{$row['displayname']}'>";
       echo "<input readonly='true' name='$htmlId' id='$htmlId' class='pdf' value='{$row['filename']}'>";
       echo "<input name='$uploadID' type='button' class='uploadButton' id='$uploadID' onMouseUp=\"" . $jsString1. "\" value='Upload File'>";
       $jsString2 = "javascript:document.getElementById('$htmlId').value='';javascript:document.getElementById('{$htmlId}_displayname').value='';";
       echo "<input name='$removeID' type='button' class='uploadButton' id='$removeID' onMouseUp=\"" .$jsString2. "\" value='Remove File' />";
       echo "&nbsp;&nbsp;<em id='{$htmlId}_size'>$fileSize KB, $dateUploaded</em>";
       echo '</div>';
        }                    
    }     
}
// required by controller, for db CRUD
echo "<input type='hidden' name='current_otherdocs_position' id='current_otherdocs_position' value='$maxPosition' />";
// required for controller, counter for new fields
echo "<input type='hidden' name='saved_otherdocs_list' id='saved_otherdocs_list' value='$savedPositionList' />";     
echo "<input type='hidden'  name='added_otherdocs_list' id='added_otherdocs_list' value='' />";     
echo "<input type='hidden' name='deleted_otherdocs_list' id= 'deleted_otherdocs_list' value='' />";     
echo "</div>";
 /******************** End of property otherdocs ********************************************/  


?>
