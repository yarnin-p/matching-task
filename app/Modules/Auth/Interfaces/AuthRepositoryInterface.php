<?php
namespace App\Modules\Auth\Interfaces;
use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function checkLogin(Request $request);
}
