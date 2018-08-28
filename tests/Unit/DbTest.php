<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \App\Models\User;
use \App\Models\Settings;
use \App\Models\Themes;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $user = User::find(1);
        $this->assertNotNull($user);
        $settings = Settings::find(1);
        $this->assertNotNull($settings);
        $title = Settings::blogTitle();
        $this->assertEquals('', $title);
        $themes = Themes::find(1);
        $this->assertNotNull($themes);
    }
}
