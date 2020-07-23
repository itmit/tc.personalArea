<?php

namespace App\Http\Controllers\Api;

use App\Models\BidForSale;
use App\Models\BidForSaleHistory;
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
            'Block' => 'required|string|max:255',
            'Name' => 'required|string|max:30|min:3',
            'Row' => 'required|string',
            'PhoneNumber' => 'required|string|max:18|min:18',
            'Floor' => 'required|string|max:255',
            'Text' => 'required|string'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError('Validation error.', $validator->errors()->first());
        }
        if ($validator->fails()) {
            return $this->sendError('Validation error.', $validator->errors()->first());
        }       
        
        $newBidForSale = BidForSale::create([
            'block' => $request->input('Block'),
            'floor' => $request->input('Floor'),
            'row' => $request->input('Row'),
            'seller_name' => $request->Name,
            'phone_number' => $request->PhoneNumber,
            'text' => $request->Text,
        ]);

        BidForSaleHistory::create([
            'bid' => $newBidForSale->id,
            'status' => 'не обработана',
        ]);

        return $this->sendResponse([
            'seller_name' => $newBidForSale->seller_name,
            'phone_number' => $newBidForSale->phone_number
        ],'success');
    }
}
