<?php

namespace App\Http\Controllers\API;

use App\Actions\UpdateAdminAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use App\Transformers\AdminTransformer;

class AuthController extends Controller {
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:admins', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login() {
        $credentials = request(['email', 'password']);

        if (!$token = auth('admins')->attempt($credentials)) {
            return $this->httpUnauthorized();
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        return $this->httpOK(auth('admins')->user(), AdminTransformer::class);
    }

    /**
     * @param UpdateAdminRequest $updateAdminRequest
     * @param UpdateAdminAction $updateAdminAction
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(UpdateAdminRequest $updateAdminRequest, UpdateAdminAction $updateAdminAction)
    {
        $updateAdminAction->execute($updateAdminRequest->validated(), auth('admins')->user());

        return $this->httpNoContent();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @param $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) {
        return response()->json([
                                    'access_token' => $token,
                                    'token_type'   => 'bearer',
                                    'expires_in'   => env('JWT_TTL', 3600)
                                ]);
    }
}
