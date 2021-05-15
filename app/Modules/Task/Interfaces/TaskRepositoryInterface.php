<?php

namespace App\Modules\Task\Interfaces;

use Illuminate\Http\Request;

interface TaskRepositoryInterface
{
    /**
     * @param Request $request
     * @param $projectId
     * @return mixed
     */
    public function getAllTasksByProject(Request $request, $projectId);

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTask(Request $request);

    /**
     * @param Request $request
     * @param $projectId
     * @return mixed
     */
    public function createTask(Request $request, $projectId);

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateTask($id, Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteTask($id, Request $request);

    /**
     * @param $taskId
     * @return mixed
     */
    public function commitTask($taskId);

    /**
     * @param Request $request
     * @param $projectId
     * @return mixed
     */
    public function getAllTasksOpenByProject(Request $request, $projectId);

    /**
     * @return mixed
     */
    public function getAllHistorySuccessTasks();
}
