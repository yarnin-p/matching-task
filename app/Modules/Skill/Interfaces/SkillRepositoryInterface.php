<?php
namespace App\Modules\Skill\Interfaces;
use Illuminate\Http\Request;

interface SkillRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllSkills(Request $request);

    /**
     * @param $id
     * @return mixed
     */
    public function getSkill($id);


    /**
     * @param Request $request
     * @return mixed
     */
    public function createSkill(Request $request);

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateSkill($id, Request $request);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteSkill($id);
}
