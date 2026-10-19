<?php
defined('BASEPATH') OR exit('No direct script access allowed');



use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;
use \Firebase\JWT\SignatureInvalidException;

class Jwt_lib
{
    private $ci;
    private $key;
    private $algorithm = 'HS256';

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->config('config');
        $this->key = $this->ci->config->item('encryption_key');

        if (empty($this->key)) {
            show_error('JWT secret key is not set in application/config/config.php (encryption_key).', 500);
        }
    }

    
    public function generate(array $data)
    {
        $issued_at = time();
    $expiration_time = $issued_at + (60 * 60 * 24 * 365); 

        $payload = array_merge($data, [
            'iat' => $issued_at,
            'exp' => $expiration_time
        ]);

        return JWT::encode($payload, $this->key, $this->algorithm);
    }

    
public function validate(string $token)
{
    try {
        
        
        $decoded = JWT::decode($token, $this->key, array($this->algorithm));
        return ['status' => true, 'data' => $decoded];
    } catch (ExpiredException $e) {
        return ['status' => false, 'message' => 'Token has expired.'];
    } catch (SignatureInvalidException $e) {
        return ['status' => false, 'message' => 'Token signature is invalid.'];
    } catch (Exception $e) {
        return ['status' => false, 'message' => $e->getMessage()];
    }
}
}