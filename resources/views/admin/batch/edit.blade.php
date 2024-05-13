@extends('admin.master')
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">Search Filter</h5>
            <form action="{{ route('batch.update', $batch->id) }}" method="post">
                @csrf
                <input type="text" value="{{$batch->id}}" name="id" class="d-none">
                <div class="card">
                    <div class="card-body">
                        <div class="border p-4 rounded">
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Department</label>
                                <div class="col-sm-9">
                                    <select class="form-select select2 meal_user" name="department_id" aria-label="Default select example">
                                        <option value="" selected>----- Select a Department -----</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->depart_id }}" @if($department->depart_id == $batch->department_id) selected @endif>{{ $department->department }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Batch Name</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$batch->batch_name}}" name="batch_name" class="form-control"
                                        id="inputEmailAddress2" placeholder="mobile">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select class="form-select select2 meal_user" name="status" aria-label="Default select example">
                                        <option value="">Select a status</option>
                                            <option value="1" @if($batch->status == 1) selected @endif>Active</option>
                                            <option value="0" @if($batch->status == 0) selected @endif>Deactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary px-5">update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
