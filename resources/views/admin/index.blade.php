@extends('admin.main')

@section('css')
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endsection

@section('main-content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard Admin</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <p>Jumlah Member</p>

                        <h3>{{$banyak_member}}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-people"></i>
                    </div>
                    <a href="{{url('admin/members')}}" class="small-box-footer">Lihat member <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>Jumlah Transaksi</p>

                        <h3>{{$banyak_transaksi}}</h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{url('admin/transaksi')}}" class="small-box-footer">Lihat transaksi <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Transaksi Berjalan (Priority Service): </h3>
                        <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($priority_service as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{date('d F Y', strtotime($item->created_at))}}</td>
                                    <td>
                                        @if ($item->status_id != '3')
                                        <span class="text-warning">{{$item->status->name}}</span>
                                        @else
                                        <span class="text-success">{{$item->status->name}}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-3">Transaksi Berjalan: </h3>
                        <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi_terbaru as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{date('d F Y', strtotime($item->created_at))}}</td>
                                    <td>
                                        @if ($item->status_id != '3')
                                        <span class="text-warning">{{$item->status->name}}</span>
                                        @else
                                        <span class="text-success">{{$item->status->name}}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
@endsection
