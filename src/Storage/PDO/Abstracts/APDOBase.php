<?php

declare(strict_types = 1);

namespace Telegram\Storage\PDO\Abstracts;

use Telegram\Storage\PDO\UserCredentials;

abstract class APDOBase {

    protected $_connectionDetails = NULL;
    protected $_userCredentials = NULL;
    protected $_connection = NULL;
    protected $_options = [];

    /**
     * APDOBase constructor.
     * @param \Telegram\Storage\PDO\Abstracts\AConnectionDetails $connectionDetails
     * @param \Telegram\Storage\PDO\UserCredentials $userCredentials
     */
    public function __construct(AConnectionDetails $connectionDetails, UserCredentials $userCredentials) {
        $this->_connectionDetails = $connectionDetails;
        $this->_userCredentials = $userCredentials;
    }

    /**
     * returns the a pdo connection when connecting is possible
     * @return \PDO
     * @throws \InvalidArgumentException thrown when connecting is not possible
     */
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

    /**
     * disconnects the pdo connection
     */
    public function disconnect() {
        $this->_connection = NULL;
    }

    /**
     * set a PDO option
     * @param string $option
     * @param string $value
     */
    public function setOption(string $option, string $value) {
        $this->_options[$option] = $value;
    }

    /**
     * Set the connectionDetails
     * @param \Telegram\Storage\PDO\Abstracts\AConnectionDetails $connectionDetails
     */
    public function setConnectionDetails(AConnectionDetails $connectionDetails) {
        $this->_connectionDetails = $connectionDetails;
    }

    /**
     * Set the user credentials
     * @param \Telegram\Storage\PDO\UserCredentials $userCredentials
     */
    public function setUserCredentials(UserCredentials $userCredentials) {
        $this->_userCredentials = $userCredentials;
    }

    /**
     * @see setOption
     * @param array $options
     */
    public function setOptions(array $options) {
        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }
    }

    /**
     * Get the pdo driver options
     * @return array
     */
    public function getPDODriverOptions() : array {
        return [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];
    }

    /**
     * Create the dsn from all provided information
     * @return string
     */
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
