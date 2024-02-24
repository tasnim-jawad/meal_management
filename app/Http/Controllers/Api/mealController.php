<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserMeals;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;



class mealController extends Controller
{
    // public function add_meal(){
    //     return 'text';
    // }

    // public function store()
    // {
    //      dd(request()->all());
    //     $meal = new UserMeals();
    //     $meal->users_id = request()->users_id;
    //     $meal->quantity = request()->quantity;
    //     $meal->date = request()->date;
    //     $meal->save();
    //     return response()->json('message', 'Info save successfully');
    //     return response()->json(['message' => 'Info save successfully'], 200);
    // }

    public function add_meal()
    {
        return view('admin.meal.add_meal');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id', // Assuming user_id must exist in the 'users' table
            'quantity' => 'required|integer|min:1', // Assuming quantity should be an integer greater than or equal to 1
            'date' => 'required|date', // Assuming date should be a valid date format
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // dd(Auth::user());

        $meal = new UserMeals();
        $meal->user_id = $request->user_id;
        $meal->quantity = $request->quantity;
        $meal->date = $request->date;
        $meal->save();

        return back()->with('message', 'Info saved successfully');
    }

    // public function search(Request $request)
    // {
    //     $selectedMonth = $request->input('selectedMonth');
    //     $selectedDate = Carbon::createFromFormat('Y-m-d', date('Y') . '-' . $selectedMonth . '-01');
    //     $meals = UserMeals::whereMonth('date', $selectedDate->month)->get();

    //     return view('admin.meal.all_meal', compact('meals'));
    // }

    public function search(Request $request)
    {
        $selectedDate = $request->input('selectedDate');

        // Query your meals based on the selectedDate
        $meals = UserMeals::whereDate('date', $selectedDate)->get();

        return view('admin.meal.all_meal', compact('meals'));
    }




    public function all_meal()
    {
        return view('admin.meal.all_meal', [
            'meals' => UserMeals::with('user')
                        ->orderBy('date', 'desc')
                        ->latest()
                        ->get()
        ]);
    }

    // public function all_meal()
    // {

    //     $meal=UserMeals::all();
    //     return response()->json(["user" => $meal], 200);
    // }

    public function find($id)
    {
        $meal = UserMeals::find($id);
        return view('admin.meal.edit', compact('meal'));
    }

    // public function find(Request $request, $id)
    // {
    //     $meal = UserMeals::find($id);
    //     return response()->json(["user" => $meal], 200);
    // }



    public function update(Request $request, $id)
    {
        $meal = UserMeals::find($id);
        $meal->user_id = $request->name;
        // $meal->users_id = $request->users_id;
        $meal->quantity = $request->quantity;
        $meal->date = $request->date;
        $meal->update();
        return redirect()->route('admin.meal.all_meal');
    }




    // public function update(Request $request, $id)
    // {
    //     $meal = UserMeals::find($id);
    //     $meal->users_id = $request->users_id;
    //     $meal->quantity = $request->quantity;
    //     $meal->date = $request->date;
    //     $meal->update();
    //     return response()->json(["user" => $meal], 200);
    // }

    public function delete($id)
    {
        UserMeals::where('id', $id)->delete();
        return redirect()->route('admin.meal.all_meal');
    }


    // public function delete($id)
    // {
    //     UserMeals::where('id', $id)->delete();
    //     return response()->json(['message' => 'Info delete successfully'], 200);
    // }

    public function download_pdf($date = null){

        $query  = UserMeals::with('user')
                    ->orderBy('date', 'desc')
                    ->latest();

        // $selectedDate = $request->input('selectedDate');
        // dd($date);
        if($date){
            $query = UserMeals::whereDate('date', $date)
                            ->with('user')
                            ->orderBy('date', 'desc')
                            ->latest();
        }
        // dd($meals);

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
        // $dataArray = [];
        // All_meal_list_load.xlsx


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
