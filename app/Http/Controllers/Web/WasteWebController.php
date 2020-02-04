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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
                'release_date' => 'required|date',
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
                'phone' => $request->input('phone'),
                'status' => 'активна'
                ]);

            return redirect()->route('auth.managerwaste.wastes.index');
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
            return response()->json([false]);
        }
        else
        {
            $wastes = Waste::select('*')->where('status', $request->input('type'))->orderBy('created_at', 'desc')->get();

            $response = [];

            foreach ($wastes as $item) {
                $place = $item->place()->get()->first();
                if($place->block != $request->input('block')) continue;
                $response[] = [
                    'id' => $item->id,
                    'block' => $place->block,
                    'floor' => $place->floor,
                    'row' => $place->row,
                    'place' => $place->place_number,
                    'name' => $item->name,
                    'phone' => $item->phone,
                    'release_date' => $item->release_date
                ];
            }

            return response()->json($response);
        };
    }

    public function createExcelFile()
    {
        // Создаем объект класса PHPExcel
        $spreadsheet = new Spreadsheet();
        $spreadsheet->createSheet();

        $wastes = Waste::select('*')->where('status', 'активна')->orderBy('created_at', 'desc')->get();

        $response = [];

        foreach ($wastes as $item) {
            $place = $item->place()->get()->first();
            $response[] = [
                'id' => $item->id,
                'block' => $place->block,
                'floor' => $place->floor,
                'row' => $place->row,
                'place' => $place->place_number,
                'name' => $item->name,
                'phone' => $item->phone,
                'release_date' => $item->release_date
            ];
        }

        self::createExcelActive($spreadsheet, $response);
        self::createExcelUnactive($spreadsheet, $response);

        // Выводим HTTP-заголовки
        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $xlsData = ob_get_contents();
        ob_end_clean();
        echo json_encode('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'.base64_encode($xlsData));
    }

    private function createExcelActive($xls, $response)
    {
        $sheet = $xls->getActiveSheet();
        // Подписываем лист
        $sheet->setTitle('Активные');

        // Вставляем текст в ячейки
        $sheet->setCellValue("A1", 'Блок');
        $sheet->setCellValue("B1", 'Этаж');
        $sheet->setCellValue("C1", 'Ряд');
        $sheet->setCellValue("D1", 'Место');
        $sheet->setCellValue("E1", 'Дата освобождения');
        $sheet->setCellValue("F1", 'Имя');
        $sheet->setCellValue("G1", 'Телефон');
        $sheet->setCellValue("H1", 'Статус');

        for ($i = 0; $i < 9; $i++) {
            for ($j = 2; $j <= count($response); $j++) {
                // Выводим таблицу умножения
                $sheet->setCellValueByColumnAndRow(
                                                $i,
                                                $j,
                                                count($response));
            }
        }
        return $xls;
    }

    private function createExcelUnactive($xls, $response)
    {
        $sheet = $xls->getSheet(1);
        // Подписываем лист
        $sheet->setTitle('Неактивные');

        // Вставляем текст в ячейки
        $sheet->setCellValue("A1", 'Блок');
        $sheet->setCellValue("B1", 'Этаж');
        $sheet->setCellValue("C1", 'Ряд');
        $sheet->setCellValue("D1", 'Место');
        $sheet->setCellValue("E1", 'Дата освобождения');
        $sheet->setCellValue("F1", 'Имя');
        $sheet->setCellValue("G1", 'Телефон');
        $sheet->setCellValue("H1", 'Статус');

        // for ($i = 2; $i < 10; $i++) {
        //     for ($j = 2; $j < 10; $j++) {
        //         // Выводим таблицу умножения
        //         $sheet->setCellValueByColumnAndRow(
        //                                         $i - 2,
        //                                         $j,
        //                                         $i . "x" .$j . "=" . ($i*$j));
        //         // Применяем выравнивание
        //         $sheet->getStyleByColumnAndRow($i - 2, $j)->getAlignment()->
        //                 setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //     }
        // }
    }

}
