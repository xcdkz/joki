<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
include_once 'private/keys.php';


function generate_token(string $id): string {
    $payload = [
        'iss' => 'http://joki.com',
        'iat' => getdate()[0],
        'id' => $id
    ];
    return JWT::encode($payload, Keys::privateKey, 'RS256');
}

function decode_token(string $token): array {
    $decoded = JWT::decode($token, new Key(Keys::publicKey, 'RS256'));
    return (array)$decoded;
}