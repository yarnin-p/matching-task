<?php
namespace App\Modules\Menu\Interfaces;
use Illuminate\Http\Request;

interface MenuRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllMenus(Request $request);

    /**
     * @param $id
     * @return mixed
     */
    public function getMenu($id);


    /**
     * @param Request $request
     * @return mixed
     */
    public function createMenu(Request $request);

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateMenu($id, Request $request);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteMenu($id);
}
