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
        if (isset($this->_message->text)) {
            $text = $this->_message->text;
            if ($this->isCommand($text)) {
                $command = $this->getCommandName($text);
                $commandHandler = $this->_getCorrectCommandHandler($command);
                if ($commandHandler) {
                    if ($this->hasLogger()) {
                        $commandHandler->setLogger($this->getLogger());
                    }
                    $commandHandler->handleCommand($command);
                } else {
                    $this->handleUnknownCommand($command);
                }
            } else {
                $this->handleText($text);
            }
        }
    }

    /* Override for text handling!*/
    public function handleText(string $text) {

    }

    /* Override for handling unknown commands */
    public function handleUnknownCommand(string $command) {

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
        foreach ($this->_commandHandlers as $handler) {
            if (in_array($command, $handler::GetRespondsTo(), TRUE)) {
                return new $handler($this->_update, $this->_bot);
            }
        }
        $this->logInfo('Could not find a commandHandler for command: ' . $command, $this->getLoggerContext());
    }
}
