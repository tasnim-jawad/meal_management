<?php

namespace App\Http\Controllers;

use App\Models\daily_expense;
use App\Models\MonthlyMealRates;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserMeals;
use App\Models\UserPayments;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $user = User::where('id',auth()->id())->with('user_role')->get()->first();

        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        $total_income = UserPayments::whereYear('month', $year)->whereMonth('month', $month)->get()->sum('amount');
        $total_expense = daily_expense::whereYear('bajar_date', $year)->whereMonth('bajar_date', $month)->get()->sum('total');
        $total_meal = UserMeals::whereYear('date', $year)->whereMonth('date', $month)->get()->sum('quantity');
        $cook_salary = Settings::latest()->first()->cook_salary;

        $total_meal_rate = ($total_expense + $cook_salary) / $total_meal;
        $balance = $total_income - $total_expense;
        // $monthly_data = meal_rate($month,$year);
        // $meal_rate = $monthly_data->meal_rate;
        // $total_meal_all = $monthly_data->total_meal_all;
        // $total_expense = $monthly_data->total_expense;
        // $total_income = $monthly_data->total_income;
        // $balance = $total_income - $total_expense;

        //total meals for tomorrow
        $tomorrow = Carbon::tomorrow();
        $tomorrow_total_meal = UserMeals::whereDate('date', $tomorrow)->sum('quantity');

        return view('admin.dashboard.home', compact('total_income', 'total_expense','total_meal','total_meal_rate','balance','tomorrow_total_meal'));
    }


}
