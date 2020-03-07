<?php

declare(strict_types = 1);

namespace Telegram\Storage;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\LogHelpers\Interfaces\ILoggerAwareInterface;
use Telegram\LogHelpers\Traits\TLoggerTrait;
use Psr\Log;

class StorageService implements Interfaces\ITelegramStorageService, ILoggerAwareInterface {

    use TLoggerTrait;

    /**
     * @var \Telegram\Storage\Interfaces\ITelegramStorageHandler[]
     */
    private $_storageHandlers = [];

    /**
     * @inheritdoc
     */
    public function getStorageHandlerName() : string {
        return 'StorageService';
    }

    /**
     * Tries to store the given TelegramObject in all provided storageHandlers; Returns TRUE on success, FALSE when one or more storageHandlers fails to store the object
     * @param \Telegram\API\Base\Abstracts\ABaseObject $object
     * @param array $optionalArguments
     * @return bool
     * @throws \Exception
     */
    public function store(ABaseObject $object, array $optionalArguments = []) : bool {
        if (empty($this->_storageHandlers)) {
            throw new \Exception('No storageHandlers pushed onto the stack!');
        }
        $success = TRUE;
        foreach ($this->_storageHandlers as $storageHandler) {
            $res = $storageHandler->store($object, $optionalArguments);
            if (!$res) {
                $success = FALSE;
                $this->logAlert('Storing was unsuccessfull for StorageHandler ' . $storageHandler->getStorageHandlerName());
            }
        }
        return $success;
    }

    /**
     * Tries to delete all refereces of Telegram object. Returns TRUE on Success; False when one of the StorageHandlers fails
     * @param \Telegram\API\Base\Abstracts\ABaseObject $object
     * @return bool
     * @throws \Exception
     */
    public function delete(ABaseObject $object) : bool {
        if (empty($this->_storageHandlers)) {
            throw new \Exception('No storageHandlers pushed onto the stack!');
        }
        $success = TRUE;
        foreach ($this->_storageHandlers as $storageHandler) {
            $res = $storageHandler->store($object);
            if (!$res) {
                $success = FALSE;
                $this->logAlert('Deleting was unsuccessfull for StorageHandler ' . $storageHandler->getStorageHandlerName());
            }
        }
        return $success;
    }

    /**
     * Returns the first viable result from a storageHandler
     * @param string $class
     * @param string $id
     * @param string $index
     * @param array $optionalArguments
     * @return \Telegram\API\Base\Abstracts\ABaseObject
     * @throws \Exception
     */
    public function load(string $class, string $id = '', string $index = NULL, array $optionalArguments = []) : ABaseObject {
        if (empty($this->_storageHandlers)) {
            throw new \Exception('No storageHandlers pushed onto the stack!');
        }
        foreach ($this->_storageHandlers as $storageHandler) {
            $result = $storageHandler->load($class, $id, $index);
            if (is_a($result, $class)) {
                return $result;
            } else {
                $this->logAlert("Incompatible result encountered while loading $class with loader " . $storageHandler->getStorageHandlerName());
            }
        }
        throw new \Exception("unable to load data for class '$class' with id '$id' and index '$index'");
    }

    /**
     * Returns the first viable set from a storageHandler
     * @param string $class
     * @param array $optionalArguments
     * @return array
     * @throws \Exception
     */
    public function loadAll(string $class, array $optionalArguments = []): array {
        if (empty($this->_storageHandlers)) {
            throw new \Exception('No storageHandlers pushed onto the stack!');
        }
        foreach ($this->_storageHandlers as $storageHandler) {
            $result = $storageHandler->loadAll($class, $optionalArguments);
            if ($result !== NULL && $result !== FALSE) {
                return $result;
            }
        }
        throw new \Exception("unable to load data for class '$class' with id '$id' and index '$index'");
    }

    /**
     * Push a storageHandler on the stack
     * @param \Telegram\Storage\Interfaces\ITelegramStorageHandler $storageHandler
     * @return int
     */
    public function pushStorageHandler(Interfaces\ITelegramStorageHandler $storageHandler) : int {
        return array_unshift($this->_storageHandlers, $storageHandler);
    }

    /**
     * Pop a storagHandler from the stack
     * @return \Telegram\Storage\Interfaces\ITelegramStorageHandler
     */
    public function popStorageHandler() : Interfaces\ITelegramStorageHandler {
        return array_shift($this->_storageHandlers);
    }
}
