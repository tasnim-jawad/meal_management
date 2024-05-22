@extends('admin.master')
@section('content')

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">All Payments</h5>
            <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
                <div class="col-md-4 user_role"></div>
                <div class="col-md-4 user_plan"></div>
                <div class="col-md-4 user_status"></div>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            {{-- <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer"><div class="row me-2"><div class="col-md-2"><div class="me-3"><div class="dataTables_length" id="DataTables_Table_0_length"><label><select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-select"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select></label></div></div></div><div class="col-md-10"><div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"><div id="DataTables_Table_0_filter" class="dataTables_filter"><label><input type="search" class="form-control" placeholder="Search.." aria-controls="DataTables_Table_0"></label></div><div class="dt-buttons btn-group flex-wrap"> <div class="btn-group"><button class="btn btn-secondary buttons-collection dropdown-toggle btn-label-secondary mx-3" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog" aria-expanded="false"><span><i class="ti ti-screen-share me-1 ti-xs"></i>Export</span><span class="dt-down-arrow"></span></button></div> <button class="btn btn-secondary add-new btn-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"><span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add New User</span></span></button> </div></div></div></div> --}}
            <table class="datatables-users table border-top dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>users_id</th>
                        <th>month</th>
                        <th>payment_date</th>
                        <th>amount</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php $i=1 @endphp
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{optional($payment->user)->name}}</td>
                            <td>{{$payment->user_id}}</td>
                            <td>{{$payment->month}}</td>
                            <td>{{$payment->payment_date}}</td>
                            <td>{{$payment->amount}}</td>
                            {{-- <td>
                                <a href="{{route('admin.user_management.edit',$payment->id)}}" class="btn btn-primary">Edit</a>
                                <a href="{{route('admin.user_management.delete',$payment->id)}}" class="btn btn-danger">Delete</a>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3 px-4">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
@endsection
