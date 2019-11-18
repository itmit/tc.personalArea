<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Asan\PHPExcel\Excel;
use Asan\PHPExcel\Reader\Xlsx;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PlaceController extends Controller
{

    /**
     * Показывает список мест.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('manager.placeList', [
            'title' => 'Список мест',
            'places' => Place::select('*')->orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Показывает форму создания места.
     *
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->can('create-place') || $user->hasRole(['super-admin', 'manager'])) {
            return view('manager.createPlace', [
                'title' => 'Создание места'
            ]);
        }

        return redirect('/login');
    }

    /**
     * Обрабатывает запрос на создание места.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->can('create-place') || $user->hasRole(['super-admin', 'manager'])) {
            $validator = $this->getValidator($request->all());

            if ($validator->fails()) {
                return redirect()
                    ->route('auth.manager.places.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            Place::create([
                'block' => $request->input('block'),
                'floor' => $request->input('floor'),
                'row' => $request->input('row'),
                'price' => $request->input('price'),
                'place_number' => $request->input('place_number'),
                'status' => $request->input('status'),
            ]);

            return redirect()->route('auth.manager.places.index');
        }

        return redirect('/login');
    }

    public function destroy(Request $request)
    {
        Place::destroy($request->input('ids'));

        return response()->json(['Places destroyed']);
    }

    public function getPlacesByBlock(Request $request)
    {
        if($request->input('block') == "По-умолчанию")
        {
            return response()->json([Place::select('*')->orderBy('created_at', 'desc')->get()]);
        }
        else
        {
            return response()->json([Place::select('*')->where('block', $request->input('block'))->orderBy('created_at', 'desc')->get()]);
        }
        
        

        // echo $request->input('block');
    }

    public function importFromExcel(Request $request)
    {
        if ($request->hasFile('excel')) {
            $file = $request->file('excel');
            if ($file->isValid()) {

                $path = storage_path() . '/app/' . $file->store('temp');

                $reader = Excel::load(
                    $path,
                    function (Xlsx $reader) {
                        $reader->setColumnLimit(4);
                        $reader->ignoreEmptyRow(false);
                    });

                DB::beginTransaction();

                $first = true;
                foreach ($reader as $row) {
                    if ($first) {
                        $first = false;
                        continue;
                    }

                    $row[3] = $row[3] ? $row[3] : 1;

                    if (Place::where('block', '=', $row[0])
                        ->where('row', '=', (string)$row[2])
                        ->where('place_number', '=', (string)$row[3])
                        ->where('floor', '=', $row[1])
                        ->get()->first() !== null
                        ) {
                            continue;
                    }

                    $data = [
                        'block' => $row[0],
                        'row' => (string)$row[2],
                        'place_number' => (string)$row[3],
                        'floor' => $row[1],
                        'status' => $request->input('status')
                    ];

                    $validator = $this->getValidator($data);

                    if ($validator->fails()) {

                        DB::rollBack();
                        return redirect()
                            ->route('auth.manager.places.index')
                            ->withErrors($validator)
                            ->withInput();
                    }

                    if ($data['floor']) {
                        Place::create([
                            'block' => $data['block'],
                            'floor' => $data['floor'],
                            'row' => $data['row'],
                            'place_number' => $data['place_number'],
                            'status' => $request->input('status'),
                        ]);
                    } else {
                        Place::create([
                            'block' => $data['block'],
                            'row' => $data['row'],
                            'place_number' => $data['place_number'],
                            'status' => $request->input('status'),
                        ]);

                    }
                }
                unlink($path);
                DB::commit();
            }
        }

        return redirect()->route('auth.manager.places.index');
    }

    /**
     * @param array $data
     * @return Validator
     */
    private function getValidator(array $data)
    {
        return Validator::make($data, [
            'block' => 'required|string|max:255',
            'floor' => 'integer',
            'row' => 'required|string',
            // 'price' => 'integer',
            'place_number' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);
    }

    /**
     * @param array $data
     * @return Validator
     */
    public function changePlaceStatus(Request $request)
    {
        if($request->selectByAccept != 'Свободен' && $request->selectByAccept != 'Арендован' && $request->selectByAccept != 'Забронировано')
        {
            return response()->json(['Invalid status']);
        }

        $place = Place::where('id', '=', $request->place_id)
            ->update(['status' => $request->selectByAccept]);

        return response()->json(['Status updated']);
    }

    /**
     *
     * Страница редактирования места
     * 
     */
    public function placeEditPage($id)
    {
        return view("manager.placeEdit", [
            'place' => Place::where('id', '=', $id)->first()
        ]);
    }

    /**
     *
     * Редактировать выбранное место
     * 
     */
    public function placeEditStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'block' => 'required',
            'floor' => 'required',
            'row' => 'required',
            'place_number' => 'required',
            'status' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.manager.place.edit.'.$request->id)
                ->withErrors($validator)
                ->withInput();
        }

        return 'edited';
    }
}
