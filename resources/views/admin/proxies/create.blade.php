@extends('admin.layout')
@section('title', 'Crear proxy')
@section('page_header', 'Crear nuevo proxy')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
            {{--@if ($errors->any())--}}
                {{--<div class="alert alert-danger">--}}
                    {{--@foreach ($errors->all() as $error)--}}
                        {{--{{ $error }}<br>--}}
                    {{--@endforeach--}}
                {{--</div>--}}
            {{--@endif--}}
            <a href="{{ url('proxies') }}"><i class="fa fa-angle-double-left"></i> Volver al listado</a><br><br>
            <form method="POST" action="{{ url('proxies') }}" accept-charset="UTF-8">
                {{ csrf_field() }}

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nuevo proxy</h3>
                    </div>
                    <div class="box-body row">
                        <div class="form-group col-md-12 {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="sr-only">Nombre</label>
                            <input type="text" name="name" placeholder="Nombre" value="{{ old('name') }}" class="form-control">
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has('server_ip') ? 'has-error' : '' }}">
                            <label for="server_ip" class="sr-only"></label>
                            <input type="text" name="server_ip" placeholder="IP del Servidor" value="{{ old('server_ip') }}" class="form-control" data-inputmask="'alias': 'ip'" data-mask>
                            <span class="help-block">{{ $errors->first('server_ip') }}</span>
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has('proxy_dns') ? 'has-error' : '' }}">
                            <label for="proxy_dns" class="sr-only"></label>
                            <input type="text" name="proxy_dns" placeholder="DNS Proxy" value="{{ old('proxy_dns') }}" class="form-control">
                            <span class="help-block">{{ $errors->first('proxy_dns') }}</span>
                        </div>

                        {{--has_ssl--}}
                        <div class="form-group col-md-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="has_ssl">
                                    Servidor Seguro
                                </label>
                            </div>
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