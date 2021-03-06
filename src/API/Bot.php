<?php

declare(strict_types = 1);

namespace Telegram\API;

use Monolog\Logger;
use Telegram\API\Method\GetMe;
use Telegram\API\Type\User;
use Telegram\LogHelpers;

class Bot implements LogHelpers\Interfaces\ILoggerAwareInterface {

    use LogHelpers\Traits\TLoggerTrait;

    /**
     * The token used to identify the bot
     * @var string
     */
    private $_token = NULL;

    /**
     * object to identify this bot
     * @var null|\Telegram\API\Type\User
     */
    private $_me = NULL;

    /**
     * maximum timeout after an exception
     * @var int
     */
    protected static $_ConnectionRetryTimeout = 120;

    /**
     * Bot constructor.
     * @param string|NULL $token
     * @param \Monolog\Logger $logger
     * @param bool $retrieveMe
     */
    public function __construct(string $token = NULL, Logger $logger = NULL, bool $retrieveMe = TRUE) {
        if ($token !== NULL) {
            $this->_token = $token;
        }

        if ($logger) {
            $this->setLogger($logger);
        }

        if ($retrieveMe) {
            $this->_retrieveMe();
        }
    }

    /**
     * @param string $token
     */
    public function setToken(string $token) {
        $this->_token = $token;
    }

    /**
     * @return string
     */
    public function getToken() : string {
        return $this->_token;
    }

    /**
     * call the Telegram api using this bot
     * @param string $method
     * @param \Telegram\API\Base\Abstracts\ABaseObject $payload
     * @return \stdClass
     */
    public function call(string $method, Base\Abstracts\ABaseObject $payload) {
        $this->logDebug('Calling method: ' . $method, $this->getLoggerContext());
        return API::CallMethod($method, $this, $payload);
    }

    /**
     * @return \Telegram\API\Type\User
     */
    public function getMe() : User {
        if ($this->_me === NULL) {
            $this->_retrieveMe();
        }
        return $this->_me;
    }

    /**
     * Returns the username of this bot
     * @return string
     */
    public function getUsername() : string {
        if (isset($this->_me)) {
            return $this->_me->getUsername();
        } else {
            return '';
        }
    }

    /**
     * Gets the logger context for this bot
     * @return array
     */
    public function getLoggerContext() : array {
        $username = $this->getUsername();
        if (empty($username)) {
            $username = 'UNKNOWN-BOT';
        }
        return ['botname' => $username];
    }

    /**
     * method to override the default connectionRetryTimeout
     * @param int $timeoutinSeconds
     */
    public static function SetConnectionRetryTimeout(int $timeoutinSeconds) {
        static::$_ConnectionRetryTimeout = $timeoutinSeconds;
    }

    /**
     * Method used to retrieve the userobject of the bot.
     *
     * @return \Telegram\API\Type\User
     */
    private function _retrieveMe() : User {
        $getMe = new GetMe;
        do {
            $this->_me = $getMe->call($this);
            if (!$this->_me instanceof User) {
                $this->logAlert("'Me' is not an instance of User! Telegram api might be down... retrying in " . static::$_ConnectionRetryTimeout . ' seconds...');
                sleep(static::$_ConnectionRetryTimeout);
            }
        } while (!$this->_me instanceof User);
        return $this->_me;
    }
}
