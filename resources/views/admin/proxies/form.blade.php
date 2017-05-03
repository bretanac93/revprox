<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{{ Request::is('proxies/create') ? 'Nuevo proxy' : 'Editar proxy' }}</h3>
    </div>
    <div class="box-body row">
        <div class="form-group col-md-12 {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="sr-only">Nombre</label>
            <input type="text" name="name" placeholder="Nombre" value="{{ Request::is('proxies/create') ? old('name') : $rev_prox->name }}" class="form-control" required>
            <span class="help-block">{{ $errors->first('name') }}</span>
        </div>

        <div class="form-group col-md-12 {{ $errors->has('server_ip') ? 'has-error' : '' }}">
            <label for="server_ip" class="sr-only"></label>
            <input type="text" name="server_ip" placeholder="IP del Servidor" value="{{ Request::is('proxies/create') ? old('server_ip') : $rev_prox->server_ip }}" class="form-control" required>
            <span class="help-block">{{ $errors->first('server_ip') }}</span>
        </div>

        <div class="form-group col-md-12 {{ $errors->has('proxy_dns') ? 'has-error' : '' }}">
            <label for="proxy_dns" class="sr-only"></label>
            <input required type="text" name="proxy_dns" placeholder="DNS Proxy" value="{{ Request::is('proxies/create') ? old('proxy_dns') : $rev_prox->proxy_dns }}" class="form-control">
            <span class="help-block">{{ $errors->first('proxy_dns') }}</span>
        </div>

        <div class="form-group col-md-12">
            <label for="route" class="sr-only"></label>
            <select name="route" id="route" class="form-control">
                @foreach($routes as $item)
                    <option value="{{ $item->filename }}">{{ $item->filename }}</option>
                @endforeach
            </select>
        </div>
        {{--has_ssl--}}
        <div class="form-group col-md-12">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="has_ssl"
                            @if(Request::is('proxies/*/edit') && $rev_prox->has_ssl)
                                checked
                            @endif
                    />
                    Servidor Seguro
                </label>
            </div>
        </div>

    </div><!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" class="btn btn-success">
            <span class="ladda-label"><i class="fa fa-save"></i> Guardar</span>
        </button>
        <a href="{{ url('proxies') }}" class="btn btn-default"><span> Cancelar</span></a>
    </div><!-- /.box-footer-->
</div>
