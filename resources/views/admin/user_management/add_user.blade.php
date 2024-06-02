@extends('admin.master')
@section('content')
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
            <form action="{{ route('admin.user_management.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Create User</h5> <small class="text-muted float-end">Default label</small>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="image">image</label>
                            <div class="col-sm-10">
                                <input type="file" name="image" id="image" class="form-control phone-mask"
                                    placeholder="658 799 8941" aria-label="658 799 8941"
                                    aria-describedby="basic-default-Status" />
                                @error('image')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="please enter the name" />
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="role">User Role</label>
                            <div class="col-sm-10">
                                <select class="form-select meal_user" name="role_id" aria-label="Default select example" >
                                    <option selected disabled>---- select role ----</option>
                                    @foreach ($user_role as $role)
                                        <option value="{{ $role->serial }}" {{ old('role_id') == $role->serial ? 'selected' : '' }}>{{ $role->user_role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="Serial">Phone</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" name="mobile" id="phone" class="form-control"
                                        placeholder="john.doe" aria-label="john.doe"
                                        aria-describedby="basic-default-phone" value="{{ old('mobile') }}"/>
                                </div>
                                @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="department">Department</label>
                            <div class="col-sm-10">
                                <select class="form-select meal_user" onchange="batchSelect()" name="department" id="department">
                                    <option selected disabled>---- select Department -----</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->depart_id }}" {{ old('department') == $department->depart_id ? 'selected' : '' }}>{{ $department->department }}</option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="batch_id">Batch</label>
                            <div class="col-sm-10">
                                <select class="form-select meal_user" name="batch_id" id="batch_id" >
                                    <option selected disabled>---- select batch -----</option>
                                </select>
                                @error('department')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="Serial">Whatsapp Number</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" name="Whatsapp" id="phone" class="form-control"
                                        placeholder="john.doe" aria-label="john.doe"
                                        aria-describedby="basic-default-phone" value="{{ old('Whatsapp') }}"/>
                                </div>
                                @error('Whatsapp')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="Serial">Telegram Number</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" name="Telegram" id="phone" class="form-control"
                                        placeholder="john.doe" aria-label="john.doe"
                                        aria-describedby="basic-default-phone" value="{{ old('Telegram') }}"/>
                                </div>
                                @error('Telegram')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control" id="email" placeholder="email" value="{{ old('email') }}"/>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="address">Address</label>
                            <div class="col-sm-10">
                                <input type="text" name="address" class="form-control" id="address"
                                    placeholder="address" value="{{ old('address') }}"/>
                                    @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="password">password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="password" />
                            </div>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="password">confirm Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                                    placeholder="password confirmation" />
                            </div>
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    @endsection

    @push('end_js')
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
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
