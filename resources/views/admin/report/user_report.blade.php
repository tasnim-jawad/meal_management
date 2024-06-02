@extends('admin.master')
@section('content')

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">Search user</h5>
            <div class="row mb-3">
                <form class="mb-3" action="{{ route('admin.report.user_report.user_search_monthly') }}" method="GET">
                    <div class="user mb-2" >
                        <label class="col-sm-3 col-form-label" for="role">Select User Name</label>
                        <div class="col-sm-9">
                            <select class="form-select select2 meal_user" name="user_id" id="user_id" onchange="userReport()">
                                <option selected disabled>----  Select User Name  ----</option>
                                @foreach ($users as $user_single)
                                    <option value="{{ $user_single->id }}">{{ $user_single->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="month mb-2">
                        <label class="col-sm-3 col-form-label" for="role">Select Month</label>
                        <div class="col-sm-9">
                            <input type="month" name="month" id="month" class="form-control" >
                        </div>
                    </div>
                    <div class="button mb-2">
                        <button type="submit" class="btn btn-primary btn-sm me-2">Filter</button>
                        <a href="{{ route('admin.report.user_report') }}" class="btn btn-danger btn-sm">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        @if ($user?? 0)
        <div class="user py-3 px-4">
            <h3 class="mb-0" >Name: <span id="user_name">{{$user->name?? ""}}</span></h3>
            <p class="mb-0">Identity: <span id="user_role">{{$user->user_role->user_role?? ""}}</span></p>
            <p class="mb-0">Department: <span id="user_department">{{$user->department?? ""}}</span></p>
            {{-- <p class="mb-0">Batch: <span id="user_batch">{{$user->name}}</span></p> --}}
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
                            <td >Total payment this month</td>
                            <td id="total_payment">{{$total_payment_monthly?? ""}}</td>
                        </tr>
                        <tr>
                            <td>Total Meal this month</td>
                            <td id="total_meal">{{$total_meal?? ""}}</td>
                        </tr>
                        {{-- <tr>
                            <td>Total @if($due > 0 ) Due @else surplus @endif this month</td>
                            <td></td>
                        </tr> --}}
                        <tr>
                            <td>Meal rate this month</td>
                            <td id="meal_rate">{{$meal_rate !== null ? round($meal_rate) : "" }}</td>
                        </tr>
                        <tr>
                            <td>Need to pay this month</td>
                            <td id="need_to_pay">{{round($meal_rate * $total_meal)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="payment_monthly mt-5 py-3 px-4">
            <h4 class="mb-0">Payment of this month</h4>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>srl#</th>
                        <th>For month</th>
                        <th>Payment date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="payment_monthly_body">
                    @foreach ($payment_monthly as $index => $payment_single)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{\Carbon\Carbon::parse($payment_single->month)->format('F') }}</td>
                            <td>{{$payment_single->payment_date}}</td>
                            <td>{{$payment_single->amount}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td colspan="2" class="text-end">total</td>
                        <td id="total_payment_monthly">{{$total_payment_monthly}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="payment_history mt-5 py-3 px-4">
            <h4 class="mb-0">All time Payment</h4>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>srl#</th>
                        <th>For month</th>
                        <th>Payment date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="payment_all_body">
                    @foreach ($payment_all as $index => $payment)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{\Carbon\Carbon::parse($payment->month)->format('F') }}</td>
                            <td>{{$payment->payment_date}}</td>
                            <td>{{$payment->amount}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
@endsection
@push('cjs')
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}
    {{-- <script>
        function userReport(){
            let user_id = document.getElementById('user_id').value;

            let user_name = document.getElementById('user_name');
            let user_role = document.getElementById('user_role');
            let user_department = document.getElementById('user_department');
            let user_batch = document.getElementById('user_batch');

            let total_payment = document.getElementById('total_payment');
            let total_meal = document.getElementById('total_meal');
            let meal_rate = document.getElementById('meal_rate');
            let need_to_pay = document.getElementById('need_to_pay');

            let payment_monthly_body = document.getElementById('payment_monthly_body');
            let total_payment_monthly = document.getElementById('total_payment_monthly');

            axios.get(`http://127.0.0.1:8000/report/user-report/user-search/${user_id}`)
                .then(response => {
                    if(response.data.status == 'success'){
                        user_name.textContent = response.data.user.name;
                        user_role.textContent = response.data.user.user_role.user_role;
                        user_department.textContent = response.data.user.department;

                        total_payment.textContent = response.data.total_payment_monthly;
                        total_meal.textContent = response.data.total_meal;
                        meal_rate.textContent = Math.round(response.data.meal_rate);
                        need_to_pay.textContent = Math.round(response.data.total_meal * response.data.meal_rate);

                        total_payment_monthly.textContent = response.data.total_payment_monthly;

                        const rowsToRemove = payment_monthly_body.querySelectorAll('tr:not(:last-child)');
                        rowsToRemove.forEach(row => {
                            row.remove();
                        });

                        let payment_month = response.data.payment_monthly;
                        let index = payment_month.length;
                        payment_month.forEach(data => {
                            let month_name = new Date(data.month).toLocaleString('default', { month: 'long' });
                            payment_monthly_body.insertAdjacentHTML('afterbegin', `
                                                                                    <tr>
                                                                                        <td>${index}</td>
                                                                                        <td>${month_name}</td>
                                                                                        <td>${data.payment_date}</td>
                                                                                        <td>${data.amount}</td>
                                                                                    </tr>
                                                                                `);
                            index--
                        })

                        payment_all_body.innerHTML = '';
                        let payment_all =  response.data.payment_all;
                        let i = payment_all.length;
                        payment_all.forEach(data => {
                            let month_name = new Date(data.month).toLocaleString('default', { month: 'long' });
                            payment_all_body.insertAdjacentHTML('afterbegin', `
                                                                                    <tr>
                                                                                        <td>${i}</td>
                                                                                        <td>${month_name}</td>
                                                                                        <td>${data.payment_date}</td>
                                                                                        <td>${data.amount}</td>
                                                                                    </tr>
                                                                                `);
                            i--
                        })
                    }
                })
        }
    </script> --}}
@endpush
