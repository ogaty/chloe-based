<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Settings;
use Illuminate\Console\Command;

class DbSet extends Command {
    protected function createUser($email, $password, $firstName, $lastName)
    {
        $user = User::firstOrNew(['email' => $email]);
        $user->password = bcrypt($password);
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->display_name = $firstName.' '.$lastName;
        $user->role = 1;
        $user->save();

        $settings = new Settings();
        $settings->setting_name = 'blog_author';
        $settings->setting_value = $user->display_name;
        $settings->save();
    }

    protected function title($blogTitle)
    {
        $settings = Settings::firstOrNew(['setting_name' => 'blog_title']);
        $settings->setting_value = $blogTitle;
        $settings->save();
    }

    protected function subtitle($blogSubtitle)
    {
        $settings = Settings::firstOrNew(['setting_name' => 'blog_subtitle']);
        $settings->setting_value = $blogSubtitle;
        $settings->save();
    }

    protected function description($blogDescription)
    {
        $settings = Settings::firstOrNew(['setting_name' => 'blog_description']);
        $settings->setting_value = $blogDescription;
        $settings->save();
    }
}
