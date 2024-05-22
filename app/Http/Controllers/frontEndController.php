<?php

namespace App\Http\Controllers;

use App\Models\daily_expense;
use App\Models\UserMeals;
use App\Models\UserPayments;
use App\Models\MonthlyMealRates;
use App\Models\User;

use Carbon\Carbon;

use Illuminate\Http\Request;

class frontEndController extends Controller
{
    public function index()
    {
        return view('frontEnd.home.home');
    }
    // public function Meal_Booking(){
    //     $meal=UserMeals::sum('quantity');
    //     $payment=UserPayments::sum('amount');

    //     $this_month = Carbon::today();
    //     $Month_check = MonthlyMealRates::whereMonth('month', $this_month)->first();
    //     $mealRate = 0;
    //     if ($Month_check !== null) {
    //         $mealRate = $Month_check->meal_rate;
    //     }

    //     $userinfo = User::where('user_role', 'User')->select('id', 'user_role', 'name', 'mobile')->with(['userpayments' => function ($q) {
    //         $q->select('id', 'amount', 'users_id');
    //     }])->with(['userMeal' => function ($r) {
    //         $r->select('id', 'quantity', 'user_id');
    //     }])
    //         ->withSum('userpayments', 'amount')
    //         ->withSum('userMeal', 'quantity')
    //         ->get();
    //     foreach ($userinfo as $user) {

    //         $total_payable = $mealRate * $user->user_meal_sum_quantity;
    //         $due = $total_payable - $user->userpayments_sum_amount;
    //         $user->due = $due;
    //     }

    //     return view('frontEnd.Meal_Booking.Meal_Booking',compact('meal','payment','userinfo','due'));
    // }

    // public function Meal_Booking(){
    //     $id = auth()->user()->id;

    //     $meal = UserMeals::where('user_id', $id)->sum('quantity');
    //     $payment = UserPayments::where('user_id', $id)->sum('amount');

    //     $this_month = Carbon::today();
    //     $Month_check = MonthlyMealRates::whereMonth('month', $this_month)->first();
    //     $mealRate = 0;
    //     if ($Month_check !== null) {
    //         $mealRate = $Month_check->meal_rate;
    //     }

    //     $userinfo = User::where('id', $id)
    //         ->select('id', 'user_role', 'name', 'mobile')
    //         ->with(['userpayments' => function ($q) {
    //             $q->select('id', 'amount', 'user_id');
    //         }])
    //         ->with(['userMeal' => function ($r) {
    //             $r->select('id', 'quantity', 'user_id');
    //         }])
    //         ->withSum('userpayments', 'amount')
    //         ->withSum('userMeal', 'quantity')
    //         ->get();

    //     foreach ($userinfo as $user) {
    //         $total_payable = $mealRate * $user->userMeal_sum_quantity;
    //         $due = $total_payable - $user->userpayments_sum_amount;
    //         $user->due = $due;
    //     }

    //     return view('frontEnd.Meal_Booking.Meal_Booking', compact('meal', 'payment', 'userinfo','due'));
    // }

    // public function Meal_Booking(){
    //     $id = auth()->user()->id;

    //     $meal = UserMeals::where('user_id', $id)->sum('quantity');
    //     $payment = UserPayments::where('user_id', $id)->sum('amount');

    //     $this_month = Carbon::now()->format('m');
    //     $Month_check = MonthlyMealRates::whereMonth('month', $this_month)->first();

    //     // dd($Month_check);
    //     $mealRate = 0;
    //     if ($Month_check !== null) {
    //         $mealRate = $Month_check->meal_rate;
    //     }

    //     $user = User::where('id', $id)
    //         ->select('id', 'user_role', 'name', 'mobile')
    //         ->with(['userpayments' => function ($q) {
    //             $q->select('id', 'amount', 'user_id');
    //         }])
    //         ->with(['userMeal' => function ($r) {
    //             $r->select('id', 'quantity', 'user_id');
    //         }])
    //         ->withSum('userpayments', 'amount')
    //         ->withSum('userMeal', 'quantity')
    //         ->first();

    //     // dd($user);

    //     $total_payable = $mealRate * $user->userMeal_sum_quantity;
    //     // dd($total_payable,$user->userMeal_sum_quantity,$user,$mealRate,$this_month);
    //     $due = $total_payable - $user->userpayments_sum_amount;

    //     // dd($due);

    //     return view('frontEnd.Meal_Booking.Meal_Booking', compact('meal', 'payment', 'user', 'due'));
    // }

    public function Meal_Booking()
    {
        $user_id = auth()->user()->id;
        $user = User::where('id',$user_id)->get()->first();

        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        $total_expence = daily_expense::all()->sum('total');
        $total_meal = UserMeals::all()->sum('quantity');
        $total_date = UserMeals::select('date')->get();
        $total_date_array = $total_date->pluck('date')->toArray();
        $total_month = $this->unique_month_count($total_date_array);

        $cook_salary = Settings::latest()->first()->cook_salary;
        $total_cook_salary = $cook_salary * $total_month;

        $total_meal_rate = ($total_expence + $total_cook_salary) / $total_meal;

        $meal_rate = total_monthly($month,$year)->total_meal_rate;
        $monthly_meal_users = monthly_meal_users($month,$year,$user_id);
        $total_monthly_meal = $monthly_meal_users->total_monthly_meal;
        $monthly_payment_users = monthly_payment_users($month,$year,$user_id);
        $total_payment_monthly = $monthly_payment_users->total_payment_monthly;
        $balance = $total_payment_monthly - ($total_monthly_meal * $meal_rate);

        return view('frontEnd.Meal_Booking.Meal_Booking', compact('meal_rate', 'total_monthly_meal', 'total_payment_monthly', 'balance'));
    }
}
