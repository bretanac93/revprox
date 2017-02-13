@extends('admin.layout')
@section('title', 'Archivos de configuración')
@section('page_header', 'Archivos de configuración')

@section('page_level_styles')
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <a class="btn btn-info pull-right" href="{{ url(route('proxies.create')) }}"><i class="fa fa-plus"></i> <span>Añadir nuevo</span></a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                    <th>Ubicación</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>

                @foreach($proxy_list as $item)
                    <tr>
                        <td>/etc/nginx/sites-available/{{ $item->proxy_dns }}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-default btn-sm" href="{{ url(route('files.edit', ['id' => $item->id])) }}"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-default btn-sm" href="#" onclick="if(confirm('Estas seguro?')) event.preventDefault(); document.getElementById('destroy-form').submit();"><i class="fa fa-remove"></i></a>
                                <form id="destroy-form" action="{{ url(route('files.destroy', ['id' => $item->id])) }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach



                </tbody>
                <tfoot>
                <tr>
                    <th>Ubicación</th>
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