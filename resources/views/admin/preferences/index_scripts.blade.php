@extends('admin.layout')
@section('title', 'Modificar scripts')
@section('page_header', 'Modificar scripts')

@section('content')
    <div class="col-md-12">
        <div class="callout callout-danger">
            <h4>Cuidado</h4>
            <p>La modificación erronea de uno de estos ficheros puede comprometer el sistema completo, si no sabe lo que hace abandone esta zona.</p>
        </div>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Ficheros, presione la cabecera para desplegar</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="box-group" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel box box-warning">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    Proxy Reverso no Seguro (http)
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="box-body">
                                <form method="POST" id="form" action="{{ url(route('preferences.scripts.update')) }}" accept-charset="UTF-8">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_file_id" value="http">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <textarea name="file_content" id="file_content" cols="30">{{ $sc1_content }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-default" value="Modificar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel box box-success">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                    Proxy Reverso Seguro (https)
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="box-body">
                                <form method="POST" id="form" action="{{ url(route('preferences.scripts.update')) }}" accept-charset="UTF-8">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_file_id" value="https">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <textarea name="file_content" id="file_content" cols="30">{{ $sc2_content }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-default" value="Editar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@stop