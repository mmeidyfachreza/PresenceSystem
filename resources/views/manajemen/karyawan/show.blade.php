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
                    Melihat Data Karyawan
                </div>
            </div>
        </div>
        <div class="page-title-actions">
            <a data-toggle="tooltip"  data-placement="bottom" class="btn-shadow mr-3 btn btn-dark" href="{{route('admin.karyawan')}}">
                Kembali
            </a>
        </div>
    </div>
</div>
<div class="tab-content">
    <div class="card bg-light">
        <div class="card-header">Profil Karyawan</div>
            <div class="card-body">
                <div class="row" >
                    <div class="col-lg-2">
                            <img class="card-img-top" src="{{asset('image/contoh_avatar.png')}}" alt="Card image">
                    </div>

                    <div class="col-lg-7">
                        <table class="table table-striped" style="width:100%">
                            <tbody>
                            <tr>
                                <th>
                                    Nama<br>
                                    Nomor Identitas<br>
                                    Tanggal Lahir<br>
                                    Tempat Lahir<br>
                                    Alamat<br>
                                    Nomor HP<br>
                                    Jenis Kelamin<br>
                                    id_telegram<br>
                                    kode_darurat
                                </th>
                                <td></td>
                                <td>
                                    {{$karyawan->nama}}<br>
                                    {{$karyawan->no_identitas}}<br>
                                    {{date("d-m-Y", strtotime($karyawan->tgl_lahir))}}<br>
                                    {{$karyawan->tempat_lahir}}<br>
                                    {{$karyawan->alamat}}<br>
                                    {{$karyawan->no_hp}}<br>
                                    {{$karyawan->jenis_kelamin}}<br>
                                    @if ($karyawan->id_telegram)
                                        {{$karyawan->id_telegram}}
                                    @endif
                                        Belum Terdaftar
                                    <br>
                                    {{$karyawan->kode_darurat}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <a href="{{route("presensi.karyawan",$karyawan->id)}}" class="btn btn-primary">Lihat Presensi</a>
                    </div>
                </div>
            </div>
    </div>

</div>
@endsection
