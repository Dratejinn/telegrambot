<?php

declare(strict_types = 1);

namespace Telegram\Storage\PDO\Abstracts;

abstract class AConnectionDetails {

    protected $_options = [];

    /**
     * Get connection details as a dsn part.
     * @return string
     */
    public function getConnectionDetailsAsDsnPart() : string {

        $connectionDetails = '';
        foreach ($this->_options as $key => $value) {
            $connectionDetails .= $key . '=' . $value . ';';
        }
        return $connectionDetails;
    }

}
