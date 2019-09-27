<?php

namespace App\Http\Controllers;
use App\Auth\Jwt;

class JwtControllers extends Controller
{
    use Jwt;

    public function sendtoken(){
        return $this->gettoken();   
    }

    public function login(\Illuminate\Http\Request $request){
        return $this->dologin($request);
    }

    public function logout(\Illuminate\Http\Request $request){
        return $this->getlogout($request);
    }

    public function decodetoken(\Illuminate\Http\Request $request){
        return $this->decoderequesttoken($request);
    }
}
