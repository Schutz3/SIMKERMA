<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistem Kerja Sama (SIMKERMA) PNJ menyajikan data historis kerja sama Politeknik Negeri Jakarta" />
    <meta name="keywords" content="Sistem Informasi Kerja Sama Politeknik Negeri Jakarta" />
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <title>Sistem Informasi Kerja Sama - Politeknik Negeri Jakarta</title>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Viga" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/fontawesome/all.min.css') }}">
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/app.css') }}">
    <script src="https://kit.fontawesome.com/9e76bc90bb.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .sidebar-wrapper {
            width: 260px
        }
        #main {
            margin-left: 260px;
        }
        .sidebar-wrapper .menu {
            padding: 0 0.5rem;
        }
        table.dataTable td, table.table-sm td {
            padding: 15px 8px !important;
        }
        .form-control.is-invalid~.form-control-icon {
            top: 32%;
        }
        .select2-container .select2-selection--single {
        height: 38px !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
        }
    </style>
</head>
<body>
    @if (url()->current() != url('/login') && url()->current() != url('/password/reset') && url()->current() != url('/sso/cb'))
        <div id="app">
            @if (Auth::check() && Auth::user()->role->role_name == 'admin')
                @include('layouts.sidebar-admin')

            @elseif (Auth::check() && Auth::user()->role->role_name == 'pemimpin')
                @include('layouts.sidebar-pemimpin')
            @elseif (Auth::check() && Auth::user()->role->role_name == 'pic')
                @include('layouts.sidebar-pic')
            @elseif (Auth::check() && Auth::user()->role->role_name == 'legal')
                @include('layouts.sidebar-legal')
            @elseif (Auth::check() && Auth::user()->role->role_name == 'direktur')
                @include('layouts.sidebar-direktur')
            @endif

            <div id="main">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>
                <div class="page-heading">
                    <h3>@yield('heading')</h3>
                </div>
                <div class="page-content">
                    @yield('content')
                </div>
                {{-- <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2021 &copy; Mazer</p>
                        </div>
                        <div class="float-end">
                            <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="http://ahmadsaugi.com">A. Saugi</a>
                            </p>
                        </div>
                    </div>
                </footer> --}}
            </div>
        </div>
    @else
        @yield('content-auth')
    @endif

    @yield('scripts')
    <script src="{{ asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/sweetalert2/sweetalert2.all.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/mazer.js') }}"></script>
    <script src="{{ asset('admin/js/extensions/sweetalert2.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const registerDeleteItemHandler = () =>{
            const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();


                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Data yang dihapus tidak dapat di kembalikan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                });
            });
        });
        }
        // registerDeleteItemHandler();

        $("#datatable").DataTable({
            "scrollX": true,
            "lengthMenu": [
                [10, 50, 75, -1],
                [10, 50, 75, "All"]
            ]
        }).on('draw.dt', function(){
            registerDeleteItemHandler();
        });
    });
    </script>
</body>
</html>
