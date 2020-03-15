<?php

namespace App\Console\Commands;

use CreatePresensisTable;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class buatabsen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absen:buat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'membuat data absen dan disimpan ke database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $karyawan = \DB::table('karyawans')->get();
        $mytime = Carbon::now();
        $faker = Faker::create('id_ID');
        foreach ($karyawan as $item) {
        # code...
        $presensi = \DB::table('presensis')->insert([
            'karyawan_id' => $item->id, 
            'tanggal' => $mytime->toDateString(),
            'jam_hadir' => $faker->time($format = 'H:i:s',),
            'tanggal' => $mytime->toDateString(),
            'kode_darurat' => $faker->randomNumber($nbDigits=4,$strict=true)
        ]);
        }
    }
}
