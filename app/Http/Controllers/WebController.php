<?php

namespace App\Http\Controllers;

use App\Mail\pengajuanBaru;
use App\Models\Jenis_kerjasama;
use App\Models\bidangKerjasama;
use App\Models\Kerjasama;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WebController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function chartData()
    {
        $active = Kerjasama::where('sifat', '<>', '')
            ->where('step', 7)
            ->whereDate('tanggal_selesai', '>=', Carbon::now())
            ->count();
        $inactive = Kerjasama::where('sifat', '<>', '')
            ->where('step', 7)
            ->whereDate('tanggal_selesai', '<', Carbon::now())
            ->count();

        return response()->json([
            'labels' => ['Masih Berlaku', 'Sudah Berakhir'],
            'data' => [$active, $inactive],
        ]);
    }
    public function chartBySifat(Request $request)
    {
        switch ($request->filter) {
            case 0:
                $sql = Kerjasama::selectRaw('sifat as label, count(*) as data')
                    ->where('step', 7)
                    ->where('sifat', '<>', '')
                    ->groupBy('sifat')
                    ->get();
                break;
            case 1:
                $sql = Kerjasama::selectRaw('sifat as label, count(*) as data')
                    ->where('step', 7)
                    ->where('sifat', '<>', '')
                    ->whereDate('tanggal_selesai', '>=', Carbon::now())
                    ->groupBy('sifat')
                    ->get();
                break;
            case 2:
                $sql = Kerjasama::selectRaw('sifat as label, count(*) as data')
                    ->where('step', 7)
                    ->where('sifat', '<>', '')
                    ->whereDate('tanggal_selesai', '<', Carbon::now())
                    ->groupBy('sifat')
                    ->get();
                break;
        }
        return response()->json([
            'result' => $sql,
        ]);
    }
    public function chartByMemorandum(Request $request)
    {
        switch ($request->filter) {
            case 0:
                $sql = Kerjasama::selectRaw('pks.id as pks_id, pks.pks as label, count(*) as data')
                    ->where('step', 7)
                    ->join('pks', DB::raw("CAST(pks.id as varchar)"), '=', 'kerjasamas.pks')
                    ->groupBy('label', 'pks_id')
                    ->get();
                $more = Kerjasama::selectRaw('kerjasamas.pks as label, count(*) as data')
                    ->where('pks', 'like', '%,%')
                    ->groupBy('pks')
                    ->get();
                break;
            case 1:
                $sql = Kerjasama::selectRaw('pks.id as pks_id, pks.pks as label, count(*) as data')
                    ->where('step', 7)
                    ->join('pks', DB::raw("CAST(pks.id as varchar)"), '=', 'kerjasamas.pks')
                    ->whereDate('tanggal_selesai', '>=', Carbon::now())
                    ->groupBy('label', 'pks_id')
                    ->get();
                $more = Kerjasama::selectRaw('kerjasamas.pks as label, count(*) as data')
                    ->whereDate('tanggal_selesai', '>=', Carbon::now())
                    ->where('pks', 'like', '%,%')
                    ->groupBy('pks')
                    ->get();
                break;
            case 2:
                $sql = Kerjasama::selectRaw('pks.id as pks_id, pks.pks as label, count(*) as data')
                    ->where('step', 7)
                    ->join('pks', DB::raw("CAST(pks.id as varchar)"), '=', 'kerjasamas.pks')
                    ->whereDate('tanggal_selesai', '<', Carbon::now())
                    ->groupBy('label', 'pks_id')
                    ->get();
                $more = Kerjasama::selectRaw('kerjasamas.pks as label, count(*) as data')
                    ->where('step', 7)
                    ->where('pks', 'like', '%,%')
                    ->whereDate('tanggal_selesai', '<', Carbon::now())
                    ->groupBy('pks')
                    ->get();
                break;
        }
        return response()->json([
            'more' => $more,
            'result' => $sql,
        ]);
    }
    public function chartByUnit(Request $request)
    {
        switch ($request->filter) {
            case 0:
                $query = Kerjasama::where('step', 7);
                break;
            case 1:
                $query = Kerjasama::where('step', 7)->whereDate('tanggal_selesai', '>=', Carbon::now());
                break;
            case 2:
                $query = Kerjasama::where('step', 7)->whereDate('tanggal_selesai', '<', Carbon::now());
                break;
        }

        $kerjasamas = $query->get();

        $unitCounts = [];
        foreach ($kerjasamas as $kerjasama) {
            $jurusanIds = explode(',', $kerjasama->jurusan);
            foreach ($jurusanIds as $jurusanId) {
                if (!empty($jurusanId)) {
                    if (!isset($unitCounts[$jurusanId])) {
                        $unitCounts[$jurusanId] = 0;
                    }
                    $unitCounts[$jurusanId]++;
                }
            }
        }

        $units = DB::table('unit')->whereIn('id', array_keys($unitCounts))->get();

        $result = $units->map(function ($unit) use ($unitCounts) {
            return [
                'unit_id' => $unit->id,
                'label' => $unit->name,
                'data' => $unitCounts[$unit->id] ?? 0
            ];
        });

        $more = $kerjasamas->filter(function ($kerjasama) {
            return strpos($kerjasama->jurusan, ',') !== false;
        })->map(function ($kerjasama) {
            return [
                'label' => $kerjasama->jurusan,
                'data' => 1
            ];
        })->values();

        return response()->json([
            'more' => $more,
            'result' => $result,
        ]);
    }
    public function chartByJenisKerjasama(Request $request)
    {
        $sqlLabels = Kerjasama::select('kerjasamas.bidang_kerjasama_id', 'bidang_kerjasamas.nama_bidang as label')
            ->where('kerjasamas.step', 7)
            ->leftJoin('bidang_kerjasamas', function ($join) {
                $join->on(DB::raw('CAST(bidang_kerjasamas.id AS TEXT)'), '=', 'kerjasamas.bidang_kerjasama_id');
            })
            ->groupBy('kerjasamas.bidang_kerjasama_id', 'bidang_kerjasamas.nama_bidang')
            ->orderBy('label', 'asc')
            ->get();

        switch ($request->filter) {
            case 0:
                $sql = Kerjasama::selectRaw('kerjasamas.bidang_kerjasama_id, count(*) as data, bidang_kerjasamas.nama_bidang as label')
                    ->where('kerjasamas.step', 7)
                    ->leftJoin('bidang_kerjasamas', function ($join) {
                        $join->on(DB::raw('CAST(bidang_kerjasamas.id AS TEXT)'), '=', 'kerjasamas.bidang_kerjasama_id');
                    })
                    ->groupBy('kerjasamas.bidang_kerjasama_id', 'bidang_kerjasamas.nama_bidang')
                    ->orderBy('label', 'asc')
                    ->get();
                break;
            case 1:
                $sql = Kerjasama::selectRaw('kerjasamas.bidang_kerjasama_id, count(*) as data, bidang_kerjasamas.nama_bidang as label')
                    ->where('kerjasamas.step', 7)
                    ->leftJoin('bidang_kerjasamas', function ($join) {
                        $join->on(DB::raw('CAST(bidang_kerjasamas.id AS TEXT)'), '=', 'kerjasamas.bidang_kerjasama_id');
                    })
                    ->whereDate('kerjasamas.tanggal_selesai', '>=', Carbon::now())
                    ->groupBy('kerjasamas.bidang_kerjasama_id', 'bidang_kerjasamas.nama_bidang')
                    ->orderBy('label', 'asc')
                    ->get();
                break;
            case 2:
                $sql = Kerjasama::selectRaw('kerjasamas.bidang_kerjasama_id, count(*) as data, bidang_kerjasamas.nama_bidang as label')
                    ->where('kerjasamas.step', 7)
                    ->leftJoin('bidang_kerjasamas', function ($join) {
                        $join->on(DB::raw('CAST(bidang_kerjasamas.id AS TEXT)'), '=', 'kerjasamas.bidang_kerjasama_id');
                    })
                    ->whereDate('kerjasamas.tanggal_selesai', '<', Carbon::now())
                    ->groupBy('kerjasamas.bidang_kerjasama_id', 'bidang_kerjasamas.nama_bidang')
                    ->orderBy('label', 'asc')
                    ->get();
                break;
        }

        return response()->json([
            'labels' => $sqlLabels,
            'result' => $sql,
        ]);
    }
    public function chartBySifatYear()
    {
        $sql = Kerjasama::selectRaw('sifat as label, count(*) as data, extract(year from tanggal_mulai) as year')
            ->where('step', 7)
            ->where('sifat', '<>', '')
            ->groupBy('year', 'label')
            ->orderBy('year', 'asc')
            ->get();
        $sqlYear = Kerjasama::selectRaw('count(*) as data, extract(year from tanggal_mulai) as year')
            ->where('step', 7)
            ->where('sifat', '<>', '')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
        return response()->json([
            'labels' => $sqlYear,
            'result' => $sql,
        ]);
    }
    public function chartByJenisYear()
    {
        $sql = Kerjasama::selectRaw('count(*) as data, extract(year from tanggal_mulai) as year, bidang_kerjasamas.nama_bidang as label')
            ->where('kerjasamas.step', 7)
            ->leftJoin('bidang_kerjasamas', function ($join) {
                $join->on(DB::raw('CAST(bidang_kerjasamas.id AS TEXT)'), '=', 'kerjasamas.bidang_kerjasama_id');
            })
            ->groupBy('year', 'bidang_kerjasamas.nama_bidang')
            ->orderBy('year', 'asc')
            ->get();

        $sqlYear = Kerjasama::selectRaw('count(*) as data, extract(year from tanggal_mulai) as year')
            ->where('step', 7)
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        return response()->json([
            'labels' => $sqlYear,
            'result' => $sql,
        ]);
    }
    public function trackingPengajuan(){
        return view('tracking.index');
    }

    public function getKerjasamaStats()
    {

        $now = Carbon::now();

        $totalKerjasama = Kerjasama::count();

        $kerjasamaBerlangsung = Kerjasama::where('tanggal_mulai', '<=', $now)
            ->where('tanggal_selesai', '>=', $now)
            ->where('step',  7)
            ->count();

        $kerjasamaSelesai = Kerjasama::where('tanggal_selesai', '<', $now)
            ->where('step',  7)
            ->count();

        return response()->json([
            'total' => $totalKerjasama,
            'berlangsung' => $kerjasamaBerlangsung,
            'selesai' => $kerjasamaSelesai,
        ]);
    }

    public function getAllKerjasama()
    {
        $kerjasamas = Kerjasama::all();

        return response()->json($kerjasamas->map(function ($kerjasama) {
            return [
                'id' => $kerjasama->id,
                'kerjasama' => $kerjasama->kerjasama,
                'mitra' => $kerjasama->mitra,
                'tanggal_mulai' => $kerjasama->tanggal_mulai,
                'tanggal_selesai' => $kerjasama->tanggal_selesai,
                'sifat' => $kerjasama->sifat,
                'pks' => $kerjasama->pks_id->pks ?? null,
                'step' => $kerjasama->step,
            ];
        }));
    }



}
