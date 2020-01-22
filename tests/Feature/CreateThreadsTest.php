<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_may_not_create_threads() : void {
        $this->withExceptionHandling();
        $this->get('/threads/create')->assertRedirect('/login');
        $this->post('/threads')->assertRedirect('/login');
    }


    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads() : void
    {
        $this->signIn();
        $thread = create(Thread::class);
        $this->post('/threads', $thread->toArray());
        $this->get($thread->path())->assertSee($thread->title)->assertSee($thread->body);
    }
}
