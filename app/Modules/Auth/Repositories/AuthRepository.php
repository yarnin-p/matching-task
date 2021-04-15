<?php

namespace App\Modules\Auth\Repositories;


use App\Modules\Auth\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\UserModel;


class AuthRepository implements AuthRepositoryInterface
{
    /**
     * @var UserModel
     */
    private $userModel;

    /**
     * AuthRepository constructor.
     * @param UserModel $_userModel
     */
    public function __construct(UserModel $_userModel)
    {
        DB::enableQueryLog();
//        var_dump(DB::getQueryLog());exit();
        $this->userModel = $_userModel;
    }

    public function checkLogin(Request $request)
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');
//            $user = $this->userModel::where('users.email', '=', $email)
//                ->where('users.password', '=', $password)
//                ->leftJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
//                ->leftJoin('roles', 'user_roles.role_id', '=', 'roles.id')
//                ->select('users.*', 'roles.role_name', 'roles.id as role_id')->first();

            $user = $this->userModel::with(['userRole.role'])
                ->where(['email' => $email,'password' => $password])
                ->withTrashed()
                ->first();

            if ($user) {
                Session::put('user_data', $user);
                return TRUE;
            }

            Session::put('user_data', []);
            return FALSE;
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('AuthRepository@checkLogin: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
