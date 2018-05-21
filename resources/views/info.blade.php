@extends('app')
@section('active_dep', 'active')
@section('content')
	<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="header">Подробная информация</div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                {{ $managers[0]['department'] }}
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-3">
									<b>Managers</b>
                                </div>
                                <div class="col-md-9">
                                    <p>
                                        @for ($i = 0; $i < count($managers); $i++)
										    <b><a href="{{route('History', $managers[$i]['emp_no'])}}">{{ $managers[$i]['first_name'] }}&nbsp;{{ $managers[$i]['last_name'] }}</a></b>&nbsp;&nbsp;({{$managers[$i]['from']}}&nbsp;-&nbsp;{{$managers[$i]['to']}}) <b>{{$managers[$i]['current']}}</b><br>
										@endfor
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
									<b>Number of employee</b>
                                </div>
                                <div class="col-md-9">
                                    <p>
                                    	{{DB::table('dept_emp')->where('dept_no',$id)->count()}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection