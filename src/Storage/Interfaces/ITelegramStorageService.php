<?php

declare(strict_types = 1);

namespace Telegram\Storage\Interfaces;

/**
 * Describes a storage service instance
 */
interface ITelegramStorageService extends ITelegramStorageHandler {
    /**
     * Push a storageHandler to the StorageService
     * @param \Telegram\Storage\Interfaces\ITelegramStorageHandler $storageHandler
     * @return mixed
     */
    public function pushStorageHandler(ITelegramStorageHandler $storageHandler);

    /**
     * pop a storageHandler from the StorageService
     * @return \Telegram\Storage\Interfaces\ITelegramStorageHandler
     */
    public function popStorageHandler() : ITelegramStorageHandler;
}
