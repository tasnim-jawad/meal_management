@extends('admin.master')
@section('content')

    <div class="row">
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-currency-dollar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">Current month User payment</h5>
                    <p class="mb-2 mt-1">{{$userpayment}}</p>
                </div>
            </div>
        </div>

        <!-- Total Sales -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-info mb-2 rounded"><i class="ti ti-chart-bar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">Current month total meal</h5>
                    <p class="mb-2 mt-1">{{$totalMeal}} </p>
                </div>
            </div>
        </div>

        <!-- Total Profit -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <a href="{{ route('admin.user.all_user') }}">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-currency-dollar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">All User Total Due</h5>
                    <p class="mb-2 mt-1">{{$total_due}}</p>
                </div>
                <!-- Add the link here with the href attribute -->
             </a>
            </div>
        </div>

        <!-- Total Sales -->
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <a href="#">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-currency-dollar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">Tomorrow Total meal</h5>
                    <p class="mb-2 mt-1">{{$tomorrowtotalMeal}}</p>
                </div>
                <!-- Add the link here with the href attribute -->
             </a>
            </div>
        </div>

        {{-- this month meal rate --}}
        <div class="col-xl-3 col-md-4 col-6 mb-4">
            <a href="#">
            <div class="card" style="height: 200px">
                <div class="card-body">
                    <div class="badge p-2 bg-label-danger mb-2 rounded"><i class="ti ti-currency-dollar ti-md"></i></div>
                    <h5 class="card-title mb-1 pt-2">Current month meal rate</h5>
                    <p class="mb-2 mt-1">{{$mealRate}}</p>
                </div>
                <!-- Add the link here with the href attribute -->
             </a>
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
