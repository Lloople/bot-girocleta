<?php

namespace App\Drivers;

use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Telegram\TelegramDriver as BotManTelegramDriver;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class TelegramDriver extends BotManTelegramDriver
{

    /**
     * Expand Telegram Driver behaviour to allow external link buttons on messages
     *
     * @param string|Question|OutgoingMessage $message
     * @param \BotMan\BotMan\Messages\Incoming\IncomingMessage $matchingMessage
     * @param array $additionalParameters
     * @return Response
     */
    public function buildServicePayload($message, $matchingMessage, $additionalParameters = [])
    {
        $parameters = parent::buildServicePayload($message, $matchingMessage, $additionalParameters);

        if (method_exists($message, 'getActions') && count($message->getActions())) {
            $parameters['reply_markup'] = json_encode([
                'inline_keyboard' => $this->convertLinks($message->getActions()),
            ], true);
        }

        return $parameters;

    }

    private function convertLinks(array $actions)
    {
        return Collection::make($actions)->map(function ($action) {
            return [$action];
        })->toArray();
    }
}