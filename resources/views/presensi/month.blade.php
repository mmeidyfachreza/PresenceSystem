@extends('presensi.layout')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-graph text-success">
                </i>
            </div>
            <div>Data Presensi {{$karyawan->nama}} bulan {{$monthName}}
                <div class="page-title-subheading">
                    {{-- sds --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Presensi
                <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">

                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Tanggal</th>
                        <th class="text-center">Jam Masuk</th>
                        <th class="text-center">Jam Keluar</th>
                        <th class="text-center">Durasi Kerja</th>
                        <th class="text-center">Lokasi Saat Presensi Hadir</th>
                        <th class="text-center">Lokasi Saat Presensi Pulang</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $x=1;
                    @endphp
                    @foreach ($presensi as $value)
                     <tr>
                        <td class="text-center text-muted">{{$x++}}</td>
                        <td>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-3">
                                        <div class="widget-content-left">
                                            <img width="40" class="rounded-circle" src="assets/images/avatars/4.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="widget-content-left flex2">
                                        <div class="widget-heading">
                                            {{ $value->tanggal->format('d') }}
                                        </div>
                                        <div class="widget-subheading opacity-7"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">{{$value->jam_hadir}}</td>
                        <td class="text-center">{{$value->jam_pulang}}</td>
                        <td class="text-center">{{$value->durasi_kerja}} Jam</td>
                        <td class="text-center"><a href="https://www.google.com/maps/place/{{$value->lokasi_user_hadir}}">{{$value->lokasi_user_hadir}}</a> </td>
                        <td class="text-center"><a href="https://www.google.com/maps/place/{{$value->lokasi_user_pulang}}">{{$value->lokasi_user_pulang}}</a> </td>
                    </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
