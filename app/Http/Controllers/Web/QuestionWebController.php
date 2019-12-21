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
    public function index()
    {
        return view('admin.questionsList', [
            'title' => 'Переуступка права пользования помещением',
            'questions' => Question::select('*')->where('type', '=', 'assignment')
            ->orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Показывает список заявок на бронирование.
     *
     * @return Factory|View
     */
    public function selectByType(request $request)
    {
        return response()->json([Question::select('*')->where('type', $request->input('type'))->orderBy('created_at', 'asc')->get()]);
    }

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
}