<?php

namespace App\Http\Controllers;

use App\Models\daily_expense;
use App\Models\MonthlyBalance;
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
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        $meal_rate = meal_rate($month,$year)->meal_rate;
        $monthly_meal_users = monthly_meal_users($month,$year,$user_id);
        $total_monthly_meal = $monthly_meal_users->total_monthly_meal;
        $monthly_payment_users = monthly_payment_users($month,$year,$user_id);
        $total_payment_monthly = $monthly_payment_users->total_payment_monthly;
        $monthly_cost = $total_monthly_meal * $meal_rate;

        $previous_data = MonthlyBalance::where('user_id',$user_id )->first();
        $previous_due = $previous_data->due?? 0 ;
        $previous_advance = $previous_data->advance?? 0;

        if($previous_due > 0){
            $balance = $total_payment_monthly - $monthly_cost - $previous_due;
        }elseif($previous_advance > 0){
            $balance = $total_payment_monthly - $monthly_cost + $previous_due;
        }else{
            $balance = $total_payment_monthly - $monthly_cost;
        }

        return view('frontEnd.Meal_Booking.Meal_Booking', compact('meal_rate', 'total_monthly_meal', 'total_payment_monthly','monthly_cost', 'balance'));
    }
}
