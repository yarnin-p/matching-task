<?php

namespace App\Modules\Assignment\Controllers;

use App\Modules\Assignment\Repositories\AssignmentRepository;
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


class AssignmentController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $assignmentRepo;

    /**
     * TaskController constructor.
     * @param ProjectRepository $projectRepository
     * @param TaskRepository $taskRepository
     */
    public function __construct(AssignmentRepository $assignmentRepo)
    {
        $this->assignmentRepo = $assignmentRepo;
    }

    public function index(Request $request)
    {
        $resultTasks = $this->assignmentRepo->getAllAssignmentTasks($request);
        return view('assignment.index', compact('resultTasks'));
    }
}
