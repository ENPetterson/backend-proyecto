<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function funLogin(Request $request) {
        //validar
        //verificar        
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required"

        ]);

        if (!Auth::attempt($credenciales)){
            //generar token
            return response()->json(["message" => "no autenticado"], 401);
        }

        $usuario = Auth::user();
        $token = $usuario->createToken("token test")->plainTextToken;

        //responder
        return response()->json([
            "access_token" => $token,
            "type_token" => "Bearer",
            "usuario" => $usuario
        ]);
    }

    public function funRegistro(Request $request) {
        //validar datos
        $request ->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "c_password" => "required|same:password"

        ]);

        //guardar usuario
        $usuario = new User;
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        return response()->json(["mensaje" => "Usuario Registrado"], 201);
    }

    public function funPerfil() {
        return Auth::user();
    }

    public function funSalir() {
        Auth::user()->tokens()->delete();

        return response()->json(["message" => "Salio"]);
        
    }
}
