@extends('manajemen.layout')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-graph text-success">
                </i>
            </div>
            <div>Data Pengguna
                <div class="page-title-subheading">
                    Menampilkan Data Pengguna
                </div>
            </div>
        </div>
        <div class="page-title-actions">
            
        </div>
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
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
            <div class="card-header">Pengguna
                <div class="btn-actions-pane-right">
                    
                </div>
            </div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="">Nama Karyawan</th>
                            <th class="text-center">Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $x=1?>
                        @foreach ($user as $item)
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
                                            <div class="widget-heading">{{$item->karyawan->nama}}</div>
                                            <div class="widget-subheading opacity-7">Thortech</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">{{$item->email}}</td>
                            <td class="text-center">
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a data-toggle="tooltip" title="Hapus" href="{{route('user.destroy',$item->id)}}" class="btn btn-warning btn-sm"><i class="far fa-trash-alt"></i></a>
                                        <a data-toggle="tooltip" title="Ubah" href="{{route('user.edit',$item->id)}}" class="btn btn-info btn-sm"><i class="far fa-edit"></i></a>
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