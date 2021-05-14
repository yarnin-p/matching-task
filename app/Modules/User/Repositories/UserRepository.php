<?php

namespace App\Modules\User\Repositories;


use App\Models\RoleModel;
use App\Models\UserModel;
use App\Modules\Project\Interfaces\ProjectRepositoryInterface;
use App\Modules\User\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\ProjectModel;


class UserRepository implements UserRepositoryInterface
{
    /**
     * @var UserModel
     */
    private $userModel, $roleModel;

    /**
     * ProjectRepository constructor.
     * @param ProjectModel $projectModel
     */
    public function __construct(UserModel $projectModel, RoleModel $roleModel)
    {
        DB::enableQueryLog();
//        var_dump(DB::getQueryLog());exit();
        $this->userModel = $projectModel;
        $this->roleModel = $roleModel;
    }

    public function getAllUsers(Request $request)
    {
        try {
            return $this->userModel::where('emp_no', '!=', 'admin')->get()->toArray();
        } catch (\Exception $e) {
            Log::error('UserRepository@getAllUsers: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $userId
     * @return false|mixed
     */
    public function getUser($userId)
    {
        try {
            return $this->userModel::where('id', $userId)->first();
        } catch (\Exception $e) {
            Log::error('UserRepository@getUser: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param Request $request
     * @return false|mixed
     */
    public function createUser(Request $request)
    {
        try {
            $input['firstname'] = trim($request->input('firstname'));
            $input['lastname'] = trim($request->input('firstname'));
            $input['email'] = trim($request->input('email'));
            $input['password'] = trim($request->input('password'));
            $input['emp_no'] = trim($request->input('emp_no'));

            $user = $this->userModel::insert($input);
            if ($user) {
                $role = DB::table('roles')->where('role_name', $request->input('emp_no'))->first();
                DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id' => $role->id]);
                return TRUE;
            }
            return FALSE;

        } catch (\Exception $e) {
            Log::error('UserRepository@createUser: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return bool
     */
    public function updateUser($id, Request $request)
    {
        try {
            $user = $this->userModel::where('id', $id)->first();
            $user->firstname = trim($request->input('firstname'));
            $user->lastname = $request->input('lastname');
            $user->email = $request->input('email');
            $user->password = $request->input('password');

            if ($user->emp_no != $request->input('emp_no')) {
                $role = DB::table('roles')->where('role_name', $user->emp_no)->first();
                $newRole = DB::table('roles')
                    ->where('role_name', $request->input('emp_no'))
                    ->first();

                $user->emp_no == $request->input('emp_no');

                DB::table('user_roles')
                    ->where('user_id', $id)
                    ->where('role_id', $role->id)
                    ->delete();
                DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id' => $newRole->id]);
            }

            $user->save();
            return TRUE;
        } catch (\Exception $e) {
            Log::error('UserRepository@updateUser: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    public function deleteUser($id, Request $request)
    {
        try {
            $this->userModel::where('id', $id)->delete();
            return TRUE;
        } catch (\Exception $e) {
            Log::error('UserRepository@deleteUser: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
