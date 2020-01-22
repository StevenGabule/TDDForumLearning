<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_may_not_create_threads(): void
    {
        $this->withExceptionHandling();
        $this->get('/threads/create')->assertRedirect('/login');
        $this->post('/threads')->assertRedirect('/login');
    }


    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads(): void
    {
        $this->signIn();
        $thread = make(Thread::class);
        $response = $this->post('/threads', $thread->toArray());
        $this->get($response->headers->get('Location'))->assertSee($thread->title)->assertSee($thread->body);
    }
    /** @test */
    public function a_thread_requires_a_title() : void
    {
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');
        /*$this->withExceptionHandling()->signIn();
        $thread = make(Thread::class, ['title' => null]);
        $this->post('/threads', $thread->toArray())->assertSessionHasErrors('title');*/
    }

    /** @test */
    public function a_thread_requires_a_body() : void
    {
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel() : void
    {
        factory(Channel::class,2)->create();
        $this->publishThread(['channel_id' => null])->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id' => 999])->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make(Thread::class, $overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
