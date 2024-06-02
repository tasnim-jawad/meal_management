<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPayments;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class paymentController extends Controller
{
    public function add_payment(){
        $taday_date = Carbon::today()->format('Y-m-d');
        // dd($taday_date);
        return view('admin.user_payment.add_payment',compact('taday_date'));
    }
    public function store(Request $request)
    {
        // $request->validate([
        //     'user_id' => 'required',
        //     'month' => 'required',
        //     'payment_date' => 'required',
        //     'amount' => 'required|numeric'
        // ]);
        $validator = Validator::make(request()->all(), [
            'user_id' => 'required',
            'month' => 'required',
            'payment_date' => 'required',
            'amount' => 'required|numeric|gt:0'
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Toastr::error($error, 'Validation Error');
            }
            return back()->withErrors($validator)->withInput();
        }

        $payments = new UserPayments();
        $payments->user_id = $request->user_id;
        $payments->month = $request->month . '-01';
        $payments->payment_date = $request->payment_date;
        $payments->amount = $request->amount;
        $payments->save();
        if($payments->save()){
            Toastr::success('Payment made successfully ', 'success');
        }
        return back()->with('message', 'Info saved successfully');
    }

    public function all_user_payment()
    {
        $payments = UserPayments::with('user')->paginate(20);
        return view('admin.user_payment.all_payment', compact('payments'));
    }

}
