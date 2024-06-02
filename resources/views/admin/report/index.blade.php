@extends('admin.master')
@section('content')

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">Search Filter</h5>
            <form class="mb-3" action="{{ route('admin.report.search') }}" method="POST">
                @csrf
                <label for="month">Select month:</label>
                <input type="month" name="month" id="month" class="form-control mb-2">
                <button type="submit" class="btn btn-primary btn-sm me-2">Filter</button>
                <a href="{{ route('admin.report.index') }}" class="btn btn-danger btn-sm">Reset</a>
            </form>
        </div>
        <div class="card-datatable table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <table class="datatables-users table border-top dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Total Meal this month</td>
                            <td>{{$total_monthly->total_meal_all}}</td>
                        </tr>
                        <tr>
                            <td>Total income this month</td>
                            <td>{{$total_monthly->total_income}}</td>
                        </tr>
                        <tr>
                            <td>Total expanse this month</td>
                            <td>{{$total_monthly->total_expense}}</td>
                        </tr>
                        <tr>
                            <td>Total @if($total_monthly->balance < 0 ) Due @else surplus @endif this month</td>
                            <td>{{abs($total_monthly->balance)}}</td>
                        </tr>
                        <tr>
                            <td>Meal rate this month</td>
                            <td>{{round($total_monthly->meal_rate)}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row mx-2"><div class="col-sm-12 col-md-6"><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 0 to 0 of 0 entries</div></div><div class="col-sm-12 col-md-6"><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="previous" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item next disabled" id="DataTables_Table_0_next"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="next" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
        </div>
    </div>
@endsection
