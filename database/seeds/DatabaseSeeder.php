<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firtUser = User::where('email', 'admin@gmail.com')->first();

        if (!$firtUser) {
            User::create([
                'name' => 'Khoi Bui Van',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123123'),
            ]);
        }
        // $this->call(UsersTableSeeder::class);
    }
}
