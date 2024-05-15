@extends('admin.master')
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">Search Filter</h5>
            <form action="{{ route('admin.user_management.update',$saveuser->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="border p-4 rounded">
                            <div class="row mb-3">
                                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{  $saveuser->name }}" name="name" class="form-control" id="inputEnterYourName" placeholder="Enter Your Name">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputEmailAddress2" class="col-sm-3 col-form-label">User Role</label>
                                <div class="col-sm-9">
                                    <select class="form-select meal_user" name="role_id" aria-label="Default select example">
                                        <option selected disabled>select role</option>
                                        @foreach (App\Models\UserRole::get() as $role)
                                            <option value="{{ $role->id }}" @if ($role->id == $saveuser->role_id) selected @endif>{{ $role->user_role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Mobile</label>
                                <div class="col-sm-9">
                                    <input type="mobile" value="{{$saveuser->mobile}}" name="mobile" class="form-control" id="inputEmailAddress2" placeholder="mobile">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Whatsapp</label>
                                <div class="col-sm-9">
                                    <input type="mobile" value="{{$saveuser->Whatsapp}}" name="Whatsapp" class="form-control" id="inputEmailAddress2" placeholder="mobile">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Telegram</label>
                                <div class="col-sm-9">
                                    <input type="mobile" value="{{$saveuser->Telegram}}" name="Telegram" class="form-control" id="inputEmailAddress2" placeholder="mobile">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputEmailAddress2" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" value="{{$saveuser->email}}" name="email" class="form-control" id="inputEmailAddress2" placeholder="Email Address">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="department" class="col-sm-3 col-form-label">Department</label>
                                <div class="col-sm-9">
                                    <select class="form-select meal_user" name="department" id="department" onchange="batchSelect()" aria-label="Select Department">
                                        <option selected disabled> ------ select department ------ </option>
                                        @foreach ($departments as $depart)
                                            <option value="{{ $depart->depart_id }}" @if ($depart->department == $saveuser->department) selected @endif>
                                                {{ $depart->department }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="batch_id">Batch</label>
                                <div class="col-sm-9">
                                    <select class="form-select meal_user" name="batch_id" id="batch_id" >
                                        <option selected disabled>---- select Department -----</option>
                                    </select>
                                    @error('department')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="address" class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$saveuser->address}}" name="address" class="form-control" id="address" placeholder="Address">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" value="" name="password" class="form-control" id="password" placeholder="password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password_confirmation" class="col-sm-3 col-form-label">confirm Password</label>
                                <div class="col-sm-9">
                                    <input type="password" value="" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="password">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputAddress4" class="col-sm-3 col-form-label">image</label>
                                <div class="col-sm-9">
                                    <input type="file" name="image" class="form-control" id="inputAddress4" rows="3" placeholder="Address">{{$saveuser->image}}</>
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

@endsection

@push('end_js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            // This code will execute after the DOM is fully loaded
            batchSelect();
        });
        function batchSelect() {
            console.log('department selected');
            let department_id = document.getElementById('department').value;
            axios.get(`http://127.0.0.1:8000/batch/department-wise/${department_id}`)
                .then(response => {
                    if(response.data.status == "success"){
                        let batchSelect = document.getElementById('batch_id');
                        batchSelect.innerHTML = "<option selected disabled>---- Select Batch -----</option>";
                        response.data.data.forEach(batch => {
                            let option = document.createElement('option');
                            option.value = batch.id;
                            option.text = batch.batch_name;
                            if (batch.id == {{ $saveuser->batch_id }}) {
                                option.selected = true;
                            }
                            batchSelect.appendChild(option);
                        })
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endpush
