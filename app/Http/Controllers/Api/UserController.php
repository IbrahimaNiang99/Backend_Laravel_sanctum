<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function addUser(UserRequest $userRequest){
        try {
            $user = new User();
            $user->name = $userRequest->name;
            $user->email = $userRequest->email;
            $user->password = Hash::make($userRequest->password, [
                'rounds'=>12
            ]);
            $user->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Enregistrement effectué',
                'data' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function login(LoginUserRequest $loginUserRequest){

        if (auth()->attempt($loginUserRequest->only(['email', 'password']))) {
            
            $user = auth()->user();
            $token = $user->createToken('CLE_DU_TOKEN')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateur connecté',
                'user'=>$user,
                'token'=>$token
            ]);

        }else {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Cette utilisateur n\'existe pas'
            ]);
        }
    }
}
