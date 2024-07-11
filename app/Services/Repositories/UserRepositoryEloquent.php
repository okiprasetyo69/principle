<?php

namespace App\Services\Repositories;

use App\Models\User;
use App\Services\Interfaces\UserService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

use Exception;

class UserRepositoryEloquent implements UserService {

    /**
     * @var User
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUsers(Request $request){
        try{
            $user = $this->user::with('role');
            $user = $user->get();

            if($user != null){
                $datatables = Datatables::of( $user);
                return $datatables->make( true );
            }

            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
         }
    }

    public function register(Request $request){
        try{

            $user = new User();
            $user->fill($request->all());

            if($request->id != null){
                $user = $user::find($request->id);
            }

            $user->company_name = $request->company_name;
            $user->email = $request->email;
            $user->phone_number = $request->phone;
            $user->address = $request->address;
            $user->role_id = $request->role_id;
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $user
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
         }
    }
}