<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTraits;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    use ResponseTraits;

    public function list()
    {
        $query = Player::query();
        $searching_Fields = ['name','email'];
        return $this->sendFilterListData($query,$searching_Fields);
    }

    public function create(Request $request)
    {
        $validation = validator($request->all(),[
            'name'      =>  'required|min:1|max:50',
            'email'     =>  'required|email|unique:players,email',
            'run'       =>  'required|numeric',
            'team_id'   =>  'required|numeric|exists:teams,id',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        $player = Player::create($request->only(['name','email','team_id']));
        $player->run()->create($request->only('run'));

        return $this->sendSuccessResponse('Player Data Added Successfully');
    }

    public function update(Request $request ,$id)
    {
        $validation = validator($request->all(),[
            'name'      =>  'required|min:1|max:50',
            'email'     =>  'required|email|unique:players,email,'.$id.',id',
            'run'       =>  'required|numeric',
            'team_id'   =>  'required|numeric|exists:teams,id',
        ]);

        if($validation->fails())
            return $this->sendValidationError($validation);

        $player = Player::findOrFail($id);
        $player->update($request->only(['name','email','team_id']));
        $player->run()->update($request->only('run'));

        return $this->sendSuccessResponse('Player Data Updated Successfully');
    }

    public function get($id)
    {
        $player = Player::with('team','run')->findOrFail($id);
        return $this->sendSuccessResponse('Playes Data',$player);
    }

    public function destroy($id)
    {
        $player = Player::findOrFail($id);
        $player->delete();

        $player->run()->delete();
        
        return $this->sendSuccessResponse('Player Data Deleted Successfully');
    }
}
