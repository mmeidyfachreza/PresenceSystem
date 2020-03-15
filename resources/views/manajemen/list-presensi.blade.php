@extends('manajemen.layout')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-graph text-success">
                </i>
            </div>
            <div>Data Presensi
                <div class="page-title-subheading">
                    Menampilkan Data Presensi Karyawan
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Daftar Karyawan
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
                        <th>Nama</th>
                        <th class="text-center">NIP</th>
                        <th class="text-center">Nomor HP</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                            <?php $x=1?>
                            @foreach ($karyawan as $item)
                            <tr>
                                <td class="text-center text-muted">#{{$x++}}</td>
                                <td>
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="widget-content-left">
                                                    <img width="40" class="rounded-circle" src="assets/images/avatars/4.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="widget-content-left flex2">
                                                <div class="widget-heading">{{$item->nama}}</div>
                                                <div class="widget-subheading opacity-7">Thortech</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{$item->no_identitas}}</td>
                                <td class="text-center">{{$item->no_hp}}</td>
                                {{-- <td class="text-center">
                                    <div class="badge badge-warning">Pending</div>
                                </td> --}}
                                <td class="text-center">
                                    <a href="{{route("presensi.karyawan",$item->id)}}" class="btn btn-primary btn-sm">Detail</a>
                                </td>
                            </tr>    
                            @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>
@endsection