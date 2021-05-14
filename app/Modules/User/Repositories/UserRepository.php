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
            return $this->userModel::find($userId)->first();
        } catch (\Exception $e) {
            Log::error('UserRepository@getUser: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    public function createUser(Request $request)
    {
        try {
            $input['firstname'] = trim($request->input('firstname'));
            $input['lastname'] = trim($request->input('firstname'));
            $input['email'] = trim($request->input('email'));
            $input['password'] = trim($request->input('password'));
            $input['emp_no'] = trim($request->input('emp_no'));

            return $this->userModel::insert($input);
        } catch (\Exception $e) {
            Log::error('ProjectRepository@createUser: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    public function updateUser($id, Request $request)
    {
        // TODO: Implement updateUser() method.
    }

    public function deleteUser($id, Request $request)
    {
        // TODO: Implement deleteUser() method.
    }
}
