@extends('admin.layout')
@section('title', 'Rutas | Crear')
@section('page_header', 'Adicionar Ruta')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ url('preferences.routes.index') }}"><i class="fa fa-angle-double-left"></i> Volver al listado</a><br><br>
            <form method="POST" id="form" action="{{ url(route('preferences.routes.store')) }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                @include('admin.preferences.routes_form')
            </form>
            <!-- /.box -->
        </div>
    </div>
@stop
@section('level_scripts')
    @include('admin.preferences.validations')
@stop