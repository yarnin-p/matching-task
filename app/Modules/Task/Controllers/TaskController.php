<?php

namespace App\Modules\Task\Controllers;

use App\Modules\Project\Repositories\ProjectRepository;
use App\Modules\Task\Repositories\TaskRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class TaskController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $projectRepo, $taskRepo;

    /**
     * TaskController constructor.
     * @param ProjectRepository $projectRepository
     * @param TaskRepository $taskRepository
     */
    public function __construct(ProjectRepository $projectRepository, TaskRepository $taskRepository)
    {
        $this->projectRepo = $projectRepository;
        $this->taskRepo = $taskRepository;
    }

    public function taskCreateView(Request $request, $projectId)
    {
        $result = $this->projectRepo->getProject($projectId);
        return view('task.create', compact('result'));
    }

    public function taskEditView(Request $request, $projectId, $taskId)
    {
        if (!$projectId) {
            redirect('projects');
        }

        if (!$taskId) {
            redirect('projects/' . $projectId . '/tasks');
        }

        $task = $this->taskRepo->getTask($taskId);
        $project = $this->projectRepo->getProject($projectId);
        if ($task && $project) {
            $result['task'] = $task;
            $result['project'] = $project;

            return view('task.edit', compact('result'));
        } else {
            redirect('projects');
        }
    }

    public function detailView(Request $request, $id)
    {
        $project = $this->projectRepo->getProject($id);
        if ($project) {
            $tasks = $this->taskRepo->getAllTasksByProject($project->id);
            if ($tasks) {
                return view('project.detail', compact('$tasks'));
            } else {
                redirect('projects');
            }
        } else {
            redirect('projects');
        }
    }

    public function create(Request $request)
    {
        try {
            $validatorTaskData = Validator::make($request->all(), [
                'task_name' => 'required',
                'period_date' => 'required'
            ]);

            if ($validatorTaskData->fails() || !$request->input('project_id')) {
                return responseError(422, 422, $validatorTaskData->errors(), []);
            }

            $isTaskCreated = $this->taskRepo->createTask($request, $request->input('project_id'));
            if ($isTaskCreated) {
                return responseSuccess(201, 201, 'Created', []);
            }
            return responseError(500, 500, 'Something went wrong!', []);
        } catch (\Exception $e) {
            Log::error('TaskController@create: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatorTaskData = Validator::make($request->all(), [
                'task_name' => 'required',
                'period_date' => 'required'
            ]);

            if ($validatorTaskData->fails() || !$id) {
                return responseError(422, 422, $validatorTaskData->errors(), []);
            }

            $isTaskUpdated = $this->taskRepo->updateTask($id, $request);
            if ($isTaskUpdated) {
                return responseSuccess(201, 201, 'Updated', []);
            }
            return responseError(500, 500, 'Something went wrong!', []);
        } catch (\Exception $e) {
            Log::error('TaskController@update: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    public function delete(Request $request, $projectId, $taskId)
    {
        try {
            if (!$taskId) {
                return responseError(422, 422, 'Task id not found!', []);
            }

            $isTaskDeleted = $this->taskRepo->deleteTask($taskId, $request);
            if ($isTaskDeleted) {
                return responseSuccess(200, 200, 'Deleted', []);
            }
            return responseError(500, 500, 'Something went wrong!', []);
        } catch (\Exception $e) {
            Log::error('TaskController@delete: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
