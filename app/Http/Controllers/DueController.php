<?php

namespace App\Http\Controllers;

use App\Models\daily_expense;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserMeals;
use App\Models\UserPayments;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DueController extends Controller
{
    public function daily($date_pass, $user_id){
        $date_carbon = Carbon::parse($date_pass);

        $date = $date_carbon->format('Y-m-d');
        $month = $date_carbon->month;
        $year = $date_carbon->year;

        $user_info = User::find($user_id);
        $all_meal_this_month = UserMeals::whereYear('date', $year)->whereMonth('date', $month)->sum('quantity');
        $date_all_meal = UserMeals::where('date',$date)->get()->sum('quantity');
        $date_all_expense = daily_expense::where('bajar_date',$date)->get()->sum('total');
        $cook_salary = Settings::latest()->first()->cook_salary;

        if ($date_all_meal == 0) {
            $response = [
                $user_id => [
                    "total_meal" => 0,
                    "mealrate" => 0,
                    "user_info" => $user_info,
                ]
            ];
            return $response;
        }
        $date_meal_rate = round(($date_all_expense / $date_all_meal) +  ( $cook_salary / $all_meal_this_month ));
        $date_user_meal = UserMeals::where('user_id', $user_id)->where('date', $date)->get()->sum('quantity');

        $response = [
            $user_id => [
                "total_meal" => $date_user_meal,
                "mealrate" => $date_meal_rate,
                "user_info" => $user_info,
            ]
        ];
        return $response;

    }

    public function daily_data(){
        $date_pass = request()->date ?? Carbon::now()->format('Y-m-d');
        $users = User::get();
        $result = [];
        foreach($users as $user){
            $result[] = $this->daily($date_pass,$user->id);
        }
        return view('admin.duelist.due',compact('result'));

    }
    public function all_data_monthly($month,$year,$user_id){

        $total_expense = daily_expense::whereYear('bajar_date', $year)->whereMonth('bajar_date', $month)->get()->sum('total');
        $total_meal = UserMeals::whereYear('date', $year)->whereMonth('date', $month)->get()->sum('quantity');

        $cook_salary = Settings::latest()->first()->cook_salary;
        if ($total_meal > 0) {
            $total_meal_rate = ($total_expense + $cook_salary) / $total_meal;
        }else{
            $total_meal_rate = 0;
        }

        $advance_payment = 0;
        $user_total_payment = UserPayments::where('user_id',$user_id)->whereYear('month', $year)->whereMonth('month', $month)->get()->sum('amount');
        $user_total_meal = UserMeals::where('user_id',$user_id)->get()->sum('quantity');
        $user_total_cost = $user_total_meal * $total_meal_rate;
        $user_total_due = $user_total_cost - $user_total_payment;

        if($user_total_due < 0 ){
            $advance_payment = abs($user_total_due);
            $user_total_due = 0;
        }

        $responce = [
            "total_expense" => $total_expense,
            "total_meal" => $total_meal,
            "cook_salary" => $cook_salary,
            "total_meal_rate" => $total_meal_rate,
            "intotal_expense" => $total_expense + $cook_salary,
            "user_total_payment" => $user_total_payment,
            "user_total_meal" => $user_total_meal,
            "user_total_cost" => $user_total_cost,
            "user_total_due" => $user_total_due,
            "advance_payment" => $advance_payment,
        ];

        return $responce;
    }

    public function monthly_data(){
        $request_month = request()->input('month', null);
        if($request_month){
            $date_pass = $request_month . '-01';
        }else{
            $date_pass = Carbon::now()->startOfMonth()->format('Y-m-d');
        }

        $date_carbon = Carbon::parse($date_pass);
        $date = $date_carbon->format('Y-m-d');
        $month = $date_carbon->month;
        $year = $date_carbon->year;
        // dd($month,$year);
        // $all_data_monthly = $this->all_data_monthly($month,$year,1);
        // dd($all_data_monthly);
        $users = User::with('user_role')->get();
        $result = [];
        foreach ($users as $user) {
            $all_data_monthly = $this->all_data_monthly($month,$year,$user->id);
            $result[] = [
                $user->id => [
                    "all_data_monthly" => $all_data_monthly,
                    "user_info" => $user,
                ]
            ];
        }

        // dd($result);
        return view('admin.duelist.due_monthly',compact('result'));
    }

    public function unique_month_count($data_array){

        $uniqueMonths = [];
        foreach ($data_array as $record) {
            $date = Carbon::parse($record);
            $yearMonth = $date->format('Y-m');
            $uniqueMonths[$yearMonth] = true;
        }
        $total_month = count($uniqueMonths);

        return $total_month;

    }

    public function all_so_far($user_id){

        $total_expence = daily_expense::all()->sum('total');
        $total_meal = UserMeals::all()->sum('quantity');

        $total_date = UserMeals::select('date')->get();
        $total_date_array = $total_date->pluck('date')->toArray();
        $total_month = $this->unique_month_count($total_date_array);

        $cook_salary = Settings::latest()->first()->cook_salary;
        $total_cook_salary = $cook_salary * $total_month;

        $total_meal_rate = ($total_expence + $total_cook_salary) / $total_meal;
        $advance_payment = 0;
        $user_total_payment = UserPayments::where('user_id',$user_id)->get()->sum('amount');
        $user_total_meal = UserMeals::where('user_id',$user_id)->get()->sum('quantity');
        $user_total_cost = $user_total_meal * $total_meal_rate;
        $user_total_due = $user_total_cost - $user_total_payment;
        if($user_total_due < 0 ){
            $advance_payment = abs($user_total_due);
            $user_total_due = 0;
        }

        $responce = [
            "total_expence" => $total_expence,
            "total_meal" => $total_meal,
            "total_month" => $total_month,
            "total_cook_salary" => $total_cook_salary,
            "total_meal_rate" => $total_meal_rate,
            "intotal_expense" => $total_expence + $total_cook_salary,
            "user_total_payment" => $user_total_payment,
            "user_total_meal" => $user_total_meal,
            "user_total_cost" => $user_total_cost,
            "user_total_due" => $user_total_due,
            "advance_payment" => $advance_payment,
        ];

        return $responce;
    }

    public function yearly_data(){
        $users = User::with('user_role')->get();
        $result = [];
        foreach ($users as $user) {
            $all_so_far = $this->all_so_far($user->id);
            $result[] = [
                $user->id => [
                    "all_so_far" => $all_so_far,
                    "user_info" => $user,
                ]
            ];
        }
        // dd($result);
        return view('admin.duelist.due_yearly',compact('result'));
    }
}
