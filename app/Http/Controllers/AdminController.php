<?php

namespace App\Http\Controllers;

use App\Models\MonthlyMealRates;
use App\Models\UserMeals;
use App\Models\UserPayments;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $this_month = Carbon::now();
        $userpayment = UserPayments::where('month', $this_month->format('Y-m'))->sum('amount');
        // $userpayment = UserPayments::where('month', 'LIKE', $this_month->format('Y-m') . '%')->sum('amount');

        //total meals for whole month
        $totalMeal = UserMeals::whereMonth('date', $this_month)->sum('quantity');

        $tomorrow = Carbon::tomorrow();
        //total meals for tomorrow
        $tomorrowtotalMeal = UserMeals::whereDate('date', $tomorrow)->sum('quantity');

        $Month_check = MonthlyMealRates::whereMonth('month', $this_month)->first();
        $mealRate = 0;

        if ($Month_check !== null) {
            $mealRate = $Month_check->meal_rate;
        }else {
            $defaultMealRate = 10;
            $mealRate = $defaultMealRate;
        }

        $total_expense = $mealRate * $totalMeal;
        $total_due = $total_expense - $userpayment;

        return view('admin.dashboard.home', compact('userpayment', 'totalMeal', 'tomorrowtotalMeal', 'total_due','mealRate'));
    }


}
