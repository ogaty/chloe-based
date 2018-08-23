<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'display_name' => 'admin',
            'email' => '',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'role' => 0,
            'url' => '',
            'twitter' => '',
            'facebook' => '',
            'bio' => '',
            'remember_token' => str_random(10),
        ]);
    }
}
