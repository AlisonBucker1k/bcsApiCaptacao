<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api', ['except' => ['create', 'login', 'unauthorized']]);
    }

    public function create(Request $request){
        $array = ['error' => '', 'return' => ''];

        $validator = Validator::make($request->all(), [
            'name' => [ 'required' ],
            'email' => [ 'required', 'email' ],
            'password' => [ 'required' ]
        ]);

        if(!$validator->fails()){
            $name = $request->input('name');
            $email = $request->input('email');        
            $password = $request->input('password');

            $emailExists = User::where('email', $email)->count();
            if($emailExists === 0){

                $newUser = new User();
                $newUser->email = $email;
                $newUser->password = password_hash($password, PASSWORD_DEFAULT);
                $newUser->name = $name;
                $newUser->save();

                $token = auth()->attempt([
                    'email' => $email,
                    'password' => $password
                ]);

                if(!$token){
                    $array['error'] = "Erro ao tentar fazer o login";
                    $array['return'] = false;
                    return $array;
                }

                $info = auth()->user();
                $info['avatar'] = url('media/avatars/'.$info['avatar']);
                $array['data'] = $info;
                $array['token'] = $token;
                $array['return'] = true;

            }else{
                $array['error'] = 'E-mail já foi cadastrado';
                $array['return'] = false;

                return $array;
            }

        }else{
            $array['error'] = 'Dados Incorretos';
            $array['return'] = false;
            return $array;
        }
        return $array;
    }

    public function login(Request $request){

        $array = ['error' => '', 'return' => ''];

        $email = $request->input('email');
        $password = $request->input('password');

        $token = auth()->attempt([
            'email' => $email,
            'password' => $password
        ]);

        if(!$token){
            $array['error'] = 'Usuário e/ou senha errados :/';
            $array['return'] = false;

            return $array;
        }

        $info = auth()->user();
        $info['avatar'] = url('media/avatars/'.$info['avatar']);
        $array['data'] = $info;
        $array['token'] = $token;
        $array['return'] = true;
        $array['error'] = false;

        return $array;
    }

    public function logout(){
        auth()->logout();
        return ['error'=>''];
    }

    public function refresh(){
        $token = auth()->refresh();

        $info = auth()->user();
        $info['avatar'] = url('media/avatars/'.$info['avatar']);
        $array['data'] = $info;
        $array['token'] = $token;
        $array['return'] = true;
        $array['error'] = false;
        return $array;
    }

    public function unauthorized() {
        return response()->json([
            'error' => 'Não Autorizado',
            'return' => false
        ], 401);
    }
}
