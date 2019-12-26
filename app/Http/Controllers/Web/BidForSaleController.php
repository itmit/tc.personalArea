<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BidForSale;
use App\Models\BidForSaleHistory;
use App\Models\Place;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'history' => BidForSaleHistory::where('bid', '=', $id)->orderBy('created_at', 'asc')->get()
        ]);
    }

    public function changeBidStatus(Request $request)
    {
        DB::beginTransaction();
        try {
                BidForSale::where('id', '=', $request->bidId)->update([
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
            $bids = BidForSale::select('*')->where('status', 'не обработана')->orderBy('created_at', 'desc')->get();
        }
        if($request->input('type') == 'in work')
        {
            $bids = BidForSale::select('*')->where('status', 'в работе')->orderBy('created_at', 'desc')->get();
        }
        if($request->input('type') == 'processed')
        {
            $bids = BidForSale::select('*')->where('status', 'отказано')->orWhere('status', 'успешно завершена')->orderBy('created_at', 'desc')->get();
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
            ];
        }

        return response()->json($response);
    }
}
