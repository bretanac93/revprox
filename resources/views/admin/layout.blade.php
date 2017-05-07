<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>revProx | @yield('title')</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="{{ asset('plugins/pace-loader/flash-white.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables/jquery.dataTables_themeroller.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
    {{-- Custom validation css tag --}}
    <style>
        .error,
        .error:active,
        .error:visited
        {
            border-color: #dd4b39;
        }
        label.error {
            color: #dd4b39;
        }

    </style>
    <script>
        var userLogged = "http://avatar.upr.edu.cu/"+"{{ Auth::user()->email }}".split("@")[0]+".jpeg"
    </script>

    @yield('page_level_styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>r</b>P</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>rev</b>Prox</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="" class="img-circle" id="user-img" alt="User Image">

                                <p>
                                    {{ Auth::user()->name }}
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="" class="img-circle user-image" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                @include('admin.menu')
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page_header')
                <small>@yield('header_description')</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            @include('admin.partials.message')
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            UPR
        </div>
        <!-- Default to the left -->
        <strong>Handcrafted by <a href="https://github.com/bretanac93">Cesar Bretaña Gonzalez</a>.</strong>
    </footer>

    <!-- Control Sidebar -->
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/dist/additional-methods.js') }}"></script>
<script src="{{ asset('js/ipValidation.js') }}"></script>

<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/chartjs/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/vendor.js') }}"></script>
<script>
    $('.user-image').attr('src', this.userLogged);
    $('#sidebar-image').attr('src', this.userLogged);
    $('#user-img').attr('src', this.userLogged);
</script>

@yield('level_scripts')

</body>
</html>
