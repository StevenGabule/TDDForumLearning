<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Auth\AuthenticationException;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->expectException(AuthenticationException::class);
        $this->post('/threads/1/replies', []);

    }

    /** @test*/
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = create(User::class));
        $thread = create(Thread::class);

        // when the user adds a reply to the thread
        $reply = make(Reply::class);
        $this->post($thread->path() . '/replies', $reply->toArray());

        // then their reply should be visible on the page
        $this->get($thread->path())->assertSee($reply->body);
    }
}