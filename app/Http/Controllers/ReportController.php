<?php

namespace App\Http\Controllers;

use App\Models\daily_expense;
use App\Models\User;
use App\Models\UserMeals;
use App\Models\UserPayments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index(){
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        $total_monthly = meal_rate($month,$year);

        return view('admin.report.index',compact( 'total_monthly'));
    }

    public function search(Request $request)
    {
        $month_year = $request->month;
        $now = Carbon::parse($month_year);
        $year = $now->year;
        $month = $now->month;

        $total_monthly = meal_rate($month,$year );

        return view('admin.report.index',compact( 'total_monthly'));
    }

    public function user_report(){
        $users = User::with('user_role')->get();
        // dd($users);
        return view('admin.report.user_report',compact('users'));
    }

    public function user_search_monthly(){

        // dd(request()->all());
        $users = User::with('user_role')->get();

        $validator = Validator::make(request()->all(), [
            'user_id' => 'required|exists:users,id',
            'month' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user_id = request()->user_id;
        $now = Carbon::parse(request()->month);
        $year = $now->year;
        $month = $now->month;
        $user = User::where('id',$user_id)->with('user_role')->get()->first();
        // dd($user);
        // $meal_rate = meal_rate($month,$year)->meal_rate;
        $meal_rate = meal_rate($month,$year)->meal_rate;

        $monthly_meal_users = monthly_meal_users($month,$year, $user_id);
        $monthly_meal = $monthly_meal_users->monthly_meal;
        $total_meal = $monthly_meal_users->total_monthly_meal;

        $monthly_payment_users = monthly_payment_users($month,$year, $user_id);
        $payment_monthly = $monthly_payment_users->payment_monthly;
        $total_payment_monthly = $monthly_payment_users->total_payment_monthly;

        $payment_all = UserPayments::where('user_id', $user_id)->latest()->get();

        // dd([
        //     'status' => 'success',
        //     'user' => $user,
        //     'total_meal' => $total_meal,
        //     'payment_monthly' => $payment_monthly,
        //     'total_payment_monthly' => $total_payment_monthly,
        //     'payment_all' => $payment_all,
        //     'meal_rate' => $meal_rate,
        // ]);
        return view('admin.report.user_report',compact(
            'users',
            'user',
            'total_meal',
            'payment_monthly',
            'total_payment_monthly',
            'payment_all',
            'meal_rate',
        ));
    }
    public function user_search($user_id){
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $user = User::where('id',$user_id)->with('user_role')->get()->first();

        $meal_rate = meal_rate($month,$year)->meal_rate;

        $monthly_meal_users = monthly_meal_users($month,$year, $user_id);
        $monthly_meal = $monthly_meal_users->monthly_meal;
        $total_meal = $monthly_meal_users->total_monthly_meal;

        $monthly_payment_users = monthly_payment_users($month,$year, $user_id);
        $payment_monthly = $monthly_payment_users->payment_monthly;
        $total_payment_monthly = $monthly_payment_users->total_payment_monthly;

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
