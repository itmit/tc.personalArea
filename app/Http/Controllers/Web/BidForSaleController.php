<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BidForSale;
use App\Models\Place;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\BidForSaleApiController;

class BidForSaleController extends Controller
{

    /**
     * Показывает список мест.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('manager.bidForSaleList', [
            'title' => 'Заявки на аренду помещения',
            'bids' => BidForSale::with('place')->orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.bidForSaleCreate', [
            'title' => 'Создать заявку продажа (для теста!!!)'
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
        $apiController = new BidForSaleApiController;
        return $apiController->store($request);
    }

    public function destroy(Request $request)
    {
        BidForSale::destroy($request->input('ids'));

        return response()->json(['Bids destroyed']);
    }

    /**
     * Показывает список мест.
     *
     * @return Factory|View
     */
    public function show($id)
    {
        return view('manager.bidForSaleDetail', [
            'title' => 'Заявка на аренду помещения',
            'bid' => BidForSale::with('place')->where('id', '=', $id)->orderBy('created_at', 'desc')->get()
        ]);
    }
}
