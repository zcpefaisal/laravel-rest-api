<?php
namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;

class AuthRepository {

    // without interface implement process
    public function login(array $data): array
    {
        $user = $this->getUserByEmail($data['email']);

        if (!$user) {
            throw new Exception("Error! User dosenot exists", 404);
        }

        if (!$this->checkIsValidPassword($user, $data)) {
            throw new Exception("Error! password dosenot match", 401);
        }

        $tokenInstance = $this->createAuthToken($user);

        return $this->getAuthData($user, $tokenInstance);

        return [];
    }

    public function register(array $data): array
    {
        $user = User::create($this->dataReadyForRegister($data));

        if (!$user) {
            throw new Exception("Error! User dosenot registered, Please try again", 500);
        }

        $tokenInstance = $this->createAuthToken($user);

        return $this->getAuthData($user, $tokenInstance);

        return [];
    }

    public function checkIsValidPassword(User $user, array $data): bool {
        return Hash::check($data['password'], $user->password);
    }

    public function getUserByEmail($email): ? User
    {
        return User::where('email', $email)->first();
    }

    public function createAuthToken(User $user): PersonalAccessTokenResult
    {
        return $user->createToken('authToken');
    }

    public function getAuthData(User $user, PersonalAccessTokenResult $tokenInstance)
    {
        return [
            'user' => $user,
            'access_token' => $tokenInstance->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenInstance->token->expires_at)->toDateTimeString(),
        ];
    }

    public function dataReadyForRegister(array $data): array
    {
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];
    }


}
