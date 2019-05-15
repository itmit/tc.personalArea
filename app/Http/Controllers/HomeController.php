<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function index()
    {
        if (Auth::user()->hasRole('super-admin')) {
            return view("admin.home", [
                'title' => 'Главная'
            ]);
        } elseif (Auth::user()->hasRole('manager')) {
            return view("manager.home", [
                'title' => 'Главная'
            ]);
        } else {
            return redirect('/login');
        }
    }
}
