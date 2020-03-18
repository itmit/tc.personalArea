<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BidForBuy;
use App\Models\BidForBuyHistory;
use App\Models\Place;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'bids' => BidForBuy::with('place')->where('status', '=', 'не обработана')->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function destroy(Request $request)
    {
        BidForBuy::destroy($request->input('ids'));

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
            'title' => 'Заявка на сдачу в аренду помещения',
            'bid' => BidForBuy::where('id', '=', $id)->orderBy('created_at', 'desc')->first(),
            'history' => BidForBuyHistory::where('bid', '=', $id)->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function changeBidStatus(Request $request)
    {
        DB::beginTransaction();
        try {
                BidForBuy::where('id', '=', $request->bidId)->update([
                    'status' => $request->status
                ]);
                BidForBuyHistory::create([
                    'bid' => $request->bidId,
                    'status' => $request->status,
                    'text' => $request->text
                ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>$e], 500); 
        }

        return response()->json(['succses'=>'Статус обновлен'], 200); 
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
            $bids = BidForBuy::select('*')->where('status', 'не обработана')->orderBy('created_at', 'desc')->get();
        }
        if($request->input('type') == 'in work')
        {
            $bids = BidForBuy::select('*')->where('status', 'в работе')->orderBy('created_at', 'desc')->get();
        }
        if($request->input('type') == 'processed')
        {
            $bids = BidForBuy::select('*')->where('status', 'отказано')->orWhere('status', 'успешно завершена')->orderBy('created_at', 'desc')->get();
        }

        $response = [];

        foreach ($bids as $item) {
            $place = $item->place()->get()->first();
            $response[] = [
                'id' => $item->id,
                'block' => $place->block,
                'floor' => $place->floor,
                'row' => $place->row,
                'place' => $place->place_number,
                'name' => $item->seller_name,
                'phone' => $item->phone_number,
                'text' => $item->text,
            ];
        }

        return response()->json($response);
    }
}
