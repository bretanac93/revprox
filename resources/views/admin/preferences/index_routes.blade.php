@extends('admin.layout')
@section('title', 'Rutas')
@section('page_header', 'Rutas')

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <a class="btn btn-info pull-right" href="{{ url(route('preferences.routes.create')) }}"><i class="fa fa-plus"></i> <span>Añadir nuevo</span></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Direcciones IP</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($nginx_routes as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->ip_allow }}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-default btn-sm" href="{{ url(route('preferences.routes.edit', ['id' => $item->id])) }}"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-default btn-sm" href="#" onclick="if(confirm('Estas seguro?')) event.preventDefault(); document.getElementById('destroy-form-{{ $item->id }}').submit();"><i class="fa fa-remove"></i></a>
                                    <form id="destroy-form-{{ $item->id }}" action="{{ url(route('preferences.routes.delete', ['id' => $item->id])) }}" method="POST" style="display: none;">
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
                        <th>Nombre</th>
                        <th>Direcciones IP</th>
                        <th>Acciones</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
@stop