@extends('manajemen.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Presensi Hari ini
                <div class="btn-actions-pane-right">

                </div>
            </div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nama</th>
                        <th class="text-center">Jam Hadir</th>
                        <th class="text-center">Jam Pulang</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $x=1?>
                    @foreach ($presensi as $item)
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
                        <td class="text-center">{{$item->jam_hadir}}</td>
                        <td class="text-center">{{$item->jam_keluar}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
