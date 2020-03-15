<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use MikrotikAPI\Core\RouterosAPI;
use Carbon\Carbon;
use App\BotConfig;
use App\SmsConfig;

class configController extends Controller
{
    //
    public function setBotToken(Request $request)
    {
        $rules = [
            'token' => 'required',
        ];
    
        $customMessages = [
            'required' => 'Kolom :attribute harus diisi.'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $bot = BotConfig::find(1);
        if ($bot) {
            # code...

            $bot->bot_token = $request->token;
            $bot->update();
            return redirect()->route('admin.botConfig')->with('success','bot token berhasil dirubah');
        }else{
            $bot = new BotConfig();
            $bot->id= 1;
            $bot->bot_token = $request->token;
            $bot->save();
            return redirect()->route('admin.botConfig')->with('success','bot token berhasil didaftarkan');
        }
        
        return "ok";
    }

    public function setWebhookUrl(Request $request)
    {
        # code... 
        $bot = BotConfig::find(1);
        $webhook = "https://".$request->url."/".$bot->bot_token."/webhook";
        $response = Telegram::setWebhook(['url' => $webhook]);
        $bot->webhook_url = $webhook;
        $bot->update();         
        return redirect()->route('admin.botConfig')->with('success','Webhook berhasil diaktifkan');
    }

    
    public function setWebhookUrl2()
    {
        # webhook with ngrok automatically
        $bot = BotConfig::find(1);
        $jsonurl = "http://127.0.0.1:4040/api/tunnels";
        $json = file_get_contents($jsonurl);
        $ngrok = json_decode($json);
        $webhook = $ngrok->tunnels[0]->public_url."/".$bot->bot_token."/webhook";

        if (substr($webhook, 0, strlen("http://")) == "http://") {
            $webhook = substr($webhook, strlen("http://"));
        }elseif (substr($webhook, 0, strlen("https://")) == "https://") {
            $webhook = substr($webhook, strlen("https://"));
        }
        $webhook = "https://".$webhook;
        $response = Telegram::setWebhook(['url' => $webhook]);
        $bot->webhook_url = $webhook;
        $bot->update();         
        return redirect()->route('admin.botConfig')->with('success','Webhook via ngrok berhasil diaktifkan');
        // $response = Telegram::setWebhook(['url' => $request->url]);
        // return "ok";

    }

    public function setMikrotik(Request $request)
    {
        # code...
        if ($config = SmsConfig::find(1)) {
            # code...
            $config->nama = "default";
            $config->ip_address = $request->ip_address;
            $config->username = $request->username;
            $config->password = $request->password;
            $config->port = $request->port;
            $config->update();
            return redirect()->route('admin.smsConfig')->with('success','Konfigurasi Berhasil Dirubah');
        }else{
            $config = new SmsConfig();
            $config->nama = "default";
            $config->ip_address = $request->ip_address;
            $config->username = $request->username;
            $config->password = $request->password;
            $config->port = $request->port;
            $config->save();

            return redirect()->route('admin.smsConfig')->with('success','Konfigurasi Berhasil Disimpan');
        }
        
        
    }

    public function tesMikrotik()
    {
        # code...
        $config = SmsConfig::find(1);
        $API= new RouterosAPI();
        $API->connect($config->ip_address,$config->port,$config->username,$config->password);
        if($API->isConnected()) {
            return redirect()->route('admin.smsConfig')->with('success','Mikrotik Berhasil'."\n".' Terhubung');
        }else{
            return redirect()->route('admin.smsConfig')->withErrors(['Ip Address: '.$config->ip_address,'Username: '.$config->username,'Mikrotik Gagal'."\n".' Terhubung']);
        }
        
        
    }

    public function configMikrotik(Request $request)
    {
        # code...
        
        $config = SmsConfig::find(1);
        $API= new RouterosAPI();
        $API->connect($config->ip_address,$config->port,$config->username,$config->password);
        if($API->isConnected()) {

            $script = $API->comm("/system/script/print");
            $x=0;
            foreach ($script as $item) {
                if ($item["name"]=="sms") {
                    # code...
                    $API->write("/system/script/remove",false);
                $API->write("=.id=".$x);
                $API->read(); 
                }
                $x++;
            }
            $scheduler = $API->comm("/system/scheduler/print");
            $y=0;
            foreach ($scheduler as $item) {
                if ($item["name"]=="schedulesms") {
                    # code...
                    
                    $API->write("/system/scheduler/remove",false);
                $API->write("=.id=".$y);
                $API->read(); 
                
                }
                $y++;
            }

            //sntp config
            $API->comm("/system/ntp/client/set",array(
                "primary-ntp" => "202.65.114.202",
                "secondary-ntp" => "36.86.63.182",
                "enabled" => "yes",
            ));

            //clock config
            $API->comm("/system/clock/set",array(
                "time-zone-autodetect" => "yes",
                "time-zone-name" => "Asia/Makassar",
            ));

            $clock1 = $API->comm("/system/clock/print");
            $clock2 = explode(":",$clock1[0]['time'],2);
            $clock3 = explode(":",$clock2[1]);
            $clock4 = (int)$clock3[0]+1;
            $clock = $clock2[0].":".$clock4.":".$clock3[1];
            

            //script untuk trigger fetch data dari laravel
            $API->comm("/system/script/add",array(
                "name" => "sms",
                "source" => "/tool fetch url=\"http://".$request->url."/smswebhook\" keep-result=no",
            ));

            $API->comm("/system/scheduler/add",array(
                "name" => "schedulesms",
                "start-time" => $clock,
                "interval" => "00:00:10",
                "on-event" => "sms",
            ));

            


            return redirect()->route('admin.smsConfig')->with('success','Mikrotik Berhasil'."\n".' dikonfigurasi');
        }else{
            return redirect()->route('admin.smsConfig')->withErrors(['Ip Address: '.$config->ip_address,'Username: '.$config->username,'Mikrotik Gagal'."\n".' Terhubung']);
        }
        
        
    }

    public function smsWebhook(){
        $config = SmsConfig::find(1);
        $API= new RouterosAPI();
        $API->connect($config->ip_address,$config->port,$config->username,$config->password);
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
      }else{
        return "gagal";
      }
      
      }
}
