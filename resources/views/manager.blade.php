@extends('app')
@section('active_manager', 'active')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    Менеджеры
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Таблица Менеджеров
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Manager of</th>
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
                                            <th>Manager of</th>
                                            <th>Gender</th>
                                            <th>Birthday</th>
                                            <th>Hire date</th>
                                            <th>Current Salary</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @for ($i = 0; $i < count($managers); $i++)
                                            <tr>
                                                <td>{{ $managers[$i]['first_name']}} {{$managers[$i]['last_name'] }}</td>
                                                <td>
                                                    {{ $managers[$i]['department']}} 
                                                </td>
                                                <td>
                                                    @if($managers[$i]['gender'] == 'M')
                                                    Male
                                                    @else
                                                    Female
                                                    @endif
                                                </td>
                                                <td>{{ $managers[$i]['birth_date']}}</td>
                                                <td>{{ $managers[$i]['hire_date']}}</td>
                                                <td>
                                                    {{ $managers[$i]['salary']}}
                                                </td>
                                                <td><a href="{{route('History',$managers[$i]['emp_no'])}}" class="btn btn-primary waves-effect">Сводка</a></td>
                                            </tr>
                                        @endfor
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
    <script>
        $(function () {
    $('.js-basic-example').DataTable({
        responsive: true
    });

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
    </script>
@endsection