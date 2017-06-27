<?php

declare(strict_types = 1);

namespace Telegram\Storage;

class MySQLStorageHandler implements Interfaces\ITelegramStorageHandler {

    private $_connection        = NULL;

    protected static $_Table      = NULL;
    protected static $_User       = NULL;
    protected static $_Password   = NULL;

    public function __construct() {

    }

    public function connect() {
        if ($this->_connection === NULL) {
            if (!class_exists('PDO') || !in_array('mysql', \PDO::getAvailableDrivers(), TRUE)) {
                // @codeCoverageIgnoreStart
                throw new \RuntimeException('You need to enable the PDO_Mysql extension for Phinx to run properly.');
                // @codeCoverageIgnoreEnd
            }

            $db = NULL;
            $options = $this->getOptions();

            $dsn = 'mysql:';

            if (!empty($options['unix_socket'])) {
                // use socket connection
                $dsn .= 'unix_socket=' . $options['unix_socket'];
            } else {
                // use network connection
                $dsn .= 'host=' . $options['host'];
                if (!empty($options['port'])) {
                    $dsn .= ';port=' . $options['port'];
                }
            }

            $dsn .= ';dbname=' . $options['name'];

            // charset support
            if (!empty($options['charset'])) {
                $dsn .= ';charset=' . $options['charset'];
            }

            $driverOptions = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

            try {
                $db = new \PDO($dsn, static::$_User, static::$_Password, $driverOptions);
            } catch (\PDOException $exception) {
                throw new \InvalidArgumentException(sprintf(
                    'There was a problem connecting to the database: %s',
                    $exception->getMessage()
                ));
            }

            $this->setConnection($db);
        }
    }

    public function setConnection(\PDO $db) {
        $this->_connection = $db;
    }
}
