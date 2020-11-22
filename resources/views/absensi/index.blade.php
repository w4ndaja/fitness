@extends('layout')
@section('title', 'Absensi')
@section('content')
<div class="container py-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary d-flex justify-content-between flex-wrap">
                    <span class="text-light h2">Absensi</span>
                    <div class="d-flex flex-wrap justify-content-end">
                        <form action="{{route('absensi.index')}}" class="d-flex flex-wrap">
                            <div class="form-group m-1 text-nowrap d-flex ">
                                <label class="mx-1 text-white">Tanggal : </label>
                                <input type="date" class="form-control" name="tanggal" value="{{request('tanggal') ?? now()->format('Y-m-d')}}">
                            </div>
                            <div class="form-group m-1 d-flex">
                                <input type="text" class="form-control" placeholder="Cari..." name="query" value="{{request('query')}}">
                                <button class="btn btn-info ml-2" type="submit">Cari</button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('absensi.update')}}" method="post">
                        @csrf
                        <div class="d-flex justify-content-end">
                            <div class="form-group m-1 ml-3">
                                <button type="submit" class="btn btn-info">Simpan</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-stripped text-nowrap position-static">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengunjungs as $keyP => $pengunjung)
                                    @if($pengunjung->absensi->count() > 0)
                                    @foreach ($pengunjung->absensi as $absensi)
                                    <tr>
                                        <td>{{$pengunjung->nama}}</td>
                                        <td>{{$pengunjung->alamat}}</td>
                                        <td>{{$absensi->tanggal ?? request('tanggal')}}<input type="hidden" name="pengunjung[{{$pengunjung->id}}][{{$absensi->id}}][tanggal]" value="{{$absensi->tanggal ?? request('tanggal')}}"></td>
                                        <td><input type="time" name="pengunjung[{{$pengunjung->id}}][{{$absensi->id}}][jam_masuk]" class="form-control" value="{{$absensi->jam_masuk}}"></td>
                                        <td><input type="time" name="pengunjung[{{$pengunjung->id}}][{{$absensi->id}}][jam_keluar]" class="form-control" value="{{$absensi->jam_keluar}}" {{$absensi->jam_masuk ? '' : 'disabled'}}></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>{{$pengunjung->nama}}</td>
                                        <td>{{$pengunjung->alamat}}</td>
                                        <td>
                                            {{$pengunjung->absensi()->firstOrNew()->tanggal ?? (request('tanggal') ?? now()->format('Y-m-d'))}}
                                            <input type="hidden" name="pengunjung[{{$pengunjung->id}}][0][tanggal]" value="{{$absensi->tanggal ?? (request('tanggal') ?? now()->format('Y-m-d'))}}">
                                        </td>
                                        <td><input type="time" name="pengunjung[{{$pengunjung->id}}][0][jam_masuk]" class="form-control" value="{{$pengunjung->absensi()->firstOrNew()->jam_masuk}}"></td>
                                        <td><input type="time" name="pengunjung[{{$pengunjung->id}}][0][jam_keluar]" class="form-control" value="{{$pengunjung->absensi()->firstOrNew()->jam_keluar}}" {{$pengunjung->absensi()->firstOrNew()->jam_masuk ? '' : 'disabled'}}></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    {{-- {{$absensis->links()}} --}}
                    {{$pengunjungs->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
