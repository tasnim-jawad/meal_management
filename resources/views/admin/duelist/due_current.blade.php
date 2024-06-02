@extends('admin.master')

@section('content')
    <div id="calendar"></div>
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-3">User Current Balance</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table border-top dataTable no-footer dtr-column text-center " id="DataTables_Table_0"
            aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr>
                    <th>serial</th>
                    <th>User</th>
                    <th>Mobile</th>
                    <th>previous due</th>
                    <th>previous advance</th>
                    <th>Clear the previous</th>
                    <th>running month due</th>
                    <th>running month advance</th>
                    <th>current due</th>
                    <th>current advance</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($result as $key => $user_data)
                    <tr>
                        <td>{{ $key + 1}}</td>
                        @foreach ($user_data as $user_id => $user)
                            <td>{{ $user['user_info']['name'] }}</td>
                            <td>{{ $user['user_info']['mobile'] }}</td>
                            <td>{{ round($user['previous_due']) }}</td>
                            <td>{{ round($user['previous_advance_payment']) }}</td>
                            <td>
                                @if ($user['previous_due'] > 0)
                                    <button type="button" class="btn btn-warning btn-sm" onclick="submit_form('received_due',{{$user_id}})"> received </button>
                                @elseif ($user['previous_advance_payment'] > 0)
                                    <button type="button" class="btn btn-info btn-sm" onclick="submit_form('return_advance',{{$user_id}})"> return </button>
                                @else
                                    {{"--"}}
                                @endif
                                <form action="" id="form_{{$user_id}}" class="d-none">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $user_id }}">
                                </form>
                            </td>
                            <td>{{ round($user['running_month_due']) }}</td>
                            <td>{{ round($user['running_month_advance_payment']) }}</td>
                            <td class="border-danger">{{ round($user['current_due']) }}</td>
                            <td class="border-success">{{ round($user['current_advance_payment']) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
@endsection
@push('end_js')
    <script>
        function received_due(user_id){
            console.log(user_id);
            console.log('clicked');
            if (confirm('Are you sure you want to remove previous dues?')) {
                // console.log('confirm');
            }
        }
        function submit_form(state,user_id){
            console.log('click submit form');
            console.log(location.href);
            if(state == 'received_due'){
                if (confirm('Are you sure you want to remove previous dues?')) {
                    const formData = new FormData(document.getElementById(`form_${user_id}`));
                    axios.post("/due/received-due",formData)
                            .then(responce => {
                                console.log(responce);
                                location.reload();
                                window.toaster('updated successfuly', 'success');
                            })
                            .catch(error => {
                                console.error(error);
                            });

                }
            }
            if(state == 'return_advance'){
                if (confirm('Are you sure you want to give back previous advance?')) {
                    console.log('confirm',event);
                    const formData = new FormData(document.getElementById(`form_${user_id}`));
                    formData.forEach((value, key) => {
                        console.log(`${key}: ${value}`);
                    });
                    axios.post("/due/return-advance",formData)
                            .then(responce => {
                                console.log(responce);
                                location.reload();
                                window.toaster('updated successfuly', 'success');
                            })
                            .catch(error => {
                                console.error(error);
                            });

                }
            }

        }
    </script>
@endpush
