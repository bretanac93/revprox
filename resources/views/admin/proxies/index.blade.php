@extends('admin.layout')
@section('title', 'Listado de proxies')
@section('page_header', 'Listado de servidores')

@section('page_level_styles')
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@stop

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
                    <th>Nombre</th>
                    <th>IP Servidor</th>
                    <th>URL Real (Proxy)</th>
                    <th>Servidor Seguro</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>

                    @foreach($proxy_list as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->server_ip }}</td>
                            <td>{{ $item->proxy_dns }}</td>

                            <td>
                                @if($item->has_ssl)
                                    <i class="fa fa-check text-success"></i>
                                @else
                                    <i class="fa fa-times text-danger"></i>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-default btn-sm" href="#"><i class="fa fa-refresh"></i></a>
                                    <a class="btn btn-default btn-sm" href="{{ url(route('proxies.edit', ['id' => $item->id])) }}"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-default btn-sm" href="#"><i class="fa fa-remove"></i></a>
                                </div>
                            </td>
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
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            $('.table').DataTable();
        })
    </script>
@stop