<?php

declare(strict_types = 1);

namespace Telegram\Storage;

use Telegram\API\Base\Abstracts\ABaseObject;
use Telegram\LogHelpers\Interfaces\ILoggerAwareInterface;
use Telegram\LogHelpers\Traits\TLoggerTrait;
use Psr\Log;

class StorageService implements Interfaces\ITelegramStorageService, ILoggerAwareInterface {

    use TLoggerTrait;

    private $_storageHandlers = [];
    private $_logger = NULL;

    public function getStorageHandlerName() : string {
        return 'StorageService';
    }

    public function store(string $origin, string $class, ABaseObject $object) : bool {
        if (empty($this->_storageHandlers)) {
            throw new \Exception('No storageHandlers pushed onto the stack!');
        }
        $success = TRUE;
        foreach ($this->_storageHandlers as $storageHandler) {
            $res = $storageHandler->store($origin, $class, $object);
            if (!$res) {
                $success = FALSE;
                $this->logAlert('Storing was unsuccessfull for StorageHandler ' . $storageHandler->getStorageHandlerName());
            }
        }
        return $success;
    }
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

    public function load(string $origin, string $class, string $id, string $index = 'id') : ABaseObject {
        if (empty($this->_storageHandlers)) {
            throw new \Exception('No storageHandlers pushed onto the stack!');
        }
        foreach ($this->_storageHandlers as $storageHandler) {
            $result = $storageHandler->load($origin, $class, $id, $index);
            if (is_a($result, $class)) {
                return $result;
            } else {
                $this->logAlert("Incompatible result encountered while loading $class with loader " . $storageHandler->getStorageHandlerName());
            }
        }
        throw new \Exception("unable to load data for class '$class' with id '$id' and index '$index'");
    }

    public function pushStorageHandler(Interfaces\ITelegramStorageHandler $storageHandler) {
        array_unshift($this->_storageHandlers, $storageHandler);
    }

    public function popStorageHandler() : Interfaces\ITelegramStorageHandler {
        return array_shift($this->_storageHandlers);
    }
}
