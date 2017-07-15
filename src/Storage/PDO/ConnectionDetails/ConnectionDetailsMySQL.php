<?php

declare(strict_types = 1);

namespace Telegram\Storage\PDO\ConnectionDetails;

use Telegram\Storage\PDO\Abstracts\AConnectionDetails;

class ConnectionDetailsMySQL extends AConnectionDetails {
    const MODE_UNIXSOCKET = 0x01;
    const MODE_NETWORKCONNECTION = 0x03;

    /**
     * @var int
     */
    private $_mode = NULL;

    /**
     * ConnectionDetailsMySQL constructor.
     */
    public function __construct() {
        $this->_mode = self::MODE_NETWORKCONNECTION;
        $this->_options['host'] = 'localhost';
        $this->_options['port'] = '3306';
    }

    /**
     * Sets the ConnectionMode to network
     * @param string $host
     * @param string $port
     */
    public function setNetworkConnection(string $host, string $port) {
        $this->_options = [
            'host' => $host,
            'port' => $port
        ];
        $this->_mode = self::MODE_NETWORKCONNECTION;
    }

    /**
     * Sets the connectionMode to a unix socket
     * @param string $unixSocket
     */
    public function setUnixSocketConnection(string $unixSocket) {
        $this->_options = [
            'unix_socket' => $unixSocket
        ];
        $this->_mode = self::MODE_UNIXSOCKET;
    }

    /**
     * Get the current connection mode
     * @return int
     */
    public function getMode() : int {
        return $this->_mode;
    }

}
