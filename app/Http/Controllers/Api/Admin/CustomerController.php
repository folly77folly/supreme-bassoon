<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Service\CustomerService;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiResponseException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = (new CustomerService)->allUsers();

        return $this->apiResponse->successWithData($users);
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
        try {
            //code...
            $user = (new CustomerService)->viewUser($id);
            return $this->apiResponse->successWithData($user);
        } catch (ApiResponseException $ape) {
            //throw $th;
            return $this->apiResponse->failure($ape->getMessage());
        } catch (\Throwable $th) {
            //throw $th;
            $this->logError($th, __FUNCTION__);
            return $this->apiResponse->failure(Parent::$uncaughtErrorMessage);
        }

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

    public function latestUsers()
    {
        //
        $users = (new CustomerService)->allNewUsers();

        return $this->apiResponse->successWithData($users);
    }
}
