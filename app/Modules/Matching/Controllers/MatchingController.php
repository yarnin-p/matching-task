<?php

namespace App\Modules\Matching\Controllers;

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

class MatchingController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $projectRepo, $taskRepo;

    /**
     * ProjectController constructor.
     * @param ProjectRepository $projectRepository
     * @param TaskRepository $taskRepository
     */
    public function __construct(ProjectRepository $projectRepository, TaskRepository $taskRepository)
    {
        $this->projectRepo = $projectRepository;
        $this->taskRepo = $taskRepository;
    }


    public function index(Request $request)
    {
        $results = $this->projectRepo->getAllProjects($request);
        return view('matching.index', compact('results'));
    }

    public function detailView(Request $request, $id)
    {
        $project = $this->projectRepo->getProject($id);
        if ($project) {
            $tasks = $this->taskRepo->getAllTasksByProject($request, $project->id);
            $results['project'] = $project;
            $results['tasks'] = $tasks;
            return view('task.index', compact('results'));
        } else {
            redirect('projects');
        }
    }


    public function createView(Request $request)
    {
        return view('project.create');
    }

    public function editView(Request $request, $id)
    {
        if (!isset($id) && !$id) {
            redirect('projects');
        }

        $result = $this->projectRepo->getProject($id);
        if ($result) {
            return view('project.edit', compact('result'));
        } else {
            redirect('projects');
        }
    }


    public function create(Request $request)
    {
        try {
            $validatorProjectData = Validator::make($request->all(), [
                'project_name' => 'required',
            ]);

            if ($validatorProjectData->fails()) {
                return responseError(422, 422, $validatorProjectData->errors(), []);
            }

            $isProjectCreated = $this->projectRepo->createProject($request);
            if ($isProjectCreated) {
                return responseSuccess(201, 201, 'Created', []);
            }
            return responseError(500, 500, 'Something went wrong!', []);
        } catch (\Exception $e) {
            Log::error('ProjectController@create: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatorProjectData = Validator::make($request->all(), [
                'project_name' => 'required'
            ]);

            if ($validatorProjectData->fails() || !$id) {
                return responseError(422, 422, $validatorProjectData->errors(), []);
            }

            $isProjectUpdated = $this->projectRepo->updateProject($id, $request);
            if ($isProjectUpdated) {
                return responseSuccess(201, 201, 'Updated', []);
            }
            return responseError(500, 500, 'Something went wrong!', []);
        } catch (\Exception $e) {
            Log::error('ProjectController@update: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            if (!$id) {
                return responseError(422, 422, 'id not found!', []);
            }

            $isProjectUpdated = $this->projectRepo->deleteProject($id, $request);
            if ($isProjectUpdated) {
                return responseSuccess(200, 200, 'Deleted', []);
            }
            return responseError(500, 500, 'Something went wrong!', []);
        } catch (\Exception $e) {
            Log::error('ProjectController@delete: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
