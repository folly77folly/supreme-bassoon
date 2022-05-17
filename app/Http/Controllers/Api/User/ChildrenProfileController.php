<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\ChildrenProfile;
use App\Http\Requests\SaveChildrenProfileRequest;
use App\Http\Requests\EditChildrenProfileRequest;
use Illuminate\Http\Request;

class ChildrenProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = ChildrenProfile::with('Parent')->get();
        return $this->apiResponse->successWithData($data, 'Get All Product Children Profile successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveChildrenProfileRequest $request)
    {
        $formData = $request->validated();
        $childrenProfile = ChildrenProfile::create($formData);
        return $this->apiResponse->created($childrenProfile, 'Children Profile saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ChildrenProfileId)
    {
        $ChildrenProfile = ChildrenProfile::find($ChildrenProfileId);
        if(!$ChildrenProfileId){
            return $this->apiResponse->failure('Children Profile Not Found');
        }
        return $this->apiResponse->successWithData($ChildrenProfile->load('Parent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditChildrenProfileRequest $request, $id)
    {
        $formData = $request->validated();
        $ChildrenProfile = ChildrenProfile::findOrFail($id);
        $ChildrenProfile->update($formData);

        return $this->apiResponse->successWithData($ChildrenProfile, 'Childern Profile Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $ChildrenProfile = ChildrenProfile::destroy($id);
        return $this->apiResponse->success('Children Profile Deleted Successfully');
    }
}
