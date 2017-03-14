@extends('admin.layout')
@section('title', 'Modificar scripts')
@section('page_header', 'Modificar scripts')

@section('page_level_styles')
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/lib/material.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/lib/simplescrollbars.css') }}">

    <script src="{{ asset('plugins/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/lib/shell.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/lib/simplescrollbars.js') }}"></script>
@stop

@section('content')
    <div class="col-md-12">
        <div class="callout callout-danger">
            <h4>Peligro</h4>
            <p>La modificación erronea de uno de estos ficheros puede comprometer el sistema completo, si no sabe lo que hace abandone esta zona.</p>
        </div>
        <div class="col-md-6">
            <div class="box box-solid box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">No seguro (HTTP)</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form method="POST" id="form" action="{{ url(route('preferences.scripts.update')) }}" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_file_id" value="http">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="file_content" id="http_content" cols="30">{{ $sc1_content }}</textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-default" value="Modificar">
                        </div>
                    </form>

                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-solid box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Seguro (HTTPS)</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form method="POST" id="form" action="{{ url(route('preferences.scripts.update')) }}" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_file_id" value="https">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="file_content" id="https_content" cols="30">{{ $sc2_content }}</textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-default" value="Modificar">
                        </div>
                    </form>

                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@stop
@section('level_scripts')
    <script>
        var e1 = CodeMirror.fromTextArea(document.getElementById('http_content'), {
            height: "500px",
            lineNumbers: true,
            styleActiveLine: true,
            matchBrackets: true,
            theme: 'material',
            indentUnit: 4,
            scrollbarStyle: 'simple'
        });

        var e2 = CodeMirror.fromTextArea(document.getElementById('https_content'), {
            height: "500px",
            lineNumbers: true,
            styleActiveLine: true,
            matchBrackets: true,
            theme: 'material',
            indentUnit: 4,
            scrollbarStyle: 'simple'
        });

    </script>
@stop