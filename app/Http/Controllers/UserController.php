<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function pruebas(Request $request){
        return "Acción de pruebas de USER-CONTROLLER";
    }
    public function register(Request $request){
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);
        if(!empty($params) && !empty($params_array)){
            $params_array = array_map('trim', $params_array);
            $validate = \Validator::make($params_array, [
                'name' => 'required|alpha',
                'surname' => 'required|alpha',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);
            if($validate->fails()){
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'El usuario no se ha creado',
                    'errors' => $validate->errors()
                );
            }else{
                $pwd = hash('sha256', $params->password);
                $user = new User();
                $user->name = $params_array['name']; 
                $user->surname = $params_array['surname']; 
                $user->email = $params_array['email']; 
                $user->password = $pwd;
                $user->role = 'ROLE_USER';
                $user->save();
                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'El usuario se ha creado correctamente',
                    'user' => $user
                );
            }
        }else{
            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Los datos enviados no son correctos'
            );
        }
        return response()->json($data, $data['code']);
    }
    public function login(Request $request){
        $jwtAuth = new \JwtAuth();
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);
        $validate = \Validator::make($params_array, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validate->fails()){
            $signup = array(
                'status' => 'error',
                'code' => '404',
                'message' => 'El usuario no se ha podido identificar',
                'errors' => $validate->errors()
            );
        }else{
            $pwd = hash('sha256', $params->password);
            $signup = $jwtAuth->signup($params->email, $pwd);
            if(!empty($params->getToken)){
                $signup = $jwtAuth->signup($params->email, $pwd, true);
            }
        }
        $email = 'omar_23_co@hotmail.com';
        $password = 'omar231198';
        $pwd = hash('sha256', $password);
        return response()->json($signup, 200);
    }
    public function update(Request $request){
        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        if($checkToken){
            echo "<h1>Login correcto</h1>";
        }else{
            echo "<h1>Login incorrecto</h1>";
        }
        die();
    }
}