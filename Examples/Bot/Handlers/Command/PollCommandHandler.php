<?php

declare(strict_types = 1);

namespace Examples\Bot\Handlers\Command;

use Telegram\API\Method\SendPoll;
use Telegram\API\Method\StopPoll;
use Telegram\API\Type\PollOption;
use Telegram\Bot\Handler\ACommandHandler;

class PollCommandHandler extends ACommandHandler {

    /** @var null|\Telegram\API\Type\Message */
    private static $_StartedPoll = NULL;

    public function handleCommand(string $command) {
        switch ($command) {
            case 'startPoll':
                $this->_startPoll();
                break;
            case 'stopPoll':
                if (self::$_StartedPoll !== NULL) {
                    $this->_stopPoll();
                }
        }
    }

    public static function GetRespondsTo() : array {
        return [
            'startPoll',
            'stopPoll'
        ];
    }

    private function _startPoll() {
        $sendPoll = new SendPoll;

        $sendPoll->question = 'Which pill will you take';
        $sendPoll->options = [
            'Red pill',
            'Blue pill'
        ];

        $sendPoll->chatId = $this->_message->chat->id;


        $answer = $sendPoll->call($this->_apiBot);
        var_dump($answer);
        self::$_StartedPoll = $answer;
    }

    private function _stopPoll() {
        $stopPoll = new StopPoll;

        $stopPoll->chatId = self::$_StartedPoll->chat->id;
        $stopPoll->messageId = self::$_StartedPoll->id;

        $response = $stopPoll->call($this->_apiBot);
        var_dump($response);
    }


}
