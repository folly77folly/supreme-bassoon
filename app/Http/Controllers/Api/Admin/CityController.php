<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Http\Requests\SaveCityRequest;
use App\Http\Requests\EditCityRequest;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $cities = City::paginate(config('constants.PAGE_LIMIT.user'));
       return $this->apiResponse->successWithData($cities, 'List of all cities');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveCityRequest $request)
    {
        $formData = $request->validated();
        $data = City::create($formData);
        return $this->apiResponse->created($data, 'City Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::findOrFail($id);
        return $this->apiResponse->successWithData($city);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCityRequest $request, $id)
    {
        $formData = $request->validated();
        $city = City::findOrFail($id);
        $city->update($formData);
        return $this->apiResponse->created($city, 'City updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::destroy($id);
        return $this->apiResponse->success('City Deleted Successfully');

    }

     /**
     * Get all city related to selected state.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCity($stateId)
    {
        $cities = City::where('state_id', $stateId)->get();
        return $this->apiResponse->successWithData($cities);
    }
}
