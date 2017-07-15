<?php

declare(strict_types = 1);

namespace Telegram\Storage\PDO;

class UserCredentials {

    /**
     * @var string
     */
    private $_username = NULL;

    /**
     * @var string
     */
    private $_password = NULL;

    /**
     * UserCredentials constructor.
     * @param string $username
     * @param string|NULL $password
     */
    public function __construct(string $username, string $password = NULL) {
        $this->_username = $username;
        $this->_password = $password;
    }

    /**
     * Get the username
     * @return string
     */
    public function getUsername() : string {
        return $this->_username;
    }

    /**
     * Get the password
     * @return NULL|string
     */
    public function getPassword() {
        return $this->_password;
    }

}
