<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Teacher;
use Illuminate\Http\Request;

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

        $teacher = Teacher::findOrFail($id);
        
        $teacher->update($request->only(['name','email','mobile']));
        
        $teacher->notices()->updateOrCreate(
        ['id' => $request->notice_id],
        [
            'body'  =>  $request->body,
        ]);

        return $this->sendSuccessResponse('Teacher Data Updated Successfully');
    }

    public function get($id)
    {
        $teacher = Teacher::with('notices','subjects','latestNotice')->findOrFail($id);
        return $this->sendSuccessResponse('Teacher Data',$teacher);
    }


    public function destroy($id)
    {
        $teacher = Teacher::FindOrFail($id);
        
        $teacher->delete();
        $teacher->notices()->delete();        
        
        $teacher->subjects()->detach();
        return $this->sendSuccessResponse('Teacher Data Deleted Successfully');
    }

}
