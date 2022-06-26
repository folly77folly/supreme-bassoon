<?php
namespace App\Service;

use App\Models\User;

class CustomerService{

    public function allUsers()
    {
        return User::with('children')
        ->orderBy('updated_at')
        ->paginate(config('constants.PAGE_LIMIT.admin'));
    }

    public function allNewUsers()
    {

        return User::with('children')
        ->latest()
        ->paginate(config('constants.PAGE_LIMIT.admin'));
    }

    public function viewUser($id)
    {

        $user = User::Find($id);
        if(!$user){
            throw new ApiResponseException('user not found');
        }
        return $user->load('children');
    }

}