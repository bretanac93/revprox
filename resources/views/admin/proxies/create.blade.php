@extends('admin.layout')
@section('title', 'Crear proxy')
@section('page_header', 'Crear nuevo proxy')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ url('proxies') }}"><i class="fa fa-angle-double-left"></i> Volver al listado</a><br><br>
            <form method="POST" id="form" action="{{ url('proxies') }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                @include('admin.proxies.form')
            </form>
            <!-- /.box -->
        </div>
    </div>
@stop
@section('level_scripts')
    @include('admin.proxies.validations')
@stop