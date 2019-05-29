<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PurchaseRequisition;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class PurchaseRequisitionWebController extends Controller
{

    /**
     * Показывает список мест.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('manager.purchaseRequisitionList', [
            'title' => 'Заявки на покупку места',
            'purchaseRequisitions' => PurchaseRequisition::all()
        ]);
    }
}
