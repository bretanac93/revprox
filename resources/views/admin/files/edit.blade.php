@extends('admin.layout')
@section('title', 'Editar Proxy')
@section('page_header', 'Editar Proxy')

@section('page_level_styles')
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/lib/material.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/lib/simplescrollbars.css') }}">

    <script src="{{ asset('plugins/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/lib/nginx.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/lib/simplescrollbars.js') }}"></script>

@stop
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ url('proxies') }}"><i class="fa fa-angle-double-left"></i> Volver al listado</a><br><br>
            <form method="POST" id="form" action="{{ url(route('files.update', ['id' => $id])) }}" accept-charset="UTF-8">
                <input type="hidden" name="_method" value="PUT">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="file_content" id="file_content" cols="30">{{ $content }}</textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-default" value="Editar">
                </div>
            </form>
            <!-- /.box -->
        </div>
    </div>
@stop

@section('level_scripts')
    <script>
        var editor = CodeMirror.fromTextArea(document.getElementById('file_content'), {
            height: "300px",
            lineNumbers: true,
            styleActiveLine: true,
            matchBrackets: true,
            theme: 'material',
            indentUnit: 4,
            scrollbarStyle: 'simple'
        });
    </script>
@stop