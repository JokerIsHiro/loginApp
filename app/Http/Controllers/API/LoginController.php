<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
<<<<<<< Updated upstream:app/Http/Controllers/LoginController.php
=======
use Validator;
>>>>>>> Stashed changes:app/Http/Controllers/API/LoginController.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function register(Request $request)
    {
<<<<<<< Updated upstream:app/Http/Controllers/LoginController.php
        $request->validate([
            'name' => 'required',
            'password' => 'required|string',
        ]);

        if (Auth::check()) {
            return response()->json(
                [
                    'message' => 'Ya esta logeado'
                ],
                200
            );
        }

        $user = User::where('name', $request->name)->first();

        if ($user && $user->password === $request->password) {

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Inicio de sesion con exito',
                'token' => $token,
            ]);
        }
        return response()->json(['message' => 'Credenciales incorrectas.'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada con éxito.']);
=======
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
>>>>>>> Stashed changes:app/Http/Controllers/API/LoginController.php
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
<<<<<<< Updated upstream:app/Http/Controllers/LoginController.php
    public function show($id)
    {
=======
    public function show(Request $request, $id)
    {
        $loggedUser = $request->user();
>>>>>>> Stashed changes:app/Http/Controllers/API/LoginController.php
        try {
            if (!Auth::check()) {
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
<<<<<<< Updated upstream:app/Http/Controllers/LoginController.php
=======
    public function logout(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $user->token()->delete();

            return response()->json([
                'message' => 'Sesion cerrada con exito',
            ]);
        }
        return response()->json([
            'message' => 'No autorizado'
        ], 401);
    }
>>>>>>> Stashed changes:app/Http/Controllers/API/LoginController.php
}
