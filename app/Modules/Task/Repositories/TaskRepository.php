<?php

namespace App\Modules\Task\Repositories;


use App\Models\QATasksModel;
use App\Modules\Task\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\ProjectModel;
use App\Models\TaskModel;
use Illuminate\Support\Facades\Session;


class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @var UserModel
     */
    private $projectModel, $taskModel, $qaTaskModel;

    /**
     * ProjectRepository constructor.
     * @param ProjectModel $projectModel
     */
    public function __construct(ProjectModel $projectModel, TaskModel $taskModel, QATasksModel $qaTaskModel)
    {
        DB::enableQueryLog();
//        var_dump(DB::getQueryLog());exit();
        $this->projectModel = $projectModel;
        $this->taskModel = $taskModel;
        $this->qaTaskModel = $qaTaskModel;
    }

    /**
     * @param Request $request
     * @param $projectId
     * @return false|mixed
     */
    public function getAllTasksByProject(Request $request, $projectId)
    {
        try {
            return $this->taskModel::join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.*', 'projects.project_name')
                ->where('project_id', $projectId)
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            Log::error('TaskRepository@getAllTasksByProject: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param Request $request
     * @param $projectId
     * @return false|mixed
     */
    public function getAllTasksProcessByProject(Request $request, $projectId)
    {
        try {
            return $this->taskModel::join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.*', 'projects.project_name')
                ->where('project_id', $projectId)
                ->where('tasks.status', 'process')
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            Log::error('TaskRepository@getAllTasksProcessByProject: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param Request $id
     * @return false|mixed
     */
    public function getTask($id)
    {
        try {
            return $this->taskModel::find($id);
        } catch (\Exception $e) {
            Log::error('TaskRepository@getTask: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param Request $request
     * @param $projectId
     * @return false|mixed
     */
    public function createTask(Request $request, $projectId)
    {
        try {
            $period_date = explode('-', $request->input('period_date'));

            $input['project_id'] = $projectId;
            $input['task_name'] = trim($request->input('task_name'));
            $input['description'] = $request->input('description') ? $request->input('description') : "";
            $input['start_date'] = defaultDateFormat($period_date[0]);
            $input['end_date'] = defaultDateFormat($period_date[1]);

            return $this->taskModel::insert($input);
        } catch (\Exception $e) {
            Log::error('TaskRepository@createTask: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return bool
     */
    public function updateTask($id, Request $request)
    {
        try {
            $period_date = explode('-', $request->input('period_date'));
            $task = $this->taskModel::find($id);
            $task->task_name = trim($request->input('task_name'));
            $task->description = $request->input('description') ? $request->input('description') : "";
            $task->start_date = defaultDateFormat($period_date[0]);
            $task->end_date = defaultDateFormat($period_date[1]);
            return $task->save();
        } catch (\Exception $e) {
            Log::error('TaskRepository@updateTask: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return false|mixed
     */
    public function deleteTask($id, Request $request)
    {
        try {
            return $this->taskModel::where('id', $id)->delete();
        } catch (\Exception $e) {
            Log::error('TaskRepository@deleteTask: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $taskId
     * @return bool
     */
    public function commitTask($taskId)
    {
        try {
            $userData = Session::get('user_data');
            $this->qaTaskModel::where('task_id', $taskId)
                ->where('qa_id', $userData->id)
                ->update(['status' => 'complete', 'updated_at' => date('Y-m-d H:i:s')]);
            $this->taskModel::where('id', $taskId)->update(['status' => 'complete']);
            return TRUE;
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('TaskRepository@deleteTask: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    public function getAllHistorySuccessTasks()
    {
        try {
            $userData = Session::get('user_data');
            return DB::table('qa_tasks')
                ->join('tasks', 'qa_tasks.task_id', '=', 'tasks.id')
                ->where('qa_tasks.qa_id', '=', $userData->id)
                ->where('tasks.status', '=', 'complete')
                ->select('tasks.task_name', 'tasks.start_date', 'tasks.end_date', 'qa_tasks.updated_at')
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            Log::error('TaskRepository@getAllHistorySuccessTasks: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
