<?php

namespace App\Modules\Assignment\Controllers;

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


    public function index(Request $request)
    {
        return view('assignment.index');
    }
}
