<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use App\Service\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;

class AuthController extends Controller
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

    /**
     * Login for admin
     */
    public function login(UserLoginRequest $request)
    {
        $validatedData = $request->validated();
        $authorizedUser = new AuthService($validatedData);
        $accessToken = $authorizedUser->adminAuthorize($validatedData);
        if (!$accessToken){
            return $this->apiResponse->failure('Invalid email or password');
        }
        $admin = Admin::where('email', $validatedData['email'])->first();
        $data = [
            "auth" => [
                "token" => $accessToken,
            ],
            "role" => [
                "id" => $admin->role_id,
                "name" => $admin->role->name,
            ],
        ];
        return $this->apiResponse->successWithData($data,);

    }
}
