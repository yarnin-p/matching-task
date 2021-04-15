<?php

use Illuminate\Http\Request;
use App\Models\RoleMenuModel;
use Illuminate\Support\Facades\Session;
use App\Models\MenuModel;

function displaySideNav()
{
    $sessionUserData = Session::get('user_data');
    $userRoleList = [];
    if (isset($sessionUserData->userRole) && count($sessionUserData->userRole)) {
        foreach ($sessionUserData->userRole as $userRole) {
            if (isset($userRole->role_id)) {
                $userRoleList[] = $userRole->role_id;
            }
        }
    }

    return RoleMenuModel::with(['sysMenu' => function ($q) {
        $q->select('menu_name', 'icon', 'id');
    }])->whereIn('role_id', $userRoleList)->get();
}


