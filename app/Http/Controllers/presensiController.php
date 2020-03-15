<?php

namespace App\Http\Controllers;

use App\Presensi;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Faker\Factory as Faker;
use MikrotikAPI\Core\RouterosAPI;
use App\Karyawan;
use App\Linkqr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Torann\GeoIP\Facades\GeoIP;

class presensiController extends Controller
{

    public function respon()
    {
      # code...
        $tes = new GeoIP();
    }

    public function getUpdates()
    {

        $recieve_response = Telegram::commandsHandler(true);

        if ($recieve_response->getMessage()->text && $recieve_response->getMessage()->get('entities', collect())->contains('type', 'bot_command')==false) {
          # code...
          if (is_numeric($recieve_response->getMessage()->text)) {
            if ($user = \DB::table('karyawans')->where('no_identitas', '=', $recieve_response['text'])->first()) {
              # code...
              $response = Telegram::sendMessage([
                'chat_id' => $recieve_response->getChat()->id,
                'text' => 'Selamat anda terverifikasi sebagai '.$user->nama.', anda sudah dapat melakukan presensi dengan command berikut:'."\n".
                '/masuk untuk melakukan presensi'."\n".
                '/pulang jika sudah selesai bekerja',
                'parse_mode'=>'html'
              ]);
              $user = \DB::table('karyawans')->where('no_identitas', '=', $recieve_response['text'])->update(['id_telegram'=>$recieve_response->getChat()->id]);
            }else{
              $response = Telegram::sendMessage([
                'chat_id' => $recieve_response->getChat()->id,
                'text' => 'Maaf.. NIP tidak dikenali',
                'parse_mode'=>'html'
              ]);
            }

          }else{
            $response = Telegram::sendMessage([
              'chat_id' => $recieve_response->getChat()->id,
              'text' => 'Maaf saya tidak mengerti',
              'parse_mode'=>'html'
            ]);
          }

        }elseif ($recieve_response->getMessage()->location) {
          # code...
          $mytime = Carbon::now();
          $user = \DB::table('karyawans')->where('id_telegram', '=', $recieve_response->getChat()->id)->first();
          if (\DB::table('presensis')->where('karyawan_id', '=', $user->id)->Where('cache', '=', '/masuk')->first()) {
            # code...
            $presensi = \DB::table('presensis')->where('karyawan_id', '=', $user->id)->Where('tanggal', '=', $mytime->toDateString())->update(['jam_hadir'=>$mytime->toTimeString(),'cache'=>'/pulang','jalur_absen'=>'telegram',]);
            $response = Telegram::sendMessage([
              'chat_id' => $recieve_response->getChat()->id,
              'text' => 'Absen telah Terdata, Selamat Bekerja... ',
              'parse_mode'=>'html'
            ]);
          }

        }



        //return response()->json($recieve_response->getMessage()->get('entities', collect())->contains('type', 'bot_command'), 200);
        return response()->json($recieve_response->getMessage()->location, 200);
    }

