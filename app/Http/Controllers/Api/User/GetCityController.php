<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

class GetCityController extends Controller
{
    
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
