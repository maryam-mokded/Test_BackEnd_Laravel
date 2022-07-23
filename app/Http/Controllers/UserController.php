<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use DB;

class UserController extends Controller
{
    public function index()
    {
        $Liste_users = DB::table('users')->get();
        return response()->json($Liste_users, 200);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $password = Hash::make($request->input('password'));
        $user->password = $password;
        $user->valider = "valider";
        $user->role = "Utilisateur";
        $user->save();
        return response()->json([
            'user' => $user,
            'success' => true
        ], 200);
    } 

    public function update(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return response()->json([
            'user' => $user,
            'success' => true
        ], 200);
    }

    public function ValidationCompte($id)
    {
        $user = User::findOrFail($id);
        $user->valider = "valider";
        $user->save();
        return response()->json([
            'user' => $user,
            'success' => true
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->delete());
        return response(null, 200);
    }
    
}
