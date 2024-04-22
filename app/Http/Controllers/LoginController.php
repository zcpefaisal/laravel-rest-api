<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ResponseTrait;

    public function login(Request $request)
    {
        // check user request
        // dd($request);
        $user = User::where('email', $request->email)->first();
        // dd($user);
        if (!$user) {
            return $this->responseError([], "User not found");
        }
        // check the password
        if (Hash::check($request->password, $user->password)) {
            $createToken = $user->createToken('authToken');
            // dd($token);
            $data = [
                'user' => $user,
                'access_token' => $createToken->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($createToken->token->expires_at)->toDateTimeString(),
            ];
            return $this->responseSuccess($data, "User Loged-in successlully");
        }
    }
}
