<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'user_id' => 'USR1',
            'first_name' => 'Apsya',
            'last_name' => 'Dira',
            'email' => 'apsya87@gmail.com',
            'password' => bcrypt('apsyadira29'),
            'created_by' => 1,
        ]);
    }
}
