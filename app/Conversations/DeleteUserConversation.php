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
        $question = Question::create('⚠️ Estàs segur que vols esborrar tota la teva informació relacionada amb el Bot de la Girocleta? Aquesta acció no es pot desfer ⚠️')
                ->addButtons([
                    Button::create('Si')->value('si'),
                    Button::create('No')->value('no'),
                ]);

        $this->ask($question, function (Answer $answer) {

            $answerValue = $answer->isInteractiveMessageReply() ? $answer->getValue() : $answer->getText();

            if (strtolower($answerValue) == 'si') {

                auth()->user()->delete();

                $this->say("He esborrat tota la teva informació, espero tornar-te a veure aviat! 👋");
            } else {
                $this->say("Veig que t'ho has repensat, podem continuar sent amics! 👍");
            }
        });
    }

}
