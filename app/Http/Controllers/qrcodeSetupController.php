<?php

namespace App\Http\Controllers;

use App\Linkqr;
use App\QRcode as AppQRcode;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Zxing\QrReader;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class qrcodeSetupController extends Controller
{
    // public function offlineReader()
    // {
    //     $var = new QrReader(public_path('images/qr.png'));
    //     dd($var->text());
    //     return "adad";
    // }
    public function create()
    {
        return view('manajemen.addlink');

    }

    public function generate(Request $request)
    {
        $mytime = Carbon::now();
        $random = (new qrcodeSetupController)->random_str();
        $linkqr = Linkqr::insertGetId([
            'link' => $random,
            'nama'=>$request->nama,
            'no_hp'=>$request->no_hp,
            'email'=>$request->email,
            'nama_p'=>$request->nama_p,
            'jabatan'=>$request->jabatan,
            'alamat_p'=>$request->alamat,
            'tanggal'=>$mytime->toDateString(),
            'user_id'=>Auth::user()->id,
            'status'=>'aktif',
        ]);
            ////////////////////////////////////
        $faker = Faker::create('id_ID');
        $secret = $faker->regexify('[A-Za-z1-9]{8}');
        $qrcode = AppQRcode::insert([
            'linkqr_id' => $linkqr,
            'qrcode' => $secret,
            'status' => 'tes'
        ]);
        return redirect()->route('admin.link')->with('success','Berhasil Membuat Link, Silahkan copy linknya <br>https://meidy-unmul.000webhostapp.com/validasi/'.$random);
    }

    public function simpanRequestLink(Request $request)
    {
        $mytime = Carbon::now();
        $linkqr = Linkqr::insert([
            'nama'=>$request->nama,
            'no_hp'=>$request->no_hp,
            'email'=>$request->email,
            'nama_p'=>$request->nama_p,
            'jabatan'=>$request->jabatan,
            'alamat_p'=>$request->alamat,
            'tanggal'=>$mytime->toDateString(),
            'user_id'=>Auth::user()->id,
            'status'=>'pengajuan',
        ]);

        return redirect()->route('karyawan.request')->with('success','Berhasil mengajukan link validasi');
    }

    public function showqr($link)
    {
        $mytime = Carbon::now();
        $linkqr = Linkqr::where('link','=',$link)->where('status','=','aktif')->first();
        if ($linkqr) {
            $qrcode = AppQRcode::where('linkqr_id','=',$linkqr->id)->first();
            $qrcode = $qrcode->qrcode;
        }
        return $linkqr?view('showqr',compact('qrcode','link')):abort(404);

    }

    private function random_str(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    public function scanqr()
    {

        return view('karyawan.scanner');
    }

    public function aktifkan($id)
    {

        $linkqr=Linkqr::find($id)->update(['status'=>'aktif']);
        return redirect()->route('admin.link')->with('success','Berhasil mengaktifkan link validasi');
    }

    public function matikan($id)
    {

        $linkqr=Linkqr::find($id)->update(['status'=>'tidak']);
        return redirect()->route('admin.link')->with('success','Berhasil mematikan link validasi');
    }

    public function disetujui($id)
    {


        $random = (new qrcodeSetupController)->random_str();
        $faker = Faker::create('id_ID');
        $secret = $faker->regexify('[A-Za-z1-9]{8}');
        $linkqr=Linkqr::find($id);
        $linkqr->update(['status'=>'aktif','link'=>$random]);
        $qrcode = AppQRcode::insert([
            'linkqr_id' => $id,
            'qrcode' => $secret,
            'status' => 'tes'
        ]);
        return redirect()->route('admin.link')->with('success','Berhasil Membuat Link, Silahkan copy linknya <br>https://meidy-unmul.000webhostapp.com/validasi/'.$random.'<br>Penerima'.$linkqr->nama);
    }

    public function hapus($id)
    {

        $linkqr = Linkqr::find($id)->delete();
        return redirect()->route('admin.link')->with('success','Berhasil Menghapus Link');
    }

    public function lihat($id)
    {
        $linkqr = Linkqr::with('user.karyawan')->find($id);
        return view('manajemen.lihatlink',compact('linkqr'));
    }

    public function edit($id)
    {

        $item = Linkqr::find($id);
        return view('manajemen.editlink',compact('item'));
    }

    public function ubah(Request $request)
    {
        $linkqr = Linkqr::find($request->id)->update([
            'nama'=>$request->nama,
            'no_hp'=>$request->no_hp,
            'email'=>$request->email,
            'nama_p'=>$request->nama_p,
            'jabatan'=>$request->jabatan,
            'alamat_p'=>$request->alamat,
        ]);
        return redirect()->route('admin.link')->with('success','Berhasil Merubah Link');
    }

}
