<?php

declare(strict_types = 1);

namespace Telegram\Storage\PDO;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\Storage\Interfaces\ITelegramStorageHandler;
use Telegram\Storage\PDO\Abstracts\{AConnectionDetails};
use Telegram\Storage\PDO\UserCredentials;
use Telegram\Storage\Migrations\TelegramAdapter;

class MySQLHandler extends Abstracts\APDOBase implements ITelegramStorageHandler {

    protected static $_DefaultDatabase = NULL;

    protected $_database = NULL;

    protected $_charSet = 'utf8';

    private $_columnStatement = NULL;
    private $_hasTableStatement = NULL;

    public function __construct(AConnectionDetails $connectionDetails, UserCredentials $userCredentials, string $Database = NULL) {
        $this->_connectionDetails = $connectionDetails;
        $this->_userCredentials = $userCredentials;

        $this->_database = $Database;
    }

    public function setDatabase(string $Database) {
        $this->_database = $Database;
    }

    public function disconnect() {
        $this->_columnStatement = NULL;
        $this->_hasTableStatement = NULL;
        parent::disconnect();
    }

    protected function _getDsn() : string {
        $dsn = parent::_getDsn();
        $Database = $this->_database ?: static::$_DefaultDatabase;
        if ($Database === NULL) {
            throw new \Exception('No Database provided!');
        }
        $dsn .= 'dbname=' . $Database;

        if ($this->_charSet !== NULL) {
            $dsn .= ';charset=' . $this->_charSet;
        }

        return $dsn;
    }

    protected function _getURI() : string {
        return 'mysql';
    }

    public static function SetDefaultDatabase(string $DatabaseName) {
        static::$_DefaultDatabase = $DatabaseName;
    }

    public static function GetDefaultDatabase() : string {
        return static::$_DefaultDatabase;
    }

    public function getStorageHandlerName() : string {
        return 'MySQLHandler';
    }

    public function store(ABaseObject $object, array $optionalArguments = []) : bool {
        $telegramAdapter = new TelegramAdapter($object);
        $table = $telegramAdapter->getClassBaseName();

        $pdo = $this->connect();
        $datamodel = $object::GetDatamodel();

        $hasTableStatement = $this->_prepareHasTableStatement($pdo);
        $hasTableStatement->execute([':database' => $this->_database, ':tableName' => $table]);

        //return if there is no table associated with the object
        if ($hasTableStatement->rowCount() == 0) {
            $this->disconnect();
            return FALSE;
        }

        $columnsStatement = $this->_prepareColumnsForTableStatement($pdo);
        $columnsStatement->execute([':tableName' => $table]);

        $storeOptionals = $columnsStatement->rowCount() != count($datamodel);
        $databaseColumns = $columnsStatement->fetchAll(\PDO::FETCH_COLUMN);

        $insertValues = [];
        foreach ($datamodel as $propName => $settings) {
            if (($settings['optional'] && !$storeOptionals) || !isset($object->{$propName})) {
                continue;
            }
            $colName = $this->_getColumnName($propName);
            if (!in_array($colName, $databaseColumns) && $object->{$propName} instanceof ABaseObject) {
                    $insertValues[$colName] = $object->getJSON();
            } else {
                if ($object->{$propName} instanceof ABaseObject) {
                    //check if the property has a Database or not.
                    $propObject = $object->{$propName};
                    $hasTableStatement->execute([':database' => $this->_database, ':tableName' => $telegramAdapter::GetBaseObjectClassBaseName($propObject)]);
                    $tableExists = ($hasTableStatement->rowCount > 0);
                    if ($tableExists) {
                        if ($object->{$propName}::HasIdProperty()) {
                            $idProp = $object->{$propName}::GetIdProperty();
                            $this->store($object->{$propName}->getFQCN(), $object->{$propName}, $optionalArguments);
                            if (!is_int($object->{$propName}->{$idProp})) {
                                $insertValues[$propName . '_' . $idProp] = $object->{$propName}->{$idProp};
                            } else {
                                $insertValues[$colName] = $object->{$propName}->{$idProp};
                            }
                        }
                    } else {
                        $insertValues[$colName] = $object->getJSON();
                    }
                } else {
                    $insertValues[$colName] = $object->{$propName};
                }
            }
        }
        if (!empty($insertValues)) {
            $columns = array_keys($insertValues);
            $updateOnDuplicate = 'ON DUPLICATE KEY UPDATE ';
            foreach ($columns as &$col) {
                $updateOnDuplicate .= '`' . $col . '`= :' . $col . ',';
                $col = '`' . $col . '`';
            }
            $values = [];
            foreach ($insertValues as $key => $value) {
                $values[':' . $key] = $value;
            }
            $updateOnDuplicate = substr($updateOnDuplicate, 0, -1);
            $statement = $pdo->prepare('INSERT INTO ' . $table . ' ('. implode(',', $columns) . ') VALUES (' . implode(',', array_keys($values)) . ') ' . $updateOnDuplicate);
            $res = $statement->execute($values);
            $this->disconnect();
            return $res;
        }
        $this->disconnect();
        return FALSE;
    }

