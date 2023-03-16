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

        // $body = array(
        //     new Notice(array('body'  => 'this first body')),
        //     new Notice(array('body'  => 'this second body')),
        // );

        //$bodyArray = array();
        // foreach ($request->body as $body) {
        //     //array_push($bodyArray, new Notice(array('body'  => $body)));
        //     $student->notices()->save(new Notice(array('body'  => $body)));
        // }
        
        $student->notices()->saveMany([
            new Notice(['body'  => $request->body])
        ]);

      /*  $student->notices()->saveMany($bodyArray);

        $notice = new Notice;
        $notice->body = $request->body;
       
        foreach ($request->body as $body) {
            $notice->body = $body;
            $student->notices()->save($notice);
        } */

        return $this->sendSuccessResponse('Student Data Added Successfully');
    }

    public function update(Request $request ,$id)
    {
        $validation = validator($request->all(),[
            'name'          =>  'required|min:3|max:50',
            'email'         =>  'required|email|unique:students,email,'.$id.',id',
            'mobile'        =>  'required|digits:10|unique:students,mobile,'.$id.',id',
            'body'          =>  'required',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);
        
        $student = Student::findOrFail($id);
        $student->update($request->only(['name','email','mobile']));

        foreach ($request->body as $body) {
            $task2 = $student->notices->toArray();
            $task2 = array_push($task2,$id,$body);
            $student->notices()->sync(array($task2));
            //$student->notices()->update((array('body'   =>  $body)));
        }

        return $this->sendSuccessResponse('Student Data Updated Successfully');
    }

}
