@extends('presensi.layout')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-graph text-success">
                </i>
            </div>
            <div>Data Presensi {{$karyawan->nama}}
                <div class="page-title-subheading">
                    Menampilkan Data Presensi {{$karyawan->nama}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Presensi
                <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Bulan</th>
                        {{-- <th class="text-center">City</th>
                        <th class="text-center">Status</th> --}}
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $x=1;
                    @endphp
                    @foreach ($karyawan->presensi->groupBy(function($d) {
                        return \Carbon\Carbon::parse($d->tanggal)->format('m');
                        }) as $key => $value)
                     <tr>
                        <td class="text-center text-muted">{{$x++}}</td>
                        <td>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    
                                    <div class="widget-content-left flex2">
                                        <div class="widget-heading">
                                            @switch((int)$key)
                                                @case(1)
                                                    <?php $month=1 ?>
                                                    Januari
                                                    @break
                                                @case(2)
                                                    <?php $month=2 ?>
                                                    Februari
                                                    @break
                                                @case(3)
                                                    <?php $month=3 ?>
                                                    Maret
                                                    @break
                                                @case(4)
                                                    <?php $month=4 ?>
                                                    April
                                                    @break
                                                @case(5)
                                                    <?php $month=5 ?>
                                                    Mei
                                                    @break
                                                @case(6)
                                                    <?php $month=6 ?>
                                                    Juni
                                                    @break
                                                @case(7)
                                                    <?php $month=7 ?>
                                                    Juli
                                                    @break
                                                @case(8)
                                                    <?php $month=8 ?>
                                                    Agustus
                                                    @break
                                                @case(9)
                                                    <?php $month=9 ?>
                                                    September
                                                    @break
                                                @case(10)
                                                    <?php $month=10 ?>
                                                    Oktober
                                                    @break
                                                @case(11)
                                                    <?php $month=11 ?>
                                                    November
                                                    @break
                                                @case(12)
                                                    <?php $month=12 ?>
                                                    Desember
                                                    @break    
                                                @default
                                                    <?php $month=0 ?>
                                                    gak tau
                                            @endswitch
                                        </div>
                                        <div class="widget-subheading opacity-7">2019</div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="text-center">
                            
                            <a href="{{route('presensiByMonth',['user'=>$karyawan->id,'month'=>$month])}}" class="btn btn-primary btn-sm">Detail</a>
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