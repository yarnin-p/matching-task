<?php

namespace App\Modules\Matching\Repositories;

use App\Models\QATasksModel;
use App\Modules\Matching\Interfaces\MatchingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\ProjectModel;


class MatchingRepository implements MatchingRepositoryInterface
{
    /**
     * @var UserModel
     */
    private $projectModel, $qaTaskModel;

    /**
     * ProjectRepository constructor.
     * @param ProjectModel $projectModel
     */
    public function __construct(ProjectModel $projectModel, QATasksModel $qaTaskModel)
    {
        DB::enableQueryLog();
//        var_dump(DB::getQueryLog());exit();
        $this->projectModel = $projectModel;
        $this->qaTaskModel = $qaTaskModel;
    }

    /**
     * @param Request $request
     * @return array|false|mixed
     */
    public function searchQA(Request $request)
    {
        try {
            $skills = $request->input('skills');
            $experience = $request->input('experience');
            $qaRole = DB::table('roles')->where('role_name', '=', 'qa')->first();
            $qaRole = $qaRole ? $qaRole->id : 1;
            $results = DB::table('users')
                ->join('qa_skills', 'users.id', '=', 'qa_skills.user_id')
                ->join('qa_experiences', 'users.id', '=', 'qa_experiences.user_id')
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->whereIn('qa_skills.skill_id', $skills)
                ->where('qa_experiences.year', '=', $experience)
                ->where('user_roles.role_id', '=', $qaRole)
                ->select('users.*')
                ->get()
                ->toArray();

            return $this->checkQaAvailable($results);
        } catch (\Exception $e) {
            Log::error('MatchingRepository@getAllProjects: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $qaList
     * @return array|false
     */
    public function checkQaAvailable($qaList)
    {
        try {
            $results = [];
            if (count($qaList) > 0) {
                foreach ($qaList as $key => $qaRow) {
                    $isAvailable = $this->qaTaskModel::join('tasks', 'qa_tasks.task_id', '=', 'tasks.id')
                        ->where('qa_tasks.status', '=', 'process')
                        ->where('qa_tasks.qa_id', '=', $qaRow->id)
                        ->whereDate('tasks.end_date', '<', date('Y-m-d'))
                        ->get()
                        ->toArray();
                    if (count($isAvailable) > 0) {
                        unset($qaList[$key]);
                    }
                }
            }

            return $qaList;
        } catch (\Exception $e) {
            Log::error('MatchingRepository@checkQaAvailable: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

}
