<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class StudentSubjectController extends Controller
{
    use ResponseTraits;

    // public function list()
    // {
    //     $query = Student::query()->get();
    //     $query->load('subjects')->get('name','code');
    //     $searching_Fields = ['name','email','mobile'];
    //     return $this->sendFilterListData($query,$searching_Fields);
    // }

    public function create(Request $request)
    {
        $request->validate([
            'student_id'    =>  'required|numeric|exists:students,id',
            'subject_id'    =>  'required|array|exists:subjects,id',
        ]);

        $student = Student::findOrFail($request->student_id);
        $student->subjects()->attach($request->subject_id);

        return $this->sendSuccessResponse('Student Subject(s) Added Successfully');

    }

    public function update(Request $request)
    {
        $request->validate([
            'student_id'    =>  'required|numeric|exists:students,id',
            'subject_id'    =>  'required|array|exists:subjects,id',
        ]);

        $student = Student::findOrFail($request->student_id);
        $student->subjects()->sync($request->subject_id);

        return $this->sendSuccessResponse('Student Subject(s) Updated Successfully');
    }

}
