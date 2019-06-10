<?php

namespace App\Http\Controllers\Api;

use App\Models\BidForSale;
use App\Models\Place;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BidForSaleApiController extends ApiBaseController
{
    private $place;

    /**
     * Обрабатывает запрос на получение всех мест.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->sendResponse(
            BidForSale::all()->toArray(),
            'Bid for sale retrieved successfully.'
        );
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    private function checkValidPlaceNumber(): bool
    {
        $place = Place::where('place_number', '=', $this->placeNumber)
            ->where('block', '=', $this->block)->first();

        return $place == null;
    }

    /**
     * Обрабатывает запрос на создание места.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        $validator = Validator::make($data, [
            'PlaceNumber' => 'required|string|max:255',
            'Block' => 'required|string|max:255',
            'Name' => 'required|string|max:30',
            'PhoneNumber' => 'required|string|max:18'
        ]);

        $this->place = Place::where('place_number', '=', $data["PlaceNumber"])
            ->where('block', '=', $data["Block"])->first();

        $validator->after(function ($validator) {
            if ($this->place == null) {
                $validator->errors()->add('PlaceNumber', 'In this block there is no place with this number.');
            }
        });


        if ($validator->fails()) {
            return $this->sendError('Validation error.', $validator->errors()->all());
        }

        $r = BidForSale::create([
            'place_number' => $this->place,
            'seller_name' => $data['Name'],
            'phone_number' => $data['PhoneNumber'],
            'price' => 0
        ]);

        return $this->sendResponse($r,'success');
    }
}
