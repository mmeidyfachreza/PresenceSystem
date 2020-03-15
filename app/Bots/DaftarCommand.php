<?php

namespace App\Bots;

use Telegram\Bot\Commands\Command;
/**
 * Class HelpCommand.
 */
class DaftarCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'start';

    
    /**
     * @var string Command Description
     */
    protected $description = 'Untuk mendaftar';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $telegram_user = \Telegram::getWebhookUpdates()['message'];
        if ($user = \DB::table('karyawans')->where('id_telegram', '=', $telegram_user['from']['id'])->first()) {
            # code...
            $message = 'Hello.. Selamat beraktifitas '.$user->nama."\n".'jangan lupa untuk presensi ya..'."\n".
            '/masuk untuk melakukan presensi'."\n".
            '/pulang jika sudah selesai bekerja';
        }else{
            $message = 'Hello.. Selamat datang di bot presensi, silahkan masukan NIP anda untuk verifikasi'."\n";
        }
        
        
        $this->replyWithMessage(['text' => $message]);

             
    }
}
