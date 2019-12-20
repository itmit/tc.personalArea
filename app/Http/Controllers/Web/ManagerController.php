<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ManagerController extends Controller
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

    /**
     * Показывает форму для создания мэнеджера.
     *
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->ability(['super-admin'], ['create-manager'])) {
            return view('admin.createManager', [
                'title' => 'Создание менеджера'
            ]);
        }

        return redirect('/login');
    }

    /**
     * Обрабатывает запрос на создание менеджера.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->ability(['super-admin'], ['create-manager'])) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->route('auth.admin.managers.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ])->attachRole(Role::where('name', '=', 'manager')->first());

            return redirect()->route('auth.admin.managers.index');
        }

        return redirect('/login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::where('contest_id', '=', $request->id)->delete();
        return response()->json(['succses'=>'Удалено'], 200); 
    }
}
