<?php

declare(strict_types = 1);

namespace Telegram\Storage\PDO;

class UserCredentials {

    private $_username = NULL;
    private $_password = NULL;

    public function __construct(string $username, string $password = NULL) {
        $this->_username = $username;
        $this->_password = $password;
    }

    public function getUsername() : string {
        return $this->_username;
    }

    public function getPassword() {
        return $this->_password;
    }

}
