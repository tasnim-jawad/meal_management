@extends('admin.master')
@section('content')
    <div class="row">
        <!-- Previous Balance -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-currency-dollar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">{{round($previous_balance)}}</h5>
                    <p class="mb-2 mt-1">Previous Month Balance</p>
                </div>
            </div>
        </div>
        <!-- Total income -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-currency-dollar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">{{$total_income}}</h5>
                    <p class="mb-2 mt-1">Current month User Payment</p>
                </div>
            </div>
        </div>
        <!-- Total expense -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-currency-dollar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">{{$total_expense}}</h5>
                    <p class="mb-2 mt-1">Current month Bajar Expense</p>
                </div>
            </div>
        </div>

        {{-- Balance this month --}}
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-currency-dollar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">{{round($current_balance)}}</h5>
                    <p class="mb-2 mt-1">Balance</p>
                </div>
            </div>
        </div>


        {{-- this month cook salary --}}
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-currency-dollar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2 ">
                        {{round($total_cook_salary)}}
                        @if($cook_salary_pay_status == 'Paid')
                            <span class="badge text-bg-success ms-2">{{$cook_salary_pay_status}}</span>
                        @else
                            <span class="badge text-bg-danger ms-2">{{$cook_salary_pay_status}}</span>
                        @endif
                    </h5>
                    <p class="mb-2 mt-1">Current month Cook salary</p>
                </div>
            </div>
        </div>
        {{-- this month cook salary --}}
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-currency-dollar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">{{round($cash_in_hand)}}</h5>
                    <p class="mb-2 mt-1">Cash in hand</p>
                </div>
            </div>
        </div>



        <!-- Total meal -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-info mb-2 rounded"><i class="ti ti-chart-bar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">{{$total_meal}}</h5>
                    <p class="mb-2 mt-1">Current Month Total Meal</p>
                </div>
            </div>
        </div>

        <!-- tomorrow total meal -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-currency-dollar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">{{$tomorrow_total_meal}}</h5>
                    <p class="mb-2 mt-1">Tomorrow Total meal</p>
                </div>
            </div>
        </div>

        {{-- this month meal rate --}}
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-currency-dollar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">{{round($meal_rate)}}</h5>
                    <p class="mb-2 mt-1">Current month meal rate</p>
                </div>
            </div>
        </div>




    </div>


    {{-- @push('cjs')
        <script src="/adminAsset/js/chartjs.js"></script>
        <script>
            isRtl = isDarkStyle = true;
            let cardColor = "#2f3349"
            let borderColor = "#434968"
            let textMuted = "#7983bb"
            let headingColor = "#cfd3ec"
            let bodyColor = "#b6bee3"
        </script>

        <script>

            const ctx = document.getElementById('muliChart');
            ctx &&
                new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: ['jan', 'feb', 'mar', 'apr', 'may'],
                        datasets: [{
                                data: {{ json_encode( $monthly_bookings ) }},
                                label: "booking",
                                borderColor: "tomato",
                                tension: .5,
                                pointStyle: "circle",
                                backgroundColor: "tomato",
                                fill: !1,
                                pointRadius: 1,
                                pointHoverRadius: 5,
                                pointHoverBorderWidth: 5,
                                pointBorderColor: "transparent",
                                pointHoverBorderColor: cardColor,
                                pointHoverBackgroundColor: "tomato"
                            },
                            {
                                data:  {{ json_encode( $monthly_income ) }},
                                label: "income",
                                borderColor: "green",
                                tension: .5,
                                pointStyle: "circle",
                                backgroundColor: "green",
                                fill: !1,
                                pointRadius: 1,
                                pointHoverRadius: 5,
                                pointHoverBorderWidth: 5,
                                pointBorderColor: "transparent",
                                pointHoverBorderColor: cardColor,
                                pointHoverBackgroundColor: "green"
                            },
                        ]
                    },
                    options: {
                        responsive: !0,
                        maintainAspectRatio: !1,
                        scales: {
                            x: {
                                grid: {
                                    color: borderColor,
                                    drawBorder: !1,
                                    borderColor: borderColor
                                },
                                ticks: {
                                    color: textMuted
                                }
                            },
                            y: {
                                scaleLabel: {
                                    display: !0
                                },
                                min: 0,
                                max: 60,
                                ticks: {
                                    color: textMuted,
                                    stepSize: 100
                                },
                                grid: {
                                    color: borderColor,
                                    drawBorder: !1,
                                    borderColor: borderColor
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                rtl: isRtl,
                                backgroundColor: cardColor,
                                titleColor: headingColor,
                                bodyColor: bodyColor,
                                borderWidth: 1,
                                borderColor: borderColor
                            },
                            legend: {
                                position: "top",
                                align: "start",
                                rtl: isRtl,
                                labels: {
                                    usePointStyle: !0,
                                    padding: 35,
                                    boxWidth: 6,
                                    boxHeight: 6,
                                    color: bodyColor
                                }
                            }
                        }
                    }
                })
        </script>
    @endpush  --}}
@endsection
