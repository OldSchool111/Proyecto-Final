<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\models\empleadomodelo;
use App\Http\controllers\controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
      $Credenciales =  $request->validate([
            'correoEmpleado' => 'required|email',
            'passwordEmpleado' => 'required|min:2| max:40',
        ]);

        $usuario = empleadomodelo::where('correoEmpleado', $Credenciales['correoEmpleado'])
                                ->where('passwordEmpleado', $Credenciales['passwordEmpleado'])
                                ->first();

        if ($usuario && $Credenciales['passwordEmpleado'] === $usuario->passwordEmpleado ) {
            $token = JWTAuth::fromUser($usuario);
            return response()->json([
                'message' => 'Inicio de sesion exitoso',
                'token'=> $token,
                'usuario'=>$usuario,
                'status'=>200
            ], 200);

        }else{
            return response()->json([
                'message' => 'error al iniciar sesion',
                'status' =>404
            ],404);
           
        }
    }
    
}
