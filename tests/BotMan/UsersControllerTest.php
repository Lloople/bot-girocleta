<?php

namespace Tests\BotMan;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_create_a_user_in_every_chat_request()
    {
        $this->assertEquals(0, User::count());

        $this->bot->receives('not captured string');

        $this->assertEquals(1, User::count());
    }

    /** @test */
    public function can_delete_user()
    {
        $this->bot->receives('/delete')
            ->receivesInteractiveMessage('si');

        $this->assertEquals(0, User::count());
    }

}