    public function delete(ABaseObject $object) : bool {
        $pdo = $this->connect();
        $telegramAdapter = new TelegramAdapter($object);
        $table = $telegramAdapter->getClassBaseName();
        if ($object::HasIdProperty()) {
            $idProp = $object::GetIdProperty();
            if ($idProp === 'id') {
                $col = 'telegram_id';
            } else {
                $col = $idProp;
            }
            $statement = $pdo->prepare("DELETE FROM $table WHERE $col = :colval");
            $success = $statement->execute([':colval' => $object->{$idProp}]);
            $this->disconnect();
            return $success;
        } else {
            //do the expensive stuff... create a query to compare all colvals
            $datamodel = $object::GetDatamodel();
            $query = "DELETE FROM $table WHERE ";
            foreach (array_keys($datamodel) as $property) {
                $query .= "$property = ?";
            }
            $statement = $pdo->prepare($query);
            $res = $statement->execute(array_values($datamodel));
            $this->disconnect();
            return $success;
        }
    }

    public function load(string $class, string $id = '', string $index = NULL, array $optionalArguments = []) : ABaseObject {
        $pdo = $this->connect();
        $dummy = new $class;
        $adapter = new TelegramAdapter($dummy);
        $table = $adapter->getClassBaseName();
        if ($index === NULL) {
            if ($dummy::HasIdProperty()) {
                $index = $dummy::GetIdProperty();
                if ($index === 'id') {
                    $index = 'telegram_id';
                }
            } else {
                throw new \InvalidArgumentException("No index provided for object $table!");
            }
        }
        $statement = $pdo->prepare("SELECT * FROM `$table` WHERE `$index` = :id");
        $success = $statement->execute(['id' => $id]);

        if (!$success) {
            $this->disconnect();
            return new $class;
        }
        $statement->setFetchMode(\PDO::FETCH_CLASS, \stdClass::class);
        $stdObj = $statement->fetch();
        if (isset($stdObj->{'telegram_id'})) {
            $stdObj->id = $stdObj->{'telegram_id'};
            unset($stdObj->{'telegram_id'});
        }
        $this->disconnect();
        $obj = new $class($stdObj);
        return $obj;
    }

    public function loadAll(string $class, string $index = NULL, array $optionalArguments = []) : array {
        $pdo = $this->connect();
        $dummy = new $class;
        $adapter = new TelegramAdapter($dummy);
        $table = $adapter->getClassBaseName();
        if ($index === NULL) {
            if ($dummy::HasIdProperty()) {
                $index = $dummy::GetIdProperty();
                if ($index === 'id') {
                    $index = 'telegram_id';
                }
            } else {
                throw new \InvalidArgumentException("No index provided for object $table!");
            }
        }
        $statement = $pdo->prepare("SELECT * FROM `$table`");
        $success = $statement->execute(['id' => $id]);

        if (!$success) {
            $this->disconnect();
            return [];
        }
        $statement->setFetchMode(\PDO::FETCH_CLASS, \stdClass::class);
        $objArr = $statement->fetchAll();
        if (isset($stdObj->{'telegram_id'})) {
            $stdObj->id = $stdObj->{'telegram_id'};
            unset($stdObj->{'telegram_id'});
        }
        $this->disconnect();
        $ret = [];
        foreach ($objArr as $stdObj) {
            $ret[] = new $class($stdObj);
        }
        return $ret;

    }

    private function _getColumnName(string $propertyName) {
        if ($propertyName === 'id') {
            $colName = 'telegram_id';
        } else {
            $colName = $propertyName;
        }
        return $colName;
    }

    protected function _prepareHasTableStatement(\PDO $pdo, string $dbReplaceVal = 'database', string $tableReplaceVal = 'tableName') : \PDOStatement {
        return $pdo->prepare("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = :$dbReplaceVal AND table_name = :$tableReplaceVal");
    }

    protected function _prepareColumnsForTableStatement(\PDO $pdo, string $tableReplaceVal = 'tableName') : \PDOStatement {
        return $pdo->prepare('SELECT `COLUMN_NAME` FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = :$tableReplaceVal');
    }

}
