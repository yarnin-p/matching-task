<?php

namespace App\Modules\Project\Repositories;


use App\Modules\Project\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\ProjectModel;


class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * @var UserModel
     */
    private $projectModel;

    /**
     * ProjectRepository constructor.
     * @param ProjectModel $projectModel
     */
    public function __construct(ProjectModel $projectModel)
    {
        DB::enableQueryLog();
//        var_dump(DB::getQueryLog());exit();
        $this->projectModel = $projectModel;
    }

    /**
     * @param Request $request
     * @return array|false|mixed
     */
    public function getAllProjects(Request $request)
    {
        try {
            return $this->projectModel::all()->toArray();
        } catch (\Exception $e) {
            Log::error('ProjectRepository@getAllProjects: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param Request $id
     * @return false|mixed
     */
    public function getProject($id)
    {
        try {
            return $this->projectModel::find($id);
        } catch (\Exception $e) {
            Log::error('ProjectRepository@getProject: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param Request $request
     * @return false
     */
    public function createProject(Request $request)
    {
        try {
            $input['project_name'] = trim($request->input('project_name'));
            $input['description'] = $request->input('description') ? $request->input('description') : "";

            return $this->projectModel::insert($input);
        } catch (\Exception $e) {
            Log::error('ProjectRepository@createProject: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return bool
     */
    public function updateProject($id, Request $request)
    {
        try {
            $input['description'] = $request->input('description') ? $request->input('description') : "";
            $project = $this->projectModel::find($id);
            $project->project_name = trim($request->input('project_name'));
            $project->description = $request->input('description');
            $project->save();
            return TRUE;
        } catch (\Exception $e) {
            Log::error('ProjectRepository@updateProject: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return false|mixed
     */
    public function deleteProject($id, Request $request)
    {
        try {
            return $this->projectModel::where('id', $id)->delete();
        } catch (\Exception $e) {
            Log::error('ProjectRepository@deleteProject: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
