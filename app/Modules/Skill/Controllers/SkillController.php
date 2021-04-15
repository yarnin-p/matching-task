<?php

namespace App\Modules\Skill\Controllers;

use App\Modules\Skill\Repositories\SkillRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class SkillController extends Controller
{
    /**
     * @var SkillRepository
     */
    private $authRepo;

    /**
     * AuthController constructor.
     * @param SkillRepository $_AuthRepository
     */
    public function __construct(SkillRepository $_AuthRepository)
    {
        $this->authRepo = $_AuthRepository;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function checkLogin(Request $request)
    {
        try {
            $validatorLogin = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validatorLogin->fails()) {
                return responseError(422, 422, $validatorLogin->errors(), []);
            }

            $isUser = $this->authRepo->checkLogin($request);
            if ($isUser) {
                return responseSuccess(200, 200, 'Authorized', []);
            }
            return responseError(401, 401, 'Unauthorized', []);
        } catch (\Exception $e) {
            Log::error('AuthController@checkLogin: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
