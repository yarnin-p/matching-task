<?php

namespace App\Modules\QA\Controllers;

use App\Models\QAExperiencesModel;
use App\Models\QASkillsModel;
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

class QAController extends Controller
{

    public function __construct()
    {
        DB::enableQueryLog();
//        var_dump(DB::getQueryLog());exit();
    }

    public function index(Request $request)
    {
        $user = $request->session()->get('user_data');

        $experiences = QAExperiencesModel::where('user_id', $user->id)->get();
        $skills = QASkillsModel::join('skills', 'skills.id', 'qa_skills.skill_id')
                            ->select('qa_skills.id as id', "skills.id as skill_id", "skills.skill_name", "skills.description")
                            ->where('qa_skills.user_id', $user->id)
                            ->whereNull('skills.deleted_at')
                            ->get();
        return view('qa.index', compact('experiences', 'skills'));
    }
}
