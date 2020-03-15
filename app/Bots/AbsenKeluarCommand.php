<?php

namespace App\Bots;

use Telegram\Bot\Actions;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Commands\Command;
/**
 * Class HelpCommand.
 */
class AbsenKeluarCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'pulang';

    /**
     * @var string Command Description
     */
    protected $description = 'Untuk mendata waktu pulang anda';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $telegram_user = \Telegram::getWebhookUpdates()['message'];
        $jalur_absen = "telegram";
        $durasi = "tes";
        if ($user = \DB::table('karyawans')->where('id_telegram', '=', $telegram_user['from']['id'])->first()) {
                $mytime = Carbon::now();
                if ($absen = \DB::table('presensis')->where('karyawan_id', '=', $user->id)->Where('tanggal', '=', $mytime->toDateString())->Where('cache', '=', '/pulang')->first()) {
                    
                    if ($absen->jalur_absen=="sms") {
                        $jalur_absen = "sms";
                    }
                    $startTime = Carbon::parse($absen->jam_hadir);
                    $finishTime = Carbon::parse($mytime);
                    $totalDuration1 =floatval($startTime->diff($finishTime)->format('%h.%i')) ;
                    $totalDuration2 = $startTime->diff($finishTime)->format('%h jam %i menit');
                    $presensi = \DB::table('presensis')
                        ->where('karyawan_id', '=', $user->id)
                        ->Where('tanggal', '=', $mytime->toDateString())
                        ->update([
                            'jam_keluar'=>$mytime->toTimeString(),
                            'jalur_absen'=>$jalur_absen,
                            'cache'=>'selesai','durasi_kerja'=>$totalDuration1
                        ]);
                    
                    
                    $response = Telegram::sendMessage([
                        'chat_id' => $telegram_user['from']['id'], 
                        'text' => 'Terimakasih sudah bekerja selama '.$totalDuration2,
                        'parse_mode'=>'html'
                      ]);
                }elseif ($absen = \DB::table('presensis')->where('karyawan_id', '=', $user->id)->Where('tanggal', '=', $mytime->toDateString())->Where('cache', '=', 'selesai')->first()) {
                    # code...
                    $startTime = Carbon::parse($absen->jam_hadir);
                    $finishTime = Carbon::parse($absen->jam_keluar);
                    
                    $totalDuration2 = $startTime->diff($finishTime)->format('%h jam %i menit');
                    $response = Telegram::sendMessage([
                        'chat_id' => $telegram_user['from']['id'], 
                        'text' => 'Anda sudah absen hari ini pada jam '.date("H:i",strtotime($absen->jam_hadir)).' dan durasi kerja anda selama '.$totalDuration2,
                        'parse_mode'=>'html'
                      ]);
                }
                
        }else{
            $message = 'Maaf.. anda belum terdaftar untuk dapat melakukan absen';
            $this->replyWithMessage(['text' => $message]);
        }
        

        // $url_arr[0]['text']='Text URL';
        // //$url_arr[0]['url']='https://www.google.com';
        // $url_arr[1]['text']='Text URL';
        // //$url_arr[1]['url']='https://www.google.com';

        // $telegram_user = \Telegram::getWebhookUpdates()['message'];

        // $btn = Keyboard::button([
        //     'text' => 'Kirim lokasi dong..',
        //     'request_location' => true
        // ]);
        // $keyboard = Keyboard::make([
        //     'keyboard' => [[$btn]],
        //     'resize_keyboard' => true,
        //     'one_time_keyboard' => true
        // ]);

        // $response = \Telegram::sendMessage([
        //     'chat_id' => $telegram_user['from']['id'], 
        //     'text' => 'Lagi dimana nih?',
        //     'parse_mode'=>'html',
        //     'reply_markup'=>$keyboard 
        // ]);
        
        // $response = \Telegram::sendMessage([
        //     'chat_id' => $telegram_user['from']['id'], 
        //     'text' => 'lagi di mana nih?',
        //     'parse_mode'=>'html',
        //     'reply_markup'=>json_encode(['inline_keyboard'=>array($url_arr)])
        // ]);

        // Storage::put('call.txt', $callbackQuery);        
    }
}
