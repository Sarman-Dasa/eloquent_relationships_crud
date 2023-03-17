<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherSubjectController extends Controller
{
    use ResponseTraits;

    public function create(Request $request)
    {
        $request->validate([
            'teacher_id'    =>  'required|numeric|exists:teachers,id',
            'subject_id'    =>  'required|array|exists:subjects,id',
        ]);

        $teacher = Teacher::findOrFail($request->teacher_id);
        $teacher->subjects()->attach($request->subject_id);

        return $this->sendSuccessResponse('Teacher Subject(s) Added Successfully');

    }

    public function update(Request $request)
    {
        $request->validate([
            'teacher_id'    =>  'required|numeric|exists:teachers,id',
            'subject_id'    =>  'required|array|exists:subjects,id',
        ]);


        $teacher = Teacher::findOrFail($request->teacher_id);
        $teacher->subjects()->sync($request->subject_id);

        return $this->sendSuccessResponse('Teacher Subject(s) Updated Successfully');
    }

}
