<?php

namespace App\Modules\Matching\Controllers;

use App\Modules\Assignment\Repositories\AssignmentRepository;
use App\Modules\Matching\Repositories\MatchingRepository;
use App\Modules\Project\Repositories\ProjectRepository;
use App\Modules\Skill\Repositories\SkillRepository;
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
    private $projectRepo, $taskRepo, $skillRepo, $matchingRepo, $assignmentRepo;

    /**
     * MatchingController constructor.
     * @param ProjectRepository $projectRepository
     * @param TaskRepository $taskRepository
     * @param SkillRepository $skillRepo
     * @param MatchingRepository $matchingRepo
     * @param AssignmentRepository $assignmentRepo
     */
    public function __construct(
        ProjectRepository $projectRepository,
        TaskRepository $taskRepository,
        SkillRepository $skillRepo,
        MatchingRepository $matchingRepo,
        AssignmentRepository $assignmentRepo
    )
    {
        $this->projectRepo = $projectRepository;
        $this->taskRepo = $taskRepository;
        $this->skillRepo = $skillRepo;
        $this->matchingRepo = $matchingRepo;
        $this->assignmentRepo = $assignmentRepo;
    }


    public function index(Request $request)
    {
        $skills = $this->skillRepo->getAllSkills($request);
        $projects = $this->projectRepo->getAllProjects($request);
        return view('matching.index', compact(['projects', 'skills']));
    }

    public function history(Request $request)
    {
        $histories = $this->assignmentRepo->getAllAssignmentTasksHistory($request);
        return view('matching.history', compact('histories'));
    }


    public function search(Request $request)
    {
        try {
//            if (!$projectId) {
//                return responseError(422, 422, 'Project id not found!', []);
//            }
            $results = $this->matchingRepo->searchQA($request);
            return responseSuccess(200, 200, 'Successfully', $results);
        } catch (\Exception $e) {
            Log::error('MatchingController@search: [' . $e->getCode() . '] ' . $e->getMessage());
            return responseError(500, 500, 'Something went wrong!', []);
        }
    }

    public function save(Request $request)
    {
        try {
            $this->matchingRepo->saveMatching($request);
            return responseSuccess(201, 201, 'Successfully', $request);
        } catch (\Exception $e) {
            Log::error('MatchingController@save: [' . $e->getCode() . '] ' . $e->getMessage());
            return responseError(500, 500, 'Something went wrong!', []);
        }
    }
}
