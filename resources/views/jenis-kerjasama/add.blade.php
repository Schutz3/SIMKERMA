@extends('layouts.app')
@section('heading', 'Jenis Kerja Sama')

@section('styles')
@endsection
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="kForm" class="form form-vertical" method="post" action="{{ url('/admin/jenis-kerjasama/store') }}">
                    @csrf
                    <div class="form-body">
                        @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                        @endif
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="jenis_kerjasama">jenis kerja sama <span class="text-danger">*</span></label>
                                    <input type="text" id="jenis_kerjasama" class="form-control" name="jenis_kerjasama" required>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-custom mb-1">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('kForm');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Loading...',
                    html: 'Memproses data ke server...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    },
                });

                // Submit the form
                this.submit();
            });
        });
    </script>
</section>
@endsection

@section('scripts')
@endsection
