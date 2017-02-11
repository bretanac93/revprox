    @extends('admin.layout')
@section('title', 'Editar Proxy')
@section('page_header', 'Editar Proxy')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="{{ url('proxies') }}"><i class="fa fa-angle-double-left"></i> Volver al listado</a><br><br>
            <form method="POST" id="form" action="{{ url(route('proxies.update', ['id' => $rev_prox->id])) }}" accept-charset="UTF-8">
                <input type="hidden" name="_method" value="PUT">
                {{ csrf_field() }}
                @include('admin.proxies.form')
            </form>
        <!-- /.box -->
        </div>
    </div>
@stop