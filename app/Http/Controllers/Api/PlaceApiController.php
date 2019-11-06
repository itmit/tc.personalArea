<?php

namespace App\Http\Controllers\Api;

use App\Models\Place;
use App\Models\Client;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/**
 * Представляет контроллер для обработки api запросов, связаных с сущностью место.
 *
 * @package App\Http\Controllers\Api
 */
class PlaceApiController extends ApiBaseController
{
    /**
     * Обрабатывает запрос на получение всех мест.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->sendResponse(
            Place::select('id', 'block', 'floor', 'row', 'place_number', 'status', 'price')
                ->get()->toArray(),
            'Places retrieved successfully.'
        );
    }

    /**
     * Обрабатывает запрос на получение всех мест в блоке.
     *
     * @param string $block
     * @return JsonResponse
     */
    public function show(string $block): JsonResponse
    {
        return $this->sendResponse(
            Place::select('id', 'block', 'floor', 'row', 'place_number', 'status', 'price')
                ->where('block', '=', $block)->get()->toArray(),
            "Places in block \"$block\" retrieved successfully.");
    }

    public function showPlacesInBlockWithStatus(string $block, string $status)
    {
        return $this->sendResponse(
            Place::select('id', 'block', 'floor', 'row', 'place_number', 'status', 'price')
                ->where('block', '=', $block)
                ->where('status', '=', $status)->get()->toArray(),
            "Places in block \"$block\", with status $status retrieved successfully.");
    }

    public function checkValidPlaceNumber(Request $request)
    {
        return Place::checkValidPlaceNumber($request->input('Block'), $request->input('Floor'), $request->input('PlaceNumber'));
    }

    public function makeReservation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'block' => 'required',
            'floor' => 'required',
            // 'row' => 'required',
            'place_number' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), "Validation error", 401);
        }

        $this->place = Place::checkValidPlaceNumber($request->input('block'), $request->input('floor'), $request->input('place_number'));

        $validator->after(function ($validator) {
            if ($this->place == null) {
                $validator->errors()->add('PlaceNumber', 'В этом блоке нет места с указанным номером.');
            }
        });

        $client = Client::where('phone', '=', $request->input('phone'))->first();
        if($client == NULL)
        {
            $newClient = Client::create([
                'phone' => $request->input('phone'),
                'rating' => 10
            ]);

            $clientId = $newClient->id;
        }
        else
        {
            $clientId = $client->id;
        }

        $isReserved = Reservation::latest()->where('place_id', '=', $this->place->id)->where('accepted', '<>', '2')->first();
        if($isReserved)
        {
            return $this->SendError('Reservation error', 'Место уже забронировано', 401);
        }
        else
        {
            $newReserved = Reservation::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'client' => $clientId,
                'place_id' => $this->place->id
            ]);

            if($newReserved > 0)
            {

                $newReservetionHistory = ReservetionHistory::create([
                    'bid' => $newReserved->id,
                    'action' => 'создание'
                ]);

                if($newReservetionHistory > 0)
                {
                    return $this->sendResponse([
                        $newReserved
                    ],
                        'Reserved');
                }
            }
        }
    }
}
