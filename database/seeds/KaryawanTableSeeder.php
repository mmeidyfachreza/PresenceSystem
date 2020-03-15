<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Karyawan;
class KaryawanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //
        $faker = Faker::create('id_ID');
        for ($i=0; $i <10; $i++) {
            # code...
            $karyawan = new Karyawan();
            $karyawan->no_identitas = $faker->randomNumber($nbDigits=8,$strict=true);
            $karyawan->nama = $faker->firstName();
            $karyawan->tgl_lahir = $faker->date($year='Y-m-d',$max='now');
            $karyawan->tempat_lahir = $faker->city;
            $karyawan->alamat = $faker->address;
            $karyawan->jenis_kelamin = $faker->randomElement(['Laki-laki', 'Perempuan']);
            $karyawan->no_hp = $faker->phoneNumber;
            // $karyawan->kode_darurat = $faker->randomNumber($nbDigits=4,$strict=true);
            $karyawan->save();
        }
    }
}
