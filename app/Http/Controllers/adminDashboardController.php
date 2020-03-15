<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Presensi;
use App\Karyawan;
use App\BotConfig;
use App\Linkqr;
use App\SmsConfig;
use App\User;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class adminDashboardController extends Controller
{
    //
    public function index()
    {
        # code...
        $presensi = Presensi::orderBy('jam_hadir','ASC')->where('tanggal','=',Carbon::now()->toDateString())->get();
        return view('manajemen.dashboard',compact('presensi'));
    }

    public function getUpdates()
    {
        # code...
        $updates = Telegram::getWebhookUpdates();
        Storage::put('log.txt', $updates);
    }

    public function botConfig()
    {
        # code...
        $bot = BotConfig::find(1);
        return view('manajemen.bot-telegram',compact('bot'));
    }

    public function smsConfig()
    {
        # code...
        $sms = SmsConfig::find(1);
        return view('manajemen.sms-gateway',compact('sms'));
    }

    public function karyawan()
    {
        # code...
        $karyawan = Karyawan::orderBy('nama')->get();
        return view('manajemen.list-karyawan',compact('karyawan'));
    }

    public function user()
    {
        # code...
        $user = User::orderBy('email')->get();
        return view('manajemen.list-user',compact('user'));
    }

    public function presensi()
    {
        # code...
        $karyawan = Karyawan::orderBy('nama')->get();
        return view('manajemen.list-presensi',compact('karyawan'));
    }

    public function linkVal()
    {
        # code...
        //$linkqr = Linkqr::where('permintaan','=','karyawan')->get();
        $linkqr = Linkqr::with('user.karyawan')->where('status','=','pengajuan')->get();
        //dd(Linkqr::with('user.karyawan')->get());
        $linkqrA = Linkqr::where('status','=','aktif')->orWhere('status','=','tidak')->get();
        return view('manajemen.linkVal',compact('linkqr','linkqrA'));
    }
}
