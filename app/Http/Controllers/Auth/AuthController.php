<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class AuthController extends Controller
{

    public function Inscription(Request $request)
    {
        //inscription user
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $password = Hash::make($request->input('password'));
        $user->password = $password;
        $user->valider = "Non valider";
        $user->role = "Utilisateur";
        $user->save();
        return response()->json([
            'user' => $user,
            'success' => true
        ], 200);
    }

    public function Login(Request $request)
    {
        $fields=$request->validate([
            'email'=> 'required|string',
            'password'=>'required'
        ]);

        // Check email
        $user = User::where('email',$fields['email'])->first();

        // Check password
         if(!$user){
             return response([
                 'message' => "Votre email est incorrect"
             ], 401);
         }
         if(!Hash::check($fields['password'],$user->password)){
            return response([
                'message' => "Le mot de passe que vous avez saisie est incorrect"
            ], 401);
        }

        if($user->valider == "Non valider"){
            return response([
                'message' => "Votre demande n'a pas été acceptée"
            ], 401);
        }
         $token =  $user->createToken('token-user')->plainTextToken;

         $response = [
                 'user' => $user,
                 'token' => $token
             ];
         return response($response,201);
    }

    public function Logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }

   
}
