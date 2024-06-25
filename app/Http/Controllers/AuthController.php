<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Constructor to set middleware for authentication, except for specified methods.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout']]);
    }

    /**
     * Authenticate user and return JWT if valid.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        // Validate incoming request data
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate user with provided credentials
        $credentials = $request->only(['email', 'password']);
        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401); // Unauthorized if credentials are invalid
        }

        // Respond with token and user data
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user()); // Return authenticated user information
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout(); // Invalidate current token

        return response()->json(['message' => 'Successfully logged out']); // Respond with success message
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh()); // Refresh and respond with new token
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
            'expires_in' => auth()->factory()->getTTL() * 60 * 24 // Token expiration time in minutes
        ]);
    }
}
