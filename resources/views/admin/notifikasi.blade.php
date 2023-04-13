@extends('admin.main')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="base_url" content="{{url('admin')}}">
<link href="{{asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{asset('vendor/datatables-responsive/css/responsive.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('main-content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">List Notification</h1>
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
                        <div class="table-responsive">
                        <table id="tbl-members" class="table dt-responsive nowrap" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Notifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @php
                                  
                                        $notif=DB::table('notifications')->where('untuk','admin')->orderBy('created_at','DESC')->get();
                                   
                                    $no=1;
                                @endphp
                                @foreach ($notif as $n)

                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td><a href="#" class="btn-detail-notif" data-toggle="modal" data-target="#detailNotif" data-id="{{ $n->id }}"> {{ $n->jd }}</a></td>
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

<div class="modal fade" id="detailNotif" tabindex="-1" role="dialog"
    aria-labelledby="detailNotifLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailNotifLabel">Lihat Notifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="isi-notif">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendor/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/notifikasi.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#tbl-members').DataTable();
    });
</script>
@endsection
