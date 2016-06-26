<?php

function generateUniquePassword($length = 8){
    return substr( md5(uniqid(mt_rand(), true)), 0, $length);
}

function isPropertAlreadyVisitedInSession($visitedProperties, $pid){
    if(empty($visitedProperties)){
        return false;
    }
    
    $visitedProperties = rtrim($visitedProperties, ',');
    $visitedIds = explode(',', $visitedProperties);
    foreach ($visitedIds as $vId){
       
        if($pid == $vId){
             //echo $vId . ' == ' . $pid . '<br>';
            return true;
        }
    }
    
    return false;
}

