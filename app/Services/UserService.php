<?php

namespace App\Services;

use App\Models\User;
use BotMan\BotMan\Interfaces\UserInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{

    /**
     * Find the user associated with that Telegram account or creates one.
     *
     * @param \BotMan\BotMan\Interfaces\UserInterface $botUser
     *
     * @return mixed
     */
    public function findOrCreate(UserInterface $botUser)
    {
        return User::firstOrCreate(
            [
                'telegram_id' => $botUser->getId()
            ],
            [
                'name' => $botUser->getFirstName(),
                'surname' => $botUser->getLastName(),
                'username' => $botUser->getUsername(),
                'email' => $botUser->getId().'@bot-girocleta.com',
                'password' => Hash::make($botUser->getUsername().'-girocleta')
            ]
        );
    }
}