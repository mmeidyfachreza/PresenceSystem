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
                    Edit Data Pengguna
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
                <div class="card-body"><h5 class="card-title">Nama Karyawan: </h5>
                    <form class="" method="POST" action="">
                        @csrf
                        <div class="position-relative form-group"><label class="">Jam Masuk</label><input required name="jam_hadir" placeholder="Masukan Jam Masuk" type="time" class="form-control"></div>
                        <div class="position-relative form-group"><label class="">Jam Keluar</label><input required name="jam_keluar" placeholder="Masukan Jam Keluar" type="time" class="form-control">
                        </div>
                        <br>
                        <div class="position-relative form-group">
                                <button class="mt-2 btn btn-primary">Simpan</button> 
                        </div>    
                        
                    </form>
                </div>
            </div>
            
        </div>
        
    </div>
@endsection