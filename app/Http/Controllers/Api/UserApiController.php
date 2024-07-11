<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Http\Controllers\Controller as BaseController;

use App\Services\Interfaces\UserService;

class UserApiController extends BaseController
{
   /**
     * @var User
    */

    private UserService $service;

    public function __construct(UserService $service) 
    {
        $this->service = $service;
    }

    public function getUser(Request $request){
        try{
           
            $user = $this->service->getUsers($request);
            if($user){
                return $user;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function register(Request $request){
        try{

            $validator = Validator::make($request->all(), [
                'company_name' => 'required',
                'email' => 'required|email',
                'phone_number' => 'required',
                'address' => 'required',
                'role_id' => 'required',
                'password' => 'required',
                
            ]);
            
            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => 400
                ]);
            }

            $user = $this->service->register($request);
            if($user){
                return $user;
            }

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
