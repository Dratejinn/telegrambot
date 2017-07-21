<?php

declare(strict_types = 1);

namespace Telegram\Storage\PDO;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\Storage\Interfaces\ITelegramStorageHandler;
use Telegram\Storage\PDO\Abstracts\{AConnectionDetails};
use Telegram\Storage\PDO\UserCredentials;
use Telegram\Storage\Migrations\TelegramAdapter;

class MySQLHandler extends Abstracts\APDOBase implements ITelegramStorageHandler {

    protected static $_DefaultDatabase = '';

    protected $_database = NULL;

    protected $_charSet = 'utf8';

    private $_columnStatement = NULL;
    private $_hasTableStatement = NULL;

    /**
     * MySQLHandler constructor.
     * @param \Telegram\Storage\PDO\Abstracts\AConnectionDetails $connectionDetails
     * @param \Telegram\Storage\PDO\UserCredentials $userCredentials
     * @param string|NULL $Database
     */
    public function __construct(AConnectionDetails $connectionDetails, UserCredentials $userCredentials, string $Database = NULL) {
        parent::__construct($connectionDetails, $userCredentials);
        $this->_database = $Database;
    }

    /**
     * Set the database to connect to
     * @param string $database
     */
    public function setDatabase(string $database) {
        $this->_database = $database;
    }

    /**
     * disconnects from the database
     */
    public function disconnect() {
        $this->_columnStatement = NULL;
        $this->_hasTableStatement = NULL;
        parent::disconnect();
    }

    /**
     * Get the dsn required to connect to the database
     * @return string
     * @throws \Exception
     */
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

    /**
     * get the pdo URI part
     * @return string
     */
    protected function _getURI() : string {
        return 'mysql';
    }

    /**
     * Set the default database
     * @param string $databaseName
     */
    public static function SetDefaultDatabase(string $databaseName) {
        static::$_DefaultDatabase = $databaseName;
    }

    /**
     * Get the default database
     * @return string
     */
    public static function GetDefaultDatabase() : string {
        return static::$_DefaultDatabase;
    }

    /**
     * Returns this handlers name
     * @return string
     */
    public function getStorageHandlerName() : string {
        return 'MySQLHandler';
    }

    /**
     * stores a Telegram object
     * @param \Telegram\API\Base\Abstracts\ABaseObject $object
     * @param array $optionalArguments
     * @return bool
     */
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
            if (($settings['optional'] && !$storeOptionals)) {
                continue;
            }
            $colName = $this->_getColumnName($propName);
            if (isset($object->{$propName}) && !in_array($colName, $databaseColumns) && $object->{$propName} instanceof ABaseObject) {
                    $insertValues[$colName] = $object->getJSON();
            } else {
                if (isset($object->{$propName}) && $object->{$propName} instanceof ABaseObject) {
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
                    $insertValues[$colName] = isset($object->{$propName}) ? $object->{$propName} : NULL;
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
            $statement = $pdo->prepare('INSERT INTO ' . $table . ' (' . implode(',', $columns) . ') VALUES (' . implode(',', array_keys($values)) . ') ' . $updateOnDuplicate);
            $res = $statement->execute($values);
            $this->disconnect();
            return $res;
        }
        $this->disconnect();
        return FALSE;
    }

