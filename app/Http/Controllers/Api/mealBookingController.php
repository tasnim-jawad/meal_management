<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\UserMeals;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class mealBookingController extends Controller
{

    public function all_meal()
    {
        return view ('admin.meal_booking.all_meal', [
            'meals' => UserMeals::with('user')->get()
        ]);
    }

    public function store(Request $request)
    {
        $currentTime = Carbon::now();
        $meat_set_last_time = Carbon::today()->setHour(18)->setMinute(0)->setSecond(0);

        if ($currentTime->lte($meat_set_last_time)) {
            $storeMeal = new UserMeals();
            $storeMeal->name = $request->name;
            $storeMeal->quantity = $request->quantity;
            $storeMeal->date = $request->date;
            $storeMeal->status = $request->status;
            $storeMeal->save();
            return view ('admin.meal_booking.all_meal',compact('storeMeal'));

        } else {
            return view ('please contact with admin');
        }

    }
}
