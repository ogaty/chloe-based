<?php

use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (!App::environment('testing')) {
            echo "only use testing environment\n";
            return;
        }
        $this->call([
            UsersSeeder::class,
            SettingsSeeder::class,
            ThemesSeeder::class,
        ]);
    }
}
