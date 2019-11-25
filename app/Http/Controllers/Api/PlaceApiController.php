<?php

namespace App\Http\Controllers\Api;

use App\Models\Place;
use App\Models\Client;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\Actions;
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
    public function show(string $block, int $offset = 0, int $limit = 100): JsonResponse
    { 
        $action = Actions::where('type', '=', 'reservation')->first();
        $places = Place::select('id', 'block', 'floor', 'row', 'place_number', 'status', 'price')
            ->where('block', '=', $block)
            ->inRandomOrder()
            ->offset($offset)
            ->limit($limit)
            ->get();
        foreach ($places as $place) {
            $reservation = Reservation::where([
                ['accepted', '=', '1'],
                ['place_id', '=', $place->id],
            ])->first();
            if($reservation != NULL && $reservation->accepted == 1)
            {
                $lastAction = ReservationHistory::where('bid', '=', $reservation->id)->latest()->first();
                if($lastAction->action == $action->id)
                {
                    $ends_at = date("Y-m-d H:i:s", strtotime($lastAction->created_at . " + " . $lastAction->timer ." hours"));
                    $place['reservation'] = $ends_at;
                }
                
            }
            else
            {
                $place['reservation'] = NULL;
            }
        }
        
        return $this->sendResponse(
            $places->toArray(),
            "Places in block \"$block\"");
    }

    public function showPlacesInBlockWithStatus(string $block, string $status)
    {
        $today = date("Y-m-d H:i:s");    
        $action = Actions::where('type', '=', 'reservation')->first();
        $places = Place::select('id', 'block', 'floor', 'row', 'place_number', 'status', 'price')
            ->where('block', '=', $block)
            ->where('status', '=', $status)->get();
        foreach ($places as $place) {
            $reservation = Reservation::where([
                ['accepted', '=', '1'],
                ['place_id', '=', $place->id],
            ])->first();
            if($reservation != NULL && $reservation->accepted == 1)
            {
                $lastAction = ReservationHistory::where('bid', '=', $reservation->id)->latest()->first();
                if($lastAction->action == $action->id)
                {
                    $ends_at = date("Y-m-d H:i:s", strtotime($lastAction->created_at . " + " . $lastAction->timer ." hours"));
                    $place['reservation'] = $ends_at;
                }
                
            }
            else
            {
                $place['reservation'] = NULL;
            }
        }
        
        return $this->sendResponse(
            $places->toArray(),
            "Places in block \"$block\", with status $status retrieved successfully.");
    }

    public function checkValidPlaceNumber(Request $request)
    {
        return Place::checkValidPlaceNumber($request->input('Block'), $request->input('Floor'), $request->input('PlaceNumber'), $request->input('row'));
    }

    public function makeReservation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'block' => 'required',
            'floor' => 'required',
            'row' => 'required',
            'place_number' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), "Validation error", 401);
        }

        $this->place = Place::checkValidPlaceNumber($request->input('block'), $request->input('floor'), $request->input('place_number'), $request->input('row'));

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
                'rating' => 0
            ]);

            $clientId = $newClient->id;
        }
        else
        {
            $clientId = $client->id;
        }

        $isReserved = Reservation::latest()->where('place_id', '=', $this->place->id)->where('accepted', '=', '1')->first();
        $isTaken = Place::where('id', '=', $this->place->id)->first();
        if($isReserved || $isTaken->status == 'Арендован')
        {
            return $this->SendError('Reservation error', 'Место уже забронировано', 401);
        }
        else
        {
            $newReserved = Reservation::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'client' => $clientId,
                'place_id' => $this->place->id,
                'expire' => 0,
                
            ]);

            $countOfReservations = Reservation::where('accepted', '=', '0')->get();
            $countOfReservations = $countOfReservations->count();
            if($countOfReservations == 1)
            {
                $secs = 15 * 60;

                Reservation::where('id', '=', $newReserved->id)->update([
                    'expires_at' => date("Y-m-d H:i:s", strtotime($newReserved->created_at . " + " . $secs ." seconds"))
                ]);
            }
            else
            {
                $secs = 10 * 60;

                Reservation::where('id', '=', $newReserved->id)->update([
                    'expires_at' => date("Y-m-d H:i:s", strtotime($newReserved->created_at . " + " . $secs ." seconds"))
                ]);
            }
            
            if($newReserved)
            {
                $create = Actions::where('type', '=', 'create')->first();

                $newReservetionHistory = ReservationHistory::create([
                    'bid' => $newReserved->id,
                    'action' => $create->id
                ]);

                $newReserved['countOfReservations'] = $countOfReservations;

                if($newReservetionHistory)
                {
                    if ($countOfReservations % 5 == 0)
                    {
                        $this->SendPush($countOfReservations);
                    }

                    return $this->sendResponse(
                        $newReserved->toArray(),
                        'Reserved');
                }
            }
        }
    }

    private function SendPush(int $countOfReservations)
    {
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/tc-gardener/messages:send");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"message":{"notification":{"body":"У вас '.$countOfReservations.' необработанных заявок.","title":"Внимание"},"topic":"AdminNotification"}}');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization : Bearer ya29.ImOyB2NvUZji_VZEKsK22DR6SRsnxIbqNbkD_kCUQuOSQ_UdXyDWk-bLMyGqHdf-auwSH0L4AaukaJADR9hH2Q-tFVUz-vGOBoBeICrBadBadi9ev3Qt1zNDm4ZuAsVGgHxw9No"
        ]);

        curl_exec($ch);

        curl_close($ch); 
    }
}
