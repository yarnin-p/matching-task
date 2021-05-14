<?php

namespace App\Modules\Matching\Interfaces;
use Illuminate\Http\Request;

interface MatchingRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function searchQA(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function saveMatching(Request $request);

    /**
     * @param $qaList
     * @param $taskSize
     * @return mixed
     */
    public function checkQaQualifiedTasks($qaList, $taskSize);
}
