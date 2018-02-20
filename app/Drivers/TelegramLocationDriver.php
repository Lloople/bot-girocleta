<?php

namespace App\Drivers;

use BotMan\Drivers\Telegram\TelegramLocationDriver as BotManTelegramLocationDriver;

class TelegramLocationDriver extends BotManTelegramLocationDriver
{

    use BuildServicePayloadWithLinksTrait;

}