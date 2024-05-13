@extends('admin.master')

@section('content')
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <form action="{{ route('batch.store') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="border p-4 rounded">
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Department</label>
                                <div class="col-sm-9">
                                    <select class="form-select select2 meal_user" name="department_id" aria-label="Default select example">
                                        <option value="" selected> ----- Select a Department ----- </option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->depart_id }}">{{ $department->department }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="batch_name" class="col-sm-3 col-form-label">Batch Name</label>
                                <div class="col-sm-9">
                                    <input type="text" name="batch_name" class="form-control" id="batch_name" placeholder="select batch name">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select class="form-select select2 meal_user" name="status" aria-label="Default select example">
                                        <option value="" selected>Select a status</option>
                                            <option value="1" >Active</option>
                                            <option value="0" >Deactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary px-5">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
