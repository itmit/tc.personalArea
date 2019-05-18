<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Представляет контролер для страницы списка мест.
 *
 * @package App\Http\Controllers
 */
class PlaceListController extends Controller
{
    /**
     * Показывает список мест.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('manager.placeList', [
            'title' => 'Список мест',
            'places' => Place::all()
        ]);
    }
}
