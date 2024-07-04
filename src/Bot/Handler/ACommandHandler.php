<?php

declare(strict_types = 1);

namespace Telegram\Bot\Handler;

abstract class ACommandHandler extends \Telegram\Bot\AHandler {

    /**
     * @throws \Exception This method should never be invoked as CommandHandlers are called from a MessageHandler
     */
    final public function handle() {
        throw new \Exception('This method should not be invoked!');
    }

    /**
     * Get the argument array from the fired command
     * @return array
     */
    public function getArguments() : array {
        return explode(' ', $this->_message->text);
    }

    /**
     * Extending class must implement this method to respond to commands
     * @param string $command
     * @return mixed
     */
    abstract public function handleCommand(string $command);

    /**
     * Extending class must implement this to define wich commands it responds to
     * @return string[]
     */
    abstract public static function GetRespondsTo() : array;

    /**
     * Returns TRUE when the command should be published through SetBotCommands
     *
     * @param string $command
     * @return bool
     */
    public static function ShouldPublishCommand(string $command) : bool {
        return FALSE;
    }

    /**
     * Called when a command from GetRespondsTo results in TRUE From ShouldPublishCommand.
     *
     * @param string $command
     * @return string
     */
    public static function GetDescriptionForCommand(string $command) : string {
        throw new \LogicException('CommandHandler returned ShouldPublish for Command but does not extend the method: ' . __METHOD__);
    }
}
