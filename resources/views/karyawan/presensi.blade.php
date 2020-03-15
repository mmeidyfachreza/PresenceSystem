@extends('karyawan.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Presensi Karyawan
                <div class="btn-actions-pane-right">

                </div>
            </div>
            <div class="card-body">
                <div id="app">
                <presensi :data="{{json_encode($presensi)}}" noid="{{Auth::user()->karyawan->id}}"></presensi>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
