<li class="header">Menu</li>
<!-- Optionally, you can add icons to the links -->
<li class="{{ Request::is('dashboard*') ? 'active': ''}}">
    <a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
</li>
<li class="{{ Request::is('proxies*') ? 'active': ''}}">
    <a href="{{ url('proxies') }}"><i class="fa fa-tasks"></i> <span>Proxies</span></a>
</li>
<li class="{{ Request::is('files*') ? 'active': ''}}">
    <a href="{{ url('files') }}"><i class="fa fa-file-text-o"></i> <span>Archivos</span></a>
</li>
<li>
    <a href="#"><i class="fa fa-history"></i> <span>Historial</span></a>
</li>
<li class="treeview {{ Request::is('preferences/*') ? 'active': '' }}">
    <a href="#">
        <i class="fa fa-reorder"></i> <span>Preferencias</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('preferences/scripts*') ? 'active': '' }}"><a href="{!! url(route('preferences.scripts.index')) !!}"><i class="fa fa-terminal"></i> Scripts</a></li>
        <li class="{{ Request::is('preferences/nginx_routes*') ? 'active': '' }}"><a href="{!! url(route('preferences.routes.index')) !!}"><i class="fa fa-toggle-on"></i> Rutas</a></li>
    </ul>
</li>
<li><a href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span>Salir</span></a></li>


{{--<li class="treeview">--}}
    {{--<a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>--}}
        {{--<span class="pull-right-container">--}}
              {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
    {{--</a>--}}
    {{--<ul class="treeview-menu">--}}
        {{--<li><a href="#">Link in level 2</a></li>--}}
        {{--<li><a href="#">Link in level 2</a></li>--}}
    {{--</ul>--}}
{{--</li>--}}