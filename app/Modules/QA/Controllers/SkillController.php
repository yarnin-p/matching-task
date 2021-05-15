<?php

namespace App\Modules\QA\Controllers;

use App\Http\Controllers\Controller;
use App\Models\QASkillsModel;
use App\Models\SkillModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;

class SkillController extends Controller
{
    public function __construct()
    {
        DB::enableQueryLog();
    }

    public function getEdit(Request $request)
    {
        $userData = Session::get('user_data');
        $skills = DB::table('skills')
            ->whereNotExists(function ($query) use ($userData) {
                $query->select('*')
                    ->from('qa_skills')
                    ->whereRaw('skills.id = qa_skills.skill_id')
                    ->where('qa_skills.user_id', '=', $userData->id);
            })->get();
//                dd(DB::getQueryLog());
//        $skills = SkillModel::get();
        return view('qa.skill.create', compact('skills'));
    }

    public function postEdit(Request $request)
    {
        $user = $request->session()->get('user_data');
        $skill = $request->input('skills');
        $check_skill = QASkillsModel::where('user_id', $user->id)
            ->where('skill_id', $skill)
            ->first();
        if (!$check_skill) {
            $qa_skill = new QASkillsModel();
            $qa_skill->user_id = $user->id;
            $qa_skill->skill_id = $skill;
            $qa_skill->save();
        }


        return redirect('qa');
    }

    public
    function delete(Request $request)
    {
        $id = $request->input('id');
        $qa_skill = QASkillsModel::find($id);
        if ($qa_skill) {
            $qa_skill->delete();
            return true;
        } else {
            return false;
        }
    }
}
