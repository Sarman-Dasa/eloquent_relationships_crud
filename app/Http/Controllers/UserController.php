<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ResponseTraits;

    public function list()
    {
        $query = User::query();
        $searching_Fields = ['name','email'];
        return $this->sendFilterListData($query, $searching_Fields);
    }

    public function update(Request $request ,$id)
    {
        $validation = validator($request->all(),[
            'name'                  =>  'required',
            'email'                 =>  'required|email|unique:users,email,'.$id.',id',
            'current_password'      =>  'required|current_password',
            'password'              =>  'required|min_digits:8|max_digits:12',
            'password_confirmation' =>  'required|same:password', 
        ]);

        if($validation->fails())
        {
            return $this->sendValidationError($validation);
        }

        $user = User::findOrFail($id)->update($request->only(['name','email'])
        +[
            'password'      =>  Hash::make($request->password),
        ]);

       return $this->sendSuccessResponse('User Data Updated Successfully');
    }

    public function get()
    {
        $id = $id ?? auth()->user()->id;
        $user = User::with('image','mobileNumbers')->findOrFail($id);
        
        return $this->sendSuccessResponse('User Profile',$user);
    }

    public function destroy()
    {
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $user->delete();

        return $this->sendSuccessResponse('User Data Deleted');
    }
}
