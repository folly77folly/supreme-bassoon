<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Service\LandingPageService;
use App\Http\Controllers\Controller;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $landingPage = (new LandingPageService)->landingPage();
        return $this->apiResponse->successWithData($landingPage);
        // allNewAdditions

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }

    public function getAllNewAdditions()
    {
        $newAdditions = (new LandingPageService)->allNewAdditions();
        return $this->apiResponse->successWithData($newAdditions);
    }

    public function getTopSellingProducts()
    {
        $newAdditions = (new LandingPageService)->allTopSellingProducts();
        return $this->apiResponse->successWithData($newAdditions);
    }
}
