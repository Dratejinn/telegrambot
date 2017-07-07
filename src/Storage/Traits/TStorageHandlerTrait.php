<?php

declare(strict_types = 1);

namespace Telegram\Storage\Traits;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\Storage\Interfaces\ITelegramStorageHandler;

trait TStorageHandlerTrait
{

    private $_storageHandler = NULL;

    public function store(ABaseObject $object, array $optionalArguments = []) : bool {
        if ($this->hasStorageHandler()) {
            return $this->_storageHandler->store($object, $optionalArguments);
        }
        return FALSE;
    }

    public function delete(ABaseObject $object) : bool {
        if ($this->hasStorageHandler()) {
            return $this->_storageHandler->delete($object);
        }
        return FALSE;
    }
    
    public function load(string $class, string $id = '*', string $index = 'id', array $optionalArguments = []) {
        if ($this->hasStorageHandler()) {
            return $this->_storageHandler->load($class, $id, $index, $optionalArguments);
        }
        return NULL;
    }

    public function loadAll(string $class, array $optionalArguments = []) : array {
        if ($this->hasStorageHandler()) {
            return $this->_storageHandler->loadAll($class, $optionalArguments);
        }
        return [];
    }

    public function hasStorageHandler() : bool {
        return $this->_storageHandler instanceof ITelegramStorageHandler;
    }

    public function getStorageHandler() : ITelegramStorageHandler {
        return $this->_storageHandler;
    }

    public function setStorageHandler(ITelegramStorageHandler $storageHandler) {
        $this->_storageHandler = $storageHandler;
    }
}
