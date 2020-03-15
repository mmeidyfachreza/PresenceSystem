@extends('karyawan.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Scan QRcode
                <div class="btn-actions-pane-right">

                </div>
            </div>
            <div class="card-body">
                <div id="app">
                    <scanqr user="{{Auth::user()->karyawan->id}}"></scanqr>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
