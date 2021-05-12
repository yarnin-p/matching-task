<?php

namespace App\Modules\Assignment\Repositories;

use App\Models\QATasksModel;
use App\Modules\Assignment\Interfaces\AssignmentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\ProjectModel;
use App\Models\TaskModel;


class AssignmentRepository implements AssignmentRepositoryInterface
{

    /**
     * @var
     */
    private $qaTaskModel;

    public function __construct(QATasksModel $qaTaskModel)
    {
        DB::enableQueryLog();
//        var_dump(DB::getQueryLog());exit();
        $this->qaTaskModel = $qaTaskModel;
    }


    public function getAllAssignmentTasks(Request $request)
    {
        try {
            $userData = Session::get('user_data');
            return $this->qaTaskModel::where('qa_id', '=', $userData->id);
        } catch (\Exception $e) {
            Log::error('AssignmentRepository@getAllAssignmentTasks: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
