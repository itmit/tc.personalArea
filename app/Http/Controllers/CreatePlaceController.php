<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

/**
 * Представляет контроля для создания мест.
 *
 * @package App\Http\Controllers
 */
class CreatePlaceController extends Controller
{

    /**
     * Показывает форму создания места.
     *
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->can('create-place') || $user->hasRole(['super-admin', 'manager'])) {
            return view('manager.createPlace', [
                'title' => 'Создание места'
            ]);
        }

        return redirect('/login');
    }

    /**
     * Обрабатывает запрос на создание места.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function createPlace(Request $request)
    {
        $user = Auth::user();
        if ($user->can('create-place') || $user->hasRole(['super-admin', 'manager'])) {
            $validator = Validator::make($request->all(), [
                'block' => 'required|string|max:255',
                'floor' => 'required|integer',
                'row' => 'required|integer',
                'price' => 'required|integer',
                'place_number' => 'required|string|max:255|min:2',
                'status' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->route('auth.manager.createPlace')
                    ->withErrors($validator)
                    ->withInput();
            }

            Place::create([
                'block' => $request->input('block'),
                'floor' => $request->input('floor'),
                'row' => $request->input('row'),
                'price' => $request->input('price'),
                'place_number' => $request->input('place_number'),
                'status' => $request->input('status'),
            ]);

            return redirect()->route('auth.manager.placeList');
        }

        return redirect('/login');
    }
}
