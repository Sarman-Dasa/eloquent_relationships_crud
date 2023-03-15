<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Mobilenumber;
use Illuminate\Http\Request;

class MobilenumberController extends Controller
{
    use ResponseTraits;
    
    //list
    public function list(Request $request)
    {
        $query = Mobilenumber::query();
        $searching_Fields = ['number'];
        return $this->sendFilterListData($query, $searching_Fields);
    }

    //create
    public function create(Request $request)
    {
        $validation = validator($request->all(),[
            'number'        =>  'required|digits:10|unique:mobilenumbers,number',
            'user_id'       =>  'required|exists:users,id|unique:images,user_id',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);
        
        $mobileNumber = Mobilenumber::create($request->only(['number','user_id']));
        return $this->sendSuccessResponse('User Mobile Number Added Successfully');
    }

    //update
    public function update(Request $request ,$id)
    {
        $validation = validator($request->all(),[
            'number'        =>  'required|digits:10|unique:mobilenumbers,number',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);
        
        
        $image = Mobilenumber::findOrFail($id);
        $image->update($request->only(['number']));
        return $this->sendSuccessResponse('User Mobile number Updated Successfully');
    }

    //get
    public function get()
    {
        $id = auth()->user()->id;
        $userMobile = Mobilenumber::with('user')->where('user_id','=',$id)->get();
        return $this->sendSuccessResponse('Mobile Numbers',$userMobile);
    }

    //destroy
    public function destroy($id)
    {
        $image = Mobilenumber::findOrFail($id);
        $image->delete();

        return $this->sendSuccessResponse('Mobile Number Deleted Successfully');
    }

}
