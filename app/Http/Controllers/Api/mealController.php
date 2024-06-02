<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserMeals;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;



class mealController extends Controller
{
    public function add_meal()
    {
        return view('admin.meal.add_meal');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|gt:0',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $meal = new UserMeals();
        $meal->user_id = $request->user_id;
        $meal->quantity = $request->quantity;
        $meal->date = $request->date;
        $meal->save();
        Toastr::success('Meal added successfully','Success');
        return back()->with('message', 'Info saved successfully');
    }

    public function search(Request $request)
    {
        $selectedDate = $request->input('selectedDate');

        // Query your meals based on the selectedDate
        $meals = UserMeals::whereDate('date', $selectedDate)->latest()->paginate(5);

        return view('admin.meal.all_meal', compact('meals'));
    }

    public function all_meal()
    {
        $today = Carbon::now()->format('Y-m-d');
        $meals = UserMeals::with('user')->where('date',$today)->latest()->paginate(30);
        return view('admin.meal.all_meal',compact('meals'));
    }

    public function find($id)
    {
        $meal = UserMeals::find($id);
        return view('admin.meal.edit', compact('meal'));
    }


    public function update(Request $request, $id)
    {
        $meal = UserMeals::find($id);
        $meal->user_id = $request->name;
        $meal->quantity = $request->quantity;
        $meal->date = $request->date;
        $meal->update();
        return redirect()->route('admin.meal.all_meal');
    }

    public function delete($id)
    {
        UserMeals::where('id', $id)->delete();
        return redirect()->route('admin.meal.all_meal');
    }

    public function download_pdf($date = null){

        $query  = UserMeals::with('user')
                    ->orderBy('date', 'desc')
                    ->latest();

        if($date){
            $query = UserMeals::whereDate('date', $date)
                                    ->with('user')
                                    ->orderBy('date', 'desc')
                                    ->latest();
        }

        $meals = $query->get()->toArray();
        $pdf = Pdf::loadView('admin.meal.meal_pdf',compact('meals'));
        return $pdf->download('all_meal.pdf');

    }

    public function download_xlsx($date = null){
        $query  = UserMeals::with('user')->orderBy('date', 'desc')->latest();

        if($date){
            $query = UserMeals::whereDate('date', $date)->with('user')->orderBy('date', 'desc')->latest();
        }

        $meals = $query->get()->toArray();
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load('All_meal_list_load.xlsx');

        $spreadsheet->getActiveSheet()->setCellValue('A1', 'All meal list')
                                    ->getStyle('A1')
                                    ->getAlignment()
                                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()
                            ->setCellValue('A2' , '#srl')
                            ->setCellValue('B2' , 'name')
                            ->setCellValue('C2' , 'mobile')
                            ->setCellValue('D2' , 'quantity')
                            ->setCellValue('E2' , 'date');

        $contentStartRow =3;
        $currentContentRow =3;
        // dd(gettype($meals));
        foreach ($meals as $key=>$meal) {
            // $dataArray[] = [
            //     'srl' => $key+1,
            //     'userName' => $meal['user']['name'],
            //     'userNumber' => $meal['user']['mobile'],
            //     'quantity' => $meal['quantity'],
            //     'mealDate' => $meal['date'],
            // ];
            // dd($meal['user']['name']);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow + 1, 1);
            $spreadsheet->getActiveSheet()
                            ->setCellValue('A'.$currentContentRow , $key + 1)
                            ->setCellValue('B'.$currentContentRow , $meal['user']['name'])
                            ->setCellValue('C'.$currentContentRow , $meal['user']['mobile'],)
                            ->setCellValue('D'.$currentContentRow , $meal['quantity'])
                            ->setCellValue('E'.$currentContentRow , $meal['date']);
            $currentContentRow++;
        }
        foreach (range('A', 'E') as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $spreadsheet->getActiveSheet()->mergeCells('A1:E1');


        // $spreadsheet->getActiveSheet()->fromArray($dataArray, null, 'A1');
        // $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="All_meal_list.xlsx"');
        // header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet,'Xlsx');
        $writer->save('php://output');

    }
}
