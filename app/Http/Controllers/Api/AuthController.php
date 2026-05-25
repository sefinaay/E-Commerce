<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone'    => 'nullable|string',
        ]);
        if ($v->fails()) return $this->validationError($v->errors());

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'role'     => 'customer',
        ]);

        $token = JWTAuth::fromUser($user);
        return $this->respondWithToken($token, $user, 201);
    }

    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);
        if ($v->fails()) return $this->validationError($v->errors());

        if (!$token = auth()->attempt($request->only('email','password'))) {
            return response()->json(['success'=>false,'message'=>'Email atau password salah'], 401);
        }
        return $this->respondWithToken($token, auth()->user());
    }

    public function profile()
    {
        $user = auth()->user();
        return response()->json(['success'=>true,'data'=>$user]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $v = Validator::make($request->all(), [
            'name'    => 'sometimes|string|max:100',
            'phone'   => 'sometimes|string',
            'address' => 'sometimes|string',
        ]);
        if ($v->fails()) return $this->validationError($v->errors());

        $user->update($request->only('name','phone','address'));
        return response()->json(['success'=>true,'message'=>'Profile updated','data'=>$user]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['success'=>true,'message'=>'Logout berhasil']);
    }

    public function refresh()
    {
        $token = auth()->refresh();
        return $this->respondWithToken($token, auth()->user());
    }

    private function respondWithToken($token, $user, $status = 200)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth()->factory()->getTTL() * 60,
                'user'         => $user,
            ]
        ], $status);
    }

    private function validationError($errors)
    {
        return response()->json(['success'=>false,'message'=>'Validasi gagal','errors'=>$errors], 422);
    }
}