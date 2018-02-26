<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class DeleteUserConversation extends Conversation
{

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        // TODO: we need inline buttons here. choose one of this
        // 1) send it as raw data somehow
        // 2) extends TelegramDriver and Question to add some multiline buttons flag
        // 3) do it in a way to make a PR to botman/driver-telegram
        $question = Question::create('⚠️ Estàs segur que vols esborrar tota la teva informació relacionada amb el Bot de la Girocleta? Aquesta acció no es pot desfer ⚠️')
                ->addButtons([
                    Button::create('Si')->value('si'),
                    Button::create('No')->value('no'),
                ]);

        $this->ask($question, function (Answer $answer) {

            $answerValue = $answer->isInteractiveMessageReply() ? $answer->getValue() : $answer->getText();

            if (strtolower($answerValue) == 'si') {
                $this->say("Molt bé, borraré tota la teva informació 😞");
            } else {
                $this->say("Veig que t'ho has repensat, així m'agrada! 👍");
            }
        });
    }

}
