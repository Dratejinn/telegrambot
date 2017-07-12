<?php

declare(strict_types = 1);

namespace Telegram\Storage\Interfaces;

/**
 * Describes a storage service aware instance.
 */
interface IStorageHandlerAware {
    /**
     * Used to check whether a class has a storageHandler
     * @return bool
     */
    public function hasStorageHandler() : bool;

    /**
     * Used to get the storageHandler
     * @return \Telegram\Storage\Interfaces\ITelegramStorageHandler
     */
    public function getStorageHandler() : ITelegramStorageHandler;

    /**
     * Used to set the storageHandler on an object
     * @param \Telegram\Storage\Interfaces\ITelegramStorageHandler $storageService
     * @return void
     */
    public function setStorageHandler(ITelegramStorageHandler $storageService);
}
