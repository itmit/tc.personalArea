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
     * Обрабатывает запрос на создание места.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'PlaceNumber' => 'required|string|max:255',
            'Block' => 'required|string|max:255',
            'Name' => 'required|string|max:30|min:3',
            'Row' => 'required|string',
            'PhoneNumber' => 'required|string|max:18|min:18',
            'Floor' => 'required|string|max:255'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError('Validation error.', $validator->errors()->first());
        }

        $this->place = Place::checkValidPlaceNumber($request->input('Block'), $request->input('Floor'), $request->input('PlaceNumber'), $request->input('Row'));  

        $validator->after(function ($validator) {
            if ($this->place == null) {
                $validator->errors()->add('PlaceNumber', 'В этом блоке нет места с указанным номером.');
            }
        });

        if ($validator->fails()) {
            return $this->sendError('Validation error.', $validator->errors()->first());
        }       
        
        $newBidForSale = BidForSale::create([
            'place' => $this->place->id,
            'seller_name' => $request->Name,
            'phone_number' => $request->PhoneNumber
        ]);

        return $this->sendResponse([
            'place' => $newBidForSale->place,
            'seller_name' => $newBidForSale->seller_name,
            'phone_number' => $newBidForSale->phone_number
        ],'success');
    }
}
