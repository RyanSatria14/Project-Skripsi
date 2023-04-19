@extends('member.main')

@section('css')
<link href="{{asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{asset('vendor/datatables-responsive/css/responsive.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('main-content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar Harga</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="kiloan-tab" data-toggle="tab" href="#kiloan" role="tab"
                                    aria-controls="kiloan" aria-selected="true">Kiloan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="satuan-tab" data-toggle="tab" href="#satuan" role="tab"
                                    aria-controls="satuan" aria-selected="false">Satuan</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="myTabContent">
                            <div class="tab-pane fade show active" id="kiloan" role="tabpanel"
                                aria-labelledby="kiloan-tab">
                                <div class="table-responsive">
                                <table id="tbl-kiloan" class="table dataTable dt-responsive nowrap" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Servis</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            <div class="tab-pane fade" id="satuan" role="tabpanel" aria-labelledby="satuan-tab">
                                <div class="table-responsive">
                                <table id="tbl-satuan" class="table dataTable dt-responsive nowrap" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Servis</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="mt-3">Daftar Tipe Service</h5>
                        <div class="tab-content mt-3" id="myTabContent">
                            <div class="table-responsive">
                            <table id="tbl-service" class="table dataTable dt-responsive nowrap" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tipe Service</th>
                                        <th>Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('scripts')
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendor/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    });

    var tabel1 = $('#tbl-kiloan').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ route('m.kiloan.list') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "no" },
                { "data": "nm_brg" },
                { "data": "nm_service" },
                { "data": "price" }
            ]  

        });

      var tabel2 = $('#tbl-satuan').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ route('m.satuan.list') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "no" },
                { "data": "nm_brg" },
                { "data": "nm_service" },
                { "data": "price" }
            ]  

        });

          var tabel3 = $('#tbl-service').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ route('m.service.list') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "no" },
                { "data": "name" },
                { "data": "cost" }
            ]  

        });
    });
</script>
@endsection
