<?php

namespace App\Http\Controllers;

use App\Models\daily_expense;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CookSalaryController extends Controller
{
    public function all_cook_salary(){
        $cook_salary_all = daily_expense::where('unit', 'salary')
                            ->where('title', 'khala')
                            ->orderBy('bajar_date', 'ASC')
                            ->get();
        $cook_salary_total = $cook_salary_all->sum('total');
        // dd($cook_salary_all);
        return view('admin.cook_salary.all_cook_salary',compact('cook_salary_all','cook_salary_total'));
    }

    public function all_cook_salary_search(){
        $search_date = request()->search;
        $cook_salary_all = daily_expense::where('unit', 'salary')
                                ->where('title', 'khala')
                                ->where('bajar_date', $search_date)
                                ->get();
        $cook_salary_total = $cook_salary_all->sum('total');

        return view('admin.cook_salary.all_cook_salary',compact('cook_salary_all','cook_salary_total'));
    }

    public function add_cook_salary(){
        $date = Carbon::now()->toDateString();
        return view('admin.cook_salary.add_cook_salary',compact('date'));
    }

    public function store_cook_salary(){
        $validator = Validator::make(request()->all(), [
            'bajar_date' => 'required',
            'total' => 'required|numeric|gt:0',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error, 'Validation Error');
            }
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // $date = Carbon::parse(request()->bajar_date);
        // $year = $date->year;
        // $month = $date->month;
        // dd($date,$month,$year);

        $check_date = daily_expense::where('unit', 'salary')
                                    ->where('title', 'khala')
                                    ->where('bajar_date', request()->bajar_date)
                                    ->exists();
        // dd(request()->bajar_date,request()->total);
        if(!$check_date){
            $expense = new daily_expense();
            $expense->title = 'khala';
            $expense->unit = 'salary';
            $expense->bajar_date = request()->bajar_date;
            $expense->total = request()->total;
            $expense->save();

            Toastr::success('Coock salary added successfully', 'Success');
            return redirect()->route('admin.daily_expense.all_cook_salary');
        }else{
            Toastr::error('Coock salary already added in this date', 'ERROR');
            return redirect()->back();
        }
    }

    public function edit_cook_salary($id){
        $cook_salary = daily_expense::where('id', $id)->get();
        return view('admin.cook_salary.edit_cook_salary',compact('cook_salary'));
    }

    public function update_cook_salary(){

        return view('admin.cook_salary.edit_cook_salary');
    }

}
