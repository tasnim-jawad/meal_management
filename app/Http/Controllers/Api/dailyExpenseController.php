<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\daily_expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class dailyExpenseController extends Controller
{
    public function add_expense(){
        return view('admin.daily_expense.add_expense');
    }
    public function store(Request $request)
    {
        // dd($request);
        // dd($request->all());
        // $validator = Validator::make($request->all(),[
            // 'title' => 'required|string|max:255',
            // 'quantity' => 'required|numeric',
            // 'unit' => 'required|string|max:255',
            // 'price' => 'required|numeric',
            // 'total' => 'required|numeric',
            // 'bajar_date' => 'required|date',
        //     'bajar.title.*' => 'required|string|max:255',
        //     'bajar.quantity.*' => 'required|numeric',
        //     'bajar.unit.*' => 'required|string|max:255',
        //     'bajar.price.*' => 'required|numeric',
        //     'bajar.total.*' => 'required|numeric',
        //     'bajar_date' => 'required|date',
        // ]);

        // if ($validator->fails()) {
        //     return back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }
        // dd($request->bajar_date != null);

        if($request->bajar == null){
            // return redirect()->back()->with('message', 'no bajar is added');
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
            // dd($key,$value);
            foreach($value as $index => $item){
                // dd(gettype($item['value']));
                if( $item['value'] == null || $item['value'] == ''){
                    // dd($item['value'],$item['field']);
                    $error_message[$key][]= [
                        'field' => $item['field'],
                    ];
                }

            }
        }


        // dd($bajar_data );
        if($error_message != [] || $bajar_data == null){
            $response = [
                'bajar'=> $error_message,
                'bajar_date'=> $bajar_data
            ];
            // header('Content-Type: application/json');
            return response([
                'status' =>'validation error',
                'data'=>$response,
            ]);
            // return redirect()->back()->with('response', $response);
        }



        // dd($request->bajar);

        foreach($request->bajar as $value){
            // dd($value['title']);
            $expense = new daily_expense();
            $expense->title =$value['title'];
            $expense->quantity = $value['quantity'];
            $expense->unit = $value['unit'];
            $expense->price = $value['price'];
            $expense->total = $value['total'];
            $expense->bajar_date = $bajar_data;
            // dd($expense);
            $expense->save();
        }

        return redirect()->back()->with('message', 'Info save successfully');
    }

    public function all_expense()
    {
        // $totalExpense = ;
        // dd($totalExpense);
        return view ('admin.daily_expense.all_expense', [
            'expense' => daily_expense::all(),
            'total_expense' => daily_expense::sum('total')
        ]);
    }

    // public function all_expense(){
    //     $expense=daily_expense::all();
    //     return response()->json(["expenses" => $expense], 200);
    // }

    public function find($id)
    {
        $expense = daily_expense::find($id);
        return view('admin.daily_expense.edit', compact('expense'));
    }

    // public function find($id)
    // {
    //     $expense = daily_expense::find($id);
    //     return response()->json(["expenses" => $expense], 200);
    // }
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

    // public function update(Request $request, $id)
    // {
    //     $expenses = daily_expense::find($id);
    //     $expenses->title=$request->title	;
    //     $expenses->quantity =$request->quantity;
    //     $expenses->unit =$request->unit;
    //     $expenses->price =$request->price;
    //     $expenses->total =$request->total;
    //     $expenses->bajar_date =$request->bajar_date;
    //     $expenses->status =$request->status;
    //     $expenses->update();
    //     return response()->json(["meal" => $expenses], 200);
    // }

    public function delete($id)
    {
        // @dd($id);
        daily_expense::where('id', $id)->delete();
        return redirect()->route('admin.daily_expense.all_expense');

    }


    // public function delete($id)
    // {
    //     daily_expense::where('id', $id)->delete();
    //     return response()->json(['message' => 'Info delete successfully'], 200);
    // }

    public function search(Request $request)
    {
        $searchText = $request->input('searchText');
        $selectedDate = $request->input('selectedDate');
        $total_expense = daily_expense::sum('total');

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

        $expense = $query->get();

        return view('admin.daily_expense.all_expense', compact('expense','total_expense'));
    }

}
