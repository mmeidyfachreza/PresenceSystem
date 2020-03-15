@extends('manajemen.layout')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-graph text-success">
                </i>
            </div>
            <div>Link Validasi Presensi
                <div class="page-title-subheading">

                </div>
            </div>
        </div>
        <div class="page-title-actions">
            <a data-toggle="tooltip" title="Tambah Karyawan" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark" href="{{route('manajemen.link.add')}}">
                <i class="fa fa-plus"></i> Tambah
            </a>
        </div>
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{!! $message !!}</p>
</div>
@endif
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
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Pengajuan Link Validasi
                <div class="btn-actions-pane-right">

                </div>
            </div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nama Perusahaan</th>
                        <th class="text-center">Nama Penerima</th>
                        <th class="text-center">No_hp</th>
                        <th class="text-center">Nama Karyawan</th>
                        <th >Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $x=1?>
                    @foreach ($linkqr as $item)
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
                                        <div class="widget-heading">{{$item->nama_p}}</div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">{{$item->nama}}</td>
                        <td class="text-center">{{$item->no_hp}}</td>
                        <td class="text-center">{{$item->user->karyawan->nama}}</td>
                        <td class="text-center">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a data-toggle="tooltip" title="Hapus" href="{{route('manajemen.link.hapus',$item->id)}}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                            <a data-toggle="tooltip" title="Detail" href="{{route('manajemen.link.lihat',$item->id)}}" class="btn btn-info btn-sm"><i class="far fa-eye"></i></a>
                                            <a data-toggle="tooltip" title="Aktifkan" href="{{route('manajemen.link.verif',$item->id)}}" class="btn btn-warning btn-sm"><i class="fas fa-link"></i></a>
                                    </div>
                            </div>
                    </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">link validasi presensi
                <div class="btn-actions-pane-right">

                </div>
            </div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nama Perusahaan</th>
                        <th class="text-center">Nama Penerima</th>
                        <th class="text-center">No_hp</th>
                        <th class="text-center">status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $x=1?>
                    @foreach ($linkqrA as $item)
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
                                        <div class="widget-heading">{{$item->nama_p}}</div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">{{$item->nama}}</td>
                        <td class="text-center">{{$item->no_hp}}</td>
                        <td class="text-center">{{$item->status}}</td>
                        <td class="text-center">
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a data-toggle="tooltip" title="Hapus" href="{{route('manajemen.link.hapus',$item->id)}}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                            <a data-toggle="tooltip" title="Detail" href="{{route('manajemen.link.lihat',$item->id)}}" class="btn btn-primary btn-sm"><i class="far fa-eye"></i></a>
                                            <a data-toggle="tooltip" title="Ubah" href="{{route('manajemen.link.edit',$item->id)}}" class="btn btn-info btn-sm"><i class="far fa-edit"></i></a>
                                            @if ($item->status=='tidak')
                                            <a data-toggle="tooltip" title="aktifkan" href="{{route('manajemen.link.aktifkan',$item->id)}}" class="btn btn-success btn-sm"><i class="fas fa-link"></i></a>
                                            @else
                                            <a data-toggle="tooltip" title="matikan" href="{{route('manajemen.link.matikan',$item->id)}}" class="btn btn-warning btn-sm"><i class="fas fa-link"></i></a>
                                            @endif
                                        </div>
                                </div>
                        </td>




                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- Button to Open the Modal -->

            </div>

        </div>
    </div>
</div>
@endsection
