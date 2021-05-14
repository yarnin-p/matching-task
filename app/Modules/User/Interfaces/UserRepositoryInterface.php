<?php
namespace App\Modules\User\Interfaces;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllUsers(Request $request);

    /**
     * @param $userId
     * @return mixed
     */
    public function getUser($userId);

    /**
     * @param Request $request
     * @return mixed
     */
    public function createUser(Request $request);

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateUser($id, Request $request);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteUser($id);
}
