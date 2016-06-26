<?php

$csvPath = 'properties-all.csv';
$data = array();
$header = NULL;
$handle = fopen($csvPath, 'r');

while( ($row = fgetcsv($handle)) !== FALSE){
    if(empty($header)){
        $header = $row;
    }
    else{
        $data[] = array_combine($header, $row);
    }
}
fclose($handle);

// create directory for id
$directors = array('brochures', 'floorplans', 'contracts', 'reservationforms', 'pricelists', 'stratafees', 'depreciations', 'specialdocs');
// check if directory not exist for property create it
$uploadDirPath = $_SERVER['DOCUMENT_ROOT'] . '/dreamcms/app/webroot/uploads/';


foreach($data as $row){
    $propID = '';
    foreach($row as $key => $value){
        if($key == 'id'){
            $propID = $value;
            // create all directories
            $propUploadDirPath = $uploadDirPath . $propID;
            if(file_exists($propUploadDirPath) === FALSE){
                mkdir($propUploadDirPath);
            }
           // created all directories
            foreach($directors as $dir){
                $dirPath = $propUploadDirPath . '/' . $dir;
                if(file_exists($dirPath) === FALSE){
                mkdir($dirPath);
            }
            }
        }
        else{
            if( !empty($value) ){
               $srcfileAbsPath = $uploadDirPath .  $key . '/' . $value;
               $desfileAbsPath = $uploadDirPath . "/$propID/". $key . '/' . $value;
               if(file_exists($srcfileAbsPath))
               copy($srcfileAbsPath, $desfileAbsPath);
            }
        }
    }
}

echo 'done';

