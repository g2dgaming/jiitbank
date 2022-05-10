<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function login(Request $req){
        if(Auth::attempt(['email'=>$req['email'],'password'=>$req['password']])){
            $user=User::where('email',$req['email'])->first();
            $token=$user->createToken('JIITBankConsumer_'.$user->id)->plainTextToken;
            return response()->json([
                'success'=>true,
                'token'=>$token
            ],200);
        }
        else{
            return response()->json([
                'success'=>false
            ],401);
        }
    }
    public function register(Request $request){
        $user=new User;
        $user->email=$request['email'];
        $user->password=Hash::make($request['password']);
        $user->email_verified_at=Carbon::now();
        $saved=$user->save();
        if($saved){
            $token=$user->createToken('JIITBankConsumer_'.$user->id)->plainTextToken;
            return response()->json([
                'success'=>true,
                'token'=>$token
            ],200);
        }
        else{
            return response()->json([
                'success'=>false,
            ],401);
        }
    }
}
