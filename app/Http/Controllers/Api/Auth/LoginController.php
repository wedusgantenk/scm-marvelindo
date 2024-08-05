<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        //set validasi
        $validator = Validator::make($request->all(), [
            'username'    => 'required',
            'password' => 'required',
        ]);

        //response error validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get "email" dan "password" dari input
        $credentials = $request->only('username', 'password');

        //check jika "email" dan "password" tidak sesuai
        if (!$token = auth()->guard('api')->attempt($credentials)) {

            //response login "failed"
            return response()->json([
                'success' => false,
                'message' => 'Username or Password is incorrect'
            ], 400);
        }

        //response login "success" dengan generate "Token"
        return response()->json([
            'success'       => true,
            'user'          => auth()->guard('api')->user()->only(['username', 'jenis', 'bagian']),
            // 'permissions'   => auth()->guard('api')->user()->getPermissionArray(),
            'token'         => $token
        ], 200);
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        //remove "token" JWT
        JWTAuth::invalidate(JWTAuth::getToken());

        //response "success" logout
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Logout'
        ], 200);
    }
}
