<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BidForSale;
use App\Models\BidForSaleHistory;
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
            'bids' => BidForSale::with('place')->where('status', '=', 'не обработана')->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function destroy(Request $request)
    {
        BidForSale::destroy($request->input('ids'));

        return response()->json(['Bids destroyed']);
    }

    /**
     * 
     *
     * @return Factory|View
     */
    public function show($id)
    {
        return view('manager.bidForSaleDetail', [
            'title' => 'Заявка на аренду помещения',
            'bid' => BidForSale::where('id', '=', $id)->orderBy('created_at', 'desc')->first(),
            'history' => BidForSaleHistory::where('bid', '=', $id)->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function changeBidStatus(Request $request)
    {
        DB::beginTransaction();
        try {
                BidForSale::where('bid', '=', $request->bidId)->update([
                    'status' => $request->status
                ]);
                BidForSaleHistory::create([
                    'bid' => $request->bidId,
                    'status' => $request->status,
                    'text' => $request->text
                ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>'Что-то пошло не так'], 500); 
        }

        return response()->json(['succses'=>'Удалено'], 200); 
    }
}
