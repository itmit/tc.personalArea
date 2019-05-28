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
     * Обрабатывает запрос на создание места.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'place_number' => 'required|string|max:255',
            'seller_name' => 'required|string|max:30',
            'phone_number' => 'required|string|max:18',
            'price' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError([]);
        }

        $r = BidForSale::create([
            'place_number' => $request->input('place_number'),
            'seller_name' => $request->input('seller_name'),
            'phone_number' => $request->input('phone_number'),
            'price' => $request->input('price'),
        ]);

        return $this->sendResponse($r,'success');
    }
}
