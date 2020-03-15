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
                    Membuat akun agar karyawan dapat mengakses website
                </div>
            </div>
        </div>
        <div class="page-title-actions">
            <a data-toggle="tooltip"  data-placement="bottom" class="btn-shadow mr-3 btn btn-dark" href="{{route('admin.karyawan')}}">
                Batal
            </a>
        </div>
    </div>
</div>
<div class="tab-content">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Nama Karyawan: {{$karyawan->nama}}</h5>
                    <form class="" method="POST" action="{{route('user.store',$karyawan->id)}}">
                        @csrf
                        <div class="position-relative form-group"><label class="">Email</label><input required name="email" placeholder="Masukan Email" type="email" class="form-control" value="{{ old('email') }}"></div>
                        <div class="position-relative form-group"><label class="">Password</label><input required name="password" placeholder="Masukan Password" type="password" class="form-control" value="{{ old('password') }}">
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <div class="position-relative form-select">
                                    <label class="">Sebagai</label>
                                    <select name="role" class="custom-select">
                                        <option value='' selected>Pilih</option>
                                        <option value="admin">Admin</option>
                                        <option value="karyawan">Karyawan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button class="mt-2 btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection
