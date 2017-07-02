<?php

declare(strict_types = 1);

namespace Telegram\Storage\PDO\Abstracts;

use Telegram\Storage\PDO\UserCredentials;

abstract class APDOBase {

    protected $_connectionDetails = NULL;
    protected $_userCredentials = NULL;
    protected $_connection = NULL;
    protected $_options = [];

    public function __construct(AConnectionDetails $connectionDetails, UserCredentials $userCredentials) {
        $this->_connectionDetails = $connectionDetails;
        $this->_userCredentials = $userCredentials;
    }

    public function connect() {
        if ($this->_connection === NULL) {
            $dsn = $this->_getDsn();
            try {
                $this->_connection = new \PDO($dsn, $this->_userCredentials->getUsername(), $this->_userCredentials->getPassword(), array_merge($this->_options, $this->getPDODriverOptions()));
            } catch (\PDOException $exception) {
                throw new \InvalidArgumentException(sprintf(
                    'There was a problem connecting to the database: %s',
                    $exception->getMessage()
                ));
            }
        }
        return $this->_connection;
    }

    public function disconnect() {
        $this->_connection = NULL;
    }

    public function setOption(string $option, string $value) {
        $this->_options[$option] = $value;
    }

    public function setConnectionDetails(ConnectionDetails $connectionDetails) {
        $this->_connectionDetails = $connectionDetails;
    }

    public function setUserCredentials(UserCredentials $userCredentials) {
        $this->_userCredentials = $userCredentials;
    }

    public function setOptions(array $options) {
        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }
    }

    public function getPDODriverOptions() : array {
        return [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];
    }

    protected function _getDsn() : string {
        $dsn = $this->_getURI();
        if (strpos($dsn, ':') === FALSE) {
            $dsn .= ':';
        }
        $dsn .= $this->_connectionDetails->getConnectionDetailsAsDsnPart();

        return $dsn;
    }

    abstract protected function _getURI() : string;
}
