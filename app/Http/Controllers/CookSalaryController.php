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
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;
        $cook_salary_all = daily_expense::whereYear('bajar_date',$year)
                                        ->whereMonth('bajar_date',$month)
                                        ->where('unit', 'salary')
                                        ->where('title', 'khala')
                                        ->get();
        $cook_salary_total = $cook_salary_all->sum('total');
        // dd($cook_salary_all);
        return view('admin.cook_salary.all_cook_salary',compact('cook_salary_all','cook_salary_total'));
    }

    public function all_cook_salary_search(){
        $selected_month = request()->search . '-01';
        $carbon_date = Carbon::parse($selected_month);
        $month = $carbon_date->month;
        $year = $carbon_date->year;
        $cook_salary_all = daily_expense::whereYear('bajar_date',$year)
                                        ->whereMonth('bajar_date',$month)
                                        ->where('unit', 'salary')
                                        ->where('title', 'khala')
                                        ->get();
        $cook_salary_total = $cook_salary_all->sum('total');

        return view('admin.cook_salary.all_cook_salary',compact('cook_salary_all','cook_salary_total'));
    }

    public function add_cook_salary(){
        $date = Carbon::now()->toDateString();
        return view('admin.cook_salary.add_cook_salary',compact('date'));
    }
    public function pay_cook_salary(){
        // $date = Carbon::now()->toDateString();
        $selected_month = request()->month . '-01';
        $carbon_date = Carbon::parse($selected_month);
        $month = $carbon_date->month;
        $year = $carbon_date->year;
        // dd($month,$year);

        $this_month_cook_salary = daily_expense::whereYear('bajar_date',$year)
                                            ->whereMonth('bajar_date',$month)
                                            ->where('unit', 'salary')
                                            ->where('title', 'khala')
                                            ->get();

        $isPaid = $this_month_cook_salary->every(function ($expense) {
            return $expense->status === 1;
        });

        if ($isPaid) {
            Toastr::info('Cook salary already paid this month');
            return redirect()->back();
        }

        $this_month_cook_salary_pay = daily_expense::whereYear('bajar_date',$year)
                                            ->whereMonth('bajar_date',$month)
                                            ->where('unit', 'salary')
                                            ->where('title', 'khala')
                                            ->update(['status' => 1]);

        if ($this_month_cook_salary_pay) {
            Toastr::info('Cook salary paid successfully');
            return redirect()->route('admin.dashboard.home');
        }else {
            Toastr::error('Failed to pay cook salary');
            return redirect()->back();
        }
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
            $expense->status = 0;
            $expense->save();

            Toastr::success('Coock salary added successfully', 'Success');
            return redirect()->route('admin.daily_expense.all_cook_salary');
        }else{
            Toastr::error('Coock salary already added in this date', 'ERROR');
            return redirect()->back();
        }
    }

    public function edit_cook_salary($id){
        $cook_salary = daily_expense::where('id', $id)->first();
        // dd($cook_salary);
        return view('admin.cook_salary.edit_cook_salary',compact('cook_salary'));
    }

    public function update_cook_salary(){
        dd(request()->all());
        $validator = Validator::make(request()->all(), [
            'id' => 'required|exists:daily_expenses,id',
            'bajar_date' => 'required',
            'total' => 'required|numeric|gt:0',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error, 'Validation Error');
            }
            return back()->withErrors($validator)->withInput();
        }

        $check_date = daily_expense::where('unit', 'salary')
                                    ->where('title', 'khala')
                                    ->where('bajar_date', request()->bajar_date)
                                    ->exists();

        $expense = daily_expense::find(request()->id);
        if(!$check_date){
            $expense->bajar_date = request()->bajar_date;
            $expense->total = request()->total;
            $expense->save();

            Toastr::success('Coock salary updated successfully', 'Success');
            return redirect()->route('admin.daily_expense.all_cook_salary');
        }else{
            $expense->total = request()->total;
            $expense->save();

            Toastr::success('Coock salary Amount updated successfully', 'Success');
            return redirect()->route('admin.daily_expense.all_cook_salary');
        }
    }

    public function delete_cook_salary(){
        $validator = Validator::make(request()->all(), [
            'id' => 'required|exists:daily_expenses,id',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error, 'Validation Error');
            }
            return back()->withErrors($validator)->withInput();
        }

        $salary = daily_expense::find(request()->id);
        $salary->delete();
        Toastr::success('Cook salary record deleted successfully.', 'Success');
        return redirect()->route('admin.daily_expense.all_cook_salary');
    }

}
