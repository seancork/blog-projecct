<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{

    use RefreshDatabase;

    protected $user;
    protected $post;
    protected $routeStore = 'dashboard.posts.store';
    protected $routeCreate = 'dashboard.posts.create';

    protected function setUp() : void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->posts = Post::factory()->count(8)->for($this->user)->create();
    }

    public function test_authenticated_user_can_only_add_new_post()
    {
        $post['title'] = "This is a test";
        $post['description'] = "Test description";
        $this->actingAs($this->user)
            ->from(route($this->routeCreate))
            ->post(route($this->routeStore),$post)
            ->assertStatus(302)
            ->assertSessionHasNoErrors();

        $this->assertEquals(9,Post::all()->count());
    }

    public function test_non_authenticated_user_cant_post()
    {
        $post['title'] = "This is a test";
        $post['description'] = "Test description";
        $this->from(route($this->routeCreate))
            ->post(route($this->routeStore),$post)
            ->assertStatus(302)
            ->assertSessionHasNoErrors();

        $this->assertEquals(8,Post::all()->count());
    }

    public function test_simple_post_validation()
    {
        $post['description'] = "Hi";
        $this->actingAs($this->user)
            ->from(route($this->routeCreate))
            ->post(route($this->routeStore),$post)
            ->assertStatus(302)
            ->assertSessionHasErrors(['title' => 'The title field is required.','description' => 'The description must be at least 5 characters.']);
    }
}
