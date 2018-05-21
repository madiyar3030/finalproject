@extends('app')
@section('active_employee', 'active')
@section('content')
	<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    Работники
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Таблица Работников
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Current Position</th>
                                            <th>Current Department</th>
                                            <th>Gender</th>
                                            <th>Birthday</th>
                                            <th>Hire date</th>
                                            <th>Current Salary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Current Position</th>
                                            <th>Current Department</th>
                                            <th>Gender</th>
                                            <th>Birthday</th>
                                            <th>Hire date</th>
                                            <th>Current Salary</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    	@foreach($employees as $employee)
	                                        <tr>
	                                            <td>{{$employee->first_name}} {{$employee->last_name }}</td>
	                                            <td>
	                                            	{{\App\Http\Controllers\AdminController::CurrentPosition($employee->emp_no)}}
	                                            </td>
	                                            <td>
	                                            	{{\App\Http\Controllers\AdminController::CurrentDepartment($employee->emp_no)}}	
	                                            </td>
	                                            <td>
		                                            @if($employee->gender == 'M')
		                                            Male
		                                            @else
		                                            Female
		                                            @endif
		                                        </td>
	                                            <td>{{$employee->birth_date}}</td>
	                                            <td>{{$employee->hire_date}}</td>
	                                            <td>
		                                            {{\App\Http\Controllers\AdminController::CurrentSalary($employee->emp_no)}}
		                                        </td>
		                                        <td><a href="{{route('History',$employee->emp_no)}}" class="btn btn-primary waves-effect">Сводка</a></td>
	                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="dataTables_paginate paging_simple_numbers">
                                	{{$employees->links()}}                                	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
<!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('public/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>
    <script src="{{asset('public/js/pages/tables/jquery-datatable.js')}}"></script>
@endsection