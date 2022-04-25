<?php
if (! function_exists('bc_get_file_name_from_url')) {

    function bc_get_file_name_from_url($url){
        $arraySplits = explode('/', $url);
        $lastArrayItem = end($arraySplits);
        $fileName = explode('.', $lastArrayItem);
        return $fileName[0];
    }
};

if (! function_exists('bc_get_folder_name_from_url')) {
    
    function bc_get_folder_name_from_url($url){
        $arraySplits = explode('/', $url);
        $arrayCount = count($arraySplits);
        $folderName = $arraySplits[$arrayCount-2];
        return $folderName;
    }
};