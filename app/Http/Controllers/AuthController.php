<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function create(Request $request){
        $longitud = rand(20, 50);
        $cadena_aleatoria = Str::random($longitud);
        $timestamp = now()->format('Y-m-d_H:i:s');
        $token = sha1($request->email.$timestamp.$cadena_aleatoria);

        $rules=[
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8'
        ];
        $validador = \Validator::make($request->input(),$rules);
        if($validador->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validador->errors()->all(),
            ],400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => hash::make($request->password),
        ]);
        return response()->json([
                'status' => true,
                'message' => 'Usuario creado satisfactoriamente',
                'token' => $user->createToken($token)->plainTextToken

        ],200);

    }

    public function login(Request $request){
        $rules=[
            'email' => 'required|string|email|max:100',
            'password' => 'required|string'
        ];
        $validador = \Validator::make($request->input(),$rules);
        if($validador->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validador->errors()->all(),
            ],400);
        }
        $longitud = rand(20, 50);
        $cadena_aleatoria = Str::random($longitud);
        $timestamp = now()->format('Y-m-d_H:i:s');
        $token = sha1($request->email.$timestamp.$cadena_aleatoria);
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'status' => false,
                'errors' => ['No Autorizado'],
            ],401);
        }
        $user = User::where('email',$request->email)->first();
        return response()->json([
                'status' => true,
                'message' => 'Usuario conectado satisfactoriamente',
                'data' => $user,
                'token' => $user->createToken($token)->plainTextToken
        ],200);

    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
                'status' => true,
                'message' => 'Usuario desconectado',
        ],200);

    }
}
