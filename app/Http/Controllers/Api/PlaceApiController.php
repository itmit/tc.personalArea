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
    public function show(string $block, Request $request): JsonResponse
    { 
        $action = Actions::where('type', '=', 'reservation')->first();
        $places = Place::select('id', 'block', 'floor', 'row', 'place_number', 'status', 'price')
            ->where('block', '=', $block)
            ->where('status', '=', 'Свободен')
            ->orderBy('created_at', 'asc')
            ->offset($request->offset)
            ->limit($request->limit)
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
            'phone' => 'required|min:18',
            'block' => 'required',
            'floor' => 'required',
            'row' => 'required',
            'place_number' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), "Validation error");
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
            return $this->SendError('Reservation error', 'Место уже арендовано');
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
        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array (
            'to' => '/topics/AdminNotification',
            "notification" => [
                "body" => "У вас ".$countOfReservations." необработанных заявок.",
                "title" => "Внимание"
            ]
        );
        $fields = json_encode ( $fields );

        $headers = array (
                'Authorization: key=' . "AAAAcZkfTDU:APA91bGgoysHhtZfk272579GGadndryldrSN49MEIO3QGrgI1aKTYir62YbtVXHEaICk1-G1NIWq9DsmCwQGmcmnqqlXWltysqQRoXPoXEdkvz-1oiHS-cF54VSNsWOvut-I_0gBQgrx",
                'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        curl_exec ( $ch );

        curl_close ( $ch );
    }
}
