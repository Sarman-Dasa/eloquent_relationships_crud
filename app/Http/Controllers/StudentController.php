<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Notice;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use ResponseTraits;
    public function list()
    {
        $query = Student::query();
        $searching_Fields = ['name','email','mobile'];
        return $this->sendFilterListData($query,$searching_Fields);
    }

    public function create(Request $request)
    {
        $validation = validator($request->all(),[
            'name'          =>  'required|min:3|max:50',
            'email'         =>  'required|email|unique:students,email',
            'mobile'        =>  'required|digits:10|unique:students,mobile',
            'body'          =>  'required|array',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);
        
        $student = Student::create($request->only(['name','email','mobile']));

        foreach ($request->body as $body) {
            Notice::create([
                'body'              =>  $body,
                'noticeable_id'     =>  $student->id,
                'noticeable_type'   =>  'App\Models\Student',
            ]);
        }
        
        return $this->sendSuccessResponse('Student Data Added Successfully');
    }

    public function update(Request $request ,$id)
    {
        $validation = validator($request->all(),[
            'name'          =>  'required|min:3|max:50',
            'email'         =>  'required|email|unique:students,email,'.$id.',id',
            'mobile'        =>  'required|digits:10|unique:students,mobile,'.$id.',id',
            'body'          =>  'required',
            'notice_id'     =>  'required|numeric'
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        $student = Student::findOrFail($id);
        
        $student->update($request->only(['name','email','mobile']));
        
        $student->notices()->updateOrCreate(
        ['id' => $request->notice_id],
        [
            'body'  =>  $request->body,
        ]);

        return $this->sendSuccessResponse('Student Data Updated Successfully');
    }

    public function get($id)
    {
        $student = Student::with('notices')->findOrFail($id);
        return $this->sendSuccessResponse('Student Data',$student);
    }


    public function destroy($id)
    {
        $student = Student::FindOrFail($id);
        
        $student->delete();
        $student->notices()->delete();        
        
        return $this->sendSuccessResponse('Student Data Deleted Successfully');
    }
}
