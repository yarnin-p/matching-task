<?php

namespace App\Modules\User\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use App\Modules\User\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepo;

    /**
     * UserController constructor.
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index(Request $request)
    {
        $results = $this->userRepo->getAllUsers($request);
        return view('user.index', compact('results'));
    }

    public function createView(Request $request)
    {
        return view('user.create');
    }

    public function editView($userId)
    {
        $result = $this->userRepo->getUser($userId);
        return view('user.edit', compact('result'));
    }


    public function create(Request $request)
    {
        try {

            $validatorUserData = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'emp_no' => 'required',
                'email' => 'required',
                'password' => 'required'
            ]);

            if ($validatorUserData->fails()) {
                return responseError(422, 422, $validatorUserData->errors(), []);
            }

            $this->userRepo->createUser($request);
            return responseSuccess(201, 201, 'Created', []);
        } catch (\Exception $e) {
            Log::error('UserController@create: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    public function update(Request $request, $userId)
    {
        try {
            $validatorUserData = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'emp_no' => 'required'
            ]);

            if ($validatorUserData->fails() || !$userId) {
                return responseError(422, 422, $validatorUserData->errors(), []);
            }

            $isProjectUpdated = $this->userRepo->updateUser($userId, $request);
            if ($isProjectUpdated) {
                return responseSuccess(201, 201, 'Updated', []);
            }
            return responseError(500, 500, 'Something went wrong!', []);
        } catch (\Exception $e) {
            Log::error('UserController@update: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
