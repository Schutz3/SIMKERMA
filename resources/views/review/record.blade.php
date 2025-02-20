@extends('layouts.app')
@section('heading', 'Rekam Kerja Sama')

@section('styles')
    <link rel="stylesheet" href="{{ asset('admin/vendors/choices.js/choices.min.css') }}">
@endsection
@section('content')
    <section class="row">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (Auth::user()->role->role_name == 'admin')
                        <form id="kForm" class="form form-vertical" method="post"
                            action="{{ url('/admin/pengajuan-kerjasama/store-record') }}" enctype="multipart/form-data">
                        @elseif (Auth::user()->role->role_name == 'pic')
                            <form id="kForm" class="form form-vertical" method="post"
                                action="{{ url('/pic/pengajuan-kerjasama/store') }}" enctype="multipart/form-data">
                    @endif
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="kerjasama">Nama Mitra<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="mitra" class="form-control" name="mitra" required
                                        value="{{ old('mitra') }}" placeholder="Masukan nama Mitra yang bekerja sama">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="kerjasama">Kerja sama <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="kerjasama" class="form-control" name="kerjasama" required
                                        value="{{ old('kerjasama') }}" placeholder="Masukan Judul Kerjasama">
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="tanggal_mulai">tanggal mulai <span
                                            class="text-danger">*</span></label>
                                    <input type="date" id="tanggal_mulai" class="form-control" name="tanggal_mulai"
                                        required value="{{ old('tanggal_mulai') }}">
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="tanggal_selesai">tanggal selesai <span
                                            class="text-danger">*</span></label>
                                    <input type="date" id="tanggal_selesai" class="form-control" name="tanggal_selesai"
                                        required value="{{ old('tanggal_selesai') }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="nomor">nomor <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="nomor" class="form-control" name="nomor" required
                                        value="{{ old('nomor') }}" placeholder="Nomor Surat Bisa WAJIB DIISI">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="kegiatan">kegiatan</label>
                                    <textarea id="kegiatan" class="form-control" name="kegiatan" rows="3"
                                        placeholder="Jelaskan kegiatan secara ringkas">{{ old('kegiatan') }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="kerjasama">Sifat (Lokal / Nasional /
                                        Internasional) <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sifat" id="sifat0"
                                            value="Lokal" required {{ old('sifat') == 'Lokal' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sifat0">
                                            Lokal
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sifat" id="sifat1"
                                            value="Nasional" required {{ old('sifat') == 'Nasional' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sifat1">
                                            Nasional
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sifat" id="sifat2"
                                            value="Internasional" {{ old('sifat') == 'Internasional' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sifat2">
                                            Internasional
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">

                                    <label class="mb-2 fw-bold text-capitalize" for="kriteria_mitra_id">Kriteria Mitra
                                        <span class="text-danger">*</span></label>
                                    <select class="form-select" required id="kriteria_mitra_id"
                                        name="kriteria_mitra_id[]">
                                        <option value="">Pilih Kriteria Mitra</option>
                                        @foreach ($kriteria_mitra as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('kriteria_mitra_id') && old('kriteria_mitra_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->id }}. {{ $item->kriteria_mitra }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="kriteria_kemitraan_id">Kriteria
                                        Kemitraan <span class="text-danger">*</span></label>
                                    <select class="choices form-select" multiple="multiple" required
                                        id="kriteria_kemitraan_id" name="kriteria_kemitraan_id[]" multiple>
                                        <option value="">Pilih Kriteria Kemitraan</option>
                                        @foreach ($kriteria_kemitraan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('kriteria_kemitraan_id') && old('kriteria_kemitraan_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->id }}. {{ $item->kriteria_kemitraan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="bidang_kerjasama_id">Bidang
                                        Kerjasama<span class="text-danger">*</span></label>
                                    <select class="choices-3 form-select" required id="bidang_kerjasama_id"
                                        name="bidang_kerjasama_id[]" multiple='multiple' multiple>

                                        <option value="">Pilih Bidang Kerjasama</option>
                                        @foreach ($bidangKerjasama as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('bidang_kerjasama_id') && old('bidang_kerjasama_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_bidang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">



                                    <label class="mb-2 fw-bold text-capitalize" for="perjanjian">Jenis Perjanjian <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="perjanjian" name="perjanjian[]" required>
                                        <option value="">Pilih Dokumen Perjanjian</option>
                                        @foreach ($perjanjian as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('perjanjian') && in_array($item->id, old('perjanjian')) ? 'selected' : '' }}>
                                                {{ $item->pks }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">

                                    <label class="mb-2 fw-bold text-capitalize" for="jurusan">Jurusan / Unit<span
                                            class="text-danger">*</span></label>
                                    <select class="choices-2 form-select" multiple="multiple" id="jurusan"
                                        name="jurusan[]" multiple required>

                                        @foreach ($unit as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('jurusan') && in_array($item->id, old('jurusan')) ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">

                                <label class="mb-2 fw-bold text-capitalize" for="prodi">Prodi</label>
                                <select id="prodi" name="prodi[]" multiple>
                                </select>
                                <div id="prodi-loading" style="display: none;">
                                    <small class="text-muted">Memuat data prodi...</small>
                                </div>


                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="pic_pnj">Nama PIC PNJ <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="pic_pnj" class="form-control" name="pic_pnj" required
                                        value="{{ auth::user()->name }}">
                                    <input type="hidden" name="pic_pnj" value="{{ auth::user()->name }}">
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="pic_industri">Nama PIC Industri/PT
                                        <span class="text-danger">*</span></label>
                                    <input type="text" id="pic_industri" class="form-control" name="pic_industri"
                                        required value="{{ old('pic_industri') }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="jabatan_pic_industri">Jabatan PIC
                                        Industri/PT <span class="text-danger">*</span></label>
                                    <input type="text" id="jabatan_pic_industri" class="form-control"
                                        name="jabatan_pic_industri" required value="{{ old('jabatan_pic_industri') }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="alamat_perusahaan">Alamat Perusahaan
                                        <span class="text-danger">*</span></label>
                                    <input type="text" id="alamat_perusahaan" class="form-control"
                                        name="alamat_perusahaan" required value="{{ old('alamat_perusahaan') }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="telp_industri">Telp. PIC
                                        Industri</label>
                                    <input type="tel" id="telp_industri" class="form-control" name="telp_industri"
                                        value="{{ old('telp_industri') }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="email">Email PIC Industri</label>
                                    <input type="email" id="email" class="form-control" name="email"
                                        value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="file">Surat Kerja sama <span
                                            class="text-danger">*</span></label>
                                    <input type="file" id="file" class="form-control" name="file" required
                                        accept="application/pdf">
                                    <small class="text-muted">Jenis file: PDF,DO,DOCX<br>Max: 25MB</small>
                                </div>
                            </div>
                            <hr>

                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-custom mb-1">Submit</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            // Inisialisasi Choices.js untuk prodi
            const prodiElement = document.getElementById('prodi');
            const prodiChoice = new Choices(prodiElement, {
                removeItemButton: true,
                searchEnabled: true
            });

            // Handler untuk perubahan unit
            $('#jurusan').on('change', function() {
                const selectedUnits = $(this).val();

                prodiChoice.clearStore();
                prodiChoice.setChoices([{
                    value: '',
                    label: '--- Memuat data prodi... ---',
                    disabled: true
                }]);

                if (selectedUnits && selectedUnits.length > 0) {
                    $.ajax({
                        url: `/api/prodi/find/${selectedUnits.join(',')}`,
                        method: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            $('#prodi-loading').show();
                        },
                        success: function(response) {
                            if (response.status === 'success' && response.data.length > 0) {
                                prodiChoice.clearStore();
                                prodiChoice.setChoices(
                                    response.data.map(prodi => ({
                                        value: prodi.id.toString(),
                                        label: prodi.name
                                    })),
                                    'value',
                                    'label',
                                    false
                                );
                            } else {
                                prodiChoice.clearStore();
                                prodiChoice.setChoices([{
                                    value: '',
                                    label: 'Tidak ada prodi tersedia',
                                    disabled: true
                                }]);
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                            prodiChoice.clearStore();
                            prodiChoice.setChoices([{
                                value: '',
                                label: 'Terjadi kesalahan saat mengambil data',
                                disabled: true
                            }]);
                        },
                        complete: function() {
                            $('#prodi-loading').hide();
                        }
                    });
                } else {
                    prodiChoice.clearStore();
                    prodiChoice.setChoices([{
                        value: '',
                        disabled: true
                    }]);
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('kForm');

            form.addEventListener('submit', function(e) {
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

@endsection

@section('scripts')
    <script src="{{ asset('admin/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/choices.js/choices.min.js') }}"></script>
    <script src="{{ asset('admin/js/pages/form-element-select.js') }}"></script>
@endsection
