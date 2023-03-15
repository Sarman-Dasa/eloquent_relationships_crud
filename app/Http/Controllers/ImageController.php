<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    use ResponseTraits;
    
    //list
    public function list(Request $request)
    {
        $query = Image::query();
        $searching_Fields = ['url','user_id'];
        return $this->sendFilterListData($query, $searching_Fields);
    }

    //create
    public function create(Request $request)
    {
        $validation = validator($request->all(),[
            'url'       =>  'required|url',
            'user_id'   =>  'required|exists:users,id|unique:images,user_id',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);
        
        $image = Image::create($request->only(['url','user_id']));
        return $this->sendSuccessResponse('User Image Added Successfully');
    }

    public function update(Request $request ,$id)
    {
        $validation = validator($request->all(),[
            'url'       =>  'required|url',
            'user_id'   =>  'required|exists:users,id|unique:images,user_id,'.$id.',id',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        $image = Image::findOrFail($id);
        $image->update($request->only(['url','user_id']));
        return $this->sendSuccessResponse('User Image Updated Successfully');
    }

    public function get()
    {
        $id = $id ?? auth()->user()->id;
        $userImage = Image::with('user')->where('user_id','=',$id)->first();
        return $this->sendSuccessResponse('image',$userImage);
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();

        return $this->sendSuccessResponse('Image Deleted Successfully');
    }
}
