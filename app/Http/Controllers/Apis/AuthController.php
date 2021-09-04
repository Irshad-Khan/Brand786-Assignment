<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponseTrait;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('login','register');
    }

    /**
     * user Registration
     *
     * @param Request $request
     * @return void
     */
    public function register(UserRegistrationRequest $request)
    {
        $request->request->add(['password' => Hash::make($request->password)]);
        $user = (new UserRepository())->create($request->all());
        $user->sendEmailVerificationNotification();
        return $this->responseWithSuccess('User created successfully. Check you email inbox for email verification', (new UserResource($user)));
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $request)
    {
       try {
            $credentials = $request->only(['email', 'password']);

            if (! $token = auth()->attempt($credentials)) {
                return $this->responseWithError('email or password is incorrect',401);
            }
            return $this->respondWithToken($token);
       } catch (\Exception $exception) {
        $this->responseWithError($exception->getMessage());
       }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return $this->responseWithSuccess('User Profile',(new UserResource(auth()->user())));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->responseWithSuccess('Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
            'error' => false,
            'message' => 'token Detail',
            'data' => [
                'user' => (new UserResource(auth()->user())),
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ],200);
    }
}
