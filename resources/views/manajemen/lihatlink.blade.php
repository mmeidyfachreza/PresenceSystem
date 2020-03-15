@extends('manajemen.layout')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-graph text-success">
                </i>
            </div>
            <div>Data Link Validasi
                <div class="page-title-subheading">
                    Melihat Data Link Validasi
                </div>
            </div>
        </div>
        <div class="page-title-actions">
            <a data-toggle="tooltip"  data-placement="bottom" class="btn-shadow mr-3 btn btn-dark" href="{{route('admin.link')}}">
                Kembali
            </a>
        </div>
    </div>
</div>
<div class="tab-content">
    <div class="card bg-light">
        <div class="card-header">Link Validasi</div>
            <div class="card-body">
                <div class="row" >
                    <div class="col-lg-2">

                    </div>

                    <div class="col-lg-7">
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <tr>
                                <td>Link</td>
                                <td><input type="text" value="https://meidy-unmul.000webhostapp.com/validasi/{{$linkqr->link}}" style="width:100%"> </td>
                            </tr>
                            <tr>
                                <td>Nama Penerima</td>
                                <td>{{$linkqr->nama}}</td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>{{$linkqr->jabatan}}</td>
                            </tr>
                            <tr>
                                <td>No Hp</td>
                                <td>{{$linkqr->no_hp}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{$linkqr->email}}</td>
                            </tr>
                            <tr>
                                <td>Nama Perusahaan</td>
                                <td>{{$linkqr->nama_p}}</td>
                            </tr>
                            <tr>
                                <td>Alamat Perusahaan</td>
                                <td>{{$linkqr->alamat_p}}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{$linkqr->status}}</td>
                            </tr>
                            <tr>
                                <td>Dibuat Oleh</td>
                            <td> <a href="{{route('karyawan.show',$linkqr->user->karyawan_id)}}">{{$linkqr->user->karyawan->nama}}</a> </td>
                            </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>

</div>
@endsection
