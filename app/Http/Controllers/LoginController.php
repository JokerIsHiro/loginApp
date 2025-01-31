<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
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
    }

    public function index()
    {
        try {
            if (!Auth::check()) {
                throw new \Exception('No estas logeado');
            }

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
}
