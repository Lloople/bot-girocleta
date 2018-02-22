<?php


namespace Tests\Unit;


use App\Services\UserService;
use BotMan\BotMan\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{

    use RefreshDatabase;
    
    /** @test */
    public function can_create_user_from_telegram_id()
    {
        $botmanUser = new User('randomid', 'Han', 'Solo', 'hansolo');
        
        $service = new UserService();
        
        $user = $service->findOrCreate($botmanUser);
        
        $this->assertDatabaseHas('users', [
            'name' => 'Han',
            'surname' => 'Solo',
            'email' => 'randomid@bot-girocleta.com',
            'telegram_id' => 'randomid',
            'username' => 'hansolo',
        ]);
        
        $this->assertNotNull($user->created_at);
    }
}