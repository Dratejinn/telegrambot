<?php

declare(strict_types = 1);

namespace Telegram\Storage\PDO\Abstracts;

abstract class AConnectionDetails {
    const MODE_UNIXSOCKET = 0x01;
    const MODE_NETWORKCONNECTION = 0x03;

    protected $_mode = NULL;
    protected $_options = [];

    public function getMode() : int {
        return $this->_mode;
    }

    public function getConnectionDetailsAsDsnPart() : string {

        $connectionDetails = '';
        foreach ($this->_options as $key => $value) {
            $connectionDetails .= $key . '=' . $value . ';';
        }
        return $connectionDetails;
    }

}
