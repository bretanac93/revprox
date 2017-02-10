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
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-md-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $proxy_count }}</h3>

                    <p>Online</p>
                </div>
                <div class="icon">
                    <i class="fa fa-signal"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-md-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>0</h3>
                    <p>Offline</p>
                </div>
                <div class="icon">
                    <i class="fa fa-wrench"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@stop