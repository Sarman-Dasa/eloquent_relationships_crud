<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    use ResponseTraits;

    public function list()
    {
        $query =Team::query();
        $searching_Fields = ['name'];
        return $this->sendFilterListData($query,$searching_Fields);
    }

    public function create(Request $request)
    {
        $validation = validator($request->all(),[
            'name'      =>  'required|min:1|max:50|unique:teams,name',
            'run'       =>  'required|numeric',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        $team = Team::create($request->only(['name']));
        $team->run()->create($request->only('run'));

        return $this->sendSuccessResponse('Team Data Added Successfully');

    }

    public function update(Request $request ,$id)
    {
        $validation = validator($request->all(),[
            'name'      =>  'required|min:1|max:50|unique:teams,name,'.$id.',id',
            'run'       =>  'required|numeric',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        $team = Team::findOrFail($id);
        $team->update($request->only(['name']));
        $team->run()->update($request->only('run'));

        return $this->sendSuccessResponse('Team Data Added Successfully');
        
    }

    public function get($id)
    {
        $team = Team::with('run','players')->findOrFail($id);

        return $this->sendSuccessResponse('Team Data',$team);
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        $team->run()->delete();
        return $this->sendSuccessResponse('Team Data Deleted Successfully');
    }
}
