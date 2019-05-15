<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceListController extends Controller
{
    public function index() {
        return view('manager.placeList', [
            'title' => 'Список мест',
            'places' => Place::all()
        ]);
    }
}
