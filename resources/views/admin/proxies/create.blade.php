@extends('admin.layout')
@section('title', 'Crear proxy')
@section('page_header', 'Crear nuevo proxy')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
            <a href="{{ url('proxies') }}"><i class="fa fa-angle-double-left"></i> Volver al listado</a><br><br>

            <form method="POST" action="{{ url('proxies') }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nuevo proxy</h3>
                    </div>
                    <div class="box-body row">
                        <div class="form-group col-md-12">
                            <label for="name" class="sr-only">Nombre</label>
                            <input type="text" name="name" placeholder="Nombre" value="{{ old('name') }}" class="form-control">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="server_ip" class="sr-only"></label>
                            <input type="text" name="server_ip" placeholder="IP del Servidor" value="{{ old('server_ip') }}" class="form-control" data-inputmask="'alias': 'ip'" data-mask>
                        </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">
                            <span class="ladda-label"><i class="fa fa-save"></i> Añadir</span>
                        </button>
                        <a href="{{ url('proxies') }}" class="btn btn-default"><span> Cancelar</span></a>
                    </div><!-- /.box-footer-->

                </div>
            </form><!-- /.box -->

        </div>
    </div>
@stop
@section('level_scripts')
    <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
@stop