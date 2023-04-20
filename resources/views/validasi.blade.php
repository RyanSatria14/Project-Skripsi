<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="shortcut icon" type="image/png" href="{{asset('img/landing/logo.jpg')}}" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('', 'Miyoshi Laundry & Dry Cleaning') }}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Javascript -->
    <script defer src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script defer src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
        <div class="container">
        <a class="navbar-brand" href="http://127.0.0.1:8000/">{{ 'Miyoshi Laundry & Dry Cleaning' }}</a>
            <!--<a class="navbar-brand" href="">{{config('app.name')}}</a>-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mr-sm-3 mb-2 mb-sm-0 mt-2">
                        <a class="btn btn-warning" href="{{url('validasi')}}">Cek Validitas</a>
                    </li>
                    <li class="nav-item mr-sm-3 mb-2 mb-sm-0 mt-2">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @lang('landing.langtext')
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{url('id')}}">Indonesia</a>
                                <a class="dropdown-item" href="{{url('en')}}">English</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="btn btn-success" href="{{url('login')}}">@lang('landing.loginOrRegister')</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <section class="kelebihan bg-blue text-white">
        <div class="container p-5">
            <div class="row">
                <div class="col-lg-12">
                    <center>
                    <h4>Cek Validitas Kwitansi</h4>
                    <p>Cek validitas kwitansi digunakan untuk cek kebenaran kwitansi anda.</p>
                    <form action="{{ url('validasi') }}" method="GET">
                        @csrf
                        <div class="input-group mb-3">
                          <input type="text" name="kwitansi" class="form-control input-lg" placeholder="Masukan No. Transaksi" value="{{ request()->get('kwitansi') }}">
                          <button class="btn btn-warning" type="submit" id="button-addon2">Cek</button>
                        </div>
                    </form>
                </center>
                </div>
                @php
                    $cek=DB::table('transactions')->where('id',request()->get('kwitansi'))->count();
                @endphp
                <div class="col-lg-12">
                @if(!empty(request()->get('kwitansi')))
                    @if(!empty($cek))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <strong>VALID</strong> Nomor Transaksi yang anda cari ditemukan.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                    @else
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>INVALID</strong> Nomor Transaksi yang anda cari tidak ditemukan.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                    @endif
                @endif
            </div>
            </div>
        </div>
    </section>


    <section class="text-center p-5">
        <h3>@lang('landing.temukankami')</h3>
    </section>

    <section class="text-white bg-blue">
        <div class="container p-5">
            <div class="row">
                <div class="col-md-6 mb-4 mb-sm-0">
                    <h5><strong>Alamat</strong></h5>
                    <p>Jalan Sultan Haji Kios B No. 006 Kota Sepang, 35149 Bandar Lampung</p>
                    <br>
                    <h5><strong>Kontak</strong></h5>
                    <p>@miyoshilaundry</p>
                    <p>+628117289785</p>
                </div>
                <div class="col-md-6">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d590.4823342916374!2d105.26565888951046!3d-5.374845741637524!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40dad62963d883%3A0x36c9a0cbf0912ea9!2sMiyoshi%20Laundry%20Wet%20%26%20Dry%20Cleaning!5e0!3m2!1sid!2sid!4v1666706030351!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                </div>
            </div>
        </div>
    </section>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; {{config('')}}
                <script>
                    document.write(new Date().getFullYear())
                </script>
            </p>
        </div>
        <!-- /.container -->
    </footer>

</body>

</html>