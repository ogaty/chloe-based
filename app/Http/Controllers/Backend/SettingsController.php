<?php

namespace App\Http\Controllers\Backend;

use Session;
use App\Models\Settings;
use App\Extensions\ThemeManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsUpdateRequest;
use Illuminate\Filesystem\Filesystem;

class SettingsController extends Controller
{
    /**
     * @var ThemeManager
     */
    protected $themeManager = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->themeManager = new ThemeManager(resolve('app'), resolve('files'));
    }

    /**
     * Display the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $themes = $this->themeManager->getThemes();
        $data = [
            'blogTitle' => Settings::blogTitle(),
            'blogSubtitle' => Settings::blogSubTitle(),
            'blogDescription' => Settings::blogDescription(),
            'blogSeo' => Settings::blogSeo(),
            'blogAuthor' => Settings::blogAuthor(),
            'analytics' => Settings::gaId(),
            'twitterCardType' => Settings::twitterCardType(),
            'themes' => $this->themeManager->getThemes(),
            'default_theme_name' => $this->themeManager->getDefaultThemeName(),
            'active_theme' => $this->themeManager->getActiveTheme(),
            'active_theme_theme' => $this->themeManager->getTheme($this->themeManager->getActiveTheme()),
            'custom_css' => Settings::customCSS(),
            'custom_js' => Settings::customJS(),
            'ad1' => Settings::ad1(),
            'ad2' => Settings::ad2(),
            'url' => env('APP_URL'),
            'ip' => isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR']:'127.0.0.1',
            'timezone' => env('APP_TIMEZONE'),
            'phpVersion' => phpversion(),
            'phpMemoryLimit' => ini_get('memory_limit'),
            'phpTimeLimit' => ini_get('max_execution_time'),
            'dbConnection' => strtoupper(env('DB_CONNECTION', 'mysql')),
            'webServer' => isset($_SERVER['SERVER_SOFTWARE'])? $_SERVER['SERVER_SOFTWARE']:'phpunit',
            'lastIndex' => date('Y-m-d H:i:s', file_exists(storage_path('posts')) ? filemtime(storage_path('posts')) : false),
            'version' => 'based 1.0',
            'curl' => (in_array('curl', get_loaded_extensions()) ? 'Supported' : 'Not Supported'),
            'curlVersion' => (in_array('curl', get_loaded_extensions()) ? curl_version()['libz_version'] : 'Not Supported'),
            'gd' => (in_array('gd', get_loaded_extensions()) ? 'Supported' : 'Not Supported'),
            'pdo' => (in_array('PDO', get_loaded_extensions()) ? 'Installed' : 'Not Installed'),
            'sqlite' => (in_array('sqlite3', get_loaded_extensions()) ? 'Installed' : 'Not Installed'),
            'openssl' => (in_array('openssl', get_loaded_extensions()) ? 'Installed' : 'Not Installed'),
            'mbstring' => (in_array('mbstring', get_loaded_extensions()) ? 'Installed' : 'Not Installed'),
            'tokenizer' => (in_array('tokenizer', get_loaded_extensions()) ? 'Installed' : 'Not Installed'),
            'zip' => (in_array('zip', get_loaded_extensions()) ? 'Installed' : 'Not Installed'),
            'userAgentString' => isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT'] : 'phpunit',
            'socialHeaderIconsUserId' => Settings::socialHeaderIconsUserId(),
        ];

        return view('backend.settings.index', compact('data'));
    }

    /**
     * Store the site configuration options. This is currently accomplished
     * by finding the specific option, deleting it, and then inserting
     * the new option.
     *
     * @param SettingsUpdateRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function store(SettingsUpdateRequest $request)
    {
        Settings::updateOrCreate(['setting_name' => 'blog_title'], ['setting_value' => $request->toArray()['blog_title']]);
        Settings::updateOrCreate(['setting_name' => 'blog_subtitle'], ['setting_value' => $request->toArray()['blog_subtitle']]);
        Settings::updateOrCreate(['setting_name' => 'blog_description'], ['setting_value' => $request->toArray()['blog_description']]);
        Settings::updateOrCreate(['setting_name' => 'blog_seo'], ['setting_value' => $request->toArray()['blog_seo']]);
        Settings::updateOrCreate(['setting_name' => 'blog_author'], ['setting_value' => $request->toArray()['blog_author']]);
        Settings::updateOrCreate(['setting_name' => 'disqus_name'], ['setting_value' => $request->toArray()['disqus_name']]);
        Settings::updateOrCreate(['setting_name' => 'ga_id'], ['setting_value' => $request->toArray()['ga_id']]);
        Settings::updateOrCreate(['setting_name' => 'twitter_card_type'], ['setting_value' => $request->toArray()['twitter_card_type']]);
        Settings::updateOrCreate(['setting_name' => 'custom_css'], ['setting_value' => $request->toArray()['custom_css']]);
        Settings::updateOrCreate(['setting_name' => 'custom_js'], ['setting_value' => $request->toArray()['custom_js']]);
        Settings::updateOrCreate(['setting_name' => 'social_header_icons_user_id'], ['setting_value' => $request->toArray()['social_header_icons_user_id']]);
        Settings::updateOrCreate(['setting_name' => 'ad1'], ['setting_value' => $request->toArray()['ad1']]);
        Settings::updateOrCreate(['setting_name' => 'ad2'], ['setting_value' => $request->toArray()['ad2']]);

        $request->session()->put('_update-settings', 'Success! The blog settings have been saved.');

        // Update theme
        $this->themeManager->setActiveTheme($request->theme);

        return redirect()->route('admin.settings');
    }
}
