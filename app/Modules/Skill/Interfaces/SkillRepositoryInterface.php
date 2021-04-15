<?php
namespace App\Modules\Skill\Interfaces;
use Illuminate\Http\Request;

interface SkillRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function checkLogin(Request $request);
}
