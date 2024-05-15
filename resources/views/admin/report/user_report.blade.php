@extends('admin.master')
@section('content')

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3"></h5>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="role">Select User Name</label>
                <div class="col-sm-9">
                    <select class="form-select select2 meal_user" name="user_id" id="user_id" onchange="userReport()">
                        <option selected disabled>----  Select User Name  ----</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="user py-3 px-4">
            <h3 class="mb-0" >Name: <span id="user_name"></span></h3>
            <p class="mb-0">Identity: <span id="user_role"></span></p>
            <p class="mb-0">Department: <span id="user_department"></span></p>
            <p class="mb-0">Batch: <span id="user_batch"></span></p>
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
                            <td id="total_payment"></td>
                        </tr>
                        <tr>
                            <td>Total Meal this month</td>
                            <td id="total_meal"></td>
                        </tr>
                        {{-- <tr>
                            <td>Total @if($due > 0 ) Due @else surplus @endif this month</td>
                            <td></td>
                        </tr> --}}
                        <tr>
                            <td>Meal rate this month</td>
                            <td id="meal_rate"></td>
                        </tr>
                        <tr>
                            <td>Need to pay this month</td>
                            <td id="need_to_pay"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="payment_monthly mt-5 py-3 px-4">
            <h4 class="mb-0">Payment of this month</h4>
            <table class="table ">
                <thead>
                    <tr>
                        <th>srl#</th>
                        <th>For month</th>
                        <th>Payment date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="payment_monthly_body">
                    <tr>
                        <td></td>
                        <td colspan="2" class="text-end">total</td>
                        <td id="total_payment_monthly"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- <div class="payment_history mt-5 py-3 px-4">
            <h4 class="mb-0">All time Payment</h4>
            <table class="table ">
                <thead>
                    <tr>
                        <th>srl#</th>
                        <th>For month</th>
                        <th>Payment date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="payment_all_body">

                    <tr>
                        <td></td>
                        <td colspan="2" class="text-end">total</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div> --}}
    </div>
@endsection
@push('cjs')
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

        function userReport(){
            console.log('user selected');
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

            console.log(user_id);
            axios.get(`http://127.0.0.1:8000/report/user-report/user-search/${user_id}`)
                .then(response => {
                    if(response.data.status == 'success'){
                        console.log(response.data);
                        user_name.textContent = response.data.user.name;
                        user_role.textContent = response.data.user.user_role.user_role;
                        user_department.textContent = response.data.user.department;
                        // user_name.textContent = response.data.user.batch;
                        total_payment.textContent = response.data.total_payment_monthly;
                        total_meal.textContent = response.data.total_meal;
                        meal_rate.textContent = Math.round(response.data.meal_rate);
                        need_to_pay.textContent = Math.round(response.data.total_meal * response.data.meal_rate);
                        total_payment_monthly.textContent = response.data.total_payment_monthly;
                        let payment_month = response.data.payment_monthly;
                        console.log(payment_month);
                        let index = 0;
                        payment_month.forEach(data => {
                            console.log(data.month);
                            let month_name = new Date(data.month).toLocaleString('default', { month: 'long' });
                            console.log(month_name);
                            payment_monthly_body.insertAdjacentHTML('afterbegin', `
                                                                                    <tr>
                                                                                        <td>${index + 1}</td>
                                                                                        <td>${month_name}</td>
                                                                                        <td>${data.payment_date}</td>
                                                                                        <td>${data.amount}</td>
                                                                                    </tr>
                                                                                `);
                        })
                    }
                })
        }
    </script>
    <script>

    </script>
@endpush
