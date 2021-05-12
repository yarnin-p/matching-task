<?php

namespace App\Modules\Matching\Controllers;

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
    private $projectRepo, $taskRepo, $skillRepo, $matchingRepo;

    /**
     * ProjectController constructor.
     * @param ProjectRepository $projectRepository
     * @param TaskRepository $taskRepository
     */
    public function __construct(
        ProjectRepository $projectRepository,
        TaskRepository $taskRepository,
        SkillRepository $skillRepo,
        MatchingRepository $matchingRepo
    )
    {
        $this->projectRepo = $projectRepository;
        $this->taskRepo = $taskRepository;
        $this->skillRepo = $skillRepo;
        $this->matchingRepo = $matchingRepo;
    }


    public function index(Request $request)
    {
        $skills = $this->skillRepo->getAllSkills($request);
        $projects = $this->projectRepo->getAllProjects($request);
        return view('matching.index', compact(['projects', 'skills']));
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
}