    public function getMe(){
      $API= new RouterosAPI();
      $API->connect('192.168.137.66','8728','meidy','123');
      $mytime = Carbon::now();
      $faker = Faker::create('id_ID');
      if($API->isConnected()) {
        echo "konek";
        $x=0;


        $API->comm("/tool/sms/set",array("receive-enabled" => "yes"));


        $smsgateway=$API->comm("/tool/sms/inbox/print");
        //$smsgateway=$API->comm("/tool/sms/inbox/find",array("message" => "/masuk"));


        echo "<br>";

        foreach ($smsgateway as $item) {
          # code...

          $array = explode(' ',$item["timestamp"],2);
          $array2 = explode(' ',$array[1],2);
          $time = date('Y-m-d',strtotime(str_replace("/","-",$array[0])))." ".$array2[0];

          if ($user = \DB::table('karyawans')->where('no_hp', '=', str_replace("+62", "0", $item['phone']))->first()) {
            $message = explode("#",$item['message']);
            // if (\DB::table('presensis')->where('karyawan_id', '=', $user->id)->Where('tanggal', '=', $mytime->toDateString())->Where('created_at', '=', $time)->first()) {
            //   echo 'dapatttt';
            // }
            if ($item['message']=='/masuk') {
              if (!\DB::table('presensis')->where('karyawan_id', '=', $user->id)->Where('tanggal', '=', $mytime->toDateString())->first()) {
                $insert = \DB::table('presensis')->insert([
                  'karyawan_id' => $user->id,
                  'tanggal' => $mytime->toDateString(),
                  'jam_hadir'=>$array2[0],
                  'jalur_absen'=>"sms",
                  'created_at'=>$time,
                  'cache' => "/pulang"
                ]);
                $API->write("/tool/sms/inbox/remove",false);
                $API->write("=.id=".$x);
                $API->read();
                $response = Telegram::sendMessage([
                  'chat_id' => 674120145,
                  'text' => 'Presensi berhasil terdata ('.$time.'), selamat bekerja',
                  'parse_mode'=>'html'
                ]);

              }
            }elseif ($item['message']=='/pulang') {
              # code...
              if ($absen = \DB::table('presensis')->where('karyawan_id', '=', $user->id)->Where('tanggal', '=', $mytime->toDateString())->Where('cache', '=', '/pulang')->first()) {

                  $startTime = Carbon::parse($absen->jam_hadir);
                  $finishTime = Carbon::parse($time);
                  $totalDuration1 =floatval($startTime->diff($finishTime)->format('%h.%i')) ;
                  $totalDuration2 = $startTime->diff($finishTime)->format('%h jam %i menit');
                  $update = \DB::table('presensis')
                      ->where('karyawan_id', '=', $user->id)
                      ->Where('tanggal', '=', $mytime->toDateString())
                      ->update([
                          'jam_keluar'=>$time,
                          'cache'=>'selesai',
                          'durasi_kerja'=>$totalDuration1
                  ]);
                  $API->write("/tool/sms/inbox/remove",false);
                  $API->write("=.id=".$x);
                  $API->read();
                  $response = Telegram::sendMessage([
                    'chat_id' => 674120145,
                    'text' => 'Terimakasih atas kerjasamanya, durasi kerja anda hari ini ('.$totalDuration2.') selamat beristirahat',
                    'parse_mode'=>'html'
                  ]);

              }
            }
          }
          echo "<br>";
          echo $time;
          echo "<br>";
          echo $item['message'];
          echo "<br>";
          $x++;
        }
    }
    return "gagal";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $karyawan = \DB::table('karyawans')->get();
        $mytime = Carbon::now()->daysInMonth;
        $month = Carbon::now()->format('m');
        $day =5;

        $date = new Carbon('2016-'.$month.'-'.$day.'');
        dd($date);
        for ($i=0; $i <$mytime ; $i++) {
          # code...
        }

        $faker = Faker::create('id_ID');
        foreach ($karyawan as $item) {
        # code...
        $presensi = \DB::table('presensis')->insert([
            'karyawan_id' => $item->id,
            'tanggal' => $mytime->toDateString(),
        ]);
        }
    }

    public function distance(){

        $lat1=-0.504118;
        $lon1=117.113558;
        $lat2=-0.503656;
        $lon2=117.113703;
        $unit="m";
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }
        else {
          $theta = $lon1 - $lon2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
          $unit = strtoupper($unit);

          if ($unit == "K") {
            return ($miles * 1.609344);
          } else if ($unit == "N") {
            return ($miles * 0.8684);
          } else {
            return ($miles*1609.34);
          }
        }
      }

    /**
     * Display the specified resource.
     *
     * @param  \App\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // $karyawans = Presensi::where('karyawan_id',$id)->get();


       $months = Presensi::get()->groupBy(function($d) {
        return Carbon::parse($d->tanggal)->format('m');
        });
        // foreach ($months as $key => $value) {
        //   # code...
        // }



        $karyawan = Karyawan::with("presensi")->find($id);

        return view('presensi.year',compact('karyawan'));

    }

    public function showByMonth($user,$month)
    {
       // $karyawans = Presensi::where('karyawan_id',$id)->get();
       switch ($month) {
         case 1:
           $monthName = "Januari";
           break;
         case 2:
           $monthName = "Februari";
           break;
         case 3:
           $monthName = "Maret";
           break;
         case 4:
           $monthName = "April";
           break;
         case 5:
           $monthName = "Mei";
           break;
         case 6:
           $monthName = "Juni";
           break;
         case 7:
           $monthName = "Juli";
           break;
         case 8:
           $monthName = "Agustus";
           break;
         case 9:
           $monthName = "September";
           break;
         case 10:
           $monthName = "Oktober";
           break;
         case 11:
           $monthName = "Novermber";
           break;
         case 12:
           $monthName = "Desember";
           break;
         default:
           # code...
           $monthName = "Error";
           break;
       }
       $presensi = Presensi::whereMonth('tanggal', '=', $month)->where("karyawan_id", '=', $user)
       ->get();
       $karyawan = Karyawan::find($user);
        return view('presensi.month',compact('presensi','monthName','karyawan'));

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Presensi $presensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presensi $presensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presensi $presensi)
    {
        //
    }

    public function indexPresensi()
    {
        # code...
        // $tai = Presensi::where('karyawan_id', '=', Auth::user()->karyawan->id)->first();
        // $qew = explode(',',$tai->lokasi_user_hadir);
        // dd($qew[1]);
        $mytime = Carbon::now();
        $presensi = json_decode(Presensi::where('karyawan_id', '=', Auth::user()->karyawan->id)->Where('tanggal', '=', $mytime->toDateString())->first());

        return view('karyawan.presensi',['presensi'=>$presensi]);
    }

    public function scannerPresensi()
    {
        # code...
        return view('karyawan.scanner');
    }

    public function IndexRequestLink()
    {
        # code...
        return view('karyawan.requestLink');
    }


}
