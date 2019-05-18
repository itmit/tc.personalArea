<?php

namespace App\Http\Controllers\Api;

use App\Models\Place;

/**
 * Class PlaceApiController
 * @package App\Http\Controllers\Api
 */
class PlaceApiController extends ApiBaseController
{
    public function index()
    {
        $places = Place::select('id', 'block', 'floor', 'row', 'place_number', 'status', 'price')->get();

        return $this->sendResponse($places->toArray(), 'Places retrieved successfully.');
    }
}
