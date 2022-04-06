<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Thumbnail;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_create_post()
    {
        $user = User::where('email', 'utest@gmail.com')->first();

        $thumbnail = Thumbnail::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->json('POST', '/api/posts', [
            'title' => 'First Post',
            'content' => 'Really long content dddddddddddddddddddddddddddddddd',
            'tags' => 'test,home,nothing',
            'thumbnail_id' => $thumbnail->id
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['post_id']);
    }

    public function test_edit_post()
    {
        $user = User::where('email', 'utest@gmail.com')->first();

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->json('PATCH', '/api/posts/' . $post->id, [
            'title' => 'Edited Post',
        ]);

        $response->assertStatus(200)
            ->assertJson(['post_id' => $post->id]);
    }

    public function test_delete_post()
    {
        $user = User::where('email', 'respinoza@gmail.com')->first();

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->json('DELETE', '/api/posts/' . $post->id);

        $response->assertStatus(200)->assertJson(['deleted' => true]);
    }

    public function test_delete_post_failed()
    {
        $user = User::where('email', 'utest@gmail.com')->first();

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->json('DELETE', '/api/posts/' . $post->id);

        $response->assertStatus(403);
    }

    public function test_view_post()
    {
        $user = User::where('email', 'utest@gmail.com')->first();

        $post = Post::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->json('GET', '/api/posts/' . $post->id);

        $response->assertStatus(200);
    }

    public function test_list_posts()
    {
        $user = User::where('email', 'utest@gmail.com')->first();

        $post = Post::factory()->count(15)->create();

        $response = $this->actingAs($user, 'sanctum')->json('GET', '/api/posts');

        $response->assertStatus(200);
    }
}
