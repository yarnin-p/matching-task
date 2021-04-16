<?php
namespace App\Modules\WorkExperience\Interfaces;
use Illuminate\Http\Request;

interface WorkExperienceRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
        public function getAllWorkExperiences(Request $request);

    /**
     * @param $id
     * @return mixed
     */
    public function getWorkExperience($id);


    /**
     * @param Request $request
     * @return mixed
     */
    public function createWorkExperience(Request $request);

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateWorkExperience($id, Request $request);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteWorkExperience($id);
}
