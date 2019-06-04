<?php

use Illuminate\Database\Seeder;
use App\User;

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
            'name' => 'Admin', 
            'email' => 'admin@titan.com',
            'password' => '$2y$10$C2/lCFkeHzrxJqmdz9IPDeZ1F3Bz9UmpgqpKsBCBLbp2/FkLjUSPm',
            'role_id' => 1,
        ]);
    }
}
