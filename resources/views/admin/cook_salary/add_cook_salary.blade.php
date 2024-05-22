@extends('admin.master')
@section('content')
    <div class="card mb-3">
        <div class="card-header">Add Cook Salary</div>
        <div class="card-body">
            <form action="{{route('admin.daily_expense.store_cook_salary')}}" method="POST">
                @csrf
                <div class="row mb-2">
                    <div class="date col-md-5">
                        <label for="bajar_date">Select date</label>
                        <input class="form-control" type="date" value="{{$date}}" name="bajar_date">
                    </div>
                    <div class="amount col-md-5">
                        <label for="total">amount</label>
                        <input class="form-control" type="number" name="total">
                    </div>
                    <div class="button col-md-2 align-self-end mt-2">
                        {{-- <a href="#" class="btn btn-primary w-100">Submit</a> --}}
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
