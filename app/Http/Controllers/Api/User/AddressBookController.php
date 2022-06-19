<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Support\Facades\Auth;
use App\Models\AddressBook;
use App\Http\Requests\SaveAddressBookRequest;
use App\Http\Requests\EditAddressBookRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AddressBookController extends Controller
{   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userAddressBook = AddressBook::whereBelongsTo(Auth::user())->get();
        return $this->apiResponse->success($userAddressBook);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveAddressBookRequest $request)
    {
        $userAddressBook = AddressBook::whereBelongsTo(Auth::user())->get();
       
        $formData = $request->validated();
        $formData['user_id'] = Auth::user()->id;
        if($userAddressBook->count() == 0){
            $formData['is_primary'] = true;
        }
        
        $addressBook = AddressBook::create($formData);
        return $this->apiResponse->created($addressBook, 'Address book created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $addressBookId = AddressBook::find($id);
        if(!$addressBookId){
            return $this->apiResponse->failure('Address Book Not Found');
        }
        return $this->apiResponse->successWithData($addressBookId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditAddressBookRequest $request, $id)
    {
        $formData = $request->validated();
        $addressBook = AddressBook::findOrFail($id);
        $addressBook->update($formData);
        return $this->apiResponse->created($addressBook, 'Address book updated successfully');

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
        $addressBook = AddressBook::destroy($id);
        return $this->apiResponse->success('Address Deleted Successfully');
    }

    /**
     * Set a address book to default.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setDefault($id)
    {
        $addressBook = AddressBook::findOrFail($id);
        if($addressBook->user_id !== Auth::id()){
            return $this->apiResponse->failure('User Not Authorised to perform this action');
        }
        $allUserAddressBook = AddressBook::where('user_id', Auth::id());
        $allUserAddressBook->update(['is_primary' => false]);
        $addressBook->update(['is_primary' => true]);
        return $this->apiResponse->successWithData($addressBook, 'Default Address Set Successfully ');
       
    }

}
