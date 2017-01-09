<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use \App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = [
            'name' => 'GANZ Anthony',
            'email' => 'anthony.ganz.bts@gmail.com',
            'password' => Hash::make('Candice*25'),
        ];
        User::create($user1);
    }
}
