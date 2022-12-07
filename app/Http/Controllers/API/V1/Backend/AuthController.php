<?php

namespace App\Http\Controllers\API\V1\Backend;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use stdClass, Validator, JWTAuthException;

class AuthController extends Controller
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

    public function sendSuccessResponse($data,$message)
    {
        $response = new stdClass;
        $response->status = true;
        $response->data = $data;
        $response->message = $message;
        return response()->json($response);
    }

    public function sendErrorResponse($errors,$message)
    {
        $response = new stdClass;
        $response->status = false;
        $response->errors = $errors;
        $response->message = $message;
        return response()->json($response);
    }
}
