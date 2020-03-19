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

class ManagerWasteWebController extends Controller
{
    /**
     * Показывает страницу списка менеджеров.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('admin.managerwasteList', [
            'managers' => Role::getUsersByRoleName('manager-waste'),
            'title' => 'Список менеджеров обходных'
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
            return view('admin.managerwasteCreate', [
                'title' => 'Создание менеджера обходных'
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
                    ->route('auth.admin.managerswaste.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ])->attachRole(Role::where('name', '=', 'manager-waste')->first());

            return redirect()->route('auth.admin.managerswaste.index');
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
        User::where('id', '=', $request->id)->delete();
        return response()->json(['succses'=>'Удалено'], 200); 
    }

    /**
     *
     * Страница редактирования места
     * 
     */
    public function managerEditPage($id)
    {
        return view("admin.editManager", [
            'manager' => User::where('id', '=', $id)->first()
        ]);
    }

    /**
     *
     * Страница редактирования места
     * 
     */
    public function edit($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.managers.edit.{id}', ['id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        User::where('id', '=', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return redirect()->route('auth.admin.managers.index');
    }
}
