@extends('karyawan.layout')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-graph text-success">
                </i>
            </div>
            <div>Pengajuan Link Validasi Presensi
                <div class="page-title-subheading">

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
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Silahkan isi formulir biodata penerima link</h5>
                    <form class="" method="POST" action="{{route('karyawan.request.simpan')}}">
                        @csrf
                        <div class="position-relative form-group"><label class="">Nama Lengkap</label><input required name="nama" placeholder="Masukan Nama Lengkap Penerima Link" type="text" class="form-control" value="{{ old('nama') }}"></div>
                        <div class="position-relative form-group"><label class="">Nomor Hp (yang saat ini digunakan)</label><input required name="no_hp" placeholder="Masukan Nomor HP Penerima Link" type="text" class="form-control" value="{{ old('no_hp') }}"></div>
                        <div class="position-relative form-group"><label class="">Email (jika tidak menggunakan hp)</label><input required name="email" placeholder="Masukan Nomor Email Penerima Link" type="text" class="form-control" value="{{ old('email') }}"></div>
                        <div class="position-relative form-group"><label class="">Jabatan</label><input required name="jabatan" placeholder="Masukan Nama Lengkap" type="text" class="form-control" value="{{ old('jabatan') }}"></div>
                        <div class="position-relative form-group"><label class="">Nama Perusahaan</label><input required name="nama_p" placeholder="Masukan Nama Lengkap" type="text" class="form-control" value="{{ old('nama_p') }}"></div>
                        <div class="position-relative form-group"><label class="">Alamat Perusahaan</label><textarea class="form-control" name="alamat" id="" cols="30" rows="5">{{ old('alamat') }}</textarea>

                        <button class="mt-2 btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection
