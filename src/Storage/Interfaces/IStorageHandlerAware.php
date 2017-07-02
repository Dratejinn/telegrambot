<?php

declare(strict_types = 1);

namespace Telegram\Storage\Interfaces;

/**
 * Describes a storage service aware instance.
 */
interface IStorageHandlerAware {
    public function hasStorageHandler() : bool;
    public function getStorageHandler() : ITelegramStorageHandler;
    public function setStorageHandler(ITelegramStorageHandler $storageService);
}
