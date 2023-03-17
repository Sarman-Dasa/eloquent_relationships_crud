<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Notice;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;

class TeacherController extends Controller
{
    use ResponseTraits;

   public function list()
   {
        $query = Teacher::query();
        $searching_Fields = ['name','email','mobile'];
        return $this->sendFilterListData($query,$searching_Fields);
   }

   public function create(Request $request)
   {

        $validation = validator($request->all(),[
            'name'          =>  'required|min:3|max:50',
            'email'         =>  'required|email|unique:teachers,email',
            'mobile'        =>  'required|digits:10|unique:teachers,mobile',
            'body'          =>  'required|array',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);
        
        $teacher = Teacher::create($request->only(['name','email','mobile']));

        foreach ($request->body as $body) {
            $teacher->notices()->create([
                'body'  =>  $body,
            ]);
        }
    /*
        foreach ($request->body as $body) {
            Notice::create([
                'body'              =>  $body,
                'noticeable_id'     =>  $teacher->id,
                'noticeable_type'   =>  'App\Models\Teacher',
            ]);
        }

    */

        return $this->sendSuccessResponse('Teacher Data Added Successfully');
    }

    public function update(Request $request ,$id)
    {
        $validation = validator($request->all(),[
            'name'          =>  'required|min:3|max:50',
            'email'         =>  'required|email|unique:teachers,email,'.$id.',id',
            'mobile'        =>  'required|digits:10|unique:teachers,mobile,'.$id.',id',
            'body'          =>  'required',
            'notice_id'     =>  'required|numeric'
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        $student = Teacher::findOrFail($id);
        
        $student->update($request->only(['name','email','mobile']));
        
        $student->notices()->updateOrCreate(
        ['id' => $request->notice_id],
        [
            'body'  =>  $request->body,
        ]);

        return $this->sendSuccessResponse('Teacher Data Updated Successfully');
    }

    public function get($id)
    {
        $student = Teacher::with('notices')->findOrFail($id);
        return $this->sendSuccessResponse('Teacher Data',$student);
    }


    public function destroy($id)
    {
        $student = Teacher::FindOrFail($id);
        
        $student->delete();
        $student->notices()->delete();        
        
        return $this->sendSuccessResponse('Teacher Data Deleted Successfully');
    }

}
