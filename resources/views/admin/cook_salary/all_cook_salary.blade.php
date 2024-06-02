@extends('admin.master')
@section('content')
    <div class="card mb-3">
        <div class="card-header">Search Monthly Cook Salary</div>
        <div class="card-body">
            <form action="{{ route('admin.daily_expense.all_cook_salary_search') }}" method="POST">
                @csrf
                <label for="search">Month</label>
                <input class="form-control mb-2" type="month" name="search" id="search" >
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.daily_expense.all_cook_salary') }}" class="btn btn-danger">Reset</a>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">Cook salary List(as per date)</h5>
        </div>
        <div class="card-datatable table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <table class="datatables-users table border-top dataTable no-footer dtr-column text-center" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                    <thead>
                        <tr>
                            <th>srl#</th>
                            <th>Bajar Date</th>
                            <th>Total expense</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($cook_salary_all as $key => $salary)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$salary->bajar_date}}</td>
                            <td>{{$salary->total}}</td>
                            <td>
                                <a href="{{ route('admin.daily_expense.edit_cook_salary', $salary->id) }}" class="btn btn-primary">Edit</a>
                                <button class="btn btn-danger" onclick="delete_cook_salary('{{$salary->id}}')" >Delete</button>
                                <form action="{{ route('admin.daily_expense.delete_cook_salary')}}" id="delete_form_{{$salary->id}}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $salary->id }}">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                        <tr>
                            <td></td>
                            <td class="text-end">Total</td>
                            <td>{{$cook_salary_total}}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="row mx-2"><div class="col-sm-12 col-md-6"><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 0 to 0 of 0 entries</div></div><div class="col-sm-12 col-md-6"><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="DataTables_Table_0_previous"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="previous" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item next disabled" id="DataTables_Table_0_next"><a href="#" aria-controls="DataTables_Table_0" data-dt-idx="next" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
        </div>
    </div>
@endsection

@push('end_js')
    <script>
        function delete_cook_salary(id){
            console.log('click delete');
            if(confirm('are you sure you want to delete?')){
                const form = document.getElementById(`delete_form_${id}`);
                form.submit();
            }

        }
    </script>
@endpush
