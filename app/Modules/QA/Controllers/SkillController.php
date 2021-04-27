<?php

namespace App\Modules\QA\Controllers;

use App\Http\Controllers\Controller;
use App\Models\QASkillsModel;
use App\Models\SkillModel;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function __construct()
    {
    }

    public function getEdit(Request $request)
    {
        $skills = SkillModel::get();
        return view('qa.skill.create', compact('skills'));
    }

    public function postEdit(Request $request)
    {
        $user = $request->session()->get('user_data');
        $skills = $request->input('skills');
        foreach ($skills as $skill) {
            $check_skill = QASkillsModel::where('user_id', $user->id)
                                ->where('skill_id', $skill)
                                ->first();

            if (!$check_skill) {
                $qa_skill = new QASkillsModel();
                $qa_skill->user_id = $user->id;
                $qa_skill->skill_id = $skill;
                $qa_skill->save();
            }
        }

        return redirect('qa');
    }

    public function delete(Request $request)
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
