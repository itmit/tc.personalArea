<?php

namespace App\Http\Controllers\Api;

use App\Models\BidForSale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BidForSaleApiController extends ApiBaseController
{
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
        $data = json_decode($request->input('data'), true);
        $validator = Validator::make($data, [
            'PlaceNumber' => 'required|string|max:255',
            'Name' => 'required|string|max:30',
            'PhoneNumber' => 'required|string|max:18'
        ]);

        if ($validator->fails()) {
            return $this->sendError([]);
        }

        $r = BidForSale::create([
            'place_number' => $data['PlaceNumber'],
            'seller_name' => $data['Name'],
            'phone_number' => $data['PhoneNumber'],
            'price' => 0
        ]);

        return $this->sendResponse($r,'success');
    }
}
