@extends('app')
@section('active_dep', 'active')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Департаменты</h2>
            </div>
            <!-- Example Tab -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Департаменты
                            </h2>
                        </div>
                        <div class="body">
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>Current Manager</th>
                                            <th>Number of employee</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($departments as $department)
                                            <tr>
                                                <td>{{$department->dept_name}}</td>
                                                <td>
                                                    {!!\App\Http\Controllers\AdminController::CurrentManager($department->dept_no)!!}
                                                </td>
                                                <td>
                                                    {{DB::table('dept_emp')->where('dept_no',$department->dept_no)->count()}}
                                                </td>
                                                <td><a href="{{route('Info', $department->dept_no)}}" class="btn btn-primary waves-effect">Подробнее</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection