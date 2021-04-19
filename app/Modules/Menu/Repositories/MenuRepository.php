<?php

namespace App\Modules\Menu\Repositories;


use App\Models\MenuModel;
use App\Models\SkillModel;
use App\Modules\Menu\Interfaces\MenuRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;



class MenuRepository implements MenuRepositoryInterface
{
    /**
     * @var MenuModel
     */
    private $menuModel;

    /**
     * MenuRepository constructor.
     * @param MenuModel $menuModel
     */
    public function __construct(MenuModel $menuModel)
    {
        DB::enableQueryLog();
//        var_dump(DB::getQueryLog());exit();
        $this->menuModel = $menuModel;
    }

    /**
     * @param Request $request
     * @return array|false|mixed
     */
    public function getAllMenus(Request $request)
    {
        try {
            return $this->menuModel::all()->toArray();
        } catch (\Exception $e) {
            Log::error('MenuRepository@getAllMenus: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @return false|mixed
     */
    public function getMenu($id)
    {
        try {
            return $this->menuModel::find($id);
        } catch (\Exception $e) {
            Log::error('MenuRepository@getMenu: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }


    /**
     * @param Request $request
     * @return false
     */
    public function createMenu(Request $request)
    {
        try {
            $input['name'] = trim($request->input('skill_name'));
            $input['sort'] = $request->input('description') ? $request->input('description') : "";

            return $this->menuModel::insert($input);
        } catch (\Exception $e) {
            Log::error('MenuRepository@createMenu: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return bool
     */
    public function updateMenu($id, Request $request)
    {
        try {
            $input['description'] = $request->input('description') ? $request->input('description') : "";
            $skill = $this->menuModel::find($id);
            $skill->skill_name = trim($request->input('skill_name'));
            $skill->description = $request->input('description');
            return $skill->save();;
        } catch (\Exception $e) {
            Log::error('MenuRepository@updateMenu: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }

    /**
     * @param $id
     * @return false|mixed
     */
    public function deleteMenu($id)
    {
        try {
            return $this->menuModel::where('id', $id)->delete();
        } catch (\Exception $e) {
            Log::error('MenuRepository@deleteMenu: [' . $e->getCode() . '] ' . $e->getMessage());
            return FALSE;
        }
    }
}
