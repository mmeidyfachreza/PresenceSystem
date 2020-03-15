<?php
use Illuminate\Database\Seeder;
use App\User;
use App\Karyawan;
use Faker\Factory as Faker;
class UserTableSeeder extends Seeder
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
        $user = new User();
        $user->karyawan_id = 1;
        // $user->email = preg_replace('/@example\..*/', '@thortech.com', $faker->unique()->safeEmail);
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('admin');
        $user->role = 'admin';
        $karyawan = Karyawan::find(1);
        $user->karyawan()->associate($karyawan)->save();
    }
}
