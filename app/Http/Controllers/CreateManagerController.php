<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class CreateManagerController
 * @package App\Http\Controllers
 */
class CreateManagerController extends Controller
{
    /**
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->can('create-manager') || $user->hasRole('super-admin')) {
            return view('admin.createManager', [
                'title' => 'Создание менеджера'
            ]);
        }

        return redirect('/login');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function createManager(Request $request)
    {
        $user = Auth::user();
        if ($user->can('create-manager') || $user->hasRole('super-admin'))
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->route('auth.admin.createManager')
                    ->withErrors($validator)
                    ->withInput();
            }

            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ])->attachRole(Role::where('name', '=', 'manager')->first());

            return redirect()->route('auth.admin.managerList');
        }

        return redirect('/login');
    }
}
