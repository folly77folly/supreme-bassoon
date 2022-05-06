<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditSizeRequest;
use App\Http\Requests\SaveSizeRequest;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Sizes = Size::active()->get();
        return $this->apiResponse->successWithData($Sizes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveSizeRequest $request)
    {
        //
        $formData = $request->validated();
        $size = Size::create($formData);
        return $this->apiResponse->created($size, 'Sizes saved successfully');
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
        $Size = Size::findOrFail($id);
        return $this->apiResponse->successWithData($Size, 'Size retrieved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditSizeRequest $request, $id)
    {
        //
        $Size = Size::find($id);
        $Size->fill($request->all())->save();
        return $this->apiResponse->successWithData($Size, 'Size updated successfully');
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
        Size::findOrFail($id);
        Size::destroy($id);
        return $this->apiResponse->success('Size deleted');
    }
}
