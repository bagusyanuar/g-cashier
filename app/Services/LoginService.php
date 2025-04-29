<?php


namespace App\Services;


use App\Commons\JWT\JWTAuth;
use App\Commons\JWT\JWTClaims;
use App\Commons\Response\ServiceResponse;
use App\Models\User;
use App\Schemas\Login\LoginSchema;
use App\UseCase\Login\LoginUseCase;
use Illuminate\Support\Facades\Hash;

class LoginService implements LoginUseCase
{

    public function login(LoginSchema $schema): ServiceResponse
    {
        try {
            $validator = $schema->validate();
            if ($validator->fails()) {
                return ServiceResponse::unprocessableEntity($validator->errors()->toArray());
            }
            $schema->hydrateBody();

            $user = User::with([])
                ->where('username', '=', $schema->getUsername())
                ->first();
            if (!$user) {
                return ServiceResponse::notFound('user not found');
            }

            $isPasswordValid = Hash::check($schema->getPassword(), $user->password);
            if (!$isPasswordValid) {
                return ServiceResponse::unauthorized('password did not match');
            }

            $jwtClaims = new JWTClaims($user->username, 'superadmin');
            $token = JWTAuth::encode($jwtClaims);
            $response = [
                'access_token' => $token,
            ];
            return ServiceResponse::statusOK("successfully login", $response);
        } catch (\Throwable $e) {
            return ServiceResponse::internalServerError($e->getMessage());
        }
    }
}