    /**
     * Delete given Telegram object from the database
     * @param \Telegram\API\Base\Abstracts\ABaseObject $object
     * @return bool
     */
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
            $statement = $pdo->prepare("DELETE FROM $table WHERE `$col` = :colval");
            $success = $statement->execute([':colval' => $object->{$idProp}]);
            $this->disconnect();
            return $success;
        } else {
            //do the expensive stuff... create a query to compare all colvals
            $datamodel = $object::GetDatamodel();
            $query = "DELETE FROM $table WHERE ";
            foreach (array_keys($datamodel) as $property) {
                $query .= "`$property` = ?";
            }
            $statement = $pdo->prepare($query);
            $res = $statement->execute(array_values($datamodel));
            $this->disconnect();
            return $success;
        }
    }

    /**
     * Load a Telegram Object
     * @param string $class
     * @param string $id
     * @param string|NULL $index
     * @param array $optionalArguments
     * @return \Telegram\API\Base\Abstracts\ABaseObject
     */
    public function load(string $class, string $id = '', string $index = NULL, array $optionalArguments = []) : ABaseObject {
        $pdo = $this->connect();
        $obj = $this->_loadBaseFromDatabase($pdo, $class, $id, $index);
        $this->disconnect();
        if ($obj !== NULL) {
            foreach ($obj as $propName => $value) {
                //prop that was not found
                if ($value === NULL) {
                    unset($obj->{$propName});
                }
            }
        }
        $obj = new $class($obj);
        return $obj;
    }

    /**
     * @internal Loads the base object from the database
     * @param \PDO $pdo
     * @param string $class
     * @param string $id
     * @param string|NULL $index
     * @return mixed|null
     * @property \Telegram\API\Base\Abstracts\ABaseObject $dummy
     */
    private function _loadBaseFromDatabase(\PDO $pdo, string $class, string $id = '', string $index = NULL) {
        /**
         * @var \Telegram\API\Base\Abstracts\ABaseObject $dummy
         */
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
        } elseif ($index === 'id') {
            $index = 'telegram_id';
        }
        $statement = $pdo->prepare("SELECT * FROM `$table` WHERE `$index` = :id");
        $statement->setFetchMode(\PDO::FETCH_CLASS, \stdClass::class);
        $success = $statement->execute(['id' => $id]);

        if (!$success) {
            $this->disconnect();
            return NULL;
        }
        $stdObj = $statement->fetch(\PDO::FETCH_CLASS);
        if ($stdObj === FALSE) {
            $this->disconnect();
            return NULL;
        }
        $this->_sanitizeStdObj($stdObj);
        $datamodel = $dummy::GetDatamodel();
        $this->_loadObjectRecursively($stdObj, $datamodel);
        return $stdObj;
    }

    /**
     * Local all TelegramClasses of type $class
     * @param string $class
     * @param array $optionalArguments
     * @return array
     */
    public function loadAll(string $class, array $optionalArguments = []) : array {
        $pdo = $this->connect();
        $dummy = new $class;
        $adapter = new TelegramAdapter($dummy);
        $table = $adapter->getClassBaseName();
        $statement = $pdo->prepare("SELECT * FROM `$table`");
        $success = $statement->execute();
        if (!$success) {
            $this->disconnect();
            return [];
        }
        $statement->setFetchMode(\PDO::FETCH_CLASS, \stdClass::class);
        $objArr = $statement->fetchAll();

        $ret = [];
        $datamodel = $dummy::GetDatamodel();
        foreach ($objArr as $stdObj) {
            $this->_sanitizeStdObj($stdObj);
            $this->_loadObjectRecursively($stdObj, $datamodel);
            $ret[] = new $class($stdObj);
        }
        $this->disconnect();
        return $ret;
    }

    /**
     * Sanitizes the object returned from the database
     * @param \stdClass $stdObj
     */
    private function _sanitizeStdObj(\stdClass $stdObj) {
        if (isset($stdObj->{'telegram_id'})) {
            $stdObj->id = $stdObj->{'telegram_id'};
            unset($stdObj->{'telegram_id'});
        }
        foreach ($stdObj as $propName => $propVal) {
            if ($propVal === NULL) {
                unset($stdObj->{$propName});
            }
        }
    }

    /**
     * Used to load objects that are part of the retrieved object
     * @param \stdClass $stdObj
     * @param array $datamodel
     */
    private function _loadObjectRecursively(\stdClass $stdObj, array $datamodel) {
        foreach ($datamodel as $propName => $model) {
            if (!isset($stdObj->{$propName})) {
                continue;
            }
            if (isset($model['class'])) {
                //first try to json_decode the value; if that returns false we can safely assume there is a table to retrieve it.
                $propVal = json_decode($stdObj->{$propName});
                if ($propVal === NULL) {
                    $stdObj->{$propName} = $this->_loadBaseFromDatabase($pdo, $model['class'], $stdObj->{$propName});
                } else {
                    $stdObj->{$propName} = $propVal;
                }
            }
        }
    }

    /**
     * Get the column name for given property
     * @param string $propertyName
     * @return string
     */
    private function _getColumnName(string $propertyName) {
        if ($propertyName === 'id') {
            $colName = 'telegram_id';
        } else {
            $colName = $propertyName;
        }
        return $colName;
    }

    /**
     * Prepares a statement to check if a certain table exists
     * @param \PDO $pdo
     * @param string $dbReplaceVal
     * @param string $tableReplaceVal
     * @return \PDOStatement
     */
    protected function _prepareHasTableStatement(\PDO $pdo, string $dbReplaceVal = 'database', string $tableReplaceVal = 'tableName') : \PDOStatement {
        return $pdo->prepare("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = :$dbReplaceVal AND table_name = :$tableReplaceVal");
    }

    /**
     * Prepares a statement to get all columns for given table
     * @param \PDO $pdo
     * @param string $tableReplaceVal
     * @return \PDOStatement
     */
    protected function _prepareColumnsForTableStatement(\PDO $pdo, string $tableReplaceVal = 'tableName') : \PDOStatement {
        return $pdo->prepare("SELECT `COLUMN_NAME` FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = :$tableReplaceVal");
    }

}
