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
                        <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small>
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
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="please enter the name" />
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="role">User Role</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="user_role" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    @foreach (App\Models\UserRole::get() as $quize)
                                        <option value="{{ $quize->id }}">{{ $quize->user_role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="Serial">Phone</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" name="mobile" id="phone" class="form-control"
                                        placeholder="john.doe" aria-label="john.doe"
                                        aria-describedby="basic-default-phone" />
                                </div>
                                @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="role">Department</label>
                            <div class="col-sm-10">
                                <select class="form-select meal_user" name="department" >
                                    <option selected disabled>Open this select menu</option>
                                    @foreach (App\Models\Department::get() as $depart)
                                        <option value="{{ $depart->id }}">{{ $depart->department }}</option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="role">Batch Number</label>
                            <div class="col-sm-10">
                                <input type="text" name="batch_no" id="batch_no" class="form-control" placeholder="enter batch number" />

                                @error('batch_no')
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
                                        aria-describedby="basic-default-phone" />
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
                                        aria-describedby="basic-default-phone" />
                                </div>
                                @error('Telegram')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control" id="email" placeholder="email" />
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="address">Address</label>
                            <div class="col-sm-10">
                                <input type="text" name="address" class="form-control" id="address"
                                    placeholder="address" />
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
                                    @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="password">confirm Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password_confirmation" class="form-control" id="password"
                                    placeholder="password" />
                            </div>
                            @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    @endsection

    @push('end_js')
        <script>
            // $('.meal_user').select2();
        </script>
    @endpush
