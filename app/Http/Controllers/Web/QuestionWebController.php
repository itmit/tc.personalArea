<?php

namespace App\Http\Controllers\Web;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class QuestionWebController extends Controller
{
    /**
     * Показывает список заявок на бронирование.
     *
     * @return Factory|View
     */
    public function assignmentIndex()
    {
        return view('admin.questionsList', [
            'title' => 'Переуступка права пользования помещением',
            'link' => 'assignment',
            'questions' => Question::select('*')->where('type', '=', 'assignment')
            ->orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Показывает список заявок на бронирование.
     *
     * @return Factory|View
     */
    public function acquisitionIndex()
    {
        return view('admin.questionsList', [
            'title' => 'Переуступка права пользования помещением',
            'link' => 'acquisition',
            'questions' => Question::select('*')->where('type', '=', 'acquisition')
            ->orderBy('created_at', 'desc')->get()
        ]);
    }

    // /**
    //  * Показывает список заявок на бронирование.
    //  *
    //  * @return Factory|View
    //  */
    // public function selectByType(request $request)
    // {
    //     $response = [];

    //     $questions = Question::select('*')->where('type', $request->input('type'))->orderBy('created_at', 'asc')->get();

    //     foreach ($questions as $item) {
    //         $place = $item->place()->get()->first();
    //         $response[] = [
    //             'id' => $item->id,
    //             'block' => $place->block,
    //             'floor' => $place->floor,
    //             'row' => $place->row,
    //             'place' => $place->place_number,
    //             'name' => $item->name,
    //             'phone' => $item->phone_number,
    //             'text' => $item->text,
    //         ];
    //     }

    //     return response()->json($response);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Question::where('id', '=', $request->id)->delete();
        return response()->json(['succses'=>'Удалено'], 200); 
    }

    /**
     * 
     *
     * @return Factory|View
     */
    public function show($id)
    {
        $bid =  Question::where('id', '=', $id)->first();
        if($bid->type == 'assignment')
        {
            return view('admin.questionDetail', [
                'title' => 'Переуступка прав',
                'bid' => $bid,
                'link' => '/assignment',
                // 'history' => BidForSaleHistory::where('bid', '=', $id)->orderBy('created_at', 'asc')->get()
            ]);
        }
        if($bid->type == 'acquisition')
        {
            return view('admin.questionDetail', [
                'title' => 'Приобретение прав',
                'bid' => $bid,
                'link' => '/acquisition',
                // 'history' => BidForSaleHistory::where('bid', '=', $id)->orderBy('created_at', 'asc')->get()
            ]);
        }
    }

    /**
     * Показывает список заявок на бронирование.
     *
     * @return Factory|View
     */
    public function selectByType(request $request)
    {
        if($request->input('type') == 'untreated')
        {
            $bids = Question::select('*')->where('status', 'не обработана')->where('type', $request->pathname)->orderBy('created_at', 'desc')->get();
        }
        if($request->input('type') == 'in work')
        {
            $bids = Question::select('*')->where('status', 'в работе')->where('type', $request->pathname)->orderBy('created_at', 'desc')->get();
        }
        if($request->input('type') == 'processed')
        {
            $bids = Question::select('*')->where('status', 'отказано')->orWhere('status', 'успешно завершена')->where('type', $request->pathname)->orderBy('created_at', 'desc')->get();
        };

        $path = null;
        if($request->pathname == 'assignment')
        {
            $path = 'assignment';
        };
        if($request->pathname == 'acquisition')
        {
            $path = 'acquisition';
        };

        $response = [];

        foreach ($bids as $item) {
            $place = $item->place()->get()->first();
            $response[] = [
                'path' => $path,
                'id' => $item->id,
                'block' => $place->block,
                'floor' => $place->floor,
                'row' => $place->row,
                'place' => $place->place_number,
                'name' => $item->name,
                'phone' => $item->phone_number,
            ];
        }

        return response()->json($response);
    }
}