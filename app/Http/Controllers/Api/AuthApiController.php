<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthApiController extends ApiBaseController
{
    /**
     * Логин в приложение для администраторов.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'login' => 'required|min:3', 
            'password' => 'required', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = User::where('name', '=', $request->login)->get()->first();

        if ($user != null) {
            if (Hash::check(request('password'), $user->password))
            {
                Auth::login($user);
            }
            else
            {
                return $this->SendError('Authorization error', 'Wrong password', 401);
            }

            if (Auth::check()) {
                $tokenResult = $user->createToken(config('app.name'));
                $token = $tokenResult->token;
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();

                return $this->sendResponse([
                    'login' => Auth::user()->name,
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString()
                ],
                    'Authorization is successful');
            }
        }

        return $this->SendError('Authorization error', 'Unauthorised', 401);
    }
}
