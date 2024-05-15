<?php

namespace App\Http\Controllers;

use App\Models\daily_expense;
use App\Models\UserMeals;
use App\Models\UserPayments;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $monthly_meal = UserMeals::whereYear('date',$year)->whereMonth('date',$month)->get();
        $total_meal = $monthly_meal->sum('quantity');

        $income = UserPayments::whereYear('month',$year)->whereMonth('month',$month)->get();
        $total_income = $income->sum('amount');

        $expense = daily_expense::whereYear('bajar_date',$year)->whereMonth('bajar_date',$month)->get();
        $total_expense = $expense->sum('total');

        $meal_rate = $total_expense / $total_meal ;
        // dd($meal_rate,$total_expense,$total_meal);
        $due = $total_expense - $total_income;
        // dd($total_income,$total_expense,$due );

        return view('admin.report.index',compact( 'total_meal','total_income','total_expense','due','meal_rate'));
    }
}
