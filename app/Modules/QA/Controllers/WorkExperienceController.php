<?php

namespace App\Modules\QA\Controllers;

use App\Http\Controllers\Controller;
use App\Models\QAExperiencesModel;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    public function __construct()
    {
    }

    public function getEdit(Request $request, $id=null)
    {
        $qaExperience = QAExperiencesModel::find($id);

        return view('qa.work-experience.edit', compact('qaExperience', 'id'));
    }

    public function postEdit(Request $request, $id=null)
    {
        $user = $request->session()->get('user_data');

        if ($id) $qaExperience = QAExperiencesModel::find($id);
        else $qaExperience = new QAExperiencesModel();

        $qaExperience->user_id = $user->id;
        $qaExperience->organization_name = $request->input('organization');
        $qaExperience->position = $request->input('position');
        $qaExperience->year = $request->input('year');
        $qaExperience->save();

        return redirect('qa');
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $qa_experience = QAExperiencesModel::find($id);
        if ($qa_experience) {
            $qa_experience->delete();
            return true;
        } else {
            return false;
        }
    }

}
