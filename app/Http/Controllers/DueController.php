<?php

namespace App\Http\Controllers;

use App\Models\daily_expense;
use App\Models\MonthlyBalance;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserMeals;
use App\Models\UserPayments;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DueController extends Controller
{
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
        $users = User::with('user_role')->get();
        $result = [];
        foreach ($users as $user) {
            $all_data_monthly = all_data_monthly($month,$year,$user->id);
            $result[] = [
                $user->id => [
                    "all_data_monthly" => $all_data_monthly,
                    "user_info" => $user,
                ]
            ];
        }

        return view('admin.duelist.due_monthly',compact('result'));
    }

    public function current_data(){
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;
        $users = User::with('user_role')->get();

        $result = [];
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

            $result[] = [
                $user->id => [
                    "all_data_monthly" => $all_data_monthly,
                    "previous_due" => $due,
                    "previous_advance_payment" => $advance ,
                    "running_month_due" => $all_data_monthly['user_total_due'],
                    "running_month_advance_payment" => $all_data_monthly['advance_payment'] ,
                    "current_due" => $current_due,
                    "current_advance_payment" => $current_advance_payment,
                    "user_info" => $user,
                ]
            ];
        }
        // dd($user,$result);
        return view('admin.duelist.due_current',compact('result'));
    }

    public function received_due(){
        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:monthly_balances,user_id'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error, 'Validation Error');
            }
            return back()->withErrors($validator)->withInput();
        }

        $data = MonthlyBalance::where('user_id',request()->id )->first();
        if ($data) {
            // Update the record's due field
            $data->due = 0;
            $data->save();

            return response([
                'status' => 'success',
                'data' => $data,
            ]);
        } else {
            return response([
                'status' => 'error',
                'data' => "",
                'message' => "no previous data",
            ]);
        }

    }
    public function return_advance(){
        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:monthly_balances,user_id'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error, 'Validation Error');
            }
            return back()->withErrors($validator)->withInput();
        }

        $data = MonthlyBalance::where('user_id',request()->id )->first();
        if ($data) {
            // Update the record's due field
            $data->advance = 0;
            $data->save();

            return response([
                'status' => 'success',
                'data' => $data,
            ]);
        } else {
            return response([
                'status' => 'error',
                'data' => "",
                'message' => "no previous data",
            ]);
        }

    }

}
