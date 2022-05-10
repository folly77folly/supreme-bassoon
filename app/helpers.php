<?php

use App\Models\GiftShop;
use App\Models\ProductGiftShop;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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

if (! function_exists('bc_get_file_name_from_array_urls')) {
    
    function bc_get_file_name_from_array_urls($array_urls){
        $files_array = array_map(fn($value) => bc_get_file_name_from_url($value), $array_urls);
        return json_encode($files_array);
    }
};

if (! function_exists('bc_get_file_url_from_array')) {
    
    function bc_get_file_url_from_array($files_arrays){
        $files_array = array_map(fn($value) => env('CLOUDINARY_FULL_URL').$value, ($files_arrays));
        return $files_array;
    }
};

if (! function_exists('bc_get__gift_shop_names_from_array')) {
    
    function bc_get__gift_shop_names_from_array($files_arrays){
        $giftShopName = array_map(fn($value) => GiftShop::find($value)->name ?? '', ($files_arrays));
        return $giftShopName;
    }
};