<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use App\Models\Place;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\Actions;
use App\Models\Client;

class QuestionApiController extends ApiBaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required',
            'text' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), "Validation error", 401);
        }

        Question::create([
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'text' => $request->input('text')
        ]);

        return $this->sendResponse([], 'Stored');
    }

    public function test()
    {
        $reservations = Reservation::where('accepted', '=', '1')->get();
        foreach($reservations as $item)
        {
            $history = ReservationHistory::where('bid', '=', $item->id)->latest()->first();
            if($history->action()->type == "reservation")
            {
                $now = time();
                $ends_at = strtotime($history->created_at->timezone('Europe/Moscow') . " + " . $history->timer ." hours");
                return 'id: ' . $item->id . ' now: ' . $now . ' end: ' . $ends_at . ' diff: ' ;
                // if($ends_at <= $stats_at)
                // {
                //     Reservation::where('id', '=', $item->id)->update([
                //         'accepted' => 2
                //     ]);
                // }
            }
        }
    }
}
