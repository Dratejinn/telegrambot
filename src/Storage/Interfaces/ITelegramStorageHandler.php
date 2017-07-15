<?php

declare(strict_types = 1);

namespace Telegram\Storage\Interfaces;

use Telegram\API\Base\Abstracts\ABaseObject;

interface ITelegramStorageHandler {
    /**
     * Get the StorageHandlerName
     * @return string
     */
    public function getStorageHandlerName() : string;

    /**
     * Store an ABaseObject
     * @param \Telegram\API\Base\Abstracts\ABaseObject $object
     * @param array $optionalArguments
     * @return bool
     */
    public function store(ABaseObject $object, array $optionalArguments = []) : bool;

    /**
     * Delete an object from storage
     * @param \Telegram\API\Base\Abstracts\ABaseObject $object
     * @return bool
     */
    public function delete(ABaseObject $object) : bool;

    /**
     * Load a certain class from storage
     * @param string $class
     * @param string $id
     * @param string|NULL $index
     * @param array $optionalArguments
     * @return \Telegram\API\Base\Abstracts\ABaseObject
     */
    public function load(string $class, string $id = '', string $index = NULL, array $optionalArguments = []) : ABaseObject;

    /**
     * Load all stored $class objects
     * @param string $class
     * @param array $optionalArguments
     * @return \Telegram\API\Base\Abstracts\ABaseObject[]
     */
    public function loadAll(string $class, array $optionalArguments = []) : array;
}
