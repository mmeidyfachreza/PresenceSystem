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
                    Edit Data Karyawan
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
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
      @endif
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Karyawan</h5>
                    <form class="" method="POST" action="{{route('karyawan.update',$karyawan->id)}}">
                        @csrf
                        <div class="position-relative form-group"><label class="">NIP</label><input required name="no_identitas" placeholder="Masukan Nomor NIP" type="text" class="form-control" value="{{$karyawan->no_identitas}}"></div>
                        <div class="position-relative form-group"><label class="">Nama Lengkap</label><input required name="nama" placeholder="Masukan Nama Lengkap" type="text" class="form-control" value="{{$karyawan->nama}}">
                        </div>
                        <div class="form-row">
                            <div class="col-md-5">
                                <div class="position-relative form-group"><label class="">Tempat Lahir</label><input required name="tempat_lahir" placeholder="Masukan Kota Lahir" type="text" class="form-control" value="{{$karyawan->tempat_lahir}}"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="position-relative form-group"><label class="">Tanggal Lahir</label><input required name="tgl_lahir" placeholder="Contoh: 21-05-1998" type="date" class="form-control" value="{{$karyawan->tgl_lahir}}"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative form-group"><label class="">Nomor Hp</label><input required name="no_hp" placeholder="Masukan Nomor HP" type="text" class="form-control" value="{{$karyawan->no_hp}}"></div>
                            </div>
                        </div>
                        <div class="position-relative form-group"><label class="">Alamat</label><textarea class="form-control" name="alamat" id="" cols="30" rows="5">{{$karyawan->alamat}}</textarea></div>

                        <div class="form-row">
                            <div class="col-md-2">
                                <div class="position-relative form-select">
                                    <label class="">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="custom-select">
                                        @if ($karyawan->jenis_kelamin=='Laki-laki')
                                            <option selected value="Laki-laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        @else
                                            <option selected value="Perempuan">Perempuan</option>
                                            <option value="Laki-laki">Laki-Laki</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                        </div>

                        <br>
                        <div class="position-relative form-group">
                                <button class="mt-2 btn btn-primary">Tambah</button>
                                @if ($karyawan->id_telegram)

                                <a class="mt-2 btn btn-info" href="{{ route('karyawan.reset',$karyawan->id) }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('reset-form').submit();">
                                        Reset Telegram
                                    </a>
                                @endif

                        </div>

                    </form>
                    <form id="reset-form" action="{{ route('karyawan.reset',$karyawan->id) }}" method="GET" style="display: none;">
                            @csrf
                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection
