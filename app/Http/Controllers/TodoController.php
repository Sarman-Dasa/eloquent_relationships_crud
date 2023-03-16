<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    use ResponseTraits;

    public function list()
    {
        $query = Todo::query();
        $searching_Fields = ['title','description'];
        return $this->sendFilterListData($query,$searching_Fields);
    }

    public function create(Request $request)
    {
        $validation = validator($request->all(),[
            'title'         =>  'required|min:5|max:50',
            'description'   =>  'required|min:1|max:100',
            'user_id'       =>  'required|array|exists:users,id',
        ],[
            'user_id.exists'    =>  'User not found!!!',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        $todo = Todo::create($request->only(['title','description']));
        $todo->users()->attach($request->user_id);
        return $this->sendSuccessResponse('Todo Data Added Successfully');
    }

    public function update(Request $request ,$id)
    {
        $validation = validator($request->all(),[
            'title'         =>  'required|min:5|max:50',
            'description'   =>  'required|min:1|max:100',
            'user_id'       =>  'required|array|exists:users,id',
        ],[
            'user_id.exists'    =>  'User not found!!!',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        $todo = Todo::findOrFail($id);
        $todo->update($request->only(['title','description']));
        $todo->users()->sync($request->user_id);
        return $this->sendSuccessResponse('Todo Data Updated Successfully');
    }

    public function get($id)
    {
        $todo = Todo::with('users')->findOrFail($id);
        //$todo = Todo::findOrFail($id)->users()->orderBy('name')->get();
        return $this->sendSuccessResponse('Todo',$todo);
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        $todo->users()->detach();
        return $this->sendSuccessResponse('Todo data Deleted Successfully');
    }
}
