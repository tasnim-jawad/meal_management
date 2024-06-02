<?php

use App\Models\daily_expense;
use App\Models\MonthlyBalance;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserMeals;
use App\Models\UserPayments;
use Carbon\Carbon;

    function meal_rate($month,$year){
        $monthly_meal_all = UserMeals::whereYear('date',$year)->whereMonth('date',$month)->get();
        $total_meal_all = $monthly_meal_all->sum('quantity');

        $expense = daily_expense::whereYear('bajar_date',$year)->whereMonth('bajar_date',$month)->get();
        $total_expense = $expense->sum('total');

        $income = UserPayments::whereYear('payment_date',$year)->whereMonth('payment_date',$month)->get();
        $total_income = $income->sum('amount');

        $meal_rate = $total_meal_all != 0 ? $total_expense / $total_meal_all : 0;
        $balance = $total_income - $total_expense;
        // return $meal_rate;
        return (object) [
            "meal_rate" => $meal_rate,
            "monthly_meal_all" => $monthly_meal_all,
            "total_meal_all" => $total_meal_all,
            "expense" => $expense,
            "total_expense" => $total_expense,
            "income" => $income,
            "total_income" => $total_income,
            "balance" => $balance,
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
        $payment_monthly = UserPayments::whereYear('payment_date',$year)->whereMonth('payment_date',$month)->where('user_id', $user_id)->latest()->get();
        $total_payment_monthly = $payment_monthly->sum('amount');

        return (object) [
            "payment_monthly" => $payment_monthly,
            "total_payment_monthly" => $total_payment_monthly,
        ];
    }

    function all_data_monthly($month,$year,$user_id){
        $total_meal_rate = meal_rate($month,$year)->meal_rate;
        $advance_payment = 0;
        $user_total_payment = monthly_payment_users($month,$year,$user_id)->total_payment_monthly;
        $user_total_meal =monthly_meal_users($month,$year,$user_id)->total_monthly_meal;
        $user_total_cost = $user_total_meal * $total_meal_rate;
        $user_total_due = $user_total_cost - $user_total_payment;

        if($user_total_due < 0 ){
            $advance_payment = abs($user_total_due);
            $user_total_due = 0;
        }

        $responce = [
            "total_meal_rate" => $total_meal_rate,
            "user_total_payment" => $user_total_payment,
            "user_total_meal" => $user_total_meal,
            "user_total_cost" => $user_total_cost,
            "user_total_due" => $user_total_due,
            "advance_payment" => $advance_payment,
        ];

        return $responce;
    }

    function eomr(){
        $date = Carbon::now()->format('Y-m-d');
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;
        $users = User::with('user_role')->get();

        foreach ($users as $user) {
            $all_data_monthly = all_data_monthly($month,$year,$user->id);
            $monthly_balance = MonthlyBalance::where('user_id', $user->id)->first();

            if($monthly_balance){
                $due = $monthly_balance->due;
                $advance = $monthly_balance->advance;
            }else{
                $due = 0;
                $advance = 0;
            }
            $now_due = $due + $all_data_monthly['user_total_due'];
            $now_advance_payment = $advance + $all_data_monthly['advance_payment'];
            $now_balance = $now_due - $now_advance_payment;

            if($now_balance < 0 ){
                $current_advance_payment = abs($now_balance);
                $current_due = 0;
            }else{
                $current_advance_payment = 0;
                $current_due = abs($now_balance);
            }


            $isExist = MonthlyBalance::where('user_id',$user->id)->exists();
            if($isExist){
                $balance = MonthlyBalance::where('user_id',$user->id)->first();

                $balance->date = $date;
                $balance->due = $current_due;
                $balance->advance = $current_advance_payment;
                $balance->save();
            }else {
                $balance = new MonthlyBalance();
                $balance->user_id = $user->id;
                $balance->date = $date;
                $balance->due = $current_due;
                $balance->advance = $current_advance_payment;

                $balance->save();
            }
        }
    }

    // function total_monthly($month,$year){

    //     $total_income = UserPayments::whereYear('payment_date', $year)->whereMonth('payment_date', $month)->get()->sum('amount');
    //     $total_expense = daily_expense::whereYear('bajar_date', $year)->whereMonth('bajar_date', $month)->get()->sum('total');
    //     $total_meal = UserMeals::whereYear('date', $year)->whereMonth('date', $month)->get()->sum('quantity');
    //     $cook_salary = Settings::latest()->first()->cook_salary;

    //     if ($total_meal > 0) {
    //         $total_meal_rate = ($total_expense + $cook_salary) / $total_meal;
    //     }else{
    //         $total_meal_rate = 0;
    //     }
    //     $balance = $total_income - $total_expense;

    //     return (object) [
    //         "total_income" => $total_income,
    //         "total_expense" => $total_expense,
    //         "total_meal" => $total_meal,
    //         "total_meal_rate" => $total_meal_rate,
    //         "balance" => $balance,
    //     ];
    // }

    // function total_all_so_far($month,$year){

    //     $total_income = UserPayments::whereYear('month', $year)->whereMonth('month', $month)->get()->sum('amount');
    //     $total_expense = daily_expense::whereYear('bajar_date', $year)->whereMonth('bajar_date', $month)->get()->sum('total');
    //     $total_meal = UserMeals::whereYear('date', $year)->whereMonth('date', $month)->get()->sum('quantity');
    //     $cook_salary = Settings::latest()->first()->cook_salary;

    //     if ($total_meal > 0) {
    //         $total_meal_rate = ($total_expense + $cook_salary) / $total_meal;
    //     }else{
    //         $total_meal_rate = 0;
    //     }
    //     $balance = $total_income - $total_expense;

    //     return (object) [
    //         "total_income" => $total_income,
    //         "total_expense" => $total_expense,
    //         "total_meal" => $total_meal,
    //         "total_meal_rate" => $total_meal_rate,
    //         "balance" => $balance,
    //     ];
    // }

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
