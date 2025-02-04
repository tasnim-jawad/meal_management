<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MonthlyMealRates;
use App\Models\daily_expense;
use App\Models\UserMeals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class mealRateController extends Controller
{
    public function add_meal_rate()
    {
        return view('admin.meal_rate.add_meal_rate');
    }

    public function store(Request $request)
    {
        // Validate the form data if needed
        $validator = Validator::make($request->all(), [
            'month' => 'required',
            'is_visible' => 'required|in:0,1',
            'month_start_date' => 'required|date',
            'month_end_date' => 'required|date|after:month_start_date',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $startDate =  $request->month_start_date;
        $endDate =  $request->month_end_date;
        // dd([$startDate,$endDate]);
        $total_expense = daily_expense::whereBetween('bajar_date', [$startDate, $endDate])->sum('total');
        // dd($total_expense);
        $total_meal = UserMeals::whereBetween('date', [$startDate, $endDate])->sum('quantity');
        // dd($total_meal);
        $meal_rate =($total_expense / $total_meal);
        // dd($meal_rate);

        $meal = new MonthlyMealRates();
        $meal->month = $request->month;
        $meal->meal_rate = $meal_rate;

        if ($request->is_visible == 1) {
            $meal->is_visible = 1;
            $data = "Data 1";
        } elseif ($request->is_visible == 0) {
            $meal->is_visible = 0;
            $data = "Data 0";
        }

        $meal->month_start_date = $request->month_start_date;
        $meal->month_end_date = $request->month_end_date;
        $meal->save();

        // You can return the data to a view or do whatever you want with it
        return back()->with('message', 'Info saved successfully')->with('data', $data);
    }


    public function all_meal_rate()
    {
        return view('admin.meal_rate.all_meal_rate', [
            'mealRate' => MonthlyMealRates::all()
        ]);
    }

    // public function all_meal_rate()
    // {
    //     $mealRate=MonthlyMealRates::all();
    //     return response()->json(["meal" => $mealRate], 200);
    // }

    public function find($id)
    {
        $mealRate = MonthlyMealRates::find($id);
        return view('admin.meal_rate.edit', compact('mealRate'));
    }

    // public function find($id)
    // {
    //     $mealRate = MonthlyMealRates::find($id);
    //     return response()->json(["user" => $mealRate], 200);
    // }

    public function update(Request $request, $id)
    {
        $mealRate = MonthlyMealRates::find($id);
        $mealRate->month = $request->month;
        $mealRate->meal_rate = $request->meal_rate;
        $mealRate->is_visible = $request->is_visible;
        $mealRate->month_start_date = $request->month_start_date;
        $mealRate->month_end_date = $request->month_end_date;
        $mealRate->update();
        return redirect()->route('admin.meal_rate.all_meal_rate');
    }


    // public function update(Request $request, $id)
    // {
    //     $mealRate = MonthlyMealRates::find($id);
    //     $mealRate->	month = $request->	month;
    //     $mealRate->meal_rate = $request->meal_rate;
    //     $mealRate->is_visible = $request->is_visible;
    //     $mealRate->month_start_date = $request->month_start_date;
    //     $mealRate->month_end_date = $request->month_end_date;
    //     $mealRate->status = $request->status;
    //     $mealRate->update();
    //     return response()->json(["meal" => $mealRate], 200);
    // }

    public function delete($id)
    {
        MonthlyMealRates::where('id', $id)->delete();
        return redirect()->route('admin.meal_rate.all_meal_rate');
    }

    // public function delete($id)
    // {
    //     MonthlyMealRates::where('id', $id)->delete();
    //     return response()->json(['message' => 'Info delete successfully'], 200);
    // }
}
