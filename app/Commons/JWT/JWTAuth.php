<?php


namespace App\Commons\JWT;


use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth
{
    public static function encode(JWTClaims $JWTClaims)
    {
        $secretKey = config('jwt.secret');
        $issuer = config('jwt.issuer');
        $expirationTime = config('jwt.exp');
        $issuedAt = time();
        $expiredAt = $issuedAt + $expirationTime;
        $payload = array(
            'iss' => $issuer,
            'iat' => $issuedAt,
            'exp' => $expiredAt,
            'claims' => [
                'username' => $JWTClaims->getUsername(),
                'role' => $JWTClaims->getRole(),
            ]
        );
        return JWT::encode($payload, $secretKey, 'HS256');
    }

    public static function decode($jwt)
    {
        try {
            $secretKey = config('jwt.secret');
            $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));
            return [
                'success' => true,
                'message' => 'success decode token',
                'data' => (array)$decoded->claims
            ];
        } catch (ExpiredException $e) {
            return [
                'success' => false,
                'message' => 'token expired',
                'data' => null
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'invalid token',
                'data' => null
            ];
        }
    }
}
