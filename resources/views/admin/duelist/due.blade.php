@extends('admin.master')

@section('content')
    <div id="calendar"></div>
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">User Meals Information</h5>
            <form class="mb-3" action="{{ route('admin.due.daily_data') }}" method="GET">
                @csrf
                <label for="date">Select Date:</label>
                <input type="date" name="date" id="date" class="form-control mb-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.due.daily_data') }}" class="btn btn-danger">Reset</a>
            </form>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table border-top dataTable no-footer dtr-column" id="DataTables_Table_0"
            aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr>
                    <th>serial</th>
                    <th>User</th>
                    <th>Quantity</th>
                    <th>Meal rate</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($result as $key => $user_data)

                    <tr>
                        <td>{{ $key + 1}}</td>
                        @foreach ($user_data as $user_id=>$user)
                            <td>{{ $user['user_info']['name'] }}</td>
                            <td>{{ $user['total_meal'] }}</td>
                            <td>{{ $user['mealrate'] }}</td>
                            <td>{{ round($user['mealrate'] * $user['total_meal'])}}</td>
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
