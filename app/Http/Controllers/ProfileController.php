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


    public function show(): JsonResponse
    {
        try{
            return Auth::guard()->user();
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage());
        }
    }

    public function logout(): JsonResponse
    {
        try{
            Auth::guard()->user()->token()->revoke();
            Auth::guard()->user()->token()->delete();
            return $this->responseSuccess('', 'User Logged out');
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage());
        }
    }
}
