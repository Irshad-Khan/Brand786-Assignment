<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    use ApiResponseTrait;

    public function verify($userId, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return $this->responseWithError('Invalid/Expired url provided.', 401);
        }

        $user = (new UserRepository())->show($userId);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->to('/');
    }
}
