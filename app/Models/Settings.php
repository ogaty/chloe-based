<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Settings extends Model
{
    protected $table = 'settings';

    public static function getByName($settingName)
    {
        return self::where('setting_name', $settingName)->pluck('setting_value')->first();
    }

    public static function blogSeo() {
        $seo = Cache::get('settings.blog.seo');
        if (is_null($seo)) {
            $seo = self::getByName('blog_seo');
            Cache::forever('settings.blog.seo', $seo);
        }
        return $seo;
    }

    public static function blogAuthor() {
        $author = Cache::get('settings.blog.author');
        if (is_null($author)) {
            $author = self::getByName('blog_author');
            Cache::forever('settings.blog.author', $author);
        }
        return $author;
    }

    public static function blogDescription() {
        $description = Cache::get('settings.blog.description');
        if (is_null($description)) {
            $description = self::getByName('blog_description');
            Cache::forever('settings.blog.description', $description);
        }
        return $description;
    }

    public static function blogTitle() {
        $title = Cache::get('settings.blog.title');
        if (is_null($title)) {
            $title = self::getByName('blog_title');
            Cache::forever('settings.blog.title', $title);
        }
        return $title;
    }

    public static function blogSubTitle() {
        $subTitle = Cache::get('settings.blog.subtitle');
        if (is_null($subTitle)) {
            $subTitle = self::getByName('blog_subtitle');
            Cache::forever('settings.blog.subtitle', $subTitle);
        }
        return $subTitle;
    }

    public static function blogUrl() {
        return url('');
    }

    public static function gaId() {
        $gaId = Cache::get('settings.blog.gaid');
        if (is_null($gaId)) {
            $gaId = self::getByName('blog_description');
            Cache::forever('settings.blog.gaid', $gaId);
        }
        return $gaId;
    }

    public static function customCSS()
    {
        return $customCSS = self::where('setting_name', 'custom_css')->pluck('setting_value')->first();
    }

    public static function customJS()
    {
        return $customJS = self::where('setting_name', 'custom_js')->pluck('setting_value')->first();
    }

    public static function ad1()
    {
        return self::where('setting_name', 'ad1')->pluck('setting_value')->first();
    }

    public static function ad2()
    {
        return self::where('setting_name', 'ad2')->pluck('setting_value')->first();
    }

    public static function twitterCardType()
    {
    }

    public static function socialHeaderIconsUserId()
    {
    }

    public static function ogImage() {
        return self::where('setting_name', 'og_image')->pluck('setting_value')->first();
    }

    public static function feedTime() {
        return self::where('setting_name', 'feed_time')->pluck('setting_value')->first();
    }
}
