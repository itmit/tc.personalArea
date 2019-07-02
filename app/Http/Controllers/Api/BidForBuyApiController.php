<?php

namespace App\Http\Controllers\Api;

use App\Models\BidForBuy;
use App\Models\Place;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BidForBuyApiController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        return $this->sendResponse(
            BidForBuy::all()->toArray(),
            'Bid for buy retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'PlaceNumber' => 'required|string|max:255',
            'Block' => 'required|string|max:255',
            'Name' => 'required|string|max:30|min:3',
            'PhoneNumber' => 'required|string|max:18|min:18',
            'Floor' => 'required|string|max:255'
        ]);

        $this->place = Place::checkValidPlaceNumber($request->input('Block'), $request->input('Floor'), $request->input('PlaceNumber'));

        $validator->after(function ($validator) {
            if ($this->place == null) {
                $validator->errors()->add('PlaceNumber', 'В этом блоке нет места с указанным номером.');
            }
        });


        if ($validator->fails()) {
            return $this->sendError('Validation error.', $validator->errors()->all());
        }    
        
        $newBidForBuy = BidForBuy::create([
            'place' => $this->place->id,
            'seller_name' => $request->Name,
            'phone_number' => $request->PhoneNumber
        ]);

        return $this->sendResponse([
            'place' => $newBidForBuy->place,
            'seller_name' => $newBidForBuy->seller_name,
            'phone_number' => $newBidForBuy->phone_number
        ],'success');
    }

}
