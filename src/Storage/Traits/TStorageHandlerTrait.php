<?php

declare(strict_types = 1);

namespace Telegram\Storage\Traits;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\Storage\Interfaces\ITelegramStorageHandler;

trait TStorageHandlerTrait
{

    /**
     * @var null|ITelegramStorageHandler
     */
    private $_storageHandler = NULL;

    /**
     * Store given Telegram object
     * @param \Telegram\API\Base\Abstracts\ABaseObject $object
     * @param array $optionalArguments
     * @return bool
     */
    public function store(ABaseObject $object, array $optionalArguments = []) : bool {
        if ($this->hasStorageHandler()) {
            return $this->_storageHandler->store($object, $optionalArguments);
        }
        return FALSE;
    }

    /**
     * Delete given Telegram object from storage
     * @param \Telegram\API\Base\Abstracts\ABaseObject $object
     * @return bool
     */
    public function delete(ABaseObject $object) : bool {
        if ($this->hasStorageHandler()) {
            return $this->_storageHandler->delete($object);
        }
        return FALSE;
    }

    /**
     * Load a Telegram class
     * @param string $class
     * @param string $id
     * @param string $index
     * @param array $optionalArguments
     * @return null|\Telegram\API\Base\Abstracts\ABaseObject
     */
    public function load(string $class, string $id = '*', string $index = 'id', array $optionalArguments = []) {
        if ($this->hasStorageHandler()) {
            return $this->_storageHandler->load($class, $id, $index, $optionalArguments);
        }
        return NULL;
    }

    /**
     * Load all objects for given class
     * @param string $class
     * @param array $optionalArguments
     * @return array
     */
    public function loadAll(string $class, array $optionalArguments = []) : array {
        if ($this->hasStorageHandler()) {
            return $this->_storageHandler->loadAll($class, $optionalArguments);
        }
        return [];
    }

    /**
     * Check whether implementing class has a storageHandler
     * @return bool
     */
    public function hasStorageHandler() : bool {
        return $this->_storageHandler instanceof ITelegramStorageHandler;
    }

    /**
     * Get the storageHandler
     * @return \Telegram\Storage\Interfaces\ITelegramStorageHandler
     */
    public function getStorageHandler() : ITelegramStorageHandler {
        return $this->_storageHandler;
    }

    /**
     * Set the storageHandler
     * @param \Telegram\Storage\Interfaces\ITelegramStorageHandler $storageHandler
     */
    public function setStorageHandler(ITelegramStorageHandler $storageHandler) {
        $this->_storageHandler = $storageHandler;
    }
}
