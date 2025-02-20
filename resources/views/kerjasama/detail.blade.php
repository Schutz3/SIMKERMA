@extends('layouts.app')
@section('heading', 'Kerja Sama')
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body text-dark">
                <h5 class="text-center page-heading"><span>TIMELINE PENGAJUAN</span></h5>
                <div class="row">
                    <!-- Tanggal Pengajuan-->
                    <div class="col-sm">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <i class="fas fa-user align" style="font-size:48px;"></i>
                                </div>
                                <br>
                                <p class="text-center"><strong>Tanggal Pengajuan</strong></p>
                                <p class="text-center">{{ $data->created_at->format('d-m-Y') }}</p>
                                <p class="text-center">Mengajukan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Review Legal (step 3 or 2 for rejection) -->
                    @php
                        $legalReview = $data->log_persetujuan->firstWhere('step', 3);
                        $legalRejection = $data->log_persetujuan->firstWhere('step', 2);
                    @endphp
                    @if($legalReview)
                        <div class="col-sm">
                            <div class="card shadow h-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <i class="fas fa-user align" style="font-size:48px;"></i>
                                    </div>
                                    <br>
                                    <p class="text-center"><strong>Tanggal Review Legal</strong></p>
                                    <p class="text-center">{{ \Carbon\Carbon::parse($legalReview->created_at)->format('d-m-Y') }}</p>
                                    <p class="text-center text-dark">
                                        <span class="bg-success text-white">Diterima</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif($legalRejection)
                        <div class="col-sm">
                            <div class="card shadow h-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <i class="fas fa-user align" style="font-size:48px;"></i>
                                    </div>
                                    <br>
                                    <p class="text-center"><strong>Tanggal Review Legal (Ditolak)</strong></p>
                                    <p class="text-center">{{ \Carbon\Carbon::parse($legalRejection->created_at)->format('d-m-Y') }}</p>
                                    <p class="text-center">
                                        <span class="bg-danger text-white">Ditolak</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Tanggal Disetujui Wadir (step 5 or 4 for rejection) -->
                    @php
                        $wadirReview = $data->log_persetujuan->firstWhere('step', 5);
                        $wadirRejection = $data->log_persetujuan->firstWhere('step', 4);
                    @endphp
                    @if($wadirReview)
                        <div class="col-sm">
                            <div class="card shadow h-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <i class="fas fa-user align" style="font-size:48px;"></i>
                                    </div>
                                    <br>
                                    <p class="text-center"><strong>Tanggal Disetujui Wadir</strong></p>
                                    <p class="text-center">{{ \Carbon\Carbon::parse($wadirReview->created_at)->format('d-m-Y') }}</p>
                                    <p class="text-center text-dark">
                                        <span class="bg-success text-white">Diterima</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif($wadirRejection)
                        <div class="col-sm">
                            <div class="card shadow h-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <i class="fas fa-user align" style="font-size:48px;"></i>
                                    </div>
                                    <br>
                                    <p class="text-center"><strong>Tanggal Review Wadir (Ditolak)</strong></p>
                                    <p class="text-center">{{ \Carbon\Carbon::parse($wadirRejection->created_at)->format('d-m-Y') }}</p>
                                    <p class="text-center">
                                        <span class="bg-danger text-white">Ditolak</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Tanggal Diterima Direktur (step 7 or 6 for rejection) -->
                    @php
                        $direkturReview = $data->log_persetujuan->firstWhere('step', 7);
                        $direkturRejection = $data->log_persetujuan->firstWhere('step', 6);
                    @endphp
                    @if($direkturReview)
                        <div class="col-sm">
                            <div class="card shadow h-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <i class="fas fa-user align" style="font-size:48px;"></i>
                                    </div>
                                    <br>
                                    <p class="text-center"><strong>Tanggal Diterima Direktur</strong></p>
                                    <p class="text-center">{{ \Carbon\Carbon::parse($direkturReview->created_at)->format('d-m-Y') }}</p>
                                    <p class="text-center text-dark">
                                        <span class="bg-success text-white">Diterima</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif($direkturRejection)
                        <div class="col-sm">
                            <div class="card shadow h-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <i class="fas fa-user align" style="font-size:48px;"></i>
                                    </div>
                                    <br>
                                    <p class="text-center"><strong>Tanggal Review Direktur (Ditolak)</strong></p>
                                    <p class="text-center">{{ \Carbon\Carbon::parse($direkturRejection->created_at)->format('d-m-Y') }}</p>
                                    <p class="text-center">
                                        <span class="bg-danger text-white">Ditolak</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body text-dark">
                <div class="row">
                    <div class="order-md-0 order-1 col-12 col-md-8">
                        <h4>{{ $data->kerjasama }}</h4>
                        <p>
                            <span>{{ $data->nomor }}</span>
                        </p>
                    </div>
                    @if (Auth::user()->role->role_name == 'admin')
                        <div class="order-md-1 order-0 col-12 col-md-4 text-md-end mb-md-0 mb-3">
                            <a href="{{ url('/admin/kerjasama/edit/'. $data->id) }}" class="btn btn-custom">Edit</a>
                            <button class="btn btn-danger" onclick="konfirmasiHapus('{{ $data->id }}')">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </div>
                    @elseif (Auth::user()->role->role_name == 'pic' && $data->user_id == Auth::user()->id)
                        <div class="order-md-1 order-0 col-12 col-md-4 text-md-end mb-md-0 mb-3">
                            <a href="{{ url('/pic/kerjasama/edit/'. $data->id) }}" class="btn btn-custom">Edit</a>
                        </div>
                    @endif


                </div>
                <p>
                    @if ($data->tanggal_selesai > date('Y-m-d'))
                        <span class="fs-6 badge bg-success">
                            {{ date('d F Y', strtotime($data->tanggal_mulai)) }} s/d {{ date('d F Y', strtotime($data->tanggal_selesai)) }}
                        </span>
                    @else
                        <span class="fs-6 badge bg-danger">
                            {{ date('d F Y', strtotime($data->tanggal_mulai)) }} s/d {{ date('d F Y', strtotime($data->tanggal_selesai)) }}
                        </span>
                    @endif
                    @if ($data->sifat == 'Nasional')
                        <span class="fw-bold fs-6 badge bg-info text-dark mt-lg-0 mt-2">{{ $data->sifat }}</span>
                    @elseif ($data->sifat == 'Internasional')
                        <span class="fw-bold fs-6 badge bg-warning text-dark mt-lg-0 mt-2">{{ $data->sifat }}</span>
                    @elseif ($data->sifat == 'Lokal')
                        <span class="fw-bold fs-6 badge bg-success text-light mt-lg-0 mt-2">{{ $data->sifat }}</span>
                    @endif
                </p>
                <div class="my-3">
                    <div class="d-flex">
                        <div class="fw-bold">Bidang Kerja Sama :</div>
                        <div class="ps-2">
                           @foreach ($bidang as $item)
                           @if ($loop->index < count($bidang) - 1)
                                {{ $item->nama_bidang }},&nbsp;
                            @else
                                {{ $item->nama_bidang }}
                            @endif
                           @endforeach
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="fw-bold">Jenis Perjanjian :</div>
                        <div class="ps-2">
                            @foreach ($perjanjian as $item)
                                @if ($loop->index < count($perjanjian) - 1)
                                    {{ $item->pks }},&nbsp;
                                @else
                                    {{ $item->pks }}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="fw-bold">Jurusan / Unit:</div>
                        <div class="ps-2">
                            @if($unit != "")
                                @foreach ($unit as $item)
                                    @if ($loop->index < count($unit) - 1)
                                        {{ $item->name }},&nbsp;
                                    @else
                                        {{ $item->name }}
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <p>
                    <strong>Kegiatan:</strong>
                    <br>{{ $data->kegiatan }}
                </p>
                @if ($data->file)
                <p>
                    <strong>Surat Kerja Sama:</strong>
                    <div class="row justify-content-center mt-2">
                        <div class="col-md-9">
                            <iframe src="{{ asset('surat_kerjasama/'.$data->file) }}" frameborder="0" class="w-100" height="580px"></iframe>
                        </div>
                    </div>
                </p>
                @else
                <p>
                    <strong>Surat Kerja Sama:</strong>
                    <div class="text-danger">Tidak ada surat kerja sama</div>
                </p>
                @endif
                <table class="table table-sm text-dark my-3">
                    <tr>
                        <td class="py-2 fw-bold px-0" width="38%">Nama PIC PNJ</td>
                        <td class="py-0">{{ $data->pic_pnj }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 fw-bold px-0" width="38%">Alamat Perusahaan</td>
                        <td class="py-0">{{ $data->alamat_perusahaan }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 fw-bold px-0" width="38%">Nama PIC Industri/PT</td>
                        <td class="py-0">{{ $data->pic_industri }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 fw-bold px-0" width="38%">Jabatan PIC Industri/PT</td>
                        <td class="py-0">{{ $data->jabatan_pic_industri }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 fw-bold px-0" width="38%">Telp. PIC Industri</td>
                        <td class="py-0">{{ $data->telp_industri }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 fw-bold px-0" width="38%">Email</td>
                        <td class="py-0">{{ $data->email }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="card-title fw-bold text-dark">
                    Log Persetujuan
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm text-dark w-100" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->log_persetujuan as $item)
                        <tr>
                            <td>{{ $loop->index+ 1 }}</td>
                            <td>{{ $item->created_at->format('d-m-Y H:m:s') }}</td>
                            <td>{{ $item->getStep() .' Oleh '. $item->user->name.'('.$item->user->role->role_name.')'   }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">

        <div class="card shadow-sm">
            <div class="card-header">
                <div class="card-title fw-bold text-dark">History Update</div>
            </div>
            <div class="card-body">
                <table class="table table-sm text-dark w-100" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Updated at</th>
                            <th>Updated by</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->repository as $item)
                            <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->user->username}}</td>
                            @if (Auth::user()->role->role_name == 'admin')
                                <td class="text-center"><a href="{{ url('/admin/kerjasama/repo/'.$item->id) }}" class="btn btn-warning text-dark"><i class="fas fa-eye"></i></a></td>
                            @elseif (Auth::user()->role->role_name == 'pemimpin')
                                <td class="text-center"><a href="{{ url('/direktur/kerjasama/repo/'.$item->id) }}" class="btn btn-warning text-dark"><i class="fas fa-eye"></i></a></td>
                            @elseif (Auth::user()->role->role_name == 'pic')
                                <td class="text-center"><a href="{{ url('/pic/kerjasama/repo/'.$item->id) }}" class="btn btn-warning text-dark"><i class="fas fa-eye"></i></a></td>
                            @endif
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function konfirmasiHapus(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menghapus pengajuan kerja sama ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('/admin/kerjasama/delete') }}/" + id;
                }
            })
        }
        </script>
</section>
@endsection
