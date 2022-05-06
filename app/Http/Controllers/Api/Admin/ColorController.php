<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditColorRequest;
use App\Http\Requests\SaveColorRequest;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $colors = Color::status()->get();
        return $this->apiResponse->successWithData($colors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveColorRequest $request)
    {
        //
        $formData = $request->validated();
        $color = Color::create($formData);
        return $this->apiResponse->created($color, 'colors saved successfully');

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
        $color = Color::findOrFail($id);
        return $this->apiResponse->successWithData($color, 'color retrieved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditColorRequest $request, $id)
    {
        //
        $color = Color::find($id);
        $color->fill($request->all())->save();
        return $this->apiResponse->successWithData($color, 'color updated successfully');
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
        Color::findOrFail($id);
        Color::destroy($id);
        return $this->apiResponse->success('color deleted');
        
    }
}
