@extends('admin.master')
@section('content')

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">Search Filter</h5>
            <form class="mb-3" action="{{ route('admin.search.all') }}" method="POST">
                @csrf
                <label for="search_key">Search</label>
                <input type="text" name="search_key" id="search_key" class="form-control mb-2" placeholder="search by number or name or email">
                <button type="submit" class="btn btn-primary btn-sm me-2">Filter</button>
                <a href="{{ route('admin.user_management.all_user') }}" class="btn btn-danger btn-sm">Reset</a>
            </form>
        </div>
        <div class="card-datatable table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <table class="datatables-users table border-top dataTable no-footer dtr-column text-center" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                    <thead>
                        <tr class="align-middle">
                            <th>ID</th>
                            <th>image</th>
                            <th>name</th>
                            <th>mobile</th>
                            <th>department</th>
                            <th>user_role</th>
                            <th>email</th>
                            <th>Whatsapp Number</th>
                            <th>Telegram Number</th>
                            <th>address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1 @endphp
                        @foreach($saveusers as $user)
                            <tr>
                                <td>{{$i++}}</td>
                                <td class="text-center">
                                    <img src="{{asset($user->image)}}" alt="" class="" height="100">
                                </td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->mobile}}</td>
                                <td>{{$user->department}}</td>
                                <td>{{$user->user_role->user_role}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->Whatsapp}}</td>
                                <td>{{$user->Telegram}}</td>
                                <td>{{$user->address}}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{route('admin.user_management.edit',$user->id)}}" class="btn btn-primary ">Edit</a>
                                        <a href="{{route('admin.user_management.delete',$user->id)}}" class="btn btn-danger ">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row mx-2">
                    <div class="col-sm-12 col-md-12 mt-3">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                            {{ $saveusers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
