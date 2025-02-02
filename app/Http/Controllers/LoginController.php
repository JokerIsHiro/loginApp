<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $params = $request->validate([
            "name" => "required",
            "password" => "required",
        ]);

        if (Auth::attempt($params)) {

            $user = Auth::user();

            $token = $user->createToken("auth_token")->plainTextToken;

            return response()->json([
                "token" => $token,
                "user" => $user
            ]);
        }

        return response()->json(
            [
                "error" => "Credenciales invalidas",
                'credenciales' => $params
            ],
            401
        );
    }

    public function index()
    {
        try {
            $users = DB::table('users')->get();

            if ($users->isEmpty()) {
                throw new \Exception('No se encontraron usuarios');
            }

            return response()->json(
                [
                    'message' => 'Aqui tiene los usuarios',
                    'users' => $users
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function show(Request $request, $id)
    {  
        $loggedUser = $request->user(); 
        try {
            if (!$loggedUser) {
                throw new \Exception('No estas logeado');
            }

            $user = DB::table("users")->find($id);

            if (!$user) {
                throw new \Exception("Usuario no encontrado");
            }
            return response()->json(
                [
                    'message' => 'Aqui tiene al usuario',
                    'users' => $user
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function logout(Request $request){
        $user = $request->user();

        if($user){
            $user->currentAccesToken()->delete();

            return response()->json([
                'message' => 'Sesion cerrada con exito'
            ]);
        }
        return response()->json([
            'message' => 'No autorizado'
        ], 401);
    }
}
