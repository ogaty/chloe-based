<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use \App\Models\User;

class RoutingTest extends TestCase
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
        $response = $this->get('/', ['tag' => 'testing']);
        $response->assertStatus(200);
        $response = $this->get('/tag/testing');
        $response->assertStatus(200);
        $response = $this->get('/search/testing');
        $response->assertStatus(200);


        $user = User::first();
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
        $response = $this->actingAs($user)->call('GET', route('admin.tag.create'));
        $response->assertStatus(200);
        $response = $this->actingAs($user)->call('POST', route('admin.tag.store'), [
                'name' => 'testingTag',
                'slug' => 'testingTag',
                'description' => 'testing',
                'meta_description' => 'testing',
        ]);
        $response->assertStatus(302);
        $response->assertSessionMissing('errors');
        $response = $this->actingAs($user)->call('GET', route('admin.post.create'));
        $response->assertStatus(200);
        $response = $this->actingAs($user)->call('POST', route('admin.post.store', [1]), [
                'user_id' => 1,
                'title' => 'testingTitle',
                'slug' => 'testing',
                'description_raw' => 'testing',
                'description_html' => 'testing',
                'content_raw' => 'testing',
                'content_html' => 'testing',
                'page_image' => 'testing_image',
                'meta_description' => 'meta',
                'published_at' => '2018-01-01 10:00:00'
        ]);
        $response->assertStatus(302);
        $response->assertSessionMissing('errors');

        $response = $this->actingAs($user)->call('GET', route('admin.user.create'));
        $response->assertStatus(200);
        $response = $this->actingAs($user)->call('POST', route('admin.user.store'), [
                'email' => 'testing@example.com',
                'first_name' => 'testing',
                'last_name' => 'testing',
                'display_name' => 'testing',
                'role' => '0',
                'password' => 'testing',
        ]);
        $response->assertStatus(302);
        $response->assertSessionMissing('errors');

        $response = $this->get('/post/testing');
        $response->assertSee('testingTitle');
//        $response = $this->get('/tag/testingTag');
//        $response->assertSee('testingTag');
        $response = $this->get('/post/testing');
        $response->assertStatus(200);
    }
}
