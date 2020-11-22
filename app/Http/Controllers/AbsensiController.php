<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Pengunjung;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengunjungs = new Pengunjung;
        $pengunjungs->with('absensi');
        if (request('tanggal')) {
            $pengunjungs = $pengunjungs->whereHas('absensi', function ($q) {
                $q->whereDate('tanggal', request('tanggal'))->latest();
            })->orWhereDoesntHave('absensi');
        }
        if (request('query')) {
            $pengunjungs = $pengunjungs->where(function ($q) {
                $q
                    ->orWhere('nama', 'LIKE', '%' . request('query') . '%')
                    ->orWhere('tempat_lahir', 'LIKE', '%' . request('query') . '%')
                    ->orWhere('tanggal_lahir', 'LIKE', '%' . request('query') . '%')
                    ->orWhere('alamat', 'LIKE', '%' . request('query') . '%')
                    ->orWhere('jenis_kelamin', 'LIKE', '%' . request('query') . '%');
            });
        }
        $pengunjungs = $pengunjungs->paginate(request('perpage') ?? 10);
        return view('absensi.index', compact('pengunjungs'));
    }
    public function update()
    {
        $pengunjungs = request()->pengunjung;
        foreach ($pengunjungs as $idP => $pengunjung) {
            foreach ($pengunjung as $idA => $absensi) {
                if (isset($absensi['jam_masuk']) || isset($absensi['jam_keluar'])) {
                    $pengunjung = Pengunjung::findOrFail($idP);
                    if (isset($absensi['jam_keluar'])) {
                        if ($pengunjung->absensi()->where('id', $idA)->firstOrNew()->jam_masuk && !$pengunjung->absensi()->where('id', $idA)->firstOrNew()->jam_keluar) {
                            if ($pengunjung->member) now()->lessThanOrEqualTo(Carbon::createFromDate($pengunjung->member->berakhir_pada->format('Y-m-d'))) ? '' : $pengunjung->transaksi()->create(['kode_transaksi' => 'ABSEN', 'total_harga' => 10000]);
                            else $pengunjung->transaksi()->create(['kode_transaksi' => 'ABSEN', 'total_harga' => 10000]);
                        }
                    }
                    $absensi = $pengunjung->absensi()->updateOrCreate(['id' => $idA], $absensi);
                }
            }
        }
        return back()->with('success', 'Absensi berhasil diupdate');
    }
}
