<?php


if(!function_exists('checkIfEmpty')){
    function checkIfEmpty($value)
    {   
        if(count($value) <= 0){
            return true; 
        }
        return false;
    }
}





