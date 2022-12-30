<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Roles;
use Auth;
use JWTAuth;
use JWTFactory;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }*/

    // try {
    //     $user = auth()->userOrFail();
    // } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
    //     // do something
    // }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {

        $credentials = request(['login', 'password']);
        
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            $token = auth()->refresh();
            return response()->json(['access_token' => $token]);
        } catch (\Exception $e) {
            return response()->json(['Token is Invalid', $e->getMessage()], 401);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $data = array(
            'user' => auth()->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 360
        );


      


        return response()->json($data, 200);
    }

}
