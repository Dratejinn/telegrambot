<?php

declare(strict_types = 1);

namespace Telegram\Storage\PDO\ConnectionDetails;

use Telegram\Storage\PDO\Abstracts\AConnectionDetails;

class ConnectionDetailsMySQL extends AConnectionDetails {
    const MODE_UNIXSOCKET = 0x01;
    const MODE_NETWORKCONNECTION = 0x03;

    public function __construct() {
        $this->_mode = self::MODE_NETWORKCONNECTION;
        $this->_options['host'] = 'localhost';
        $this->_options['port'] = '3306';
    }

    public function setNetworkConnection(string $host, string $port) {
        $this->_options = [
            'host' => $host,
            'port' => $port
        ];
        $this->_mode = self::MODE_NETWORKCONNECTION;
    }

    public function setUnixSocketConnection(string $unixSocket) {
        $this->_options = [
            'unix_socket' => $unixSocket
        ];
        $this->_mode = self::MODE_UNIXSOCKET;
    }

}
