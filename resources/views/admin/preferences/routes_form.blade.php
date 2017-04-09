<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{{ Request::is('preferences/nginx_routes/create') ? 'Nueva ruta' : 'Editar ruta' }}</h3>
    </div>
    <div class="box-body row">
        <div class="form-group col-md-12 {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="sr-only">Nombre</label>
            <input type="text" name="name" placeholder="Nombre" value="{{ Request::is('preferences/nginx_routes/create') ? old('name') : $route->name }}" class="form-control" required>
            <span class="help-block">{{ $errors->first('name') }}</span>
        </div>

        <div class="form-group col-md-12 {{ $errors->has('ip_allow') ? 'has-error' : '' }}">
            <label for="ip_allow" class="sr-only"></label>
            <input type="text" name="ip_allow" placeholder="Direcciones IP" value="{{ Request::is('preferences/nginx_routes/create') ? old('ip_allow') : $route->ip_allow }}" class="form-control" required>
            <span class="help-block">{{ $errors->first('ip_allow') }}</span>
        </div>

    </div><!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" class="btn btn-success">
            <span class="ladda-label"><i class="fa fa-save"></i> Añadir</span>
        </button>
        <a href="{!! url(route('preferences.routes.index')) !!}" class="btn btn-default"><span> Cancelar</span></a>
    </div><!-- /.box-footer-->

</div>