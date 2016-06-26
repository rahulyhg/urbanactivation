$(document).ready(function(){
    $('#add_new_document').click(function(){           
           // get 
        var position = $('#current_otherdocs_position').val(); 
        ++position;
        $('#current_otherdocs_position').val(position);
        var propertyID = $('#txtPropertyDirName').val();
        var folderName = "otherdocs/" + propertyID;   
        var htmlId = 'PropertyOtherDoc_' + position; 
        var uploadID = 'upload' +  htmlId;
        var removeID = 'remove' +  htmlId;
        var jsString1 = "javascript:uploadFile('5', '" + htmlId + "', '" + folderName + "');";
        var jsString2 = "javascript:document.getElementById('" + htmlId + "').value='';javascript:document.getElementById('" + htmlId + "_displayname').value='';";

        var html = "<div class='input text required' id='otherdoc_div_" + position +  "' name='otherdoc_div_" + position +  "'>";
        //html += "<label>" + label  + "($)</label>";
        html += "<input placeholder='enter display name' name='" + htmlId + "_displayname' id='" + htmlId +  "_displayname' value=''>";
        html += "<input readonly='true' name='" + htmlId + "' id='" + htmlId + "' class='pdf' value='' >";
        html += "<input name='" + uploadID + "' type='button' class='uploadButton' id='" + uploadID + "' onMouseUp=\"" + jsString1 + "\" value='Upload File'>";
        html += "<input name='" + removeID + "' type='button' class='uploadButton' id='" + removeID + "' onMouseUp=\"" + jsString2 + "\" value='Remove File' />";
        html += "<label id='" + htmlId +  "_size' />";
        html += '</div>';

        var addedPosition = $('#added_otherdocs_list').val();
        if(addedPosition.indexOf(position) == -1){
        $('#added_otherdocs_list').val(addedPosition + position + ',');	
        }
        $('#otherdocs_div').append(html);
        var savedPositions = $('#saved_otherdocs_list').val();
        var newlyAddedPositions = $('#added_otherdocs_list').val();
        if( savedPositions.length > 0 || newlyAddedPositions.length > 0 ){
            $('#remove_last_document').prop('disabled', false);
        }
      });  
        
        
   // Remove last document function
   $('#remove_last_document').click(function(){  
        var savedPositions = $('#saved_otherdocs_list').val().trim();
        var newlyAddedPositions = $('#added_otherdocs_list').val().trim();
        if(savedPositions.length == 0 && newlyAddedPositions.length == 0){
           $('#remove_last_document').prop('disabled', true); 
           return;
        }
        
        var position = -1;
        if(newlyAddedPositions != null && newlyAddedPositions.length == 0){
            // check from saved positions
            if(savedPositions.length == 0){
               $('#remove_last_document').prop('disabled', true); 
               return; 
            }
            
           position = getLastPosition(savedPositions);   
           if(position != -1){
                  $('#otherdoc_div_' + position).remove();
                   savedPositions = savedPositions.replace(position + ',', '');
                   $('#saved_otherdocs_list').val(savedPositions);
                   // add the position in delete array for db
                   var delPositions = $('#deleted_otherdocs_list').val();
                    $('#deleted_otherdocs_list').val(delPositions + position + ',');	
            }
        }
        else{ // delete from newly added
        
        // split newly added position, to get last added position
        position = getLastPosition(newlyAddedPositions);          
       
        if(position != -1){
            $('#otherdoc_div_' + position).remove();
            newlyAddedPositions = newlyAddedPositions.replace(position + ',', '');
            $('#added_otherdocs_list').val(newlyAddedPositions);
        }
    }  
    
    var savedPositions = $('#saved_otherdocs_list').val().trim();
    var newlyAddedPositions = $('#added_otherdocs_list').val().trim();
    if(savedPositions.length == 0 && newlyAddedPositions.length == 0){
        $('#remove_last_document').prop('disabled', true); 
    }
    
    }); 
    
    // check remove button state
    var savedPositions = $('#saved_otherdocs_list').val().trim();
    var newlyAddedPositions = $('#added_otherdocs_list').val().trim();
    if(savedPositions.length == 0 && newlyAddedPositions.length == 0){
        $('#remove_last_document').prop('disabled', true); 
    }
});

function getLastPosition(commaSepartedText){
    commaSepartedText = commaSepartedText.trim();
    if(commaSepartedText.length == 0){
        return -1;
    }
    var posArray = commaSepartedText.split(',');
    var temp;
    for(var i = posArray.length - 1; i >= 0; --i){
        temp = posArray[i].trim();
        if(temp == null || temp.length == 0){
            continue;
        }
        return temp;
       }
       
       return -1;            
}
