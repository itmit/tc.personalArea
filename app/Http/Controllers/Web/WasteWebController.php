<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Waste;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class WasteWebController extends Controller
{
    /**
     * Показывает страницу списка менеджеров.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('waste.wasteList', [
            // 'wastes' => Waste::('manager-waste'),
            'title' => 'Список отходных заявок'
        ]);
    }

    /**
     * Показывает форму для создания мэнеджера.
     *
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {        
        return view('waste.wasteCreate', [
            'title' => 'Создание отходной заявки'
        ]);
    }

    /**
     * Обрабатывает запрос на создание менеджера.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'block' => 'required',
                'floor' => 'required',
                'row' => 'required',
                'place_number' => 'required',
                'release_date' => 'required',
            ]);

            $this->place = Place::checkValidPlaceNumber($request->input('block'), $request->input('floor'), $request->input('place_number'), $request->input('row'));

            $validator->after(function ($validator) {
                if ($this->place == null) {
                    $validator->errors()->add('place', 'В этом блоке нет места с указанным номером.');
                }
            });

            if ($validator->fails()) {
                return redirect()
                    ->route('auth.managerwaste.wastes.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            Waste::create([
                'place' => $this->place->id,
                'release_date' => $request->input('release_date'),
                'name' => $request->input('name'),
                'phone' => $request->input('email'),
                'status' => 'активна'
                ]);

            return redirect()->route('auth.admin.managerswaste.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::where('id', '=', $request->id)->delete();
        return response()->json(['succses'=>'Удалено'], 200); 
    }

    public function selectByBlock(Request $request)
    {
        if($request->input('block') == "empty")
        {
            return response()->json([]);
        }
        else
        {
            return response()->json([Place::select('*')->where('block', $request->input('block'))->orderBy('sort', 'asc')->get()]);
        };
    }
}
