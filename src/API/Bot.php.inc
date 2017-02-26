<?php

declare(strict_types = 1);

namespace Telegram\API;

class Bot {

    /**
     * The token used to identify the bot
     * @var string
     */
    private $_token = NULL;

    public function __construct(string $token = NULL) {
        if ($token !== NULL) {
            $this->_token = $token;
        }
    }

    public function setToken(string $token) {
        $this->_token = $token;
    }

    public function getToken() : string {
        return $this->_token;
    }

    public function call(string $method, Base\Abstracts\ABaseObject $payload) {
        return API::CallMethod($method, $this, $payload);
    }
}
