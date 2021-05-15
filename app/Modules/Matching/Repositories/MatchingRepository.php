<?php

namespace App\Modules\Matching\Repositories;

use App\Models\QATasksModel;
use App\Models\TaskModel;
use App\Modules\Matching\Interfaces\MatchingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

use App\Models\ProjectModel;


class MatchingRepository implements MatchingRepositoryInterface
{
    /**
     * @var UserModel
     */
    private $projectModel, $qaTaskModel, $taskModel;

    /**
     * ProjectRepository constructor.
     * @param ProjectModel $projectModel
     */
    public function __construct(ProjectModel $projectModel, QATasksModel $qaTaskModel, TaskModel $taskModel)
    {
        DB::enableQueryLog();
//        var_dump(DB::getQueryLog());exit();
        $this->projectModel = $projectModel;
        $this->taskModel = $taskModel;
        $this->qaTaskModel = $qaTaskModel;
    }

    /**
     * @param Request $request
     * @return array|false|mixed
     */
    public function searchQA(Request $request)
    {
        try {
            $taskId = $request->input('task_id');
            $taskSize = $this->taskModel::where('id', $taskId)->select('task_size')->first();
            $skills = $request->input('skills');
            $experience = (string)$request->input('experience');

            if (substr($experience, 0, 1) == 0) {
                $experience = substr($experience, 1);
            }

            $qaRole = DB::table('roles')->where('role_name', '=', 'qa')->first();

            $qaRole = $qaRole ? $qaRole->id : 2;
            $qaList = DB::table('users')
                ->join('qa_skills', 'users.id', '=', 'qa_skills.user_id')
                ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->where(function ($query) use ($skills) {
                    if ($skills) {
                        $query->whereIn('qa_skills.skill_id', $skills);
                    }
                })->where('user_roles.role_id', '=', $qaRole)
                ->select('users.*')
                ->get()
                ->toArray();

            $isExpMatched = $this->getExpQa($qaList, $experience);
            $isPassed = $this->checkQaQualifiedTasks($isExpMatched, $taskSize->task_size);
            $isAvailable = $this->checkQaAvailable($isPassed);
            return $this->checkDidMaxTask($isAvailable, $taskSize->task_size);
        } catch (Exception $e) {
            Log::error('MatchingRepository@getAllProjects: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $qaList
     * @param $experience
     * @return false
     */
    public function getExpQa($qaList, $experience)
    {
        try {
            if (count($qaList) > 0) {
                foreach ($qaList as $key => $qaRow) {
                    $totalExp = 0;
                    $workExps = DB::table('qa_experiences')
                        ->where('user_id', '=', $qaRow->id)
                        ->get()
                        ->toArray();
                    foreach ($workExps as $workExp) {
                        $totalExp += $workExp->year;
                    }

                    if ($totalExp >= (int)$experience) {
                        continue;
                    } else {
                        unset($qaList[$key]);
                    }
                }
            }
            return $qaList;
        } catch (Exception $e) {
            Log::error('MatchingRepository@getExpQa: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $qaList
     * @param $taskSize
     * @return false|mixed
     */
    public function checkQaQualifiedTasks($qaList, $selectedTaskSize)
    {
        try {
            $qualifiedTaskNum = 3;
            $taskSize = 'S';
            if ($selectedTaskSize == 'L') {
                $taskSize = 'M';
            } else if ($selectedTaskSize == 'XL') {
                $taskSize = 'L';
            }

            if (count($qaList) > 0) {
                foreach ($qaList as $key => $qaRow) {
                    if ($selectedTaskSize !== 'S') {
                        $isPassed = $this->qaTaskModel::join('tasks', 'qa_tasks.task_id', '=', 'tasks.id')
                            ->where('qa_tasks.status', '=', 'complete')
                            ->where('qa_tasks.qa_id', '=', $qaRow->id)
                            ->where('tasks.task_size', '=', $taskSize)
                            ->get()
                            ->toArray();
                        if (count($isPassed) < $qualifiedTaskNum) {
                            unset($qaList[$key]);
                        }
                    }
                }
            }

            return $qaList;
        } catch (\Exception $e) {
            Log::error('MatchingRepository@checkQaQualifiedTasks: [' . $e->getCode() . '] ' . $e->getMessage());
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

    public function saveMatching(Request $request)
    {
        try {
            $input['task_id'] = $request->input('task_id');
            $input['qa_id'] = $request->input('qa_id');
            $input['status'] = 'process';
            $input['created_at'] = date('Y-m-d H:i:s');

            $this->taskModel::where('id', $input['task_id'])->update(['status' => 'process']);

            return $this->qaTaskModel::create($input);
        } catch (\Exception $e) {
            Log::error('MatchingRepository@saveMatching: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $qaList
     * @param $selectedTaskSize
     * @return array|false
     */
    public function checkDidMaxTask($qaList, $selectedTaskSize)
    {
        try {

            $taskSize = 'S';
            if ($selectedTaskSize == 'L') {
                $taskSize = 'M';
            } else if ($selectedTaskSize == 'XL') {
                $taskSize = 'L';
            }


            if (count($qaList) > 0) {
                foreach ($qaList as $key => $qaRow) {
                    $qaIdList[$key] = $qaRow->id;
                }

                $result = DB::table('qa_tasks')
                    ->join('tasks', 'qa_tasks.task_id', '=', 'tasks.id')
                    ->join('users', 'users.id', '=', 'qa_tasks.qa_id')
                    ->where('users.emp_no', '=', 'qa')
                    ->whereIn('qa_tasks.qa_id', $qaIdList)
                    ->where('tasks.task_size', $taskSize)
                    ->select('users.id', 'users.firstname', 'users.lastname', 'qa_tasks.task_id', 'qa_tasks.qa_id', DB::raw('COUNT(*) AS total_task'))
                    ->groupBy('qa_tasks.task_id', 'qa_tasks.qa_id', 'users.id', 'users.firstname', 'users.lastname')
                    ->orderBy('total_task', 'DESC')
                    ->get()
                    ->toArray();
                if (!$result) {
                    return $qaList;
                } else {
                    return $result;
                }
            }

            return $qaList;
        } catch (\Exception $e) {
            Log::error('MatchingRepository@checkDidMaxTask: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
