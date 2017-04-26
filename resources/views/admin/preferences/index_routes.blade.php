@extends('admin.layout')
@section('title', 'Rutas')
@section('page_header', 'Rutas')

@section('content')
    <div class="row">
        <div class="modal fade" id="files-modal" tabindex="-1" role="dialog" aria-labelledby="filesModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Subir un nuevo archivo de visibilidad</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form" name="files_form" id="files_form" action="{{ url(route('preferences.routes.store')) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input class="form-control" type="file" name="visibility_file" value="Subir archivo">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" form="files_form" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <a class="btn btn-info pull-right" data-toggle="modal" data-target="#files-modal"><i class="fa fa-plus"></i> <span>Añadir nuevo</span></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if (count($nginx_routes) == 0)
                    <h3>Ninguna ruta en el sistema, intente adicionar una.</h3>
                @else
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                            <tbody>
                                @foreach($nginx_routes as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-default btn-sm" href="{{ url(route('preferences.routes.download', ['id' => $item->id])) }}"><i class="fa fa-download"></i></a>
                                                <a class="btn btn-default btn-sm" href="{{ url(route('preferences.routes.upload', ['id' => $item->id])) }}"><i class="fa fa-upload"></i></a>
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
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
    </div>
@stop
