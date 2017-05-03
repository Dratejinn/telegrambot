<?php

declare(strict_types = 1);

namespace Telegram\API;

use Telegram\API\Method\GetMe;
use Telegram\API\Type\User;
use Monolog\Logger;

class Bot {

    /**
     * The token used to identify the bot
     * @var string
     */
    private $_token = NULL;
    private $_me = NULL;

    public function __construct(string $token = NULL) {
        if ($token !== NULL) {
            $this->_token = $token;
        }
        $getMe = new GetMe;
        $this->_me = $getMe->call($this);
    }

    public function setToken(string $token) {
        $this->_token = $token;
    }

    public function getToken() : string {
        return $this->_token;
    }

    public function call(string $method, Base\Abstracts\ABaseObject $payload) {
        $this->getLogger()->debug('Calling method: ' . $method, $this->getLoggerContext());
        return API::CallMethod($method, $this, $payload);
    }

    public function getMe() : User {
        return $this->_me;
    }

    public function getUsername() : string {
        if (isset($this->_me)) {
            return $this->_me->getUsername();
        } else {
            return '';
        }
    }

    public function getLogger() : Logger {
        return API::GetLogger('BOT');
    }

    public function getLoggerContext() : array {
        $username = $this->getUsername();
        if (empty($username)) {
            $username = 'UNKNOWN-BOT';
        }
        return ['botname' => $username];
    }

}
