@extends('admin.main')

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
                <h1 class="m-0 text-dark">Daftar Member</h1>
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
                                    <th>ID Member</th>
                                    <th>Nama Member</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>No Telp</th>
                                    <th>Poin</th>
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

        var tabel1 = $('#tbl-members').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ route('a.member.list') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "no" },
                { "data": "id" },
                { "data": "name" },
                { "data": "gender" },
                { "data": "address" },
                { "data": "phone_number" },
                { "data": "point" }
            ]  

        });
    });
</script>
@endsection
