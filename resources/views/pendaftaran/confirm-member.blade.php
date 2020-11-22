@extends('layout')
@section('title', 'Konfirmasi Member')
@section('content')
<div class="container pt-3">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <form action="{{route('pendaftaran.add-to-member', $pengunjung->id)}}" method="post">
                    @csrf
                    <div class="card-header">Peringatan...!</div>
                    <div class="card-body">
                        Apakah Anda yakin ingin menjadikan pengunjung dengan nama <strong class="text-info">{{$pengunjung->nama}}</strong> sebagai <strong class="text-success">member</strong> ?

                        <div class="form-group row mt-3">
                            <label class="col-lg-4">Berapa Lama</label>
                            <div class="col-lg-8">
                                <select name="durasi" id="" class="form-control">
                                    <option value="1">1 Bulan - Rp. 100.000,--</option>
                                    <option value="3">3 Bulan - Rp. 250.000,--</option>
                                    <option value="6">6 Bulan - Rp. 400.000,--</option>
                                    <option value="12">12 Bulan - Rp. 700.000,--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{route('pendaftaran.index')}}" class="btn btn-info">Kembali</a>
                        <button type="submit" class="btn btn-success">Jadikan Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
