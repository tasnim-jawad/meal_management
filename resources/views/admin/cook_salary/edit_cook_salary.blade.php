@extends('admin.master')
@section('content')
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <form action="{{ route('admin.daily_expense.update_cook_salary') }}" method="post">
                @csrf
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Cook Salary</h5>
                        <small class="text-muted float-end">Edit Cook Salary details</small>
                    </div>
                    <div class="card-body">
                        <input type="text" value="{{ $cook_salary->id }}" name="id" class="d-none"  />
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="bajar_date">Salary Date</label>
                            <div class="col-sm-10">
                                <input type="date" value="{{ $cook_salary->bajar_date }}" name="bajar_date"
                                    class="form-control"  />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="total">Amount</label>
                            <div class="col-sm-10">
                                <input type="text" value="{{ $cook_salary->total }}" name="total" id="total"
                                    class="form-control" />
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="total">Amount</label>
                            <div class="col-sm-10">
                                <select class="form-select select2 meal_user" name="status" aria-label="Default select example">
                                    <option value="1" @if($cook_salary->status == 1) selected @endif>Paid</option>
                                    <option value="0" @if($cook_salary->status == 0) selected @endif>Due</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
