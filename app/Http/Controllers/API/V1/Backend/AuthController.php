<?php

namespace App\Http\Controllers\API\V1\Backend;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PasswordChangeFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\V1\Backend\ApiController;

use stdClass, Validator, JWTAuthException;

class AuthController extends ApiController
{
    private $token = null;

    public function __construct()
    {
        Auth::shouldUse('admin-api');
    }

    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|max:50',
            'password'=>'required|string|min:8|max:30'
        ]);

        if($validator->fails())
        {
            $this->sendErrorResponse($validator->errors(),$message = 'Login Failed');
        }
        try {
            if(!$this->token = JWTAuth::attempt($validator->validated()))
            {
                return $this->sendErrorResponse($errors = 'Invalid username or password',$message = 'Login Failed');
            }else{
                $data = new stdClass;
                $data->token_type = "Bearer";
                $data->token = $this->token;
                $data->user = auth()->user();
                return $this->sendSuccessResponse($data,$message="Login Successfull");
            }
        } catch (JWTAuthException $th) {
            return $this->sendErrorResponse($errors = $th->getMessage(),$message = 'Failed to create token');
        }

    }

    public function profile()
    {
        return $this->sendSuccessResponse(auth()->user(),$message="Logged in admin user profile data");
    }

    public function passwordChange(PasswordChangeFormRequest $request){
        try {
           $user = Auth::user();
           if(!Hash::check($request->current_password, $user->password)){
                return $this->sendErrorResponse('Current password dose not match!','Current password dose not match!');
           }else{
            $user->password = $request->password;
            if($user->update()){
                return $this->sendSuccessResponse('Password changed successfull!','Password changed successfull!');
            }else{
                return $this->sendErrorResponse('Failed to change password!','Failed to change password!');
            }
           }
        } catch (\Throwable $th) {
            return $this->sendErrorResponse('Failed To Change Password',$th->getMessage());
        }
    }
}
