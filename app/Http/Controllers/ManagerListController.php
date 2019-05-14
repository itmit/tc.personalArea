<?php

namespace App\Http\Controllers;

use App\Models\Role;

class ManagerListController extends Controller
{
    public function index()
    {
        return view('admin.managerList', [
            'managers' => Role::getUsersByRoleName('manager'),
            'title'    => 'Список менеджеров'
        ]);
    }
}
