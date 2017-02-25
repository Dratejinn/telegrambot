<?php

declare(strict_types = 1);

namespace Telegram\Bot\Handler;

use Telegram\API;
use Telegram\Bot\ABot;
use Telegram\API\Method\SendMessage;

abstract class AMessageHandler extends \Telegram\Bot\AHandler {

    protected $_commandHandlers = [];

    protected $_message = NULL;

    public function __construct(API\Type\Update $update, ABot $bot) {
        parent::__construct($update, $bot);
        $this->_message = $update->message;
    }

    public function handle() {
        echo 'Going to handle Message!' . PHP_EOL;
        if (isset($this->_message->text)) {
            $text = $this->_message->text;
            if ($this->isCommand($text)) {
                $command = $this->getCommandName($text);
                $commandHandler = $this->_getCorrectCommandHandler($command);
                if ($commandHandler) {
                    $commandHandler->handleCommand($command);
                } else {
                    $this->sendTextMessage('I dont know how to respond to that command!');
                }
            } else {
                $this->handleText($text);
            }
        }
    }

    /* Override for text handling!*/
    public function handleText(string $text) {

    }

    public function addCommandHandler(string $handler) {
        if (class_exists($handler) && is_a($handler, ACommandHelper::class, TRUE)) {
            $this->_commandHandlers[] = $handler;
        }
    }

    public function isCommand(string $text) : bool {
        if (substr($text, 0, 1) === '/') {
            return TRUE;
        }
        return FALSE;
    }

    public function getCommandName(string $text) : string {
        list($command) = explode(' ', $text);
        $pos = strpos($command, '@');
        if ($pos === FALSE) {
            $command = substr($command, 1);
        } else {
            $command = substr($command, 1, ($pos - 1));
        }
        return $command;
    }

    /**
     * @todo implement multi handlers for one command!
     */
    private function _getCorrectCommandHandler(string $command) {
        echo 'Going to try to find a correct command handler!' . PHP_EOL;
        foreach ($this->_commandHandlers as $handler) {
            if (in_array($command, $handler::GetRespondsTo(), TRUE)) {
                return new $handler($this->_update, $this->_bot);
            }
        }
    }
}
