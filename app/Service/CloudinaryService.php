<?php
namespace App\Service;



use Illuminate\Support\Str;
use App\Exceptions\ApiResponseException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryService{

    private $cloudinary_url;
    private $cloudinary_preset_url;
    private $cloudinary_notification_url;

    public $folderPath;
    public $file;

    public function __construct(){
        $this->cloudinaryUrl = config('services.cloudinary.cloudinary_notification_url');
        $this->cloudinaryPresetUrl = config('services.cloudinary.cloudinary_upload_preset');
        $this->cloudinaryNotificationUrl = config('services.cloudinary.cloudinary_notification_url');
    }

    public function uploadMedia($folderName, $files, $allowedExtensions){
        $result = null;
        if(!$this->verifyExtension($files, $allowedExtensions)) throw new ApiResponseException('file type not allowed');
        if(!$this->verifyFileSize($files)) throw new ApiResponseException('file too large, must be below 10MB');
        //upload file
        foreach ($files as $key => $file) {
            # code...
            $fileName = $this->getCustomFileName($file);
            $uploadedFileUrl = $file->storeOnCloudinaryAs($folderName, $fileName);

            $result[] = $uploadedFileUrl->getSecurePath();
        }
        return $result;
    }

    public function verifyExtension ($files, $allowedExtensions):bool{
        foreach ($files as $key => $file) {
            # code...
            $fileExtension = $file->getClientOriginalExtension();
           if(!in_array($fileExtension, $allowedExtensions)) return false;
        }
        return true;
    }

    public function verifyFileSize ($files):bool{
        foreach ($files as $key => $file) {
            # code...
            $fileSize = $file->getSize();
           if($fileSize > 10000000000) return false;
        }
        return true;
    }

    public function getCustomFileName($file)
    {
        $fileNameWithExtension = $file->getClientOriginalName();
        //get filename without extension
        $filename = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
        return date('YmdHi').'_'.Str::Slug($filename,'_');
    }

    public function removeMedia($url)
    {
        $folderName = bc_get_folder_name_from_url($url);
        $fileName = bc_get_file_name_from_url($url);
        $answer = Cloudinary::destroy($folderName.'/'.$fileName);

    }

}