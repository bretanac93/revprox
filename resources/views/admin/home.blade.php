@extends('admin.layout')
@section('title', 'Dashboard')

@section('page_header', 'Dashboard')
@section('header_description', 'Resumen de estadísticas')

@section('content')
    <div class="row">
        <!-- ./col -->
        <div class="col-lg-4 col-md-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $proxy_count }}</h3>

                    <p>Total</p>
                </div>
                <div class="icon">
                    <i class="fa fa-globe"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-md-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $proxy_active }}</h3>

                    <p>Online</p>
                </div>
                <div class="icon">
                    <i class="fa fa-signal"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-md-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $proxy_inactive }}</h3>
                    <p>Offline</p>
                </div>
                <div class="icon">
                    <i class="fa fa-wrench"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title">Sitios por nivel de visibilidad</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                      <div class="chart-responsive">
                        <canvas id="pieChart" height="150"></canvas>
                      </div>
                  </div>
                </div>
          </div>
        </div>
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Usuarios conectados</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    @foreach($users as $item)
                      <li>
                        <img src="img/avatar04.png" alt="User Image">
                        <a class="users-list-name" href="#">{{ $item->name }}</a>
                      </li>
                    @endforeach
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <!-- /.box-footer -->
              </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Ultimas operaciones realizadas</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                @foreach($operations as $item)
                  <li class="item">
                    <div class="product-img">
                      <img class="img-circle" src="img/avatar04.png" alt="Product Image">
                    </div>
                    <div class="product-info">
                      <p class="product-title">{{ $item->user->name }}<span class="label label-info pull-right">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span></p>
                          <span class="product-description">
                            {{ $item->description }}
                          </span>
                    </div>
                  </li>
                @endforeach
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
              <a href="javascript:void(0)" class="uppercase">Ver todas las operaciones</a>
            </div>
            <!-- /.box-footer -->
          </div>
        </div>
    </div>
@stop

@section('level_scripts')
<script src="{{ asset('js/chart.js') }}"></script>
@stop