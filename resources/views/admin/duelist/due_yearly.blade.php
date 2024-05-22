@extends('admin.master')

@section('content')
    <div id="calendar"></div>
    <div class="card">
        <div class="card-header border-bottom">
            {{-- <h5 class="card-title mb-3">User Meals Information</h5>
            <form class="mb-3" action="{{ route('admin.due.daily_data') }}" method="GET">
                @csrf
                <label for="date">Select Date:</label>
                <input type="date" name="date" id="date" class="form-control mb-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.due.daily_data') }}" class="btn btn-danger">Reset</a>
            </form> --}}
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table border-top dataTable no-footer dtr-column" id="DataTables_Table_0"
            aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr>
                    <th>serial</th>
                    <th>User</th>
                    <th>Meal</th>
                    <th>Meal rate</th>
                    <th>cost</th>
                    <th>payment</th>
                    <th>due</th>
                    <th>advance</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($result as $key => $user_data)

                    <tr>
                        <td>{{ $key + 1}}</td>
                        @foreach ($user_data as $user_id=>$user)
                            <td>{{ $user['user_info']['name'] }}</td>
                            <td>{{ $user['all_so_far']['user_total_meal'] }}</td>
                            <td>{{ $user['all_so_far']['total_meal_rate'] }}</td>
                            <td>{{ $user['all_so_far']['user_total_cost'] }}</td>
                            <td>{{ $user['all_so_far']['user_total_payment'] }}</td>
                            <td>{{ $user['all_so_far']['user_total_due'] }}</td>
                            <td>{{ $user['all_so_far']['advance_payment'] }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
@endsection
{{-- <td>{{ $userPayments[$data['userId']]['total_amount'] ?? 0 }}</td>
<td>{{ $dues[$data['userId']][$data['month']] }}</td> --}}
