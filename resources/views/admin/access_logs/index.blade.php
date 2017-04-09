@extends('admin.layout')
@section('title', 'Registro de Accesos')
@section('page_header', 'Registro de Accesos')

@section('content')
    <div class="box">
        <div class="box-header">
            <a class="btn btn-info pull-right" href="{{ url('proxies/create') }}"><i class="fa fa-plus"></i> <span>Añadir nuevo</span></a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                    <th>Url Servidor</th>
                    <th>IP Cliente</th>
                    <th>Solicitud</th>
                    <th>Fecha y Hora</th>
                    <th>Respuesta</th>
                </tr>
                </thead>
                <tbody>

                @foreach($access_logs as $item)
                    <tr>
                        <td>{{ $item->referrer }}</td>
                        <td>{{ $item->host }}</td>
                        <td>{{ $item->request }}</td>
                        <td>{{ $item->time }}</td>
                        <td>{{ $item->status }}</td>
                    </tr>
                @endforeach



                </tbody>
                <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>IP Servidor</th>
                    <th>URL Real (Proxy)</th>
                    <th>Servidor Seguro</th>
                    <th>Acciones</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    {{--<ul>--}}

    {{--</ul>--}}
@stop
@section('level_scripts')
    <script>
        $(function () {
            $('.table').DataTable();
        })
    </script>
@stop