<?php
namespace App\Modules\Project\Interfaces;
use Illuminate\Http\Request;

interface ProjectRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllProjects(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function getProject(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function createProject(Request $request);

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateProject($id, Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteProject($id, Request $request);
}
