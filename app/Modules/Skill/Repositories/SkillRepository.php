<?php

namespace App\Modules\Skill\Repositories;


use App\Models\SkillModel;
use App\Modules\Skill\Interfaces\SkillRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;



class SkillRepository implements SkillRepositoryInterface
{
    /**
     * @var SkillModel
     */
    private $skillModel;

    /**
     * SkillRepository constructor.
     * @param SkillModel $skillModel
     */
    public function __construct(SkillModel $skillModel)
    {
        DB::enableQueryLog();
//        var_dump(DB::getQueryLog());exit();
        $this->skillModel = $skillModel;
    }

    /**
     * @param Request $request
     * @return array|false|mixed
     */
    public function getAllSkills(Request $request)
    {
        try {
            return $this->skillModel::all()->toArray();
        } catch (\Exception $e) {
            Log::error('SkillRepository@getAllSkills: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @return false|mixed
     */
    public function getSkill($id)
    {
        try {
            return $this->skillModel::find($id);
        } catch (\Exception $e) {
            Log::error('SkillRepository@getSkill: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }


    /**
     * @param Request $request
     * @return false
     */
    public function createSkill(Request $request)
    {
        try {
            $input['skill_name'] = trim($request->input('skill_name'));
            $input['description'] = $request->input('description') ? $request->input('description') : "";

            return $this->skillModel::insert($input);
        } catch (\Exception $e) {
            Log::error('SkillRepository@createSkill: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return bool
     */
    public function updateSkill($id, Request $request)
    {
        try {
            $input['description'] = $request->input('description') ? $request->input('description') : "";
            $skill = $this->skillModel::find($id);
            $skill->skill_name = trim($request->input('skill_name'));
            $skill->description = $request->input('description');
            return $skill->save();;
        } catch (\Exception $e) {
            Log::error('SkillRepository@updateSkill: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @return false|mixed
     */
    public function deleteSkill($id)
    {
        try {
            return $this->skillModel::where('id', $id)->delete();
        } catch (\Exception $e) {
            Log::error('SkillRepository@deleteSkill: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
