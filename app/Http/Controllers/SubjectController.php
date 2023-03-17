<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    use ResponseTraits;

    public function list()
    {
        $query = Subject::query();
        $searching_Filed = ['code','name'];
        return $this->sendFilterListData($query,$searching_Filed);
    }

    public function create(Request $request)
    {
        $request->validate([
            'code'      =>  'required|alpha_dash|min:4|max:30|unique:subjects,code',
            'name'      =>  'required|string|min:1|max:150|unique:subjects,name',
        ]);

        $subject = Subject::create($request->only(['code','name']));

        return $this->sendSuccessResponse('Subject Data Added Successfully');
    }

    public function update(Request $request ,$id)
    {
        $request->validate([
            'code'      =>  'required|alpha_dash|min:4|max:30|unique:subjects,code,'.$id.',id',
            'name'      =>  'required|string|min:1|max:150|unique:subjects,name,'.$id.',id',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update($request->only(['code','name']));

        return $this->sendSuccessResponse('Subject Data Updated Successfully');
    }

    public function get($id)
    {
        $subject = Subject::with('students','teachers')->findOrFail($id);
        return $this->sendSuccessResponse('Subject Data',$subject);
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return $this->sendSuccessResponse('Subject Deleted Successfully');
    }
}
