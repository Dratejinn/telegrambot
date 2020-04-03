<?php

declare(strict_types = 1);

namespace Telegram\Bot\Handler;

use Telegram\API\Type\Message;

abstract class AMessageHandler extends \Telegram\Bot\AHandler {

    /**
     * @var \Telegram\Bot\Handler\ACommandHandler[]
     */
    protected $_commandHandlers = [];

    /**
     * @inheritdoc
     */
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
        } else {
            $this->handleMessage($this->_message);
        }
    }

    /**
     * Extending classes should implement this method if they wish to respond to Text messages
     * @param string $text
     */
    public function handleText(string $text) {

    }

    /**
     * Extending classes should implement this method if they wish to respond to unknown commands
     * @param string $command
     */
    public function handleUnknownCommand(string $command) {

    }

    /**
     * Used to handle the message
     *
     * @param \Telegram\API\Type\Message $message
     */
    public function handleMessage(Message $message) {
    }

    /**
     * Used to add a command handler
     * @param string $handler
     */
    public function addCommandHandler(string $handler) {
        if (class_exists($handler) && is_a($handler, ACommandHandler::class, TRUE)) {
            $this->_commandHandlers[] = $handler;
        }
    }

    /**
     * Used to check wether the text is a command
     * @param string $text
     * @return bool
     */
    public function isCommand(string $text) : bool {
        if (substr($text, 0, 1) === '/') {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Used to get the command name from text
     * @param string $text
     * @return string
     */
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
     * Returns the current set of CommandHandlers
     *
     * @return \Telegram\Bot\Handler\ACommandHandler[]
     */
    public function getCommandHandlers() : array {
        return $this->_commandHandlers;
    }

    /**
     * Returns the commandHandler responsible for handling $command
     * @param string $command
     * @return null|\Telegram\Bot\Handler\ACommandHandler
     */
    private function _getCorrectCommandHandler(string $command) {
        foreach ($this->_commandHandlers as $handler) {
            if (in_array($command, $handler::GetRespondsTo(), TRUE)) {
                return new $handler($this->_update, $this->_bot);
            }
        }
        $this->logInfo('Could not find a commandHandler for command: ' . $command, $this->getLoggerContext());
        return NULL;
    }
}
