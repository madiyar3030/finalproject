@extends('app')
@section('active_index', 'active')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Главная Страница</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">group</i>
                        </div>
                        <div class="content">
                            <div class="text">Департаменты</div>
                            <div class="number count-to" data-from="0" data-to="{{\App\Models\Department::count()}}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person</i>
                        </div>
                        <div class="content">
                            <div class="text">Менеджеры</div>
                            <div class="number count-to" data-from="0" data-to="{{count($managers)}}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_outline</i>
                        </div>
                        <div class="content">
                            <div class="text">Работники</div>
                            <div class="number count-to" data-from="0" data-to="{{\App\Models\Employee::count()-count($managers)}}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>Работники Департамента</h2>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <canvas id="bar_chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>Зарплата Менеджеров</h2>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <canvas id="bar_chart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <!-- Visitors -->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="body bg-pink">
                            <div class="sparkline" data-type="line" data-spot-Radius="4" data-highlight-Spot-Color="rgb(233, 30, 99)" data-highlight-Line-Color="#fff"
                                 data-min-Spot-Color="rgb(255,255,255)" data-max-Spot-Color="rgb(255,255,255)" data-spot-Color="rgb(255,255,255)"
                                 data-offset="90" data-width="100%" data-height="92px" data-line-Width="2" data-line-Color="rgba(255,255,255,0.7)"
                                 data-fill-Color="rgba(0, 188, 212, 0)">
                                {{$salary[0]['min']}},{{intval($salary[0]['avg'])}},{{$salary[0]['max']}}
                            </div>
                            <ul class="dashboard-stat-list">
                                <li>
                                    Highest salary
                                    <span class="pull-right"><b>{{$salary[0]['max']}}</b> <small>$</small></span>
                                </li>
                                <li>
                                    Average salary
                                    <span class="pull-right"><b>{{intval($salary[0]['avg'])}}</b> <small>$</small></span>
                                </li>
                                <li>
                                    Lowest salary
                                    <span class="pull-right"><b>{{$salary[0]['min']}}</b> <small>$</small></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- #END# Visitors -->
                <!-- Latest Social Trends -->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="body bg-cyan">
                            <div class="m-b--35 font-bold">Gender</div>
                            <ul class="dashboard-stat-list">
                                <li>
                                    Men
                                    <span class="pull-right">
                                        {{\App\Models\Employee::where('gender', 'M')->count()}}
                                    </span>
                                </li>
                                <li>
                                    Women
                                    <span class="pull-right">
                                        {{\App\Models\Employee::where('gender', 'F')->count()}}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- #END# Latest Social Trends -->
                <!-- Answered Tickets -->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="body bg-teal">
                            <div class="font-bold m-b--35">Positions</div>
                            <ul class="dashboard-stat-list">
                                @foreach($jobs as $job)
                                    <li>
                                        {{$job->title}}
                                        <span class="pull-right"><b>{{$job->user_count}}</b></span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- #END# Answered Tickets -->
            </div>

            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2>Departments</h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Department</th>
                                            <th>Current Manager</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($departments as $department)
                                        <tr>
                                            <td>{{$department->dept_no}}</td>
                                            <td>{{$department->dept_name}}</td>
                                            <td>
                                                {!!\App\Http\Controllers\AdminController::CurrentManager($department->dept_no)!!}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Task Info -->
                <!-- Browser Usage -->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="header">
                            <h2>Работники Департамента</h2>
                        </div>
                        <div class="body">
                            <div id="donut_chart" class="dashboard-donut-chart"></div>
                        </div>
                    </div>
                </div>
                <!-- #END# Browser Usage -->
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{asset('public/js/pages/index.js')}}"></script>
    <script>
        function initDonutChart() {
    Morris.Donut({
        element: 'donut_chart',
        data: [
            @for ($i = 0; $i < count($count_deps); $i++)
                {
                    label: '{{$count_deps[$i]}}',
                    value: ({{$employees[$i]}}*100/{{\App\Models\Employee::count()}}).toFixed(2)
                },
            @endfor
            ],
        colors: ['rgb(233, 30, 99)', 'rgb(0, 188, 212)', 'rgb(255, 152, 0)', 'rgb(0, 150, 136)', 'rgb(96, 125, 139)'],
        formatter: function (y) {
            return y + '%'
        }
    });
}
        $(function () {
    new Chart(document.getElementById("bar_chart").getContext("2d"), getChartJs('bar'));
    new Chart(document.getElementById("bar_chart2").getContext("2d"), getChartJs2('bar'));
});

function getChartJs(type) {
    var config = null;
        config = {
            type: 'bar',
            data: {
                labels: [
                    @foreach($departments as $department)
                        "{{$department->dept_name}}",
                    @endforeach
                ],
                datasets: [{
                    label: "Employees",
                    data: [
                        @for ($i = 0; $i < count($employees); $i++)
                            {{$employees[$i]}},
                        @endfor
                    ],
                    backgroundColor: 'rgba(0, 188, 212, 0.8)'
                }]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
    return config;
}
function getChartJs2(type) {
    var config = null;
        config = {
            type: 'line',
            data: {
                labels: [
                    @foreach($departments as $department)
                        "{{$department->dept_name}}",
                    @endforeach
                ],
                datasets: [{
                    label: "Зарплата",
                    data: [
                        @for ($i = 0; $i < count($salary_graph); $i++)
                            {{$salary_graph[$i]}},
                        @endfor
                    ],
                    backgroundColor: 'rgba(0, 188, 212, 0.8)'
                }]
            },
            options: {
                responsive: true,
                legend: true
            }
        }
    return config;
}
    </script>
    <!-- Morris Plugin Js -->
    <script src="{{asset('public/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('public/plugins/morrisjs/morris.js')}}"></script>

    <!-- ChartJs -->
    <script src="{{asset('public/plugins/chartjs/Chart.bundle.js')}}"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="{{asset('public/plugins/flot-charts/jquery.flot.js')}}"></script>
    <script src="{{asset('public/plugins/flot-charts/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('public/plugins/flot-charts/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('public/plugins/flot-charts/jquery.flot.categories.js')}}"></script>
    <script src="{{asset('public/plugins/flot-charts/jquery.flot.time.js')}}"></script>
@endsection