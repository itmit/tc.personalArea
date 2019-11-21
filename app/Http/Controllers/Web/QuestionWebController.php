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
            'questions' => Question::select('*')
            ->orderBy('created_at', 'desc')->get()
        ]);
    }
}