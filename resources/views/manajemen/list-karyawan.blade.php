@extends('manajemen.layout')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-graph text-success">
                </i>
            </div>
            <div>Data Karyawan
                <div class="page-title-subheading">
                    Menampilkan Data Karyawan
                </div>
            </div>
        </div>
        <div class="page-title-actions">
            <a data-toggle="tooltip" title="Tambah Karyawan" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark" href="{{route('karyawan.add')}}">
                <i class="fa fa-plus"></i> Tambah
            </a>
        </div>
    </div>
</div>
@if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
      @endif
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Karyawan
                <div class="btn-actions-pane-right">

                </div>
            </div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th class="text-center">NIP</th>
                        <th class="text-center">Nomor HP</th>
                        <th class="">Aksi</th>
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
                                        <div class="widget-subheading opacity-7"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">{{$item->no_identitas}}</td>
                        <td class="text-center">{{$item->no_hp}}</td>
                        <td class="text-center">
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <a data-toggle="tooltip" title="Hapus" href="{{route('karyawan.destroy',$item->id)}}" class="btn btn-warning btn-sm"><i class="far fa-trash-alt"></i></a>
                                                <a data-toggle="tooltip" title="Ubah" href="{{route('karyawan.edit',$item->id)}}" class="btn btn-info btn-sm"><i class="far fa-edit"></i></a>
                                                <a data-toggle="tooltip" title="Detail" href="{{route('karyawan.show',$item->id)}}" class="btn btn-primary btn-sm"><i class="far fa-eye"></i></a>
                                                @if ($item->user)
                                                <a data-toggle="tooltip" title="Edit Akun" href="{{route('user.edit',$item->user->id)}}" class="btn btn-success btn-sm" style="padding: 2.5px 10px;"><i class="fas fa-user-tie"></i></a>
                                                @else
                                                <a data-toggle="tooltip" title="Buat Akun" href="{{route('user.add',$item->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-user-cog"></i></a>
                                                @endif
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
@endsection
