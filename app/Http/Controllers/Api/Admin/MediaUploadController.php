<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Service\CloudinaryService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiResponseException;
use App\Http\Requests\SaveMediaUploadRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class MediaUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveMediaUploadRequest $request)
    {
        //
        $validatedData = $request->validated();
        if(!$request->hasFile('files')){
            return $this->apiResponse->failure('Files to upload not found');
        }
        $imagesAllowedExtension = ['bmp','jpg','png', 'jpeg'];
        $videoAllowedExtension = [];
        $audioAllowedExtension = [];
        $filesToUpload = $request->file('files');
        try {
            //code...
            $file = new CloudinaryService;
            $urls = $file->uploadMedia($validatedData['folder_name'], $filesToUpload, $imagesAllowedExtension );
            return $this->apiResponse->successWithData($urls, 'Files Uploaded successfully');
            
        }
        catch (ApiResponseException $th) {
            //throw $th;
            return $this->apiResponse->failure($th->getMessage());
        } 
        catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            Log::error($th->getFile());
            Log::error($th->getLine());
            return $this->apiResponse->failure('something went wrong');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        try {
            //code...
            $file = new CloudinaryService;
            $file->removeMedia($request->file);
            return $this->apiResponse->success('File deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            Log::error($th->getFile());
            Log::error($th->getLine());
            return $this->apiResponse->failure('something went wrong');
        }
    }
}
