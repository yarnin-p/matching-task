<?php

namespace App\Modules\WorkExperience\Repositories;


use App\Models\SkillModel;
use App\Modules\WorkExperience\Interfaces\WorkExperienceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;



class WorkExperienceRepository implements WorkExperienceRepositoryInterface
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
    public function getAllWorkExperiences(Request $request)
    {
        try {
            return $this->skillModel::all()->toArray();
        } catch (\Exception $e) {
            Log::error('WorkExperienceRepository@getAllWorkExperiences: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @return false|mixed
     */
    public function getWorkExperience($id)
    {
        try {
            return $this->skillModel::find($id);
        } catch (\Exception $e) {
            Log::error('WorkExperienceRepository@getWorkExperience: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }


    /**
     * @param Request $request
     * @return false
     */
    public function createWorkExperience(Request $request)
    {
        try {
            $input['skill_name'] = trim($request->input('skill_name'));
            $input['description'] = $request->input('description') ? $request->input('description') : "";

            return $this->skillModel::insert($input);
        } catch (\Exception $e) {
            Log::error('WorkExperienceRepository@createWorkExperience: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return bool
     */
    public function updateWorkExperience($id, Request $request)
    {
        try {
            $input['description'] = $request->input('description') ? $request->input('description') : "";
            $skill = $this->skillModel::find($id);
            $skill->skill_name = trim($request->input('skill_name'));
            $skill->description = $request->input('description');
            return $skill->save();;
        } catch (\Exception $e) {
            Log::error('WorkExperienceRepository@updateWorkExperience: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @return false|mixed
     */
    public function deleteWorkExperience($id)
    {
        try {
            return $this->skillModel::where('id', $id)->delete();
        } catch (\Exception $e) {
            Log::error('WorkExperienceRepository@deleteWorkExperience: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
