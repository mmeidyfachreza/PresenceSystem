@extends('layouts.presensi')
@section('sidebar')
    @component('components.sidebar')
    @slot('menu')
    <ul class="vertical-nav-menu">
           <li class="app-sidebar__heading">Dashboard</li>
           <li>
               <a href="{{route('home')}}">
                   <i class="metismenu-icon fas fa-tv"></i>
                   Beranda
               </a>
           </li>
           <li class="app-sidebar__heading">Presensi</li>
           <li>
               <a href="{{route('admin.presensi')}}">
                   <i class="metismenu-icon fas fa-clipboard-list"></i>
                   Data Presensi
               </a>
           </li>
           <li>
            <a href="{{route('admin.link')}}">
                <i class="metismenu-icon fas fa-clipboard-list"></i>
                Link Validasi
            </a>
            </li>
           <li class="app-sidebar__heading">Data</li>
           <li>
               <a href="{{route('admin.karyawan')}}">
                   <i class="metismenu-icon fas fa-users">
                   </i>Data Karyawan
               </a>
           </li>
           <li>
               <a href="{{route('admin.user')}}">
                   <i class="metismenu-icon fas fa-user-tie">
                   </i>Data Pengguna
               </a>
           </li>

       </ul>
    @endslot
    @endcomponent
@endsection

@section('content')
    @yield('content')
@endsection
