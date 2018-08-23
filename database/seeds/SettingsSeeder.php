<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'setting_name' => 'blog_title',
            'setting_value' => '',
        ]);
        DB::table('settings')->insert([
            'setting_name' => 'blog_author',
            'setting_value' => '',
        ]);
        DB::table('settings')->insert([
            'setting_name' => 'blog_description',
            'setting_value' => '',
        ]);
        DB::table('settings')->insert([
            'setting_name' => 'blog_subtitle',
            'setting_value' => '',
        ]);
        DB::table('settings')->insert([
            'setting_name' => 'gaid',
            'setting_value' => '',
        ]);
        DB::table('settings')->insert([
            'setting_name' => 'blog_seo',
            'setting_value' => '',
        ]);
        DB::table('settings')->insert([
            'setting_name' => 'twitter_card_type',
            'setting_value' => '',
        ]);
        DB::table('settings')->insert([
            'setting_name' => 'custom_css',
            'setting_value' => '',
        ]);
        DB::table('settings')->insert([
            'setting_name' => 'custom_js',
            'setting_value' => '',
        ]);
        DB::table('settings')->insert([
            'setting_name' => 'active_theme',
            'setting_value' => 'default',
        ]);
        DB::table('settings')->insert([
            'setting_name' => 'ad1',
            'setting_value' => '',
        ]);
        DB::table('settings')->insert([
            'setting_name' => 'ad2',
            'setting_value' => '',
        ]);
    }
}
