<?php
namespace App\Auth;

use Firebase\JWT\JWT as BaseJWT;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\User;

trait Jwt
{
	protected function gettoken(){
		return response()->json(['_token' => csrf_token()])
		->header('Content-Type', 'application/json charset=utf-8');
	}

	protected function dologin(\Illuminate\Http\Request $request){
		return $this->validateLogin($request) !== true?
		response()->json(['_token' => csrf_token(),'_error' => '403'])
		->header('Content-Type', 'application/json charset=utf-8'):
		Auth::attempt($request->only(['email','password']))?
		response()->json(
			array_flip([
				BaseJWT::encode(Auth::user()->only(['id','email','name']),env('JWT_KEY')) 
				=> Auth::logout() === null? "jwt_token":"jwt_token"
			])
		)->header('Content-Type', 'application/json charset=utf-8'):
		response()->json(['_token' => csrf_token(),'_error' => '403'])
		->header('Content-Type', 'application/json charset=utf-8');
	}

	protected function decoderequesttoken(\Illuminate\Http\Request $request){
		if($this->validateJwt_token($request) === true){
			try{
				return response()
				->json(BaseJWT::decode($request['jwt_token'],env('JWT_KEY'), array('HS256')))
				->header('Content-Type', 'application/json charset=utf-8');
			}
			catch(\Exception $e){
				return response()
				->json(['_error'=>'unkown token'])
				->header('Content-Type', 'application/json charset=utf-8');
			}
		}
		response()->json(['_token' => csrf_token(),'_error' => '403'])
		->header('Content-Type', 'application/json charset=utf-8');
	}


	private function validateJwt_token(\Illuminate\Http\Request $request):bool{
		return $request->isJson()
		&& $request->isMethod('post')
		&& Validator::make(
			$request->only(['jwt_token']),[
				'jwt_token' => 'required|string'
			]
			)->fails() === false;
	}

	private function validateLogin(\Illuminate\Http\Request $request):bool{
		return $request->isJson()
		&& $request->isMethod('post')
		&& Validator::make(
			$request->only(['email','password']),[
				'email' => 'required|exists:users,email|max:32',
				'password' => 'required|string|max:32']
			)->fails() === false;
	}

	private function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}