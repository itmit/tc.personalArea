<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BidForBuy;
use App\Models\Place;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\BidForBuyApiController;

class BidForBuyWebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('manager.bidForBuyList', [
            'title' => 'Заявки на сдачу в аренду помещения',
            'bids' => BidForBuy::with('place')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.bidForBuyCreate', [
            'title' => 'Создать заявку покупка (для теста!!!)'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $apiController = new BidForBuyApiController;
        return $apiController->store($request);
    }
}
