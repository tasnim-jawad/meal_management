<?php

namespace App\Http\Controllers;

use App\Models\daily_expense;
use App\Models\MonthlyBalance;
use App\Models\MonthlyMealRates;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserMeals;
use App\Models\UserPayments;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $user = User::where('id',auth()->id())->with('user_role')->get()->first();

        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        $total_income = meal_rate($month,$year)->total_income;
        $total_expense = meal_rate($month,$year)->total_expense;
        $total_meal = meal_rate($month,$year)->total_meal_all;
        $meal_rate = meal_rate($month,$year)->meal_rate;
        $balance = $total_income - $total_expense ;

        $cook_salary_this_month = daily_expense::where('title','khala')
                                                ->where('unit','salary')
                                                ->whereYear('bajar_date',$year)
                                                ->whereMonth('bajar_date',$month)
                                                ->get();
        $isPaid = $cook_salary_this_month->every(function ($expense) {
            return $expense->status === 1;
        });


        $total_cook_salary = $cook_salary_this_month->sum('total');
        $previous_due = MonthlyBalance::sum('due');
        $previous_advance = MonthlyBalance::sum('advance');
        $previous_balance = $previous_advance - $previous_due;

        $current_balance = $previous_balance + $balance;
        if ($isPaid) {
            $cook_salary_pay_status = 'Paid';
            $cash_in_hand = $previous_balance + $balance;
        }else{
            $cook_salary_pay_status = 'Due';
            $cash_in_hand = $previous_balance + $balance + $total_cook_salary;
        }

        // dd($previous_due,$previous_advance,$previous_balance,);
        $tomorrow = Carbon::tomorrow();
        $tomorrow_total_meal = UserMeals::whereDate('date', $tomorrow)->sum('quantity');

        return view('admin.dashboard.home', compact('total_income', 'total_expense','total_meal',
                                                    'meal_rate','balance','tomorrow_total_meal',
                                                    'total_cook_salary','cook_salary_pay_status',
                                                    'previous_balance','cash_in_hand','current_balance'));
    }


}
