<?php

namespace App\Http\Controllers\Web;

use App\Models\BidForSale;
use App\Models\Place;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BidForSaleController extends Controller
{

    /**
     * Показывает список мест.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('manager.placeList', [
            'title' => 'Заявки на продажу места',
            'places' => BidForSale::all()
        ]);
    }

    /**
     * Показывает форму создания места.
     *
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->ability(['super-admin', 'manager'], ['create-place'])) {
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
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->ability(['create-place'], ['super-admin', 'manager'])) {
            $validator = Validator::make($request->all(), [
                'block' => 'required|string|max:255',
                'floor' => 'required|integer',
                'row' => 'required|integer',
                'price' => 'required|integer',
                'place_number' => 'required|string|max:255',
                'status' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->route('auth.manager.places.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            BidForSale::create([
                'block' => $request->input('number'),
                'floor' => $request->input('seller_name'),
                'row' => $request->input('place'),
                'price' => $request->input('phone_number'),
                'place_number' => $request->input('place_number'),
                'status' => $request->input('price'),
            ]);

            return redirect()->route('auth.manager.places.index');
        }

        return redirect('/login');
    }
}
