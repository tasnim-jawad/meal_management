<?php

namespace App\Http\Controllers;

use App\Models\daily_expense;
use App\Models\User;
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

        $meal_rate = $total_meal != 0 ? $total_expense / $total_meal : 0;
        // dd($meal_rate,$total_expense,$total_meal);
        $due = $total_expense - $total_income;
        // dd($total_income,$total_expense,$due );

        return view('admin.report.index',compact( 'total_meal','total_income','total_expense','due','meal_rate'));
    }

    public function search(Request $request)
    {
        $month_year = $request->month;
        $now = Carbon::parse($month_year);
        $year = $now->year;
        $month = $now->month;
        $monthly_meal = UserMeals::whereYear('date',$year)->whereMonth('date',$month)->get();
        $total_meal = $monthly_meal->sum('quantity');

        $income = UserPayments::whereYear('month',$year)->whereMonth('month',$month)->get();
        $total_income = $income->sum('amount');

        $expense = daily_expense::whereYear('bajar_date',$year)->whereMonth('bajar_date',$month)->get();
        $total_expense = $expense->sum('total');

        $meal_rate = $total_meal != 0 ? $total_expense / $total_meal : 0;
        // dd($meal_rate,$total_expense,$total_meal);
        $due = $total_expense - $total_income;
        // dd($total_income,$total_expense,$due );

        return view('admin.report.index',compact( 'total_meal','total_income','total_expense','due','meal_rate'));
    }

    public function user_report(){
        $users = User::with('user_role')->get();
        // dd($users);
        return view('admin.report.user_report',compact('users'));
    }
    public function user_search($user_id){
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $user = User::where('id',$user_id)->with('user_role')->get()->first();

        $monthly_meal_all = UserMeals::whereYear('date',$year)->whereMonth('date',$month)->get();
        $total_meal_all = $monthly_meal_all->sum('quantity');

        $expense = daily_expense::whereYear('bajar_date',$year)->whereMonth('bajar_date',$month)->get();
        $total_expense = $expense->sum('total');

        $meal_rate = $total_meal_all != 0 ? $total_expense / $total_meal_all : 0;

        $monthly_meal = UserMeals::whereYear('date',$year)->whereMonth('date',$month)->where('user_id', $user_id)->get();
        $total_meal = $monthly_meal->sum('quantity');

        $payment_monthly = UserPayments::whereYear('month',$year)->whereMonth('month',$month)->where('user_id', $user_id)->get();
        $total_payment_monthly = $payment_monthly->sum('amount');

        $payment_all = UserPayments::where('user_id', $user_id)->get();

        return response([
            'status' => 'success',
            'user' => $user,
            'total_meal' => $total_meal,
            'payment_monthly' => $payment_monthly,
            'total_payment_monthly' => $total_payment_monthly,
            'payment_all' => $payment_all,
            'meal_rate' => $meal_rate,
        ]);
    }
}
