<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Представляет контроллер для страницы списка менеджеров.
 *
 * @package App\Http\Controllers
 */
class ManagerListController extends Controller
{
    /**
     * Показывает страницу списка менеджеров.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('admin.managerList', [
            'managers' => Role::getUsersByRoleName('manager'),
            'title' => 'Список менеджеров'
        ]);
    }
}
