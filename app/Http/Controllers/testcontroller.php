<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
class testcontroller extends Controller
{
    public function logintest(Request $request){ 
        if(Auth::attempt([
            'email'=>$request->email,
            'password'=>$request->password
        ])){
            $user=Auth::user();
            $res=[];
$res['token']=$user->createToken('api-app')->accessToken;
$res['name']=$user->name;
return response()->json($res,200);
        }else{
         return response()->json(['error'=>'unauthorized'],203); 
        }
     }
 /** 
      * Register api 
      * 
      * @return \Illuminate\Http\Response 
      */ 
     public function registertest(Request $request) 
     { 
 $validator = Validator::make($request->all(), [ 
     'name' => 'required', 
     'email' => 'required|email', 
     'password' => 'required', 
 ]);
 if ($validator->fails()) { 
     return response()->json(['error'=>$validator->errors()], 202);            
 }
$alldata=$request->all();
$alldata['password']=bcrypt($alldata['password']);
$user=User::create($alldata);
$res=[];
$res['token']=$user->createToken('api-app')->accessToken;
$res['name']=$user->name;
return response()->json($res,200);

     }
}
