<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BidForSale;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

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
            'title' => 'Заявки на продажу места',
            'bids' => BidForSale::all()
        ]);
    }
}
