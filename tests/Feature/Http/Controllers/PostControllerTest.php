<?php

namespace Tests\Feature;

use Exception;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_create_post(): void
    {
        $user = User::factory()->create();
        Auth::login($user);
        $response = $this->postJson('/api/post', [
            'author_id' => $user->id,
            'title' => 'Special story',
            'link' => 'http://foobar.com'
        ]);
        $this->assertDatabaseHas(
            'posts',
            [
                'title' => 'Special story',
                'link' => 'http://foobar.com'
            ]
        );
        $this->assertDatabaseCount('posts', 1);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_can_delete_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()
                ->for($user, 'author')
                ->create();
        Auth::login($user);
        $response = $this->deleteJson('/api/post/delete', [
            'post_id' => $post->id
        ]);
        $this->assertDatabaseMissing(
            'posts',
            [
                'id' => $post->id,
                'title' => $post->title
            ]
        );
        $this->assertDatabaseCount('posts', 0);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_can_update_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()
                ->for($user, 'author')
                ->create();
        Auth::login($user);
        $response = $this->putJson('/api/post/update', [
            'post_id' => $post->id,
            'title' => 'im an edited post'
        ]);
        $this->assertDatabaseHas(
            'posts',
            [
                'id' => $post->id,
                'title' => $post->title
            ]
        );
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cannot_delete_if_not_post_owner(): void
    {
        $owner = User::factory()->create();
        $post = Post::factory()
                ->for($owner, 'author')
                ->create();
        $response = $this->deleteJson('/api/post/delete', [
            'post_id' => $post->id
        ]);
        $this->assertDatabaseHas('posts',
            [
                'id' => $post->id,
                'title'=> $post->title
            ]
            );
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
