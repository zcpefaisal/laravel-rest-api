<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use ResponseTrait;

    public function __construct(private AuthRepository $auth)
    {
        $this->auth = $auth;
    }


    public function show()
    {
        try{
            return Auth::guard()->user();
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    public function logout(): JsonResponse
    {
        try{
            Auth::guard()->user()->token()->revoke();
            Auth::guard()->user()->token()->delete();
            return $this->responseSuccess('', 'User Logged out');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }
}
