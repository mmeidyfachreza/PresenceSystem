@extends('layouts.presensi2')
@section('sidebar')
    @component('components.sidebar')
         @slot('menu')
         <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">{{Auth::user()->karyawan->nama}}</li>
                <li>
                    <a href="{{route('karyawan.presensi')}}">
                        <i class="metismenu-icon fas fa-tv"></i>
                        Presensi
                    </a>
                </li>
                <li>
                    <a href="{{route('karyawan.request')}}">
                        <i class="metismenu-icon fas fa-clipboard-list"></i>
                        Link Validasi
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                        <i class="metismenu-icon fas fa-sign-out-alt"></i>
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
         @endslot
    @endcomponent
@endsection

@section('content')
    @yield('content')
@endsection
