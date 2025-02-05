<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "password" => "required",
            "c_password" => "required|same:password",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => $validator->errors(),
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Usuario registrado con éxito',
            'user' => $user,
        ], 201);
    }
    public function login(Request $request)
    {
        $credetentials = $request->validate([
            "login" => "required",
            "password" => "required|string",
        ]);

        $field = strpos($credetentials['login'], '@') !== false ? 'email' : 'name';

        // Preparar las credenciales para Auth::attempt
        $loginCredentials = [
            $field => $credetentials['login'],
            'password' => $credetentials['password'],
        ];

        if (Auth::attempt($loginCredentials)) {

            $user = Auth::user();

            $token = $user->createToken('auth_token')->accessToken;

            return response()->json([
                "token" => $token,
                "user" => $user
            ]);
        }

        return response()->json(
            [
                "error" => "Credenciales invalidas",
                'credenciales' => $credetentials
            ],
            401
        );
    }

    public function index()
    {
        try {
            $users = DB::table('users')->select('id','name')->get();

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
    public function logout(Request $request)
    {

        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Sesion cerrada con exito',
            ]);
        }
        return response()->json([
            'message' => 'No autorizado'
        ], 401);
    }
}
