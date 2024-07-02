<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Basic\Persona;
use App\Models\Basic\PersonaNatural;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string',
            'ape_pat' => 'required|string',
            'ape_mat' => 'required|string',
            'tipoid' => 'required', // Tipo numero documento
            'numero' => 'required|string', // Numero de documero
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
        ]);
        $fullname = $request->name . ' ' . $request->ape_pat . ' ' . $request->ape_mat;
        DB::beginTransaction();
        try {
            $persona = Persona::create([
                'registro' => Carbon::now(),
                'tipo' => '',
                'direccion' => '',
                'distritoid' => 1249,
                'foto' => '',
                'telefono' => '',
                'email' => $request->email,
                'rol' => '',
                'usuarioid' => 0,
                'ip' => $request->ip(),
                'estado' => true,
                'paisid' => 1
            ]);
            $personaid = $persona->personaid;
            PersonaNatural::create([
                'personaid' => $personaid,
                'titulo' => '',
                'ape_pat' => $request->ape_pat,
                'ape_mat' => $request->ape_mat,
                'nombre' => $request->name,
                'sexo' => '',
                'est_civil' => '',
                'nacimiento' => '1980-05-15',
            ]);
            User::create([
                'name' => $fullname,
                'personaid' => $personaid,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' =>  null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "status" => true,
            "message" => "User registered successfully",
            "data" => []
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email|string",
            "password" => "required"
        ]);
        $user = User::where("email", $request->email)->first();
        if (!empty($user)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("mytoken")->accessToken;
                return response()->json([
                    "status" => true,
                    "message" => "Login successful",
                    "data" => [
                        "token" => $token
                    ]
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Password didn't match",
                    "data" => []
                ]);
            }
        } else {
            return response()->json([
                "status" => false,
                "message" => "Invalid Email value",
                "data" => []
            ]);
        }
    }

    public function profile()
    {
        $userData = auth()->user();
        return response()->json([
            "status" => true,
            "message" => "Profile information",
            "data" => $userData
        ]);
    }

    public function logout()
    {
        $token = auth()->user()->token();
        $token->revoke();
        return response()->json([
            "status" => true,
            "message" => "User Logged out successfully",
            "data" => []
        ]);
    }
}
