<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthentificationController extends Controller
{

    // Registration

    public function register(Request $request)
    {
        $this->validate($request, [
            'nom' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);


        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'token' => $accessToken], 200);
    }

    //   Login

    public function login(Request $request)
    {


        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;




        return  $response = [
            'user' => auth()->user(),
            'token' =>  $accessToken,
        ];
        return response($response, 201);
    }

    // update 

    public function update(Request $request)
    {


        $user = Auth::user();
        $user->nom = $request['nom'];
        $user->prenom = $request['prenom'];
        $user->email = $request['email'];
        $user->civilité = $request['civilité'];
        $user->ville = $request['ville'];
        $user->adresse = $request['adresse'];
        $user->photo = $request['photo'];


        if ($request->hasFile('photo')) {

            $path = $request->file('photo')->store('avatars');
            $user->photo = $path;
            $user->save();
        }
        $user->save();

        return  $response = [
            'user' =>  $user,
            'message' => 'Mise à jour des informations utilisateur avec succès !'
        ];
        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response('Loggedout', 200);
    }
}
