<?php

use App\Models\daily_expense;
use App\Models\Settings;
use App\Models\UserMeals;
use App\Models\UserPayments;

    function meal_rate($month,$year){
        $monthly_meal_all = UserMeals::whereYear('date',$year)->whereMonth('date',$month)->get();
        $total_meal_all = $monthly_meal_all->sum('quantity');

        $expense = daily_expense::whereYear('bajar_date',$year)->whereMonth('bajar_date',$month)->get();
        $total_expense = $expense->sum('total');

        $income = UserPayments::whereYear('month',$year)->whereMonth('month',$month)->get();
        $total_income = $income->sum('amount');

        $meal_rate = $total_meal_all != 0 ? $total_expense / $total_meal_all : 0;

        // return $meal_rate;
        return (object) [
            "meal_rate" => $meal_rate,
            "monthly_meal_all" => $monthly_meal_all,
            "total_meal_all" => $total_meal_all,
            "expense" => $expense,
            "total_expense" => $total_expense,
            "income" => $income,
            "total_income" => $total_income,
        ];
    }

    function monthly_meal_users($month,$year,$user_id){
        $monthly_meal = UserMeals::whereYear('date',$year)->whereMonth('date',$month)->where('user_id', $user_id)->get();
        $total_monthly_meal = $monthly_meal->sum('quantity');

        return (object) [
            "monthly_meal" => $monthly_meal,
            "total_monthly_meal" => $total_monthly_meal,
        ];
    }

    function monthly_payment_users($month,$year,$user_id){
        $payment_monthly = UserPayments::whereYear('month',$year)->whereMonth('month',$month)->where('user_id', $user_id)->latest()->get();
        $total_payment_monthly = $payment_monthly->sum('amount');

        return (object) [
            "payment_monthly" => $payment_monthly,
            "total_payment_monthly" => $total_payment_monthly,
        ];
    }

    function total_monthly($month,$year){

        $total_income = UserPayments::whereYear('month', $year)->whereMonth('month', $month)->get()->sum('amount');
        $total_expense = daily_expense::whereYear('bajar_date', $year)->whereMonth('bajar_date', $month)->get()->sum('total');
        $total_meal = UserMeals::whereYear('date', $year)->whereMonth('date', $month)->get()->sum('quantity');
        $cook_salary = Settings::latest()->first()->cook_salary;

        if ($total_meal > 0) {
            $total_meal_rate = ($total_expense + $cook_salary) / $total_meal;
        }else{
            $total_meal_rate = 0;
        }
        $balance = $total_income - $total_expense;

        return (object) [
            "total_income" => $total_income,
            "total_expense" => $total_expense,
            "total_meal" => $total_meal,
            "total_meal_rate" => $total_meal_rate,
            "balance" => $balance,
        ];
    }

    function total_all_so_far($month,$year){

        $total_income = UserPayments::whereYear('month', $year)->whereMonth('month', $month)->get()->sum('amount');
        $total_expense = daily_expense::whereYear('bajar_date', $year)->whereMonth('bajar_date', $month)->get()->sum('total');
        $total_meal = UserMeals::whereYear('date', $year)->whereMonth('date', $month)->get()->sum('quantity');
        $cook_salary = Settings::latest()->first()->cook_salary;

        if ($total_meal > 0) {
            $total_meal_rate = ($total_expense + $cook_salary) / $total_meal;
        }else{
            $total_meal_rate = 0;
        }
        $balance = $total_income - $total_expense;

        return (object) [
            "total_income" => $total_income,
            "total_expense" => $total_expense,
            "total_meal" => $total_meal,
            "total_meal_rate" => $total_meal_rate,
            "balance" => $balance,
        ];
    }

    // function total_monthly_user($month,$year,$user_id){
    //     $total_monthly = total_monthly($month,$year);

    //     $payment_monthly = UserPayments::whereYear('month',$year)->whereMonth('month',$month)->where('user_id', $user_id)->get();
    //     $total_payment_monthly = $payment_monthly->sum('amount');

    //     return (object) [
    //         "total_monthly" => $total_monthly,
    //         "payment_monthly" => $payment_monthly,
    //         "total_payment_monthly" => $total_payment_monthly,
    //     ];

    // }

?>
