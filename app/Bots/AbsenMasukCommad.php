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
class AbsenMasukCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'masuk';

    /**
     * @var string Command Description
     */
    protected $description = 'Untuk mendata waktu hadir anda';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $telegram_user = \Telegram::getWebhookUpdates()['message'];
        if ($user = \DB::table('karyawans')->where('id_telegram', '=', $telegram_user['from']['id'])->first()) {
            $mytime = Carbon::now();
            $faker = Faker::create('id_ID');
            if (!\DB::table('presensis')->where('karyawan_id', '=', $user->id)->Where('tanggal', '=', $mytime->toDateString())->first()) {
                $presensi = \DB::table('presensis')->insert([
                    'karyawan_id' => $user->id, 
                    'tanggal' => $mytime->toDateString(),
                    'cache' => $telegram_user['text']
                ]);
                $btn = Keyboard::button([
                    'text' => 'Tekan ini untuk kirim lokasi..',
                    'request_location' => true
                ]);
                $keyboard = Keyboard::make([
                    'keyboard' => [[$btn]],
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ]);
        
                $response = \Telegram::sendMessage([
                    'chat_id' => $telegram_user['from']['id'], 
                    'text' => 'Silahkan kirim lokasi anda saat ini',
                    'parse_mode'=>'html',
                    'reply_markup'=>$keyboard 
                ]);
            }elseif ($absen = \DB::table('presensis')->where('karyawan_id', '=', $user->id)->Where('tanggal', '=', $mytime->toDateString())->Where('cache', '=', '/pulang')->first()) {
                # code...
                $response = Telegram::sendMessage([
                    'chat_id' => $telegram_user['from']['id'], 
                    'text' => 'Anda sudah melakukan absen masuk hari ini pada jam '.date("H:i",strtotime($absen->jam_hadir)),
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
            }else {
                $btn = Keyboard::button([
                    'text' => 'Kirim lokasi dong..',
                    'request_location' => true
                ]);
                $keyboard = Keyboard::make([
                    'keyboard' => [[$btn]],
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ]);
        
                $response = \Telegram::sendMessage([
                    'chat_id' => $telegram_user['from']['id'], 
                    'text' => 'Lagi dimana nih?',
                    'parse_mode'=>'html',
                    'reply_markup'=>$keyboard 
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
