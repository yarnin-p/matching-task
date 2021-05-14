<?php
namespace App\Modules\Assignment\Interfaces;
use Illuminate\Http\Request;

interface AssignmentRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllAssignmentTasks(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllAssignmentTasksHistory(Request $request);
}
