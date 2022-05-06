<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\GiftShop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditGiftShopRequest;
use App\Http\Requests\SaveGiftShopRequest;

class GiftShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $giftShops = GiftShop::active()->get();
        return $this->apiResponse->successWithData($giftShops);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveGiftShopRequest $request)
    {
        //
        $formData = $request->validated();
        $giftShop = GiftShop::create($formData);
        return $this->apiResponse->created($giftShop, 'GiftShops saved successfully');
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
        $giftShop = GiftShop::findOrFail($id);
        return $this->apiResponse->successWithData($giftShop);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditGiftShopRequest $request, $id)
    {
        //
        $formData = $request->validated();

        $giftShop = GiftShop::findOrFail($id);
        $data = $giftShop->fill($request->all());

        return $this->apiResponse->successWithData($data, 'Parent Category Updated Successfully');
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
        $giftShop = GiftShop::destroy($id);
        return $this->apiResponse->success('Product Category Deleted Successfully');
    }
}
