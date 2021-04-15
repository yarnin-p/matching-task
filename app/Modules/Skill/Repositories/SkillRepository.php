<?php

namespace App\Modules\Skill\Repositories;


use App\Modules\Skill\Interfaces\SkillRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\UserModel;


class SkillRepository implements SkillRepositoryInterface
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
            $user = $this->userModel::where('users.email', '=', $email)
                ->where('users.password', '=', $password)
                ->leftJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->leftJoin('roles', 'user_roles.role_id', '=', 'roles.id')
                ->select('users.*', 'roles.role_name')->get();
            if ($user->isNotEmpty()) {
                $request->session()->put('user_data', $user->toArray());
                return TRUE;
            }
            $request->session()->put('user_data', []);
            return FALSE;
        } catch (\Exception $e) {
            Log::error('AuthRepository@checkLogin: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
