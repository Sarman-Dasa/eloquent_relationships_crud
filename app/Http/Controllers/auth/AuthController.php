<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTraits;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ResponseTraits;
    public function register(Request $request)
    {
        $validation = validator($request->all(),[
            'name'                  =>  'required',
            'email'                 =>  'required|email|unique:users,email',
            'password'              =>  'required|min_digits:8|max_digits:12',
            'password_confirmation' =>  'required|same:password', 
        ]);

        if($validation->fails())
        {
            return $this->sendValidationError($validation);
        }

        $user = User::create($request->only(['name','email'])
        +[
            'password'      =>  Hash::make($request->password),
        ]);

       return $this->sendSuccessResponse('Registration Successfully');
    }

    public function login(Request $request){
        $validation = validator($request->all() ,[
            'email'     =>  'required|email|exists:users,email',
            'password'  =>  'required',
        ]);

        if($validation->fails())
        {
            return $this->sendValidationError($validation);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password,'is_active'=>1]))
        {
            //$user = User::where('email', $request->email)->first();
            $user = auth()->user();
            $token = $user->createToken("API TOKEN")->plainTextToken;
            $userName = $user->first_name;
            return $this->sendSuccessResponse('Successfully login',$token);
        }
        else
        {
            return $this->sendFailureResponse("Invalid password!!!");
        }
    }
        
}
