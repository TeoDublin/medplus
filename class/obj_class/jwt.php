<?php
require_once __DIR__ . '/../libraries/php-jwt/src/JWK.php';
require_once __DIR__ . '/../libraries/php-jwt/src/JWT.php';
require_once __DIR__ . '/../libraries/php-jwt/src/ExpiredException.php';
require_once __DIR__ . '/../libraries/php-jwt/src/BeforeValidException.php';
require_once __DIR__ . '/../libraries/php-jwt/src/SignatureInvalidException.php';

use \Firebase\JWT\JWT as FirebaseJWT;

class Jwt {
    protected $key = "M3dPlu$@#";

    public function encode($params = []) {
        return FirebaseJWT::encode($params, $this->key, 'HS256');
    }

    public function decode(String $params) {
        return FirebaseJWT::decode($params, $this->key, ['HS256']);
    }
}
