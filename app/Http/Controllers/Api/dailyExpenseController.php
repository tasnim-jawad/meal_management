<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\daily_expense;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class dailyExpenseController extends Controller
{
    public function add_expense(){
        return view('admin.daily_expense.add_expense');
    }

    public function store(Request $request)
    {

        if($request->bajar == null){
            return response([
                'status' =>'validation error',
                'message'=> 'Please click the green Add(+) button on the right side and enter your Bajar List.'
            ]);
        }

        $bajar_data = $request->bajar_date;
        $error_message =[];
        $flatArray = [];
        foreach($request->bajar as $key => $item ){

            $keys = array_keys($item);
            $value = array_values($item);

            foreach($keys as $i => $item){
            $flatArray[$key][$i] =[
                'field' => $item,
                'value' => $value[$i]
            ];

            }
        }

        foreach($flatArray as $key => $value){
            foreach($value as $index => $item){
                if( $item['value'] == null || $item['value'] == ''){
                    $error_message[$key][]= [
                        'field' => $item['field'],
                    ];
                }

            }
        }

        if($error_message != [] || $bajar_data == null){
            $response = [
                'bajar'=> $error_message,
                'bajar_date'=> $bajar_data
            ];
            return response([
                'status' =>'validation error',
                'data'=>$response,
            ]);
        }

        foreach($request->bajar as $value){
            $expense = new daily_expense();
            $expense->title =$value['title'];
            $expense->quantity = $value['quantity'];
            $expense->unit = $value['unit'];
            $expense->price = $value['price'];
            $expense->total = $value['total'];
            $expense->bajar_date = $bajar_data;
            $expense->save();
        }
        Toastr::success('bajar save successfully','success');

        return redirect()->back()->with('message', 'bajar save successfully');
    }

    public function all_expense()
    {
        $expenses = daily_expense::paginate(30);
        $total_expense = daily_expense::sum('total');
        return view ('admin.daily_expense.all_expense', [
            'expense' => $expenses,
            'total_expense' => $total_expense,
        ]);
    }

    public function expense_date(){
        $unique_dates = daily_expense::select('bajar_date')->groupBy('bajar_date')->orderBy('bajar_date', 'DESC')->limit(30)->get();
        $result = [];
        foreach($unique_dates->toArray() as $key => $date){
            $expense_date_wise = daily_expense::where('bajar_date',$date['bajar_date'])->get()->sum('total');
            $result[]=[
                $date['bajar_date'] => $expense_date_wise,
            ];
        }
        return view('admin.daily_expense.expense_date',compact('result'));
    }

    public function expense_daily($date){

        $expense = daily_expense::where('bajar_date',$date)->paginate(30);
        $total_expense = $expense->sum('total');

        return view('admin.daily_expense.all_expense', compact('expense','total_expense'));
    }


    public function find($id)
    {
        $expense = daily_expense::find($id);
        return view('admin.daily_expense.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $expenses = daily_expense::find($id);
        $expenses->title=$request->title	;
        $expenses->quantity =$request->quantity;
        $expenses->unit =$request->unit;
        $expenses->price =$request->price;
        $expenses->total =$request->total;
        $expenses->bajar_date =$request->bajar_date;
        // $expenses->status =$request->status;
        $expenses->update();
        return redirect()->route('admin.daily_expense.all_expense');

    }

    public function delete($id)
    {
        daily_expense::where('id', $id)->delete();
        return redirect()->route('admin.daily_expense.all_expense');

    }


    public function search(Request $request)
    {
        $searchText = $request->input('searchText');
        $selectedDate = $request->input('selectedDate');


        $query = daily_expense::query();

        if (!empty($searchText)) {
            $query->where(function ($subQuery) use ($searchText) {
                $subQuery->where('title', 'like', "%$searchText%")
                    ->orWhere('quantity', 'like', "%$searchText%")
                    ->orWhere('unit', 'like', "%$searchText%")
                    ->orWhere('price', 'like', "%$searchText%")
                    ->orWhere('total', 'like', "%$searchText%")
                    ->orWhere('bajar_date', 'like', "%$searchText%");
            });
        }

        if (!empty($selectedDate)) {
            $query->whereDate('bajar_date', $selectedDate);
        }

        $total_expense = $query->sum('total');
        $expense = $query->paginate(30);

        return view('admin.daily_expense.all_expense', compact('expense','total_expense'));
    }

}
