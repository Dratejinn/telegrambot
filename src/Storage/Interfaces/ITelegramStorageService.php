<?php

declare(strict_types = 1);

namespace Telegram\Storage\Interfaces;

/**
 * Describes a storage service instance
 */
interface ITelegramStorageService extends ITelegramStorageHandler {
    public function pushStorageHandler(Interfaces\ITelegramStorageHandler $storageHandler);
    public function popStorageHandler() : Interfaces\ITelegramStorageHandler;
}
