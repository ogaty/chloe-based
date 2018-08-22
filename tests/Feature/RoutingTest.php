<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \App\Models\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->call('GET', route('admin.home'));
        $response->assertStatus(200);
        $response = $this->actingAs($user)->call('GET', route('admin.post.index'));
        $response->assertStatus(200);
        $response = $this->actingAs($user)->call('GET', route('admin.tag.index'));
        $response->assertStatus(200);
        $response = $this->actingAs($user)->call('GET', route('admin.setting.index'));
        $response->assertStatus(200);
        $response = $this->actingAs($user)->call('GET', route('admin.user.index'));
        $response->assertStatus(200);
        $response = $this->actingAs($user)->call('GET', route('admin.upload'));
        $response->assertStatus(200);
    }
}
