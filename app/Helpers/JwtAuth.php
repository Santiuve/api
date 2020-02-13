<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;
class JwtAuth{
    public $key;
    public function __construct(){
        $this->key = "esto_es_una_clave_super_dificil_14745853";
    }
    public function signup($email, $password, $getToken = null){
        $user = User::where([
            'email' => $email,
            'password' => $password
        ])->first();
        $signup = false;
        if(is_object($user)){
            $signup = true;
        }
        if($signup){
            $token = array(
                'sub' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'surname' => $user->surname,
                'iat' => time(),
                'exp' => time() + (7*24+60+60)
            );
            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
            if(is_null($getToken)){
                $data = $jwt;
            }else{
                $data = $decoded;
            }
        }else{
            $data = array(
                'status' => 'error',
                'message' => 'Login incorrecto.'
            );
        }
        return $data;
    }
}
