<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{{ Request::is('proxies/create') ? 'Nuevo proxy' : 'Editar proxy' }}</h3>
    </div>
    <div class="box-body row">
        <div class="form-group col-md-12 {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="sr-only">Nombre de referencia</label>
            <input type="text" name="name" value="{{ Request::is('proxies/create') ? old('name') : $rev_prox->name }}" class="form-control" required aria-describedby="nameHelp">
            <small id="nameHelp" class="form-text text-muted">Nombre descriptivo para facilidad de búsqueda en el panel de administración.</small>
            <span class="help-block">{{ $errors->first('name') }}</span>

        </div>

        <div class="form-group col-md-12 {{ $errors->has('server_ip') ? 'has-error' : '' }}">
            <label for="server_ip" class="sr-only">IP del sistema</label>
            <input type="text" name="server_ip" value="{{ Request::is('proxies/create') ? old('server_ip') : $rev_prox->server_ip }}" class="form-control" required aria-describedby="ipHelp">
            <small id="ipHelp" class="form-text text-muted">Dirección IP del sistema (ej: 10.2.24.48)</small>
            <span class="help-block">{{ $errors->first('server_ip') }}</span>

        </div>

        <div class="form-group col-md-12 {{ $errors->has('proxy_dns') ? 'has-error' : '' }}">
            <label for="proxy_dns" class="sr-only">Subdominio</label>
            <input required type="text" name="proxy_dns" value="{{ Request::is('proxies/create') ? old('proxy_dns') : $rev_prox->proxy_dns }}" class="form-control" aria-describedby="subdomainHelp">
            <small id="subdomainHelp" class="form-text text-muted">Subdominio. (ej: intranet.upr.edu.cu)</small>
            <span class="help-block">{{ $errors->first('proxy_dns') }}</span>

        </div>

        <div class="form-group col-md-12">
            <label for="route" class="sr-only">Archivo de visibilidad</label>
            <select name="route_id" id="route" class="form-control">
                @foreach(App\NginxRoute::all() as $item)
                    <option value="{{ $item->id }}">{{ $item->filename }}</option>
                @endforeach
            </select>
            <small id="routeHelp" class="form-text text-muted">Archivo de visibilidad</small>
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
