<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        if (App::environment('pro')) {
            echo 'cannot use in production'.PHP_EOL;
        }
        $this->call([
            UsersSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}
