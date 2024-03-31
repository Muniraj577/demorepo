@extends('layouts.admin.app')
@section('title', 'Dashboard')
@section('dashboard', 'active')
@section('content')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card create-card">
                        <div class="card-body">
                            <button class="btn btn-primary">Dashboard</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach($dashboard_datas as $key => $data)
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="{{$data['link'] != null ? $data['link'] : 'javascript:void(0);'}}"
                           style="color: black">
                            <div class="info-box">
                                <span class="info-box-icon {{$data['color']}} elevation-1"><i
                                            class="{{$data['icon']}}"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{$data['title']}}</span>
                                    <span class="info-box-number">
                                    {{$data['totalCount']}}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @if(($key + 1) % 2 == 0)
                        <div class="clearfix hidden-md-up"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
