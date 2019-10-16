<?php

namespace App\Http\Controllers\Web;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class QuestionsWebController extends Controller
{
    /**
     * Показывает список заявок на бронирование.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('manager.reservationList', [
            'title' => 'Заявки на бронь',
            'questions' => Question::select('*')
            ->orderBy('created_at', 'desc')->get()
        ]);
    }
}