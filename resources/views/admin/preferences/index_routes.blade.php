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
                                    <tr id="route-{{ $item->id }}">
                                        <td>{{ $item->real_path }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-default btn-sm" href="{{ url(route('preferences.routes.download', ['id' => $item->id])) }}"><i class="fa fa-download"></i></a>
                                                <a class="btn btn-default btn-sm" data-toggle="modal" data-target="#files-modal"><i class="fa fa-upload"></i></a>
                                                <a class="btn btn-default btn-sm destroy-btn" href="#" id="route_rem" o-target="{{ $item->filename }}" o-target-id="{{ $item->id }}"><i class="fa fa-remove"></i></a>
                                                <form class="destroy-form-hidden" action="{{ url(route('preferences.routes.delete', ['id' => $item->id])) }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" id="with_backup" name="with_backup" value="false">
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
{{-- if(confirm('Estas seguro?')) event.preventDefault(); document.getElementById('destroy-form-{{ $item->id }}').submit();" --}}
@section('level_scripts')
    <script>
        $('.destroy-btn').click(function (e) {
            e.preventDefault();
            var self = $(this);
            var file = self.attr('o-target');
            var file_id = self.attr('o-target-id');

            swal({
                title: 'Esta seguro?',
                text: 'Una vez eliminado el archivo será irrecuperable',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Volver atrás',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {

                if (isConfirm === true) {
                    $.get('/ajax/bak/' + file, function (res) {
                        has_bak = res.data === "" ? false: true;
                        if (has_bak) {
                            swal({
                                title: 'Archivo con backup',
                                text: 'Este archivo contiene un backup, desea crear uno nuevo, o mantener el actual?',
                                type: 'info',
                                showCancelButton: true,
                                confirmButtonText: 'Mantener el actual',
                                cancelButtonText: 'Crear uno nuevo',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                closeOnConfirm: false,
                                closeOnCancel: false
                            }, function(isConfirm) {
                                // Yes - Keep the current
                                // No - Create a new one
                                if (isConfirm === true) {

                                    // Delete the file and keep the bak
                                    $.ajax({
                                        url: '/preferences/nginx_routes/' + file_id,
                                        method: 'POST',
                                        data: {
                                            _method: 'DELETE',
                                            _token: "{{ csrf_token() }}",
                                            with_backup: 1
                                        },
                                        success: function (res) {
                                            if (res.code == 200) {
                                                swal('Eliminado!', 'El archivo ha sido eliminado correctamente dejando el respaldo anterior.', 'success');
                                                $('#route-'+file_id).remove();
                                            }
                                        }
                                    });
                                    // Delete the file and override the bak
                                } else if (isConfirm === false) {
                                    $.ajax({
                                        url: '/preferences/nginx_routes/' + file_id,
                                        method: 'POST',
                                        data: {
                                            _method: 'DELETE',
                                            _token: "{{ csrf_token() }}",
                                            with_backup: 2
                                        },
                                        success: function (res) {
                                            if (res.code == 200)
                                                swal('Eliminado!', 'El archivo ha sido eliminado correctamente creando un nuevo respaldo antes de la eliminacion.', 'success');
                                                $('#route-'+file_id).remove();
                                        }
                                    });

                                }

                            });
                        }
                        else {
                            // Without bak, delete the file and create a new one.
                            $.ajax({
                                url: '/preferences/nginx_routes/' + file_id,
                                method: 'POST',
                                data: {
                                    _method: 'DELETE',
                                    _token: "{{ csrf_token() }}",
                                    with_backup: 3
                                },
                                success: function (res) {
                                    if (res.code == 200) {
                                        swal('Eliminado!', 'El archivo ha sido eliminado correctamente creando un nuevo respaldo antes de la eliminacion.', 'success');
                                        $('#route-'+file_id).remove();
                                    }
                                }
                            });
                        }
                    });
                } //isConfirm
                else {
                    swal.close();
                }
            })
        });
    </script>
@stop
